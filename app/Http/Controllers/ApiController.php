<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Log;
use App\Book;
//use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function testlog(){
        //Log::info("test log!");
        $book = Book::all();
        //$book['test'] = 'test';
        $count = count($book);
        $book[0]->test = 'test';  //[]array, {}object, x[]->y=z (array x中的物件新增key=y, value=z)
        $book[$count] = 'test2';
        return response()->json(['result'=>true, 'book'=>$book]);
    }

    public function time(Request $request){
        if($request->has('q')){
            //non-number string or datetime
            //http://localhost:8000/api/time?q=next%20wednesday
            $q = $request->q;
            $dt = Carbon::create($q);
            $now = Carbon::create('now')->toDateTimeString();
            $diffForHumans = $dt->diffForHumans();
            $dt = Carbon::create($q)->toDateTimeString();
            return response()->json(['q' => $q, 'dt' => $dt, 'now' => $now, 'diffForHumans' => $diffForHumans]);
        }else if($request->has('type')){
            //q1: dt, q2: num, type: addYears subYears addMonths subMonths addDays subDays addWeeks subWeeks addHours subHours addMinutes subMinutes addSeconds subSeconds
            //http://localhost:8000/api/time?q1=2012-5-30&q2=64&type=addDays
            $q1 = $request->q1;
            $q2 = $request->q2;
            $type =$request->type;
            $dt = Carbon::create($request->q1);
            switch($type){
                case 'addYears':
                    $dt->addYears($q2);
                    break;
                case 'subYears':
                    $dt->subYears($q2);
                    break;
                case 'addMonths':
                    $dt->addMonths($q2);
                    break;
                case 'subMonths':
                    $dt->subMonths($q2);
                    break;
                case 'addDays':
                    $dt->addDays($q2);
                    break;
                case 'subDays':
                    $dt->subDays($q2);
                    break;
                case 'addWeeks':
                    $dt->addWeeks($q2);
                    break;
                case 'subWeeks':
                    $dt->subWeeks($q2);
                    break;
                case 'addMonths':
                    $dt->addMonths($q2);
                    break;
                case 'subMonths':
                    $dt->subMonths($q2);
                    break;
                case 'addDays':
                    $dt->addDays($q2);
                    break;
                case 'subDays':
                    $dt->subDays($q2);
                    break;
                case 'addWeeks':
                    $dt->addWeeks($q2);
                    break;
                case 'subWeeks':
                    $dt->subWeeks($q2);
                    break;
                case 'addHours':
                    $dt->addHours($q2);
                    break;
                case 'subHours':
                    $dt->subHours($q2);
                    break;
                case 'addMinutes':
                    $dt->addMinutes($q2);
                    break;
                case 'subMinutes':
                    $dt->subMinutes($q2);
                    break;
                case 'addSeconds':
                    $dt->addSeconds($q2);
                    break;
                case 'subSeconds':
                    $dt->subSeconds($q2);
                    break; 
            }
            $time = $dt->toDateTimeString();
            //$time->toDateTimeString();
            //echo($time);
            return response()->json(['q1' => $q1, 'q2' => $q2, 'type' => $type, 'time' => $time]);
        }else{
            //two datetime 
            //http://localhost:8000/api/time?q1=2012-5-30&q2=2011-2-10
            $q1 = $request->q1;
            $q2 = $request->q2;
            $dt1 = Carbon::create($request->q1);
            $dt2 = Carbon::create($request->q2);
            if($dt1->gte($dt2)){
                $year = $dt1->diffInYears($dt2);
                $mon = $dt1->diffInMonths($dt2);
                $day = $dt1->diffInDays($dt2); 
                $hour = $dt1->diffInHours($dt2); 
                $min = $dt1->diffInMinutes($dt2);
            }else{
                $year = $dt2->diffInYears($dt1);
                $mon = $dt2->diffInMonths($dt1);
                $day = $dt2->diffInDays($dt1); 
                $hour = $dt2->diffInHours($dt1); 
                $min = $dt2->diffInMinutes($dt1);
            }
            $dt1 = Carbon::create($request->q1)->toDateTimeString();
            $dt2 = Carbon::create($request->q2)->toDateTimeString();
            return response()->json(['q1' => $q1, 'q2' => $q2, 'dt1' => $dt1, 'dt2' => $dt2, 'years' => $year, 'months' => $mon, 'days' => $day, 'hours' => $hour, 'mins' => $min]);
        } 
    }
}
