<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use App\Models\slide;
use Auth;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $objs = DB::table('slides')
                ->Orderby('id', 'desc')
                ->paginate(15);

        $data['objs'] = $objs;
        return view('admin.slide.index', $data);
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
        $data['url'] = url('admin/slide_show');
        return view('admin.slide.create', $data);
    }


    public function slide_status(Request $request){

        //  dd($request->all());
    
          $user = slide::findOrFail($request->user_id);
    
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
             'image' => 'required',
             'title' => 'required',
             'url_btn' => 'required'
         ]);

            $path = 'img/slide/';
            $filename = time()."-".$image->getClientOriginalName();
            $image->move($path, $filename);

      $package = new slide();
      $package->title = $request['title'];
      $package->detail = $request['detail'];
      $package->url_btn = $request['url_btn'];
      $package->image = $filename;
      $package->save();

      return redirect(url('admin/slide_show/'))->with('add_success','คุณทำการเพิ่มอสังหา สำเร็จ');
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
        $objs = slide::find($id);

        $data['url'] = url('admin/slide_show/'.$id);
        $data['method'] = "put";
        $data['objs'] = $objs;
        return view('admin.slide.edit', $data);
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
            'title' => 'required',
            'url_btn' => 'required'
         ]);


      $package = slide::find($id);
      $package->title = $request['title'];
      $package->detail = $request['detail'];
      $package->url_btn = $request['url_btn'];
      $package->save();

      if($image != NULL){

        $objs = DB::table('slides')
               ->where('id', $id)
               ->first();

               if(isset($objs->image)){
                $file_path = 'img/slide/'.$objs->image;
                 unlink($file_path);
              }

            $path = 'img/slide/';
            $filename = time()."-".$image->getClientOriginalName();
            $image->move($path, $filename);

          $package = slide::find($id);
          $package->image = $filename;
          $package->save();

      }
      return redirect(url('admin/slide_show/'))->with('edit_success','คุณทำการเพิ่มอสังหา สำเร็จ');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function del_slide($id)
    {
        $objs = DB::table('slides')
            ->where('id', $id)
            ->first();

            if(isset($objs->image)){
              $file_path = 'img/slide/'.$objs->image;
               unlink($file_path);
            }
             DB::table('slides')->where('id', $id)->delete();
             return redirect(url('admin/slide_show'))->with('del_success','คุณทำการเพิ่มอสังหา สำเร็จ');
        //
    }
}
