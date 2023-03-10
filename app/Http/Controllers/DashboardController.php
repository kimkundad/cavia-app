<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\slide;
use App\Models\order;
use App\Models\point;
use App\Models\product;
use App\Models\wheelsetting;
use App\Imports\UsersImport;
use App\Models\point_reward;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\UserUpPoint;

class DashboardController extends Controller
{
    //
    public function index(){

        $objs = DB::table('wheel_logs')->select(
            'wheel_logs.*',
            'wheel_logs.id as id_q',
            'users.*'
            )
            ->leftjoin('users', 'users.id',  'wheel_logs.user_id')
            ->orderby('wheel_logs.id', 'desc')
            ->paginate(10);

        $data['objs'] = $objs;

        $data_checkin = point_reward::where('point_date', date("Y-m-d"))->sum('coins');
        $data['data_checkin'] = $data_checkin;

        $count_checkin = point_reward::where('point_date', date("Y-m-d"))->count();
        $data['count_checkin'] = $count_checkin;

        $count_wheel = \DB::table('wheel_logs')
            ->whereDate('date_time', date("Y-m-d"))
            ->count();

            $data['count_wheel'] = $count_wheel;


            $sum_wheel = \DB::table('wheel_logs')
            ->whereDate('date_time', date("Y-m-d"))
            ->sum('coins');

            $data['sum_wheel'] = $sum_wheel;


            $sum_wheel_all = \DB::table('wheel_logs')
            ->sum('coins');

            $data['sum_wheel_all'] = $sum_wheel_all;


        $User = User::where('id', '!=', 1 )->where('id', '!=', 2 )->count();
        $data['User'] = $User;

        $slide = slide::count();
        $data['slide'] = $slide;

        $order = order::count();
        $data['order'] = $order;

        $product = product::count();
        $data['product'] = $product;

        $data['sum'] = 1;
        return view('admin.dashboard.index', $data);
    }

    public function edit_point_checkin($id){

        $objs = DB::table('point_rewards')->select(
            'point_rewards.*',
            'point_rewards.id as id_q',
            'point_rewards.created_at as created_ats',
            'users.*'
            )
            ->leftjoin('users', 'users.id',  'point_rewards.user_id')->where('point_rewards.id', $id)->first();

        $data['objs'] = $objs;
        $data['id'] = $id;
        return view('admin.dashboard.edit_point_checkin', $data);

    }

    public function post_point_checkin(Request $request, $id){

        $this->validate($request, [
            'point_date' => 'required'
        ]);

        $package = point_reward::find($id);
       $package->point_date = $request['point_date'];
       $package->save();

        return redirect(url('/admin/point_checkin'))->with('edit_success','??????????????? ??????????????????????????????????????????????????????');

    }

    public function del_checkin_all(){

        point_reward::truncate();

        return redirect(url('/admin/point_checkin'))->with('edit_success','??????????????? ??????????????????????????????????????????????????????');
    }


    public function point_checkin(){

        $data_checkin = point_reward::sum('coins');
        $data['data_checkin'] = $data_checkin;

        $objs = DB::table('point_rewards')->select(
            'point_rewards.*',
            'point_rewards.id as id_q',
            'point_rewards.created_at as created_ats',
            'users.*'
            )
            ->leftjoin('users', 'users.id',  'point_rewards.user_id')
            ->orderby('point_rewards.id', 'desc')
            ->paginate(10);

        $data['objs'] = $objs;

        return view('admin.dashboard.point_checkin', $data);
    }

    public function wheel(){

        $objs = \DB::table('wheelsetting')->wherein('id', [1,2,3,4,5,6,7])->get();
        $data['objs'] = $objs;

        $data['sum'] = 1;
        return view('admin.wheel.index', $data);
    }

    public function get_point_create(){

      $package = new wheelsetting();
      $package->value = 1;
      $package->text = 1;
      $package->message = 1;
      $package->percent = 1;
      $package->minDegree = 1;
      $package->maxDegree = 1;
      $package->save();

      return redirect(url('admin/wheel/'))->with('add_success','????????????????????????????????????????????????????????? ??????????????????');

    }


    public function edit_point($id){

        $objs = \DB::table('wheelsetting')->where('id', $id)->first();
        $data['objs'] = $objs;
        

        $data['id'] = $id;
        return view('admin.wheel.edit', $data);

    }


    public function post_wheel(Request $request, $id){

        $this->validate($request, [
            'value' => 'required',
            'text' => 'required',
            'message' => 'required',
            'percent' => 'required'
        ]);

        $package = wheelsetting::find($id);
        $package->value = $request['value'];
        $package->text = $request['text'];
        $package->message = $request['message'];
        $package->percent = $request['percent'];
        $package->minDegree = $request['minDegree'];
        $package->maxDegree = $request['maxDegree'];
        $package->save();

      return redirect(url('admin/wheel/'))->with('edit_success','????????????????????????????????????????????????????????? ??????????????????');

    }



    public function import(Request $request){

        $this->validate($request, [
            'file' => 'required'
        ]);


      $data_csv = Excel::import(new UsersImport, request()->file('file'));
      
    //  $user = User::get();

    //   if(isset($user)){
    //     foreach($user as $j){

    //         // $details['phone'] = $j->phone;
    //         // $details['type'] = $j->type;
    //         // $details['point'] = $j->point;
    //         // $details['id'] = $j->id;

    //         // UserUpPoint::dispatch($details);

    //       /*  $total_point = 0;
    //         $objs = point::where('user_key', $j->phone)->get();

    //         foreach($objs as $u){
    //             if($u->type == 0){
    //                 $total_point += $u->point;
    //             }elseif($u->type == 2){
    //             $total_point += $u->point;
    //             }else{
    //                 $total_point -= $u->point;
    //             }
    //         }

    //         $package = User::find($j->id);
    //         $package->point = $total_point;
    //         $package->save(); */

    //     }
    // }
        

     // dd($data_csv);

        return redirect(url('admin/get_point/'))->with('add_success','????????????????????????????????????????????????????????? ??????????????????');
    }



    public function get_point(){

        $point_count = DB::table('points')->select(
            'points.*',
            'points.id as idp',
            'points.point as points',
            'users.*',
            'users.id as idu'
            )
            ->leftjoin('users', 'users.phone', '=', 'points.user_key')
            ->orderby('points.id', 'desc')
            ->count();

        $point = DB::table('points')->select(
            'points.*',
            'points.id as idp',
            'points.point as points',
            'users.*',
            'users.id as idu'
            )
            ->leftjoin('users', 'users.phone', 'points.user_key')
            ->orderby('points.id', 'desc')
            ->paginate(20);
            

        $data['point_count'] = $point_count;
        $data['point'] = $point;
        return view('admin.dashboard.get_point', $data);
    }
}
