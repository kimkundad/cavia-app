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
use App\Exports\PointsExport;
use App\Exports\OrderExport;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

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


    public function points_export() 
    {
        return Excel::download(new PointsExport, 'point.xlsx');
    }

    public function orders_export() 
    {
        return Excel::download(new OrderExport, 'orders.xlsx');
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

        return redirect(url('/admin/point_checkin'))->with('edit_success','เพิ่ม เสร็จเรียบร้อยแล้ว');

    }

    public function del_checkin_all(){

        point_reward::truncate();

        return redirect(url('/admin/point_checkin'))->with('edit_success','เพิ่ม เสร็จเรียบร้อยแล้ว');
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

      return redirect(url('admin/wheel/'))->with('add_success','คุณทำการเพิ่มอสังหา สำเร็จ');

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

      return redirect(url('admin/wheel/'))->with('edit_success','คุณทำการเพิ่มอสังหา สำเร็จ');

    }



    public function import(Request $request){

        $this->validate($request, [
            'file' => 'required'
        ]);

        // $upload = $request->file('file');
        
        // $filePath = $upload->getRealPath();

        // //Read the file
        // $file=fopen($filePath, 'r');

        // $header = fgetcsv($file);

        // //Loop through the columns
        // while ($columns = fgetcsv($file)){

        //     //$data['total_valid_bet_amount']

        //     $data = array_combine($header, $columns);

        //     $point_last = DB::table('points')->where('user_key', $data['user_key'])->orderby('id', 'desc')->first();
        //     $point = 0;
        //     $get_point = 0;
        //     $get_user = User::where('phone', $data['user_key'])->count();

        //     if(isset($point_last)){
        //         if($point_last->date == $data['date']){
                        
        //         }else{

        //             $get_point = 0;

        //     if($get_user > 0){

        //         $get_point = ($data['total_valid_bet_amount']*(2))/100;

        //         \DB::table('users')->where('phone', $data['user_key'])->increment('point', $get_point);
                
        //     }else{

        //         if($get_user == 0){

        //         $get_point = ($data['total_valid_bet_amount']*(2))/100;
        //         $pass = (\random_int(1000, 9999)).''.(\random_int(1000, 9999)).''.(\random_int(10, 99));
        //         $ran = array("1483537975.png","1483556517.png","1483556686.png");

        //         $user = User::create([
        //             'name' => $data['user_key'],
        //             'email' => (\random_int(1000000, 9999999)).'@gmail.com',
        //             'password' => Hash::make($pass),
        //             'is_admin' => false,
        //             'provider' => 'email',
        //             'avatar' => $ran[array_rand($ran, 1)],
        //             'code_user' => $pass,
        //             'phone' => $data['user_key'],
        //             'point' => $get_point,
        //           ]);

        //         $user
        //         ->roles()
        //         ->attach(Role::where('name', 'user')->first());

        //         }

        //     }

                    
        //         }
        //     }else{

        //         $get_point = 0;
            
        //         if($get_user > 0){
    
        //             $get_point = ($data['total_valid_bet_amount']*(2))/100;
    
        //             \DB::table('users')->where('phone', $data['user_key'])->increment('point', $get_point);
        //         }else{
    
        //             if($get_user == 0){
    
        //             $get_point = ($data['total_valid_bet_amount']*(2))/100;
        //             $pass = (\random_int(1000, 9999)).''.(\random_int(1000, 9999)).''.(\random_int(10, 99));
        //             $ran = array("1483537975.png","1483556517.png","1483556686.png");
    
        //             $user = User::create([
        //                 'name' => $data['user_key'],
        //                 'email' => (\random_int(1000000, 9999999)).'@gmail.com',
        //                 'password' => Hash::make($pass),
        //                 'is_admin' => false,
        //                 'provider' => 'email',
        //                 'avatar' => $ran[array_rand($ran, 1)],
        //                 'code_user' => $pass,
        //                 'phone' => $data['user_key'],
        //                 'point' => $get_point,
        //               ]);
    
        //             $user
        //             ->roles()
        //             ->attach(Role::where('name', 'user')->first());
    
        //             }
    
        //         }
        //     }


        //     if(isset($point_last)){

        //         $point = 0;
        //     $get_point = 0;

        //     $point = $point_last->last_point;
        //     //20
        //     $get_point = ($data['total_valid_bet_amount']*(2))/100;
        //     $point = $point + $get_point;

        //     if($point_last->date == $data['date']){
                
        //     }else{

        //         point::create([
        //             'user_key'  => $data['user_key'],
        //             'date'  =>  $data['date'],
        //             'total_valid_bet_amount'  =>  $data['total_valid_bet_amount'],
        //             'point'  => $get_point,
        //             'last_point'  => $point,
        //           ]);

        //     }

        //     }else{

        //         $point = 0;
        //     $get_point = 0;

        //     $get_point = ($data['total_valid_bet_amount']*(2))/100;
        //     $point = $get_point;

        //     point::create([
        //         'user_key'  => $data['user_key'],
        //         'date'  =>  $data['date'],
        //         'total_valid_bet_amount'  =>  $data['total_valid_bet_amount'],
        //         'point'  => $get_point,
        //         'last_point'  => $point,
        //       ]);


        //     }

        // }

      //  dd(request()->file('file'));

      $data_csv = Excel::import(new UsersImport, request()->file('file'));
      dd($data_csv);
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

        return redirect(url('admin/get_point/'))->with('add_success','คุณทำการเพิ่มอสังหา สำเร็จ');
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
