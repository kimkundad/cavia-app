<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\product;
use App\Models\order;
use App\Models\User;
use App\Models\order_detail;
use App\Models\slide;
use App\Models\point;
use Session;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      //  dd(array(Session::get('cart')));

      $slide = slide::where('status', 1)->orderby('id', 'desc')->get();
        $data['slide'] = $slide;

        $objs = product::where('status', 1)->where('status_2', 0)->orderby('id', 'desc')->get();
        $data['objs'] = $objs;

        $obj = product::where('status', 1)->where('status_2', 1)->orderby('id', 'desc')->paginate(16);
        $data['obj'] = $obj;

        return view('welcome', $data);
    }


    public function upgame_Joker(){


        $url = 'https://production.otb-api.com/Joker';

        $response = file_get_contents($url);
        $newsData = json_decode($response);

        $uses = [];
  
        foreach($newsData->ListGames as $item) { //foreach element in $arr
                echo $item->GameCode; //etc
        }

      //  return response()->json($uses);

    }



    public function upgame_PGP(){


        $url = 'https://production.otb-api.com/Pragmatic';

        $response = file_get_contents($url);
        $newsData = json_decode($response);

        $uses = [];
  
        foreach($newsData->gameList as $item) { //foreach element in $arr
                echo $item->gameID; //etc
        }

      //  return response()->json($uses);

    }

    public function upgame_allgame1(){


        $url = 'https://production.otb-api.com/qtech/gamelist';

        $response = file_get_contents($url);
        $newsData = json_decode($response);

      //  \DB::connection('mysql2')->table('gamelists')->where('partner', 'jk')->update(['active' => 0]);

       \DB::connection('mysql2')->table('gamelists')->whereIn('partner', ['BNG', 'BPG', 'EVP', 'FNG', 'GA'])->update(['active' => 0]);
  
        foreach($newsData->items as $item) { //foreach element in $arr
               // echo $item->name; //etc
               \DB::connection('mysql2')->table('gamelists')->where('code', $item->id)->whereIn('partner', ['BNG', 'BPG', 'EVP', 'FNG', 'GA'])->update(['active' => 1]);
               $count = \DB::connection('mysql2')->table('gamelists')->where('code', $item->id)->whereIn('partner', ['BNG', 'BPG', 'EVP', 'FNG', 'GA'])->count();

               if($count == 0){

                $objs = \DB::connection('mysql2')->table('game_partners')->where('short_name', $item->provider)->first();
                $pieces = explode(" ", $objs->game_type);
                $obj = \DB::connection('mysql2')->table('game_type')->where('name', 'LIKE', "%$pieces[0]%")->first();

                if(isset($objs)){

                    \DB::connection('mysql2')->table('gamelists')->insert(
                        array(
                                   'partner' => 'jk',     
                                   'name' => $item->name,
                                   'code' => $item->id,
                                   'active' => 1,
                                   'game_type' => $obj->id,
                                   'date_time' => date("Y-m-d H:i:s")
                            )
                        );

                }
            }

        }

        return response()->json(['status' => 'success', 'message' => 'อัพเดทเกมส์ค่าย BNG, BPG, EVP, FNG, GA ']);

      //  return response()->json($uses);

    }




    public function cart()
    {
        return view('cart');
    }

    public function get_modal($id){

        $objs = product::where('id', $id)->first();
        $data['objs'] = $objs;
        return view('modal', $data);
    }

    public function add_my_order(Request $request){

        $this->validate($request, [
            'name_order' => 'required',
            'telephone_order' => 'required',
            'address' => 'required'
        ]);

        $randomSixDigitInt = 'ORDER'.(\random_int(1000000, 9999999));

          $package = new order();
          $package->user_id = Auth::user()->id;
          $package->name_order = $request['name_order'];
          $package->order_no = $randomSixDigitInt;
          $package->telephone_order = $request['telephone_order'];
          $package->address = $request['address'];
          $package->sum_point = $request['total'];
          $package->note = $request['note'];
          $package->save();

          $the_id = $package->id;

          $last = 0;

          $point_last = DB::table('points')->where('user_key', Auth::user()->phone)->orderby('id', 'desc')->first();
          
          if(isset($point_last)){
            $last = $point_last->last_point - $request['total'];
          }else{
            $last = Auth::user()->point;
          }
          

          $package1 = new point();
          $package1->user_key = Auth::user()->phone;
          $package1->date = date('Y-m-d');
          $package1->total_valid_bet_amount = 0;
          $package1->point = $request['total'];
          $package1->type = 1;
          $package1->last_point = $last;
          $package1->detail = 'แลกของรางวัล ออเดอร์ '.$randomSixDigitInt;
          $package1->save();

          $cart = Session::get('cart');
 
          foreach ($cart as $product_item){
 
            $obj = new order_detail();
            $obj->user_id = Auth::user()->id;
            $obj->order_no = $the_id;
            $obj->pro_id = $product_item['id'];
            $obj->amount = 1;
            $obj->pro_name = $product_item['name_product'];
            $obj->pro_point = $product_item['point'];
            $obj->pro_image = $product_item['image'];
            $obj->save();

            $total_pro = 0;

            $get_p = product::where('id', $product_item['id'])->first();

            $total_pro = ($get_p->stock - 1);

            DB::table('products')
            ->where('id', $product_item['id'])
            ->update(['stock' => $total_pro]);

          }

          $user = User::where('id', Auth::user()->id)->first();
          $mypoint = ($user->point - $request['total']);

          DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['point' => $mypoint]);

            DB::table('orders')
            ->where('id', $the_id)
            ->update(['old_point' => $mypoint]);

          unset($cart);
         session()->forget('cart');

         $message = "มีรายการแลกสินค้าจาก  ".$package->name_order.", ข้อมูลผู้ติดต่อ : ".$package->telephone_order." หมายเลขสั่งซื้อ : ".$randomSixDigitInt." จำนวนพอยท์ : ".$package->sum_point;
        $lineapi = env('line_token'); 
        

        $mms =  trim($message);
        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($chOne, CURLOPT_POST, 1);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=$mms");
        curl_setopt($chOne, CURLOPT_FOLLOWLOCATION, 1);
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$lineapi.'',);
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);
        if(curl_error($chOne)){
        echo 'error:' . curl_error($chOne);
        }else{
        $result_ = json_decode($result, true);
   
        }
        curl_close($chOne);



         return redirect(url('payment_success/'.$randomSixDigitInt))->with('pay_success','เพิ่ม เสร็จเรียบร้อยแล้ว');
    }


    public function update_user(Request $request)
    {
        $id = Auth::user()->id;
       $package = User::find($id);
       $package->name = $request['name'];
       $package->phone = $request['phone'];
       $package->email = $request['email'];
       $package->birthday = $request['birthday'];
       $package->shop_id = $request['shop_id'];
       $package->save();

        return redirect(url('/account'))->with('user_update','เพิ่ม เสร็จเรียบร้อยแล้ว');

    }


    public function add_to_checkout($id){

        $product = DB::select('select * from products where id='.$id);
    $cart = Session::get('cart');

    $total = $product[0]->point;

    if(isset($cart)){
        foreach($cart as $product_item){
            $total += ($product_item['point']);
        }
    }
    

    if($total > Auth::user()->point){
        return redirect(url('/'))->with('error_point','คุณทำการเพิ่มอสังหา สำเร็จ');
    }else{

    

    $cart[$product[0]->id] = array(
        "id" => $product[0]->id,
        "name_product" => $product[0]->name,
        "point" => $product[0]->point,
        "image" => $product[0]->image,
        "qty" => 1,
    );

    Session::put('cart', $cart);
}

    return redirect(url('/checkout'))->with('add_success','คุณทำการเพิ่มอสังหา สำเร็จ');


    }

    public function add_session_value(Request $request){

    $id = $request->input('product_id');

    $product = DB::select('select * from products where id='.$id);
    $cart = Session::get('cart');

    $total = $product[0]->point;

    if(isset($cart)){
        foreach($cart as $product_item){
            $total += ($product_item['point']);
        }
    }
    

    if($total > Auth::user()->point){
        return redirect(url('/'))->with('error_point','คุณทำการเพิ่มอสังหา สำเร็จ');
    }else{

    

    $cart[$product[0]->id] = array(
        "id" => $product[0]->id,
        "name_product" => $product[0]->name,
        "point" => $product[0]->point,
        "image" => $product[0]->image,
        "qty" => 1,
    );

    Session::put('cart', $cart);
}

    return redirect(url('/'))->with('add_success','คุณทำการเพิ่มอสังหา สำเร็จ');
    }

    public function deleteCart($id)
    {
        $cart = Session::get('cart');
        unset($cart[$id]);
        Session::put('cart', $cart);
        session()->forget('vouchers_value');
        return redirect(url('/'))->with('del_success','คุณทำการเพิ่มอสังหา สำเร็จ');
    }

    public function deleteCart2($id)
    {
        $cart = Session::get('cart');
        unset($cart[$id]);
        Session::put('cart', $cart);
        session()->forget('vouchers_value');
        return redirect(url('/cart'))->with('del_success','คุณทำการเพิ่มอสังหา สำเร็จ');
    }


    public function checkout()
    {
        return view('checkout');
    }
    public function payment_success($id)
    {
        $data['obj'] = $id;
        return view('payment_success', $data);
    }
    public function promotion()
    {
        return view('promotion');
    }

    public function my_point()
    {
        $objs = point::where('user_key', Auth::user()->phone)->orderby('id', 'desc')->paginate(15);
        $data['objs'] = $objs;
   
        return view('account.my_point', $data);
    }
    public function history()
    {
        $objs = order::where('user_id', Auth::user()->id)->orderby('id', 'desc')->paginate(15);

        if(isset($objs)){
            foreach($objs as $u){
                $u->option = order_detail::where('order_no', $u->id)->get();
            }
        }

        $data['objs'] = $objs;
   
        return view('account.history', $data);
    }
    public function invoice_detail($id)
    {

        $objs = order::where('order_no', $id)->first();
        $data['objs'] = $objs;

        $objs2 = order_detail::where('order_no', $objs->id)->get();
        $data['objs2'] = $objs2;

        $data['obj'] = $id;
        return view('account.invoice_detail', $data);

    }
    public function account()
    {
        return view('account.index');
    }
    public function contact()
    {
        return view('contact');
    }
    public function term()
    {
        return view('term');
    }
    public function how_to()
    {
        return view('how_to');
    }
    
    
    
    
    
}
