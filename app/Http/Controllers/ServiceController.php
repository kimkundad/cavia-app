<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\point;
use App\Models\User;
use Auth;

class ServiceController extends Controller
{
    //
    public function addwheelresult(){

        $wheelsetting = \DB::table('wheelsetting')->get();

        //check free day wheel

        $free_wheel = \DB::table('wheel_logs')
            ->where('user_id', Auth::user()->id)
            ->whereDate('date_time', date("Y-m-d"))
            ->count();

        //end check free day wheel

        $cat = DB::table('settings')
          ->where('id', 1)
          ->first();

        $coins_wheel_turn = $cat->get_my_file;

        $get_free_coin = 0;

        if(Auth::user()->point < $coins_wheel_turn){

            return response()->json(
                [
                    'data' => null,
                    'status' => 202
                ]
            );

        }

		$fruits = array();

		foreach ($wheelsetting as $key => $value) {
			$fruits[$value->value] = $value->percent;
		}

        $newFruits = array();
		foreach ($fruits as $fruit => $value) {
			$newFruits = array_merge($newFruits, array_fill(0, $value, $fruit));
		}

		$coin = $newFruits[array_rand($newFruits)];

        

            \DB::table('wheel_logs')->insert(
				array(
					'user_id' => Auth::user()->id,
					'coins' =>  $coin,
                    'date_time' => date('Y-m-d H:i:s')
				)
			);

        if($free_wheel > 0){

            $get_free_coin = $coins_wheel_turn;

            $delobj = new point();
            $delobj->user_key = Auth::user()->phone;
            $delobj->date = date("Y-m-d");
            $delobj->total_valid_bet_amount = $coins_wheel_turn;
            $delobj->point = $coins_wheel_turn;
            $delobj->detail = 'ใช้ Point '.$coins_wheel_turn.' เพื่อหมุนกงล้อ';
            $delobj->type = 1;
            $delobj->status = 5;
            $delobj->save();

        }

     
        $package = new point();
        $package->user_key = Auth::user()->phone;
        $package->date = date("Y-m-d");
        $package->total_valid_bet_amount = $coin;
        $package->point = $coin;
        $package->type = 0;
        $package->detail = 'ได้ Point '.$coin.' จากการหมุนกงล้อ';
        $package->status = 5;
        $package->save();

 
        $user = User::where('phone', Auth::user()->phone)->first();
 
        //$total_point = $user->point;
        $total_point = 0;
 
        $objs = point::where('user_key', Auth::user()->phone)->get();
        
        foreach($objs as $u){
             if($u->type == 0){
                 $total_point += $u->point;
             }elseif($u->type == 2){
                 $total_point += $u->point;
             }else{
                 $total_point -= $u->point;
             }
        }
 
        $ob = point::find($package->id);
        $ob->last_point = $total_point;
        $ob->save();
 
        $package = User::find($user->id);
        $package->point = $total_point;
        $package->save();

    

    $wheel_final = \DB::table('wheelsetting')->where('value', $coin)->first();

    
        return response()->json(
            [
                'data' => $wheel_final,
                'status' => 201,
                'coin_return' => $coin-$get_free_coin
            ]
        );

    }

    public function data_wheel(){

        $wheelsetting = \DB::table('wheelsetting')->where('maxDegree', '>', 0)->get();

		$fruits = array();

		foreach ($wheelsetting as $key => $value) {
			$fruits[$value->value] = $value->percent;
		}

        return response()->json($wheelsetting);

    }

    public function data_labelwheel(){

        $wheelsetting = \DB::table('wheelsetting')->select('text')->wherein('id', [1,2,3,4,5,6])->get();


        return response()->json($wheelsetting);

    }
}
