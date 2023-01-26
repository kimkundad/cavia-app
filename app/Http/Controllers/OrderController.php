<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use App\Models\order;
use App\Models\order_detail;
use App\Models\product;
use App\Models\User;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $objs = order::orderby('id', 'desc')->paginate(15);

        if(isset($objs)){
            foreach($objs as $u){
                $user = User::where('id', $u->user_id)->first();
                if(isset($user)){
                    $u->user_name = $user->name;
                    $u->user_idx = $user->id;
                }
                
            }
        }

        $data['objs'] = $objs;
        return view('admin.order.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $objs = DB::table('orders')
            ->where('orders.id', $id)
            ->first();

        $data['objs'] = $objs;

        $detail = DB::table('order_details')
            ->where('order_no', $objs->id)
            ->get();

        $data['detail'] = $detail;

        $data['method'] = "put";
        $data['url'] = url('admin/order/'.$id);
        return view('admin.order.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $package = order::find($id);
        $package->track_no = $request['track_no'];
        $package->shipping = $request['shipping'];
        $package->name_order = $request['name_order'];
        $package->telephone_order = $request['telephone_order'];
        $package->address = $request['address'];
        $package->status = $request['status'];
        $package->save();

      return redirect(url('admin/order/'))->with('edit_success','คุณทำการเพิ่มอสังหา สำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function del_order($id)
    {
        //
        $objs = DB::table('orders')
            ->where('id', $id)
            ->first();

        DB::table('order_details')->where('order_no', $id)->delete();
        DB::table('orders')->where('id', $id)->delete();
        return redirect(url('admin/order'))->with('del_success','คุณทำการเพิ่มอสังหา สำเร็จ');
    }
}
