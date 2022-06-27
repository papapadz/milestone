<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\PalayVariant;

class SimpleChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */

    public function handler(Request $request): Chartisan
    {
        $palayVariantLabels = PalayVariant::pluck('variant')->toArray();
        $palayVariantSum = [];
        $chart = Chartisan::build()
            ->labels($palayVariantLabels);

        foreach($palayVariantLabels as $variant) {
            $sum=0;
            $palayVariantObj = Product::where('name',$variant)->get();
            foreach($palayVariantObj as $pobj) {
                if($pobj->unit=='ton')
                    $sum += $pobj->quantity*1000;
                else if($pobj->unit=='sacks')
                    $sum += $pobj->quantity*50;
                else
                    $sum += $pobj->quantity;
            }
            
            array_push($palayVariantSum,$sum);
            //$chart->dataset($variant,[$sum]);
        }
        $chart->dataset('Palay Variants',$palayVariantSum);
        return $chart;
    }
}