<?php

namespace App\Http\Controllers;

use App\Models\Ips;
use App\Models\Occupation;
use App\Models\OutOfService;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class OccupationController extends Controller
{
    public function index()
    {
        $occupations = Occupation::with('ips')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();
        return view('occupations.index', compact('occupations'));
    }

    public function create()
    {
        return view('occupations.create');
    }

    public function loadFile(Request $request)
    {
        try {
            $file = $request->file('file');
            $data = Excel::toArray([], $file);
            $occupations = $data[0];
            $out_of_service = $data[1];
            $keys = $occupations[0];
            $keys_out_of_service = $out_of_service[0];
            unset($occupations[0]);
            unset($out_of_service[0]);

            if (count($keys) != 39) {
                return response()->json([
                    'message' => 'El archivo no contiene la estructura correcta. Columnas del archivo: ' . count($keys) . ', Columnas esperadas: 39',
                    'status' => 400
                ]);
            }

            $ips = Ips::get(["id", "name"]);
            $indexed_ips = [];
            foreach ($ips as $ip) {
                $indexed_ips[$ip->name] = $ip->id;
            }

            $synchronize_occupations = [];
            $synchronize_occupations_errors = [];
            $synchronize_out_of_service = [];

            $chunkSize = 40;
            $results_chunks = array_chunk($occupations, $chunkSize);
            unset($occupations);

            foreach ($results_chunks as $chunk) {
                foreach ($chunk as $result) {
                    if (!isset($indexed_ips[trim($result[0])])) {
                        $synchronize_occupations_errors[] = [
                            'name' => trim($result[0]),
                            'message' => 'IPS no encontrada'
                        ];
                        continue;
                    }

                    $ips_id = $indexed_ips[trim($result[0])];
                    $date = DateTime::createFromFormat('d/m/Y', $result[1])->format('Y-m-d');
                    $time = $result[2];

                    // Urgencias
                    $urgency_stretchers_adults = $result[28] ? $result[28] : 0;
                    $urgency_chairs_adults = $result[30] ? $result[30] : 0;
                    $urgency_revival_adults = $result[32] ? $result[32] : 0;

                    $urgency_stretchers_pediatric = $result[34] ? $result[34] : 0;
                    $urgency_chairs_pediatric = $result[36] ? $result[36] : 0;
                    $urgency_revival_pediatric = $result[38] ? $result[38] : 0;

                    // Hospitalizaciones
                    $hospitalization_stretchers_adults = $result[5] ? $result[5] : 0;
                    $hospitalization_obstetrics = $result[11] ? $result[11] : 0;
                    $hospitalization_pediatrics = $result[15] ? $result[15] : 0;

                    // UCE
                    $uce_adults = $result[7] ? $result[7] : 0;
                    $uce_pediatrics = $result[17] ? $result[17] : 0;
                    $uce_neonatal = $result[23] ? $result[23] : 0;

                    // UCI
                    $uci_adults = $result[9] ? $result[9] : 0;
                    $uci_pediatrics = $result[19] ? $result[19] : 0;
                    $uci_neonatal = $result[25] ? $result[25] : 0;


                    $synchronize_occupations[] = [
                        'ips_id' => $ips_id,
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


            $synchronize_out_of_service = [];

            $chunkSize = 40;
            $results_out_of_service_chunks = array_chunk($out_of_service, $chunkSize);
            unset($out_of_service);

            foreach ($results_out_of_service_chunks as $chunk_out) {
                foreach ($chunk_out as $result_out) {
                    if (!isset($indexed_ips[trim($result_out[0])])) {
                        $synchronize_occupations_errors[] = [
                            'name' => trim($result_out[0]),
                            'message' => 'IPS no encontrada'
                        ];
                        continue;
                    }

                    $ips_id = $indexed_ips[trim($result_out[0])];
                    $date = DateTime::createFromFormat('d/m/Y', $result_out[1])->format('Y-m-d');
                    $time = $result_out[2];
                    $name = trim($result_out[0]);
                    unset($result_out[0]);
                    unset($result_out[1]);
                    unset($result_out[2]);
                    unset($result_out[3]);

                    foreach ($result_out as $key => $out) {
                        if (isset($out) && $out > 0) {
                            $synchronize_out_of_service[] = [
                                'ips_id' => $ips_id,
                                'date' => $date,
                                'time' => $time,
                                "quantity" => $out,
                                "reason" => $keys_out_of_service[$key],
                            ];
                        }
                    }
                }
            }

            return response()->json([
                'message' => 'Archivo procesado correctamente',
                'status' => 200,
                "synchronize_occupations" => $synchronize_occupations,
                "synchronize_out_of_service" => $synchronize_out_of_service,
                "synchronize_occupations_errors" => $synchronize_occupations_errors
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al procesar el archivo: ' . $e->getMessage()], 500);
        }
    }

    public function insertOccupations(Request $request)
    {
        try {
            Occupation::insert($request->occupations);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear el registro: ' . $e->getMessage()], 500);
        }
    }

    public function insertOutOfService(Request $request)
    {
        try {
            OutOfService::insert($request->out_of_service);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear el registro: ' . $e->getMessage()], 500);
        }
    }
}
