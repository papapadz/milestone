<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\PalayVariant;
use Carbon\Carbon;
use App\Models\Rice;
use App\Models\Darak;

class SimpleChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */

    public function handler(Request $request): Chartisan
    {
        switch($request->flag) {
            case 1: return $this->palay($request); break;
            case 2: return $this->riceDarak($request); break;
        }
    }

    public function palay(Request $request) {
        $palayVariantLabels = PalayVariant::pluck('variant')->toArray();
        $palayVariantSum = [];
        $chart = Chartisan::build()
            ->labels($palayVariantLabels);

        foreach($palayVariantLabels as $variant) {
            $sum=0;
            $palayVariantObj = Product::where('name',$variant)->whereBetween('date_delivered',[$request->datefrom,$request->dateto])->get();
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

    public function riceDarak(Request $request) {
        $rice = Rice::whereBetween('created_at',[$request->datefrom,$request->dateto])->get();
        $riceSum = 0;
        foreach($rice as $r) {
            if($r->unit=='ton')
                $riceSum += $r->quantity*1000;
            else if($r->unit=='sacks')
                $riceSum += $r->quantity*50;
            else
                $riceSum += $r->quantity;
        }

        $darak = Darak::whereBetween('created_at',[$request->datefrom,$request->dateto])->get();
        $darakSum = 0;
        foreach($darak as $d) {
            if($d->unit=='ton')
                $darakSum += $d->quantity*1000;
            else if($d->unit=='sacks')
                $darakSum += $d->quantity*50;
            else
                $darakSum += $d->quantity;
        }

        return Chartisan::build()
            ->labels(['Rice','Darak'])
            ->dataset('Totals', [$riceSum,$darakSum]);
    }
}