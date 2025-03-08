<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

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
        $count = Product::where('type', 0)->count();
        $objs = Product::where('type', 0)->orderby('id', 'desc')->paginate(15);
        $data['objs'] = $objs;
        $data['count'] = $count;
        return view('admin.product.index', $data);
    }


    public function creditProduct(){

        $count = Product::where('type', 1)->count();
        $objs = Product::where('type', 1)->orderby('id', 'desc')->paginate(15);
        $data['objs'] = $objs;
        $data['count'] = $count;
        return view('admin.product.creditProduct', $data);

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


    public function product_status(Request $request)
{
    $product = Product::findOrFail($request->user_id);
    $oldStatus = $product->status;

    // สลับค่า status (0 -> 1, 1 -> 0)
    $product->status = $product->status == 1 ? 0 : 1;
    $product->save();

    // แปลงค่า status เป็นข้อความที่เข้าใจง่าย
    $statusText = $product->status == 1 ? 'เปิดใช้งาน' : 'ปิดใช้งาน';
    $oldStatusText = $oldStatus == 1 ? 'เปิดใช้งาน' : 'ปิดใช้งาน';

    // บันทึก Log
    ActivityLog::create([
        'admin_id' => Auth::id(), // Admin ที่แก้ไข
        'action' => 'เปลี่ยนสถานะสินค้า',
        'details' => "Admin ".Auth::user()->name." เปลี่ยนสถานะของสินค้า '{$product->name}' จาก '{$oldStatusText}' เป็น '{$statusText}'"
    ]);

    return response()->json([
        'data' => [
            'success' => true,
            'status' => $product->status
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
    $product->type = $request->input('type');
    $product->credit = $request->input('credit');
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
    $product = Product::findOrFail($id);

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
    $product->type = $request->input('type');
    $product->credit = $request->input('credit');
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
