<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\point;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class UserController extends Controller
{
    //
    public function index()
    {
        $userRole = Auth::user()->roles[0]->name; // ดึง Role ของ User ที่ Login

        // เริ่ม Query โดยไม่แสดง SuperAdmin (role_id = 1)
        $query = User::whereNotIn('id', function ($q) {
            $q->select('user_id')->from('role_user')->where('role_id', 1);
        });

        // ถ้าเป็น Operator ให้แสดงเฉพาะลูกค้า (role_id = 3)
        if ($userRole === 'operator') {
            $query->whereHas('roles', function ($q) {
                $q->where('role_id', 3);
            });
        }

        // นับจำนวน User ที่พบ
        $count_user = $query->count();

        // ดึงข้อมูล User
        $objs = $query->orderBy('id', 'desc')->paginate(15);

        return view('admin.user.index', [
            'count_user' => $count_user,
            'objs' => $objs
        ]);
    }

    public function create()
    {
        //
        $data['pass'] = (\random_int(1000, 9999)).''.(\random_int(1000, 9999)).''.(\random_int(10, 99));
        $data['method'] = "post";
        $data['url'] = url('admin/users');
        return view('admin.user.create', $data);
    }



    public function user_search(Request $request)
{
    $this->validate($request, [
        'search' => 'required'
    ]);

    $search = $request->get('search');
    $userRole = Auth::user()->roles[0]->name; // ดึง Role ของผู้ใช้ที่ Login

    // เริ่มต้น Query ค้นหา User
    $query = User::where('name', 'like', "%$search%");

    // กรองไม่ให้ค้นหา SuperAdmin (role_id = 1)
    $query->whereNotIn('id', function ($q) {
        $q->select('user_id')->from('role_user')->where('role_id', 1);
    });

    // ถ้าเป็น Operator ค้นหาได้แค่ลูกค้า (role_id = 3)
    if ($userRole === 'operator') {
        $query->whereHas('roles', function ($q) {
            $q->where('role_id', 3);
        });
    }

    // ดึงข้อมูลตามเงื่อนไขทั้งหมด
    $cat = $query->paginate(15);

    return view('admin.user.search', ['objs' => $cat, 'search' => $search]);
}


    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'phone' => 'required',
            'password' => 'required'
        ]);

        $ran = array("1483537975.png","1483556517.png","1483556686.png");

       $package = new User();
       $package->name = $request['name'];
       $package->phone = $request['phone'];
       $package->email = (\random_int(1000000, 9999999)).'@gmail.com';
       $package->provider = 'email';
       $package->is_admin = false;
       $package->avatar = $ran[array_rand($ran, 1)];
       $package->password = Hash::make($request['password']);
       $package->code_user = $request['password'];
       $package->point = $request['point'];
       $package->save();

       $role = Role::find($request->status_2);

       $package
       ->roles()
       ->attach(Role::where('name', $role->name)->first());

       return redirect(url('admin/users/'))->with('add_success','คุณทำการเพิ่มอสังหา สำเร็จ');
    }

    public function edit($id)
    {
        //


        $cat2 = DB::table('role_user')
       ->where('user_id', $id)
       ->first();

       $data['cat2'] = $cat2;

        $obj = User::find($id);
        $data['url'] = url('admin/users/'.$id);
        $data['method'] = "put";

        $point = point::where('user_key', $obj->phone)->orderby('id', 'desc')->paginate(15);
        $data['point'] = $point;

        $sumpoint = point::where('user_key', $obj->phone)->where('type', 0)->orwhere('type', 2)->sum('point');
        $data['sumpoint'] = $sumpoint;

        $sumpointdel = point::where('user_key', $obj->phone)->where('type', 1)->sum('point');
        $data['sumpointdel'] = $sumpointdel;

      //  dd($point_final);
        $data['objs'] = $obj;
        return view('admin.user.edit', $data);
    }


    public function update_point($id){

         $obj = User::find($id);
        // $point_final = point::where('user_key', $obj->phone)->orderby('id', 'desc')->first();

        // $package = User::find($id);
        // $package->point = $point_final->last_point;
        // $package->save();

        $objs = point::where('user_key', $obj->phone)->get();

      //  dd($objs);
        $total_point = 0;
        foreach($objs as $u){
            if($u->type == 0){
                $total_point += $u->point;
            }elseif($u->type == 2){
                $total_point += $u->point;
            }else{
                $total_point -= $u->point;
            }

            $ob = point::find($u->id);
            $ob->last_point = $total_point;
            $ob->save();

       }

       $package = User::find($id);
        $package->point = $total_point;
        $package->save();

        return redirect(url('admin/users/'.$id.'/edit'))->with('edit_success','คุณทำการเพิ่มอสังหา สำเร็จ');
    }

    public function del_point_user_2($id){

        $point = point::where('id', $id)->first();
        DB::table('points')->where('id', $id)->delete();

    //     $user = User::where('phone', $point->user_key)->first();
    //     $total_point = 0;
    //     $objs = point::where('user_key', $point->user_key)->get();

    //     foreach($objs as $u){
    //         if($u->type == 0){
    //             $total_point += $u->point;
    //         }else{
    //             $total_point -= $u->point;
    //         }
    //    }

    //    if(isset($user)){

    //     $package = User::find($user->id);
    //     $package->point = $total_point;
    //     $package->save();

    //    }


       return redirect(url('admin/get_point'))->with('edit_success','คุณทำการเพิ่มอสังหา สำเร็จ');

    }

    public function del_point_user(Request $request, $id){

        $point = point::where('id', $id)->first();
        DB::table('points')->where('id', $id)->delete();

        $user = User::where('phone', $point->user_key)->first();
    //    $total_point = 0;
    //    $objs = point::where('user_key', $point->user_key)->get();

    //     foreach($objs as $u){
    //         if($u->type == 0){
    //             $total_point += $u->point;
    //         }elseif($u->type == 2){
    //             $total_point += $u->point;
    //         }else{
    //             $total_point -= $u->point;
    //         }
    //    }

    //    $package = User::find($user->id);
    //    $package->point = $total_point;
    //    $package->save();

       return redirect(url('admin/users/'.$user->id.'/edit'))->with('edit_success','คุณทำการเพิ่มอสังหา สำเร็จ');

    }

    public function add_point_user(Request $request, $id){

        $this->validate($request, [
            'date' => 'required',
            'phone' => 'required',
            'xpoint' => 'required'
        ]);

        $totalValidBetAmount = floatval($request['xpoint'] ?? 0);

        $get_point = ($totalValidBetAmount*(2))/100;

     //   dd($get_point);


        $package = new point();
       $package->user_key = $request['phone'];
       $package->date = $request['date'];
       $package->total_valid_bet_amount = $request['xpoint'];
       $package->point = $get_point;
       $package->type = 0;
       $package->status = 0;
       $package->save();

       $user_key = $request['phone'];

       $user = User::where('phone', $user_key)->first();

       $total_point = $user->point + $get_point;
    //    $total_point = 0;

    //    $objs = point::where('user_key', $user_key)->get();

    //    foreach($objs as $u){
    //         if($u->type == 0){
    //             $total_point += $u->point;
    //         }elseif($u->type == 2){
    //             $total_point += $u->point;
    //         }else{
    //             $total_point -= $u->point;
    //         }
    //    }

       $ob = point::find($package->id);
       $ob->last_point = $total_point;
       $ob->save();

       $package = User::find($user->id);
       $package->point = $total_point;
       $package->save();

       return redirect(url('admin/users/'.$request['myid'].'/edit'))->with('edit_success','คุณทำการเพิ่มอสังหา สำเร็จ');

    }


    public function update(Request $request, $id)
{
    // Validate ข้อมูล
    $this->validate($request, [
        'phone' => 'required',
        'password' => 'required'
    ]);

    $user = User::findOrFail($id);
    $oldData = $user->toArray(); // เก็บค่าเดิมก่อนเปลี่ยนแปลง

    $new_point = 0;
    $logDetails = [];

    // กรณีลด Point
    if ($user->point > $request['point']) {
        $new_point = $user->point - $request['point'];

        $package1 = new point();
            $package1->user_key = $user->phone;
            $package1->date = date('Y-m-d');
            $package1->total_valid_bet_amount = 0;
            $package1->point = $new_point;
            $package1->type = 1;
            $package1->last_point = $user->point-$new_point;
            $package1->detail = 'admin : '.Auth::user()->name.' ( '.Auth::user()->id.' ) ทำการลด point '.$new_point.' user : '.$user->name;
            $package1->save();

        $logDetails[] = "Admin " . Auth::user()->name . " ลด Point จาก " . $user->point . " เหลือ " . $request['point'] . " ให้ User: " . $user->name;
    }

    // กรณีเพิ่ม Point
    if ($user->point < $request['point']) {
        $new_point = $request['point'] - $user->point;

        $package1 = new point();
            $package1->user_key = $user->phone;
            $package1->date = date('Y-m-d');
            $package1->total_valid_bet_amount = 0;
            $package1->point = $new_point;
            $package1->type = 2;
            $package1->last_point = $user->point+$new_point;
            $package1->detail = 'admin : '.Auth::user()->name.' ( '.Auth::user()->id.' ) ทำการเพิ่ม point '.$new_point.' user : '.$user->name;
            $package1->save();

        $logDetails[] = "Admin " . Auth::user()->name . " เพิ่ม Point จาก " . $user->point . " เป็น " . $request['point'] . " ให้ User: " . $user->name;
    }

    // ตรวจสอบการเปลี่ยนแปลงอื่น ๆ
    if ($user->name !== $request['name']) {
        $logDetails[] = "ชื่อผู้ใช้เปลี่ยนจาก '{$user->name}' เป็น '{$request['name']}'";
    }
    if ($user->phone !== $request['phone']) {
        $logDetails[] = "เบอร์โทรเปลี่ยนจาก '{$user->phone}' เป็น '{$request['phone']}'";
    }
    if (!Hash::check($request['password'], $user->password)) {
        $logDetails[] = "Admin " . Auth::user()->name . " เปลี่ยนรหัสผ่านให้ User: " . $user->name;
    }

    // บันทึกการเปลี่ยนแปลง
    $user->name = $request['name'];
    $user->phone = $request['phone'];
    $user->password = Hash::make($request['password']);
    $user->code_user = $request['password'];
    $user->point = $request['point'];
    $user->save();

    // บันทึก Log ถ้ามีการเปลี่ยนแปลง
    if (!empty($logDetails)) {
        ActivityLog::create([
            'admin_id' => Auth::id(), // Admin ที่แก้ไข
            'action' => 'อัปเดตข้อมูลผู้ใช้',
            'details' => implode(', ', $logDetails)
        ]);
    }

    return redirect(url('admin/users/' . $id . '/edit'))->with('edit_success', 'คุณทำการแก้ไขข้อมูลผู้ใช้สำเร็จ');
}


    public function del_user($id)
    {
        //

        if($id == 1 || $id == 2){

        }else{

            $obj = DB::table('users')
            ->where('id', $id)
            ->delete();

        }

        return redirect(url('admin/users/'))->with('delete','ลบข้อมูล สำเร็จ');
    }




}
