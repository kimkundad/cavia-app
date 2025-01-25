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
use Carbon\Carbon;

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


    public function cleanupOldPoints()
    {
        try {
            // คำนวณวันที่ย้อนหลัง 3 เดือน
            $threeMonthsAgo = Carbon::now()->subMonths(3);

            // ลบ records ที่มี date ย้อนหลังเกิน 3 เดือน (และเป็น พ.ศ.)
            $deleted = Point::whereRaw("STR_TO_DATE(CONCAT(YEAR(date) - 543, '-', MONTH(date), '-', DAY(date)), '%Y-%m-%d') < ?", [
                $threeMonthsAgo->format('Y-m-d')
            ])->delete();

            return response()->json([
                'success' => true,
                'message' => "ลบข้อมูลสำเร็จ: $deleted records deleted."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
            ], 500);
        }
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


    private function processUserPoints(array $data)
{
    // แปลง total_valid_bet_amount เป็น float
    $totalValidBetAmount = floatval($data['total_valid_bet_amount'] ?? 0);

    // ตรวจสอบ user_key ว่ามีอยู่หรือไม่
    $lastPoint = DB::table('points')
        ->where('user_key', $data['user_key'])
        ->orderBy('id', 'desc')
        ->first();

    $userExists = User::where('phone', $data['user_key'])->exists();

    // คำนวณ point
    $getPoint = ($totalValidBetAmount * 2) / 100;

    if ($userExists) {
        User::where('phone', $data['user_key'])->increment('point', $getPoint);
    } else {
        $this->createNewUser($data, $getPoint);
    }

    // เพิ่มข้อมูล point ใหม่หากจำเป็น
    if (!$lastPoint || $lastPoint->date !== $data['date']) {
        $lastPointValue = $lastPoint ? $lastPoint->last_point : 0;
        $newPointValue = $lastPointValue + $getPoint;

        Point::create([
            'user_key' => $data['user_key'],
            'date' => $data['date'],
            'total_valid_bet_amount' => $totalValidBetAmount,
            'point' => $getPoint,
            'last_point' => $newPointValue,
        ]);
    }
}


/**
 * Create a new user with random values and points
 */
private function createNewUser(array $data, float $getPoint)
{
    $password = rand(10000000, 99999999);
    $avatars = ["1483537975.png", "1483556517.png", "1483556686.png"];

    $user = User::create([
        'name' => $data['user_key'],
        'email' => rand(1000000, 9999999) . '@gmail.com',
        'password' => Hash::make($password),
        'is_admin' => false,
        'provider' => 'email',
        'avatar' => $avatars[array_rand($avatars)],
        'code_user' => $password,
        'phone' => $data['user_key'],
        'point' => $getPoint,
    ]);

    // Assign 'user' role
    $user->roles()->attach(Role::where('name', 'user')->first());
}



    // public function import(Request $request){

    //     $this->validate($request, [
    //         'file' => 'required'
    //     ]);

    //     $upload = $request->file('file');

    //     $filePath = $upload->getRealPath();

    //     //Read the file
    //     $file=fopen($filePath, 'r');

    //     $header = fgetcsv($file);

    //     //Loop through the columns
    //     while ($columns = fgetcsv($file)){

    //         //$data['total_valid_bet_amount']

    //         $data = array_combine($header, $columns);

    //         $point_last = DB::table('points')->where('user_key', $data['user_key'])->orderby('id', 'desc')->first();
    //         $point = 0;
    //         $get_point = 0;
    //         $get_user = User::where('phone', $data['user_key'])->count();

    //         if(isset($point_last)){
    //             if($point_last->date == $data['date']){

    //             }else{

    //                 $get_point = 0;

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


    //             }
    //         }else{

    //             $get_point = 0;

    //             if($get_user > 0){

    //                 $get_point = ($data['total_valid_bet_amount']*(2))/100;

    //                 \DB::table('users')->where('phone', $data['user_key'])->increment('point', $get_point);
    //             }else{

    //                 if($get_user == 0){

    //                 $get_point = ($data['total_valid_bet_amount']*(2))/100;
    //                 $pass = (\random_int(1000, 9999)).''.(\random_int(1000, 9999)).''.(\random_int(10, 99));
    //                 $ran = array("1483537975.png","1483556517.png","1483556686.png");

    //                 $user = User::create([
    //                     'name' => $data['user_key'],
    //                     'email' => (\random_int(1000000, 9999999)).'@gmail.com',
    //                     'password' => Hash::make($pass),
    //                     'is_admin' => false,
    //                     'provider' => 'email',
    //                     'avatar' => $ran[array_rand($ran, 1)],
    //                     'code_user' => $pass,
    //                     'phone' => $data['user_key'],
    //                     'point' => $get_point,
    //                   ]);

    //                 $user
    //                 ->roles()
    //                 ->attach(Role::where('name', 'user')->first());

    //                 }

    //             }
    //         }


    //         if(isset($point_last)){

    //             $point = 0;
    //         $get_point = 0;

    //         $point = $point_last->last_point;
    //         //20
    //         $get_point = ($data['total_valid_bet_amount']*(2))/100;
    //         $point = $point + $get_point;

    //         if($point_last->date == $data['date']){

    //         }else{

    //             point::create([
    //                 'user_key'  => $data['user_key'],
    //                 'date'  =>  $data['date'],
    //                 'total_valid_bet_amount'  =>  $data['total_valid_bet_amount'],
    //                 'point'  => $get_point,
    //                 'last_point'  => $point,
    //               ]);

    //         }


    //         }else{

    //             $point = 0;
    //         $get_point = 0;

    //         $get_point = ($data['total_valid_bet_amount']*(2))/100;
    //         $point = $get_point;

    //         point::create([
    //             'user_key'  => $data['user_key'],
    //             'date'  =>  $data['date'],
    //             'total_valid_bet_amount'  =>  $data['total_valid_bet_amount'],
    //             'point'  => $get_point,
    //             'last_point'  => $point,
    //           ]);


    //         }

    //     }



    //     return redirect(url('admin/get_point/'))->with('add_success','คุณทำการเพิ่มอสังหา สำเร็จ');
    // }



    public function import(Request $request)
{
    $this->validate($request, [
        'file' => 'required|file',
    ]);

    $file = $request->file('file');
    $filePath = $file->getRealPath();

    // Read the CSV file
    $handle = fopen($filePath, 'r');
    $header = fgetcsv($handle);

    DB::beginTransaction();

    try {
        while ($row = fgetcsv($handle)) {
            $data = array_combine($header, $row);

            // ข้ามแถวที่ `user_key` ว่าง
            if (empty($data['user_key']) || trim($data['user_key']) === '') {
                continue;
            }

            // Process the row
            $this->processUserPoints($data);
        }

        DB::commit();
        fclose($handle);

        return redirect(url('admin/get_point/'))->with('add_success', 'การเพิ่มข้อมูลสำเร็จ!');
    } catch (\Exception $e) {
        DB::rollBack();
        fclose($handle);

        // Log the error for debugging
        \Log::error('Error during import: ' . $e->getMessage());

        return redirect()->back()->withErrors('เกิดข้อผิดพลาดระหว่างการนำเข้าข้อมูล: ' . $e->getMessage());
    }
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
            ->paginate(20)->onEachSide(2);


        $data['point_count'] = $point_count;
        $data['point'] = $point;
        return view('admin.dashboard.get_point', $data);
    }
}
