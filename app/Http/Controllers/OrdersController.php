<?php

namespace App\Http\Controllers;

use App\Item;
use App\Order;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use Session;

class OrdersController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function addItemToBasket(Request $request)
    {
        $inputData=$request->all();
        $itemAddition=array();
        $itemAddition[$inputData['id']]=array('product'=>$inputData['product'],'item'=>$inputData['item'],'quantity'=>$inputData['quantity'],'price'=>$inputData['price'],'total_price'=>($inputData['price']*$inputData['quantity']));
        if(Session::has('basket')){
            $basket=Session::get('basket');
            $addedProductKeys=array_keys($basket);
            if(in_array($inputData['id'],$addedProductKeys)){
                unset($basket[$inputData['id']]);
            }
            $newBasket=$basket+$itemAddition;
            Session::put('basket',$newBasket);
        }else{
            Session::put('basket',$itemAddition);
        }
        return Response::make(array('message'=>'محصول با موفقیت به سبد خرید شما اضافه گردید'));
    }

    /**
     * @return $this
     */
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'admin' || Auth::user()->role == 'user') {
                if (Session::has('basket')) {
                    $basket = Session::get('basket');
                } else {
                    $basket = array();
                }
                return view('orders.index')->with('basket', $basket);
            }
            return view('welcome');
        }
        return redirect()->to('Auth/Login');
    }

    /**
     * @param $id
     * @return $this
     */
    public function edit($id){
        if(Auth::check()) {
            if (Auth::user()->role === 'admin' || Auth::user()->role === 'user') {
                $basket = Session::get('basket');
                $item = $basket[$id];
                return view('orders.edit')->with('item', $item)->with('id', $id);
            }
            return view('welcome');
        }
        return redirect()->to('Auth/Login');
    }

    /**
     * @param \Request $request
     */
    public function update(Request $request){
        if (Auth::check()) {
            $inputData = $request->all();
            $basket = Session::get('basket');
            $current = $basket[$inputData['record_id']];
            $current['quantity'] = $inputData['quantity'];
            $current['total_price'] = $inputData['quantity'] * $current['price'];
            $basket[$inputData['record_id']] = $current;
            Session::set('basket', $basket);
            return redirect()->to('Orders')->with('message', 'you updated the Order');
        }
        return redirect()->to('Auth/Login');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id){
        if(Auth::check()) {
            $basket = Session::get('basket');
            unset($basket[$id]);
            Session::put('basket', $basket);
            return redirect()->to('Orders')->with('message', 'Your basket has been updated.');
        }
        return redirect()->to('Auth/Login');
    }
    public function finalizeOrder(){
        if(Auth::check()){
            $basket=Session::get('basket');
            $user=Auth::user();
            $orderToDb=array();
            $orderToDb['user_id']=$user->id;
            $orderToDb['address']=$user->address;
            $orderToDb['phone']=$user->phone;
            $order=Order::create($orderToDb);
            $items=array();
            foreach($basket as $id=>$options){
                $data=array();
                $data['order_id']=$order->id;
                $data['product']=$options['product'];
                $data['item']=$options['item'];
                $data['quantity']=$options['quantity'];
                $data['total_price']=$options['total_price'];
                $data['created_at']=Carbon::now();
                $items[]=$data;
            }
            Item::insert($items);
			Session::forget('basket');
            return redirect()->to('Products')->with('message','سفارش شما ثبت شد و سبد خرید شما خالی شد.');

        }else{
            return redirect()->to('Auth/Login');
        }


    }
    public function viewOrders()
    {
        if (Auth::check()) {
            $user = Auth::user();

            //check to see if the current user is a normal user. You can check it by database
            if ($user->role == 'user') {
                $orders = $user->orders->sortByDesc('created_at');
                return view('orders.view')->with('orders', $orders)->with('role', 'user');
            }
            //if not so this is an admin
            if ($user->role == 'admin') {
                $orders = Order::orderBy('created_at', 'desc')->paginate(20);
                return view('orders.view')->with('orders', $orders)->with('role', 'admin');
            }
        }
    }
}
