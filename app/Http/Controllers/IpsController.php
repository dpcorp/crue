<?php

namespace App\Http\Controllers;

use App\Models\Ips;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class IpsController extends Controller
{
    public function index()
    {
        $ips = Ips::get();
        return view('ips.index', compact('ips'));
    }

    public function create()
    {
        return view('ips.create');
    }

    public function getComplexity()
    {
        return view('ips.complexity');
    }

    public function loadFile(Request $request)
    {
        try {
            // Cargar y procesar el archivo
            $file = $request->file('file');
            $data = Excel::toArray([], $file);
            $data = $data[0];
            $keys = $data[0];
            unset($data[0]);

            if (count($keys) != 70) {
                return response()->json([
                    'message' => 'El archivo no contiene la estructura correcta. Columnas del archivo: ' . count($keys) . ', Columnas esperadas: 69',
                    'status' => 400
                ]);
            }

            // Procesar datos
            $results = [];
            foreach ($data as $item) {
                $name = $item[0];
                $datetime = $this->parseDatetime($item[1], $item[2]);

                // Verificar si el registro ya existe y comparar fechas y horas
                if (!isset($results[$name]) || $datetime > $results[$name][70]) {
                    $results[$name] = $item;
                    $results[$name][70] = $datetime; // Guardar DateTime para comparación
                }
            }

            // $ips = Ips::get()->pluck('name')->toArray();
            $ips = Ips::get(["id", "name", 'date', 'time']);
            $indexed_ips = [];
            foreach ($ips as $ip) {
                $indexed_ips[$ip->name] = [
                    'id' => $ip->id,
                    'date' => $ip->date,
                    'time' => $ip->time
                ];
            }

            $to_create = 0;
            $to_update = 0;
            $synchronize_data = [];
            $synchronize_errors = [];
            $chunkSize = 40;
            $results_chunks = array_chunk($results, $chunkSize);

            foreach ($results_chunks as $chunk) {
                foreach ($chunk as $result) {
                    $name = trim($result[0]);
                    $date = DateTime::createFromFormat('d/m/Y', $result[1])->format('Y-m-d');
                    $time = $result[2];

                    // Urgencias
                    $urgency_stretchers_adults = $result[42] ? $result[42] : 0;
                    $urgency_chairs_adults = $result[43] ? $result[43] : 0;
                    $urgency_revival_adults = $result[44] ? $result[44] : 0;

                    $urgency_stretchers_pediatric = $result[45] ? $result[45] : 0;
                    $urgency_chairs_pediatric = $result[46] ? $result[46] : 0;
                    $urgency_revival_pediatric = $result[47] ? $result[47] : 0;

                    // Hospitalizaciones
                    $hospitalization_stretchers_adults = $result[67] ? $result[67] : 0;
                    $hospitalization_obstetrics = $result[68] ? $result[68] : 0;
                    $hospitalization_pediatrics = $result[69] ? $result[69] : 0;

                    // UCE
                    $uce_adults = $result[60] ? $result[60] : 0;
                    $uce_pediatrics = $result[62] ? $result[62] : 0;
                    $uce_neonatal = $result[64] ? $result[64] : 0;

                    // UCI
                    $uci_adults = $result[61] ? $result[61] : 0;
                    $uci_pediatrics = $result[63] ? $result[63] : 0;
                    $uci_neonatal = $result[65] ? $result[65] : 0;


                    if (in_array($name, isset($indexed_ips[$name]) ? array_keys($indexed_ips) : [])) {

                        $ips_in_db = new DateTime($indexed_ips[$name]['date'] . ' ' . $indexed_ips[$name]['time']);
                        $ips_to_import = new DateTime("$date $time");

                        if ($ips_in_db > $ips_to_import) {
                            $synchronize_errors[] = [
                                'name' => $name,
                                'message' => 'La fecha y hora de la IPS ' . $name . ' en la base de datos es mayor que la del archivo.' . '<br>' . 'Fecha y hora de la base de datos: ' . $indexed_ips[$name]['date'] . ' ' . $indexed_ips[$name]['time'] . '. Fecha y hora del archivo: ' . $date . ' ' . $time
                            ];
                            continue;
                        }
                        $to_update++;
                    } else {
                        $to_create++;
                    }

                    $synchronize_data[] = [
                        'name' => $name,
                        'date' => $date,
                        'time' => $time,
                        'urgency_adults' => $urgency_stretchers_adults + $urgency_chairs_adults + $urgency_revival_adults,
                        'urgency_pediatrics' => $urgency_stretchers_pediatric + $urgency_chairs_pediatric + $urgency_revival_pediatric,

                        'hospitalization_adults' => $hospitalization_stretchers_adults,
                        'hospitalization_obstetrics' => $hospitalization_obstetrics,
                        'hospitalization_pediatrics' => $hospitalization_pediatrics,

                        'uce_adults' => $uce_adults,
                        'uce_pediatrics' => $uce_pediatrics,
                        'uce_neonatal' => $uce_neonatal,

                        'uci_adults' => $uci_adults,
                        'uci_pediatrics' => $uci_pediatrics,
                        'uci_neonatal' => $uci_neonatal,
                    ];
                }
            }

            return response()->json([
                'message' => 'Archivo procesado correctamente',
                'status' => 200,
                'data' => $synchronize_data,
                'to_create' => $to_create,
                'to_update' => $to_update,
                'errors' => $synchronize_errors
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al procesar el archivo: ' . $e->getMessage() . ' (' . $e->getFile() . ':' . $e->getLine() . ')'], 500);
        }
    }

    public function toCreate(Request $request)
    {
        try {

            // Usamos solo 'name' como campo único
            $uniqueBy = ['name'];

            // Campos a actualizar si ya existe un registro con el mismo 'name'
            $updateColumns = [
                'date',
                'time',
                'hospitalization_adults',
                'hospitalization_obstetrics',
                'hospitalization_pediatrics',
                'uce_adults',
                'uce_neonatal',
                'uce_pediatrics',
                'uci_adults',
                'uci_neonatal',
                'uci_pediatrics',
                'urgency_adults',
                'urgency_pediatrics'
            ];

            Ips::upsert($request->ips, $uniqueBy, $updateColumns);

            return response()->json([
                'message' => 'Registro creado correctamente',
                'status' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear el registro: ' . $e->getMessage()], 500);
        }
    }

    public function loadComplexity(Request $request)
    {

        try {
            // Cargar y procesar el archivo
            $file = $request->file('file');
            $data = Excel::toArray([], $file);
            $data = $data[0];
            $keys = $data[0];
            unset($data[0]);

            if (count($keys) != 2) {
                return response()->json([
                    'message' => 'El archivo no contiene la estructura correcta. Columnas del archivo: ' . count($keys) . ', Columnas esperadas: 2',
                    'status' => 400
                ]);
            }

            // $ips = Ips::get()->pluck('name')->toArray();
            $ips = Ips::get(["id", "name"]);
            $indexed_ips = [];
            foreach ($ips as $ip) {
                $indexed_ips[$ip->name] = $ip->id;
            }

            $to_update = 0;
            $synchronize_data = [];
            $synchronize_errors = [];
            $ips_in_array = [];
            $chunkSize = 40;
            $results_chunks = array_chunk($data, $chunkSize);

            foreach ($results_chunks as $chunk) {
                foreach ($chunk as $result) {
                    $name = trim($result[0]);
                    $complexity = trim($result[1]);


                    if (!in_array($name, isset($indexed_ips[$name]) ? array_keys($indexed_ips) : [])) {
                        $synchronize_errors[] = [
                            'name' => $name,
                            'message' => 'No existe la IPS: ' . $name
                        ];
                        continue;
                    } else {
                        if (in_array($name, $ips_in_array)) {
                            $synchronize_errors[] = [
                                'name' => $name,
                                'message' => 'La IPS: ' . $name . ' ya fue procesada'
                            ];
                            continue;
                        }

                        $to_update++;
                    }

                    $synchronize_data[] = [
                        'eps_id' => $indexed_ips[$name],
                        'complexity' => $complexity,
                    ];
                    $ips_in_array[] = $name;
                }
            }

            return response()->json([
                'message' => 'Archivo procesado correctamente',
                'status' => 200,
                'data' => $synchronize_data,
                'to_update' => $to_update,
                'errors' => $synchronize_errors
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al procesar el archivo: ' . $e->getMessage() . ' (' . $e->getFile() . ':' . $e->getLine() . ')'], 500);
        }
    }

    public function insertComplexity(Request $request)
    {
        try {
            foreach ($request->ips as $ip) {
                Ips::where('id', $ip['eps_id'])->update(['complexity' => $ip['complexity']]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al cargar las IPS: ' . $e->getMessage() . ' (' . $e->getFile() . ':' . $e->getLine() . ')'], 500);
        }
    }

    // Convertir fecha y hora a formato datetime para comparación
    private function parseDatetime($date, $time)
    {
        return DateTime::createFromFormat('d/m/Y H:i:s', "$date $time");
    }
}
