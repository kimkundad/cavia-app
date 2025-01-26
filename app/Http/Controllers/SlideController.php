<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use App\Models\slide;
use Auth;
use Illuminate\Support\Facades\Storage;

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


    private function deleteOldFile($fileUrl, $path)
{
    if ($fileUrl) {
        // Convert full URL to relative path
        $relativePath = str_replace('https://kingbar.sgp1.cdn.digitaloceanspaces.com/', '', $fileUrl);

        // Delete the file from DigitalOcean Spaces
        Storage::disk('do_spaces')->delete($relativePath);
    }
}


    private function uploadImage($image, $path)
    {
        if ($image) {
            // ตรวจสอบชนิดไฟล์
            $extension = $image->getClientOriginalExtension();

            // Generate unique filename
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $image->getClientOriginalName());

            if (strtolower($extension) === 'gif') {
                // อัปโหลด GIF โดยไม่ปรับขนาด
                Storage::disk('do_spaces')->putFileAs(
                    $path,
                    $image,
                    $filename,
                    'public'
                );
            } else {
                // Resize and prepare the image for non-GIF files
                $img = Image::make($image->getRealPath());
                $img->resize(800, 800, function ($constraint) {
                    $constraint->aspectRatio(); // Keep aspect ratio
                });
                $img->stream(); // Stream the resized image

                Storage::disk('do_spaces')->put(
                    "$path/$filename",
                    $img->__toString(),
                    'public'
                );
            }

            // Return the file URL
            return "https://kingbar.sgp1.cdn.digitaloceanspaces.com/$path/$filename";
        }

        return null;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'title' => 'required|string|max:255',
            'url_btn' => 'required',
            'detail' => 'nullable|string',
        ]);

        // Upload image to DigitalOcean Spaces
        $filename = $this->uploadImage($request->file('image'), 'cv168point/slide');

        // Save slide data to the database
        $slide = new Slide();
        $slide->title = $request->input('title');
        $slide->detail = $request->input('detail');
        $slide->url_btn = $request->input('url_btn');
        $slide->image = $filename; // Store the image URL
        $slide->save();

        return redirect(url('admin/slide_show/'))->with('add_success', 'เพิ่มข้อมูลสำเร็จ!');
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
        // Validation
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'url_btn' => 'required',
            'detail' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        // ค้นหา slide
        $slide = Slide::findOrFail($id);

        // อัปเดตข้อมูลพื้นฐาน
        $slide->title = $request->input('title');
        $slide->detail = $request->input('detail');
        $slide->url_btn = $request->input('url_btn');

        // ตรวจสอบว่าอัปโหลดรูปภาพใหม่หรือไม่
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // ลบรูปภาพเก่า (ถ้ามี)
            if ($slide->image) {
                $this->deleteOldFile($slide->image, 'cv168point/slide');
            }

            // อัปโหลดรูปภาพใหม่
            $filename = $this->uploadImage($image, 'cv168point/slide');
            $slide->image = $filename; // เก็บ URL ของรูปภาพใหม่
        }

        // บันทึกข้อมูล
        $slide->save();

        return redirect(url('admin/slide_show/'))->with('edit_success', 'แก้ไขข้อมูลสำเร็จ!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function del_slide($id)
    {
        try {
            // ค้นหา Slide ที่ต้องการลบ
            $slide = Slide::findOrFail($id);

            // ลบรูปภาพถ้ามี
            if ($slide->image) {
                $this->deleteOldFile($slide->image, 'cv168point/slide');
            }

            // ลบ Slide ออกจากฐานข้อมูล
            $slide->delete();

            return redirect(url('admin/slide_show'))->with('del_success', 'ลบข้อมูลสำเร็จ!');
        } catch (\Exception $e) {
            // จัดการข้อผิดพลาดและส่งข้อความแจ้งกลับ
            return redirect()->back()->withErrors('เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }
}
