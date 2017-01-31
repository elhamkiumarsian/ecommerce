<?php

namespace App\Http\Controllers;

use App\Product;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use File;
use DB;
use Morilog\Jalali\Facades\jDate;
use Response;
use Session;

class ProductsController extends Controller
{

    protected $data = [];

    public function getOptionById($id,array $allOptions){
        $keys=array_keys($allOptions);
        if(in_array($id,$keys)) {
            return $allOptions[$id];
        }
        return false;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if(Auth::check()) {
            if (Auth::user()->role == 'admin' || Auth::user()->role == 'user') {
                $mainProducts = Product::whereNull('parent')->get();
                //get all files as an array
                $files = File::allFiles('images' . DIRECTORY_SEPARATOR . 'Product');
                $filesList = array();
                foreach ($files as $file) {
                    $filesList[pathinfo($file)['filename']] = pathinfo($file);
                }
                return view('products.index')->with('mainProducts', $mainProducts)->with('filesList', $filesList);
            }
        }
        return redirect()->to('Auth/Login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                // ********** fetch from db and handle to child parent **********
                $products = Product::all()->toArray();
                $stack = [];
                $heap = [];
                foreach ($products as $j) {
                    if (is_null($j['parent'])) {
                        $heap[$j['id']] = [$j['id'], 'children'];
                        $stack[$j['id']] = $j;
                    } else {
                        $this->set_on_depth($stack, $heap, $j);
                    }
                }
                // **************************************************************
                //dd($stack);
                //$lists = $this->create_list(['id'=>0],true);
                //$this->create_form($stack,$lists,true);
                return view('products.create')->with([
                    'products' => $stack
                ]);
            }
            return view('welcome');
        }
        return redirect()->to('Auth/Login');
    }

    public function set_on_depth(&$stack , &$heap, &$record){

        $depth = $heap[$record['parent']];
        if(is_array($cur = $this->array_depth_get($stack,$depth))){
            $this->array_depth_set($stack,$depth,$cur+[$record['id']=>$record]);
        }else{
            $this->array_depth_set($stack,$depth,[$record['id']=>$record]);
        }
        $depth[]=$record['id'];
        $depth[] = 'children';
        $heap[$record['id']] = $depth;
    }

    function array_depth_set(array & $array, array $depth, $newValue) {
        $aux =& $array;
        foreach ($depth as $key) {
            if (isset($aux[$key])) {
                $aux =& $aux[$key];
            } else if($key=='children') {
                $aux[$key]='';
                $aux =& $aux[$key];
            }else{
                dd('Error');
            }
        }
        $aux = $newValue;
        return true;
    }

    function array_depth_get(&$stack, $depth) {
        foreach($depth as $seg) {
            if (isset($stack[$seg])) {
                $stack = & $stack[$seg];
            } else {
                return null;
            }
        }
        return $stack;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                foreach ($request->files as $i => $file) {
                    $file->move(public_path('Images/Product'), $i /*.'.'. $file->getClientOriginalExtension()*/);
                    //$file->move(public_path('Images/Product'),$i .'.'. $file->getClientOriginalExtension() );
                }
                $req = json_decode($request->all()['data'], true);
                unset($req['_token']);
                if ($req[0]['id'] == 0) unset($req[0]);

                DB::table('products')->truncate();
                $this->saveToDB($req);

                Product::insert($this->data);
                return "Succeed To Save";

            }
            return view('welcome');
        }
        return redirect()->to('Auth/Login');
    }
    protected function saveToDB($recs, $dep = null)
    {
        foreach ($recs as $j) {

            if (!isset($j['children'])) {
                $j['parent'] = ((!is_null($dep)) ? ($dep) : (null));
                $this->data[] = $j;
            } else {
                $child = $j['children'];
                unset ($j['children']);
                $j['parent'] = ((!is_null($dep)) ? ($dep) : (null));
//                if(!is_null($dep)){
//                    $j['parent']=$dep;
//                }else{
//                    $j['parent']=null;
//                }
//                if($j['parent']=='')unset($j['parent']);
                $this->data[] = $j;

                $this->saveToDB($child, $j['id']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'admin' || Auth::user()->role == 'user') {
                $product = Product::findOrFail($id);
                $ids = $product->allOptions()->lists('id');
                $allOptions = array();
                //get all files as an array
                $files = File::allFiles('images' . DIRECTORY_SEPARATOR . 'Product');
                $filesList = array();
                foreach ($files as $file) {
                    $filesList[pathinfo($file)['filename']] = pathinfo($file);
                }
                foreach ($ids as $id) {
                    $option = Product::findOrFail($id);
                    //check if the record has a picture
                    if (array_key_exists($id, $filesList)) {
                        $allOptions[$id] = array('name' => $option->name, 'type' => $option->type, 'parent' => $option->parent, 'price' => $option->price, 'pic' => $filesList[$id]['basename']);
                    } else {
                        $allOptions[$id] = array('name' => $option->name, 'type' => $option->type, 'parent' => $option->parent, 'price' => $option->price, 'pic' => '');
                    }
                }

                $priceGroup = array();
                foreach ($allOptions as $id => $option) {
                    if (!($option['price'] == 0)) {
                        $priceGroup[$id] = $option;
                    }
                }
                $final = array();
                foreach ($priceGroup as $id => $last) {
                    $priceSeries = array();
                    $finalPrice = $last;
                    while ($this->getOptionById($last['parent'], $allOptions)) {
                        $last = ($this->getOptionById($last['parent'], $allOptions));
                        $priceSeries[$last['parent']] = $last;
                    }
                    $final[$id] = (array_merge(['lastRecord' => $finalPrice], $priceSeries));
                }
                $itemString = '';
                $items = array();
                foreach ($final as $id => $options) {
                    foreach ($options as $key => $value) {
                        if (is_numeric($key)) {
                            $itemString = $itemString . $value['type'] . ':' . $value['name'] ;
                        } else {
                            $itemString = $itemString . $value['type'] . ':' . $value['name']. '-';
                            $price=$value['price'];
                        }
                        $items[$id] = array('item' => $itemString,'price'=>$price);

                    }
                    $itemString = '';
                }
                return view('products.show')->with('final', $final)->with('items', $items)->with('product', $product);

            }
            return redirect()->to('Auth/Login');
        }
        return redirect()->to('Auth/Login');
    }

}
