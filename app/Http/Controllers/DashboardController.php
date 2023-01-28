<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\slide;
use App\Models\order;
use App\Models\point;
use App\Models\product;
use App\Imports\UsersImport;
use Excel;
use App\Jobs\UserUpPoint;

class DashboardController extends Controller
{
    //
    public function index(){

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
