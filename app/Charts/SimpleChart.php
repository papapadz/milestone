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
use App\Models\Task;
use App\Models\Employee;

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
            case 3: return $this->tasks($request); break;
            case 4: return $this->employee($request); break;
        }
    }

    public function palay(Request $request) {

        if($request->variant==0)
            $palayVariantLabels = PalayVariant::pluck('variant')->toArray();
        else
            $palayVariantLabels = PalayVariant::where('id',$request->variant)->pluck('variant')->toArray();

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

    public function tasks(Request $request) {

        if($request->variant==0) {
            $onprogress = Task::where('status', 1)->count();
            $completed = Task::where('status', 0)->count();
        } else {
            $onprogress = Task::where([['status', 1],['company_id', $request->variant]])->count();
            $completed = Task::where([['status', 0],['company_id', $request->variant]])->count();
        }
        
        return Chartisan::build()
            ->labels(['In Progress','Completed'])
            ->dataset('Tasks Count',[$onprogress,$completed]);
    }

    public function employee(Request $request) {

        if($request->variant==0) {
            $age1 = Employee::where('age', '<=',24)->count();
            $age2 = Employee::where([['age', '>=',25],['age', '<=',34]])->count();
            $age3 = Employee::where([['age', '>=',35],['age', '<=',44]])->count();
            $age4 = Employee::where([['age', '>=',45],['age', '<=',54]])->count();
            $age5 = Employee::where('age', '>=',55)->count();
        } else {
            $age1 = Employee::where([['age', '<=',24],['company_id', $request->variant]])->count();
            $age2 = Employee::where([['age', '>=',25],['age', '<=',34],['company_id', $request->variant]])->count();
            $age3 = Employee::where([['age', '>=',35],['age', '<=',44],['company_id', $request->variant]])->count();
            $age4 = Employee::where([['age', '>=',45],['age', '<=',54],['company_id', $request->variant]])->count();
            $age5 = Employee::where([['age', '>=',55],['company_id', $request->variant]])->count();
        }

        return Chartisan::build()
            ->labels(['24 and below','25-34','35-44','45-54','55 and above'])
            ->dataset('Age Group',[$age1,$age2,$age3,$age4,$age5]);
    }
}