<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use App\Models\product;
use Illuminate\Support\Facades\Storage;

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

        $filename = $this->uploadImage($request->file('image'), 'cv168point/product');

    // Save product
    $product = new product();
    $product->name = $request->input('name');
    $product->detail = $request->input('detail');
    $product->stock = $request->input('stock');
    $product->point = $request->input('point');
    $product->status_2 = $request->input('status_2');
    $product->image = $filename; // Store image URL
    $product->save();

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

        // ค้นหา Product
    $product = product::findOrFail($id);

    // Update image if provided
    if ($request->hasFile('image')) {
        $image = $request->file('image');

        // ลบไฟล์เก่า
        if ($product->image) {
            $this->deleteOldFile($product->image, 'cv168point/product');
        }

        // อัปโหลดไฟล์ใหม่
        $filename = $this->uploadImage($image, 'cv168point/product');
        $product->image = $filename;
    }

    // Update product details
    $product->name = $request->input('name');
    $product->detail = $request->input('detail');
    $product->stock = $request->input('stock');
    $product->point = $request->input('point');
    $product->status_2 = $request->input('status_2', false);
    $product->save();

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
        try {
            // ค้นหา Product
            $product = Product::findOrFail($id);

            // ลบไฟล์ภาพถ้ามี
            if ($product->image) {
                $this->deleteOldFile($product->image, 'cv168point/product');
            }

            // ลบข้อมูลจากฐานข้อมูล
            $product->delete();

            return redirect(url('admin/product/'))->with('del_success', 'ลบข้อมูลสำเร็จ!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }

}
