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
use Auth;

class UserController extends Controller
{
    //
    public function index()
    {

        $count_user = User::where('id', '!=', 1 )->where('id', '!=', 2 )->orderby('id', 'desc')->count();
        $data['count_user'] = $count_user;

        $objs = User::where('id', '!=', 1 )->where('id', '!=', 2 )->orderby('id', 'desc')->paginate(15);
        $data['objs'] = $objs;
        return view('admin.user.index', $data);
    }

    public function create()
    {
        //
        $data['pass'] = (\random_int(1000, 9999)).''.(\random_int(1000, 9999)).''.(\random_int(10, 99));
        $data['method'] = "post";
        $data['url'] = url('admin/users');
        return view('admin.user.create', $data);
    }


    public function user_search(Request $request){

        $this->validate($request, [
          'search' => 'required'
        ]);
        $search = $request->get('search');
  
              $cat = DB::table('users')
                    ->where('name', 'like', "%$search%")
                    ->paginate(15);
  
              $data['objs'] = $cat;
              $data['search'] = $search;

              return view('admin.user.search', $data);
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

       $status_2 = $request['status_2'];

       if($status_2 == 0){

        $package
       ->roles()
       ->attach(Role::where('name', 'user')->first());
           
       }else{

        $package
       ->roles()
       ->attach(Role::where('name', 'admin')->first());

       }
       

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

        $user = User::where('phone', $point->user_key)->first();
        $total_point = 0;
        $objs = point::where('user_key', $point->user_key)->get();

        foreach($objs as $u){
            if($u->type == 0){
                $total_point += $u->point;
            }else{
                $total_point -= $u->point;
            }
       }

       if(isset($user)){

        $package = User::find($user->id);
        $package->point = $total_point;
        $package->save();

       }
       

       return redirect(url('admin/get_point'))->with('edit_success','คุณทำการเพิ่มอสังหา สำเร็จ');

    }

    public function del_point_user(Request $request, $id){

        $point = point::where('id', $id)->first();
        DB::table('points')->where('id', $id)->delete();

        $user = User::where('phone', $point->user_key)->first();
        $total_point = 0;
        $objs = point::where('user_key', $point->user_key)->get();

        foreach($objs as $u){
            if($u->type == 0){
                $total_point += $u->point;
            }elseif($u->type == 2){
                $total_point += $u->point;
            }else{
                $total_point -= $u->point;
            }
       }

       $package = User::find($user->id);
       $package->point = $total_point;
       $package->save();

       return redirect(url('admin/users/'.$user->id.'/edit'))->with('edit_success','คุณทำการเพิ่มอสังหา สำเร็จ');

    }

    public function add_point_user(Request $request, $id){

        $this->validate($request, [
            'date' => 'required',
            'phone' => 'required',
            'xpoint' => 'required'
        ]);

        $get_point = ($request['xpoint']*(2))/100;

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

       //$total_point = $user->point;
       $total_point = 0;

       $objs = point::where('user_key', $user_key)->get();
        
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

       return redirect(url('admin/users/'.$request['myid'].'/edit'))->with('edit_success','คุณทำการเพิ่มอสังหา สำเร็จ');

    }


    public function update(Request $request, $id)
    {
        //

        $this->validate($request, [
            'phone' => 'required',
            'password' => 'required'
        ]);


        $obj = User::find($id);
        //dd($obj->point);

        $new_point = 0;

        if($obj->point > $request['point']){

            // - point
            $new_point = $obj->point - $request['point'];

           

            $package1 = new point();
            $package1->user_key = $obj->phone;
            $package1->date = date('Y-m-d');
            $package1->total_valid_bet_amount = 0;
            $package1->point = $new_point;
            $package1->type = 1;
            $package1->last_point = $obj->point-$new_point;
            $package1->detail = 'admin : '.Auth::user()->name.' ( '.Auth::user()->id.' ) ทำการลด point '.$new_point.' user : '.$obj->name;
            $package1->save();

        }

        if($obj->point < $request['point']){

            // + point
            $new_point = $request['point'] - $obj->point;

            $package1 = new point();
            $package1->user_key = $obj->phone;
            $package1->date = date('Y-m-d');
            $package1->total_valid_bet_amount = 0;
            $package1->point = $new_point;
            $package1->type = 2;
            $package1->last_point = $obj->point+$new_point;
            $package1->detail = 'admin : '.Auth::user()->name.' ( '.Auth::user()->id.' ) ทำการเพิ่ม point '.$new_point.' user : '.$obj->name;
            $package1->save();

            
        }


            $package = User::find($id);
            $package->name = $request['name'];
            $package->phone = $request['phone'];
            $package->password = Hash::make($request['password']);
            $package->code_user = $request['password'];
            $package->point = $request['point'];
            $package->save(); 
        
       // dd($new_point);
       

       $status_2 = $request['status_2'];

       if($status_2 == 0){

        DB::table('role_user')
        ->where('user_id', $id)
        ->update(['role_id' => 3]);

       }else{

        DB::table('role_user')
        ->where('user_id', $id)
        ->update(['role_id' => 1]);

       }

       return redirect(url('admin/users/'.$id.'/edit'))->with('edit_success','คุณทำการเพิ่มอสังหา สำเร็จ');
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
