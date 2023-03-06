<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\setting;
use Auth;

class SettingController extends Controller
{
    //
        public function setting(){

            $objs = DB::table('settings')
                ->Where('id', 1)
                ->first();

            $data['objs'] = $objs;
            return view('admin.setting.index', $data);

        }
        

        public function post_setting(Request $request){

            $image = $request->file('image');
            $line_img = $request->file('line_img');

            $banner_point = $request->file('banner_point');
            $banner_his = $request->file('banner_his');
            $banner_login = $request->file('banner_login');

        
            $id = 1;
            $obj = setting::find($id);
            $obj->nme_website = $request['nme_website'];
            $obj->facebook = $request['facebook'];
            $obj->get_my_file = $request['get_my_file'];
            $obj->facebook_url = $request['facebook_url'];
            $obj->twitter = $request['twitter'];
            $obj->facebook_title = $request['facebook_title'];
            $obj->facebook_detail = $request['facebook_detail'];
            $obj->line_oa = $request['line_oa'];
            $obj->line_oa_url = $request['line_oa_url'];
            $obj->line_token = $request['line_token'];
            $obj->phone = $request['phone'];
            $obj->email = $request['email'];
            $obj->google_analytic = $request['google_analytic'];
            $obj->save();

           if($image != NULL){

           $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
           $img = Image::make($image->getRealPath());
           $img->resize(800, 800, function ($constraint) {
           $constraint->aspectRatio();
           })->save('img/setting/'.$input['imagename']);

            $obj = setting::find($id);
            $obj->facebook_image = $input['imagename'];
            $obj->save();

            }

            if($line_img != NULL){

                $path1 = 'img/setting/';
        $filename1 = (\random_int(1000000, 9999999))."-".$line_img->getClientOriginalName();
        $line_img->move($path1, $filename1);

        $objq = setting::find($id);
        $objq->line_img = $filename1;
        $objq->save();

            }



            if($banner_point != NULL){

                $path2 = 'img/setting/';
        $filename2 = (\random_int(1000000, 9999999))."-".$banner_point->getClientOriginalName();
        $banner_point->move($path2, $filename2);

        $objq = setting::find($id);
        $objq->banner_point = $filename2;
        $objq->save();

            }


            if($banner_his != NULL){

                $path3 = 'img/setting/';
        $filename3 = (\random_int(1000000, 9999999))."-".$banner_his->getClientOriginalName();
        $banner_his->move($path3, $filename3);

        $objq = setting::find($id);
        $objq->banner_his = $filename3;
        $objq->save();

            }


            if($banner_login != NULL){

                $path4 = 'img/setting/';
        $filename4 = (\random_int(1000000, 9999999))."-".$banner_login->getClientOriginalName();
        $banner_login->move($path4, $filename4);

        $objq = setting::find($id);
        $objq->banner_login = $filename4;
        $objq->save();

            }

            return redirect(url('admin/setting/'))->with('add_success','คุณทำการเพิ่มอสังหา สำเร็จ');

        }
        
}
