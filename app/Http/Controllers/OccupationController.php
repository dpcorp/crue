<?php

namespace App\Http\Controllers;

use App\Models\Blocked;
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

            if (!isset($data[1])) {
                return response()->json([
                    'message' => 'El archivo no contiene la estructura correcta.',
                    'status' => 400
                ]);
            }

            $out_of_service = $data[1];
            $keys = $occupations[0];
            $keys_out_of_service = $out_of_service[0];
            unset($occupations[0]);
            unset($out_of_service[0]);
            unset($data);

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
            $blockeds_occupations = [];

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

                    unset($result_out[0]);
                    unset($result_out[1]);
                    unset($result_out[2]);
                    unset($result_out[3]);

                    // Urgencias
                    $urgency_adults_isolation = $result_out[4] ? $result_out[4] : 0;
                    $urgency_adults_maintenance = $result_out[5] ? $result_out[5] : 0;
                    $urgency_adults_human_resources = $result_out[6] ? $result_out[6] : 0;

                    $urgency_revival_adults_isolation = $result_out[7] ? $result_out[7] : 0;
                    $urgency_revival_adults_maintenance = $result_out[8] ? $result_out[8] : 0;
                    $urgency_revival_adults_human_resources = $result_out[9] ? $result_out[9] : 0;

                    $urgency_adults_total = $urgency_adults_isolation + $urgency_adults_maintenance + $urgency_adults_human_resources + $urgency_revival_adults_isolation + $urgency_revival_adults_maintenance + $urgency_revival_adults_human_resources;

                    $urgency_pediatric_isolation = $result_out[10] ? $result_out[10] : 0;
                    $urgency_pediatric_maintenance = $result_out[11] ? $result_out[11] : 0;
                    $urgency_pediatric_human_resources = $result_out[12] ? $result_out[12] : 0;

                    $urgency_revival_pediatric_isolation = $result_out[13] ? $result_out[13] : 0;
                    $urgency_revival_pediatric_maintenance = $result_out[14] ? $result_out[14] : 0;
                    $urgency_revival_pediatric_human_resources = $result_out[15] ? $result_out[15] : 0;

                    $urgency_pediatrics_total = $urgency_pediatric_isolation + $urgency_pediatric_maintenance + $urgency_pediatric_human_resources + $urgency_revival_pediatric_isolation + $urgency_revival_pediatric_maintenance + $urgency_revival_pediatric_human_resources;

                    //UCE

                    $uce_adults_isolation = $result_out[16] ? $result_out[16] : 0;
                    $uce_adults_maintenance = $result_out[17] ? $result_out[17] : 0;
                    $uce_adults_human_resources = $result_out[18] ? $result_out[18] : 0;

                    $uce_adults_total = $uce_adults_isolation + $uce_adults_maintenance + $uce_adults_human_resources;

                    $uce_neonatal_isolation = $result_out[28] ? $result_out[28] : 0;
                    $uce_neonatal_maintenance = $result_out[29] ? $result_out[29] : 0;
                    $uce_neonatal_human_resources = $result_out[30] ? $result_out[30] : 0;

                    $uce_neonatal_total = $uce_neonatal_isolation + $uce_neonatal_maintenance + $uce_neonatal_human_resources;

                    $uce_pediatric_isolation = $result_out[34] ? $result_out[34] : 0;
                    $uce_pediatric_maintenance = $result_out[35] ? $result_out[35] : 0;
                    $uce_pediatric_human_resources = $result_out[36] ? $result_out[36] : 0;

                    $uce_pediatric_total = $uce_pediatric_isolation + $uce_pediatric_maintenance + $uce_pediatric_human_resources;

                    //UCI

                    $uci_adults_isolation = $result_out[19] ? $result_out[19] : 0;
                    $uci_adults_maintenance = $result_out[20] ? $result_out[20] : 0;
                    $uci_adults_human_resources = $result_out[21] ? $result_out[21] : 0;

                    $uci_adults_total = $uci_adults_isolation + $uci_adults_maintenance + $uci_adults_human_resources;

                    $uci_neonatal_isolation = $result_out[31] ? $result_out[31] : 0;
                    $uci_neonatal_maintenance = $result_out[32] ? $result_out[32] : 0;
                    $uci_neonatal_human_resources = $result_out[33] ? $result_out[33] : 0;

                    $uci_neonatal_total = $uci_neonatal_isolation + $uci_neonatal_maintenance + $uci_neonatal_human_resources;

                    $uci_pediatric_isolation = $result_out[37] ? $result_out[37] : 0;
                    $uci_pediatric_maintenance = $result_out[38] ? $result_out[38] : 0;
                    $uci_pediatric_human_resources = $result_out[39] ? $result_out[39] : 0;

                    $uci_pediatric_total = $uci_pediatric_isolation + $uci_pediatric_maintenance + $uci_pediatric_human_resources;

                    // Hospitalización

                    $hospitalization_adults_isolation = $result_out[25] ? $result_out[25] : 0;
                    $hospitalization_adults_maintenance = $result_out[26] ? $result_out[26] : 0;
                    $hospitalization_adults_human_resources = $result_out[27] ? $result_out[27] : 0;

                    $hospitalization_adults_total = $hospitalization_adults_isolation + $hospitalization_adults_maintenance + $hospitalization_adults_human_resources;

                    $hospitalization_pediatric_isolation = $result_out[43] ? $result_out[43] : 0;
                    $hospitalization_pediatric_maintenance = $result_out[44] ? $result_out[44] : 0;
                    $hospitalization_pediatric_human_resources = $result_out[45] ? $result_out[45] : 0;

                    $hospitalization_pediatric_total = $hospitalization_pediatric_isolation + $hospitalization_pediatric_maintenance + $hospitalization_pediatric_human_resources;

                    $blockeds_occupations[] = [
                        'ips_id' => $ips_id,
                        'date' => $date,
                        'time' => $time,

                        'urgency_adults' => $urgency_adults_total,
                        'urgency_pediatrics' => $urgency_pediatrics_total,

                        'hospitalization_adults' => $hospitalization_adults_total,
                        'hospitalization_obstetrics' => 0,
                        'hospitalization_pediatrics' => $hospitalization_pediatric_total,

                        'uce_adults' => $uce_adults_total,
                        'uce_pediatrics' => $uce_pediatric_total,
                        'uce_neonatal' => $uce_neonatal_total,

                        'uci_adults' => $uci_adults_total,
                        'uci_pediatrics' => $uci_pediatric_total,
                        'uci_neonatal' => $uci_neonatal_total,
                    ];

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
                'blockeds_occupations' => $blockeds_occupations,
                "synchronize_out_of_service" => $synchronize_out_of_service,
                "errors" => $synchronize_occupations_errors
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al procesar el archivo: ' . $e->getMessage()], 500);
        }
    }

    public function insertOccupations(Request $request)
    {
        try {
            Occupation::insert($request->data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear el registro: ' . $e->getMessage()], 500);
        }
    }

    public function insertBlockeds(Request $request)
    {
        try {
            Blocked::insert($request->data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear el registro: ' . $e->getMessage()], 500);
        }
    }

    public function insertOutOfService(Request $request)
    {
        try {
            OutOfService::insert($request->data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear el registro: ' . $e->getMessage()], 500);
        }
    }
}
