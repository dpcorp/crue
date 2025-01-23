<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Ips;
use App\Models\Saturation;
use App\Models\Service;
use Illuminate\Http\Request;

class IndicatorController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        $services = Service::all();
        $ips = Ips::all();
        return view('indicators.index', compact('groups', 'services', 'ips'));
    }

    public function mathematicMoreThantHundred(Request $request)
    {
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $ips = $request->ips;
        $complexity = $request->complexity;
        $services = $request->services;
        $groups = $request->groups;

        $saturations = Saturation::with('ips')
            ->whereBetween('date', [$date_start, $date_end]);
        if (isset($ips) && count($ips) > 0) {
            $saturations = $saturations->whereIn('ips_id', $ips);
        }
        $saturations = $saturations->get();

        $fields = [];

        $hospitalization = [
            'hospitalization_adults',
            'hospitalization_obstetrics',
            'hospitalization_pediatrics',
        ];

        $urgency = [
            'urgency_adults',
            'urgency_pediatrics',
        ];

        $uce = [
            'uce_adults',
            'uce_pediatrics',
            'uce_neonatal',
        ];

        $uci = [
            'uci_adults',
            'uci_pediatrics',
            'uci_neonatal'
        ];

        if (isset($services)) {
            if (in_array(1, $services)) {
                $fields = array_merge($fields, $hospitalization);
            }
            if (in_array(4, $services)) {
                $fields = array_merge($fields, $urgency);
            }
            if (in_array(2, $services)) {
                $fields = array_merge($fields, $uce);
            }
            if (in_array(3, $services)) {
                $fields = array_merge($fields, $uci);
            }
        } else {
            $fields = array_merge($urgency, $hospitalization, $uce, $uci);
        }

        $adults = [
            'hospitalization_obstetrics',
            'hospitalization_pediatrics',
            'urgency_pediatrics',
            'uce_pediatrics',
            'uce_neonatal',
            'uci_pediatrics',
            'uci_neonatal'
        ];

        $pediatrics = [
            'hospitalization_adults',
            'hospitalization_obstetrics',
            'urgency_adults',
            'uce_adults',
            'uce_neonatal',
            'uci_adults',
            'uci_neonatal'
        ];

        $neonatal = [
            'uci_adults',
            'uci_pediatrics',
            'uce_adults',
            'uce_pediatrics',
            'urgency_adults',
            'urgency_pediatrics',
            'hospitalization_adults',
            'hospitalization_pediatrics',
        ];

        $obstetrics = [
            'uci_adults',
            'uci_pediatrics',
            'uce_adults',
            'uce_pediatrics',
            'urgency_adults',
            'urgency_pediatrics',
            'hospitalization_adults',
            'hospitalization_pediatrics',
        ];

        if (isset($groups)) {
            if (in_array(1, $groups)) {
                $fields = array_diff($fields, $adults);
            }
            if (in_array(2, $groups)) {
                $fields = array_diff($fields, $obstetrics);
            }
            if (in_array(3, $groups)) {
                $fields = array_diff($fields, $neonatal);
            }
            if (in_array(4, $groups)) {
                $fields = array_diff($fields, $pediatrics);
            }
        }

        $data_percentage = [];
        $data_labels = [];
        $data = [];
        // Procesar datos paginados
        foreach ($saturations as $saturation) {
            $total = 0;
            $count = 0;


            // Calcular promedio de los campos
            foreach ($fields as $field) {
                $total += $saturation->{$field};
                $count++;
            }

            $average = $count > 0 ? $total / $count : 0;
            if ($average <= 100) {
                continue;
            }

            if (isset($complexity)) {
                if (!in_array(trim($saturation->ips->complexity), $complexity)) {
                    continue;
                }
            }

            $data[] = [
                'average' => number_format($average, 1, '.', ''),
                'name' => $saturation->ips->name
            ];
        }

        usort($data, function ($a, $b) {
            return $b['average'] <=> $a['average'];
        });

        foreach ($data as $item) {
            $data_percentage[] = $item['average'];
            $data_labels[] = $item['name'];
        }

        // Preparar respuesta con datos paginados
        return response()->json([
            'data_percentage' => $data_percentage,
            'data_labels' => $data_labels,
        ]);
    }

    public function mathematicLessThantHundred(Request $request)
    {

        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $ips = $request->ips;
        $complexity = $request->complexity;
        $services = $request->services;
        $groups = $request->groups;

        $saturations = Saturation::with('ips')
            ->whereBetween('date', [$date_start, $date_end]);
        if (isset($ips) && count($ips) > 0) {
            $saturations = $saturations->whereIn('ips_id', $ips);
        }
        $saturations = $saturations->get();

        $fields = [];

        $hospitalization = [
            'hospitalization_adults',
            'hospitalization_obstetrics',
            'hospitalization_pediatrics',
        ];

        $urgency = [
            'urgency_adults',
            'urgency_pediatrics',
        ];

        $uce = [
            'uce_adults',
            'uce_pediatrics',
            'uce_neonatal',
        ];

        $uci = [
            'uci_adults',
            'uci_pediatrics',
            'uci_neonatal'
        ];

        if (isset($services)) {
            if (in_array(1, $services)) {
                $fields = array_merge($fields, $hospitalization);
            }
            if (in_array(4, $services)) {
                $fields = array_merge($fields, $urgency);
            }
            if (in_array(2, $services)) {
                $fields = array_merge($fields, $uce);
            }
            if (in_array(3, $services)) {
                $fields = array_merge($fields, $uci);
            }
        } else {
            $fields = array_merge($urgency, $hospitalization, $uce, $uci);
        }

        $adults = [
            'hospitalization_obstetrics',
            'hospitalization_pediatrics',
            'urgency_pediatrics',
            'uce_pediatrics',
            'uce_neonatal',
            'uci_pediatrics',
            'uci_neonatal'
        ];

        $pediatrics = [
            'hospitalization_adults',
            'hospitalization_obstetrics',
            'urgency_adults',
            'uce_adults',
            'uce_neonatal',
            'uci_adults',
            'uci_neonatal'
        ];

        $neonatal = [
            'uci_adults',
            'uci_pediatrics',
            'uce_adults',
            'uce_pediatrics',
            'urgency_adults',
            'urgency_pediatrics',
            'hospitalization_adults',
            'hospitalization_pediatrics',
        ];

        $obstetrics = [
            'uci_adults',
            'uci_pediatrics',
            'uce_adults',
            'uce_pediatrics',
            'urgency_adults',
            'urgency_pediatrics',
            'hospitalization_adults',
            'hospitalization_pediatrics',
        ];

        if (isset($groups)) {
            if (in_array(1, $groups)) {
                $fields = array_diff($fields, $adults);
            }
            if (in_array(2, $groups)) {
                $fields = array_diff($fields, $obstetrics);
            }
            if (in_array(3, $groups)) {
                $fields = array_diff($fields, $neonatal);
            }
            if (in_array(4, $groups)) {
                $fields = array_diff($fields, $pediatrics);
            }
        }


        $data_percentage = [];
        $data_labels = [];
        $data = [];
        // Procesar datos paginados
        foreach ($saturations as $saturation) {
            $total = 0;
            $count = 0;


            // Calcular promedio de los campos
            foreach ($fields as $field) {
                $total += $saturation->{$field};
                $count++;
            }

            $average = $count > 0 ? $total / $count : 0;
            if ($average > 100) {
                continue;
            }

            if (isset($complexity)) {
                if (!in_array(trim($saturation->ips->complexity), $complexity)) {
                    continue;
                }
            }

            $data[] = [
                'average' => number_format($average, 1, '.', ''),
                'name' => $saturation->ips->name
            ];
        }

        usort($data, function ($a, $b) {
            return $b['average'] <=> $a['average'];
        });

        foreach ($data as $item) {
            $data_percentage[] = $item['average'];
            $data_labels[] = $item['name'];
        }

        // Preparar respuesta con datos paginados
        return response()->json([
            'data_percentage' => $data_percentage,
            'data_labels' => $data_labels,
        ]);
    }
}
