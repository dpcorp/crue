<?php

namespace App\Http\Controllers;

use App\Models\Blocked;
use App\Models\Ips;
use App\Models\Occupation;
use App\Models\Saturation;
use Illuminate\Http\Request;

class SaturationController extends Controller
{
    public function index()
    {
        $saturation = Saturation::with('ips')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();
        return view('saturations.index', compact('saturation'));
    }

    public function mathematic()
    {
        $occupations = Occupation::with('ips')->where('status', '1')->get();
        $blockeds = Blocked::where('status', '1')->get();
        $blockeds_indexed = [];
        foreach ($blockeds as $key => $blocked) {
            $blockeds_indexed[$blocked->date . '-' . $blocked->time] = $blocked;
        }
        $saturations = [];
        $blockeds_id = [];
        $occupations_id = [];
        foreach ($occupations as $key => $occupation) {

            $saturations[] = [
                'ips_id' => $occupation->ips_id,
                "date" => $occupation->date,
                "time" => $occupation->time,

                'urgency_adults' => $this->calculatePercentage($occupation->urgency_adults, $occupation->ips->urgency_adults, $blockeds_indexed[$occupation->date . '-' . $occupation->time]->urgency_adults),
                'urgency_pediatrics' => $this->calculatePercentage($occupation->urgency_pediatrics, $occupation->ips->urgency_pediatrics, $blockeds_indexed[$occupation->date . '-' . $occupation->time]->urgency_pediatrics),

                'hospitalization_adults' => $this->calculatePercentage($occupation->hospitalization_adults, $occupation->ips->hospitalization_adults, $blockeds_indexed[$occupation->date . '-' . $occupation->time]->hospitalization_adults),
                'hospitalization_obstetrics' => $this->calculatePercentage($occupation->hospitalization_obstetrics, $occupation->ips->hospitalization_obstetrics, $blockeds_indexed[$occupation->date . '-' . $occupation->time]->hospitalization_obstetrics),
                'hospitalization_pediatrics' => $this->calculatePercentage($occupation->hospitalization_pediatrics, $occupation->ips->hospitalization_pediatrics, $blockeds_indexed[$occupation->date . '-' . $occupation->time]->hospitalization_pediatrics),

                'uce_adults' => $this->calculatePercentage($occupation->uce_adults, $occupation->ips->uce_adults, $blockeds_indexed[$occupation->date . '-' . $occupation->time]->uce_adults),
                'uce_pediatrics' => $this->calculatePercentage($occupation->uce_pediatrics, $occupation->ips->uce_pediatrics, $blockeds_indexed[$occupation->date . '-' . $occupation->time]->uce_pediatrics),
                'uce_neonatal' => $this->calculatePercentage($occupation->uce_neonatal, $occupation->ips->uce_neonatal, $blockeds_indexed[$occupation->date . '-' . $occupation->time]->uce_neonatal),

                'uci_adults' => $this->calculatePercentage($occupation->uci_adults, $occupation->ips->uci_adults, $blockeds_indexed[$occupation->date . '-' . $occupation->time]->uci_adults),
                'uci_pediatrics' => $this->calculatePercentage($occupation->uci_pediatrics, $occupation->ips->uci_pediatrics, $blockeds_indexed[$occupation->date . '-' . $occupation->time]->uci_pediatrics),
                'uci_neonatal' => $this->calculatePercentage($occupation->uci_neonatal, $occupation->ips->uci_neonatal, $blockeds_indexed[$occupation->date . '-' . $occupation->time]->uci_neonatal),
            ];

            $blockeds_id[] = $blockeds_indexed[$occupation->date . '-' . $occupation->time]->id;
            $occupations_id[] = $occupation->id;
        }

        Saturation::insert($saturations);
        Blocked::whereIn('id', $blockeds_id)->update(['status' => 0]);
        Occupation::whereIn('id', $occupations_id)->update(['status' => 0]);


        return response()->json([
            'success' => true,
            'saturations' => $saturations
        ]);
    }

    function calculatePercentage($occupation, $capacity, $blocked, $decimals = 1)
    {
        $denominator = $capacity - $blocked;

        if ($denominator == 0) {
            return number_format(0, $decimals, '.', ''); // Retorna 0 si hay división por cero
        }

        $percentage = ($occupation / $denominator) * 100;

        return number_format($percentage, $decimals, '.', ''); // Formatea el porcentaje
    }
}
