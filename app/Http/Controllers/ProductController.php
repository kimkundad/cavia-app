<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use App\Models\product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $count = product::count();
        $objs = product::orderby('id', 'desc')->paginate(15);
        $data['objs'] = $objs;
        $data['count'] = $count;
        return view('admin.product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['method'] = "post";
        $data['url'] = url('admin/product');
        return view('admin.product.create', $data);
    }


    public function product_status(Request $request){

        //  dd($request->all());
    
          $user = product::findOrFail($request->user_id);
    
                  if($user->status == 1){
                      $user->status = 0;
                  } else {
                      $user->status = 1;
                  }
    
          return response()->json([
          'data' => [
            'success' => $user->save(),
          ]
        ]);
    
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

        $image = $request->file('image');

        $this->validate($request, [
            'name' => 'required',
            'detail' => 'required',
            'point' => 'required',
            'stock' => 'required',
            'image' => 'required'
        ]);

        $path = 'assets/img/products/';
        $filename = time()."-".$image->getClientOriginalName();
        $image->move($path, $filename);

      $package = new product();
      $package->name = $request['name'];
      $package->detail = $request['detail'];
      $package->stock = $request['stock'];
      $package->image = $filename;
      $package->point = $request['point'];
      $package->status_2 = $request['status_2'];
      $package->save();

      return redirect(url('admin/product/'))->with('add_success','คุณทำการเพิ่มอสังหา สำเร็จ');
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
        $objs = DB::table('products')
            ->where('products.id', $id)
            ->first();

        $data['objs'] = $objs;
        $data['method'] = "put";
        $data['url'] = url('admin/product/'.$id);
        return view('admin.product.edit', $data);
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

        $image = $request->file('image');

        $this->validate($request, [
            'name' => 'required',
            'detail' => 'required',
            'point' => 'required',
            'stock' => 'required'
        ]);

        if($image != NULL){

            $objs = DB::table('products')
               ->where('id', $id)
               ->first();

               if(isset($objs->image)){
                $file_path = 'assets/img/products/'.$objs->image;
                 unlink($file_path);
               }


                 $path = 'assets/img/products/';
            $filename = time()."-".$image->getClientOriginalName();
            $image->move($path, $filename);

          $package = product::find($id);
          $package->image = $filename;
          $package->save();


        }
        
        $package = product::find($id);
        $package->name = $request['name'];
        $package->detail = $request['detail'];
        $package->stock = $request['stock'];
        $package->point = $request['point'];
        $package->status_2 = $request['status_2'];
        $package->save();

      return redirect(url('admin/product/'))->with('edit_success','คุณทำการเพิ่มอสังหา สำเร็จ');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function del_product($id)
    {
        //

        $objs = DB::table('products')
            ->where('id', $id)
            ->first();

            if(isset($objs->image)){
              $file_path = 'assets/img/products/'.$objs->image;
               unlink($file_path);
            }
            

             DB::table('products')->where('id', $id)->delete();
             return redirect(url('admin/product'))->with('del_success','คุณทำการเพิ่มอสังหา สำเร็จ');
    }
}
