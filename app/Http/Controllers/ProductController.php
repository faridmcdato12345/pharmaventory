<?php

namespace App\Http\Controllers;

use App\Type;
use App\Unit;
use App\Brand;
use App\Potency;
use App\Product;
use App\Storage;
use App\Category;
use App\Packaging;
use App\ProductType;
use App\Classification;
use App\UserLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use RealRashid\SweetAlert\Facades\Alert;
use DataTables;

class ProductController extends Controller
{

    private $user;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::with(
            'categories',
            'brands',
            'types',
            'potencies',
            'packagings'
        )->get();
        if($request->ajax()){
            $output = '';
            foreach($products as $row){
                $output .= '
                <tr>
                    <td>'.$row->id.'</td>
                    <td>'.$row->categories()->first()['name'].'</td>
                    <td>'.$row->brands()->first()['name'].'</td>
                    <td>'.$row->name.'</td>
                    <td>'.$row->barcode.'</td>
                    <td>'.$row->description.'</td>
                    <td>'.$row->PurchasedPriceAsCurrency.'</td>
                    <td>'.$row->PriceAsCurrency.'</td>
                    <td>'.$row->quantity.'</td>
                    <td>'.$row->expiration.'</td>
                    <td>'.$row->potencies()->first()['name'].'</td>
                    <td>'.$row->types()->first()['name'].'</td>
                    <td>'.$row->packagings()->first()['name'].'</td>
                </tr>
                ';
            }
            $data = array(
                'dataTable' => $output,
            );
            return json_encode($data);
        }
        else{
            return view('admin.product.index',compact('products'));
        }
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $units = Unit::all();
        $classes = Classification::all();
        $potencies = Potency::all();
        $packagings = Packaging::all();
        $brands = Brand::all();
        $categories = Category::all();
        $storages = Storage::all();
        return view('admin.product.create',compact(
            'types',
            'units',
            'classes',
            'potencies',
            'packagings',
            'brands',
            'categories',
            'storages'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::create($this->dataValidation());
        $productName = Product::latest()->first()->name;
        $productId = Product::latest()->first()->id;
        if($request->type_id){
            $typeId = $request->type_id;
            $type = Type::find($typeId);
            $type->products()->attach($productId);
        }
        if($request->potency_id){
            $potencyId = $request->potency_id;
            $potency = Potency::find($potencyId);
            $potency->products()->attach($productId);
        }
        if($request->packaging_id){
            $packagingId = $request->packaging_id;
            $packaging = Packaging::find($packagingId);
            $packaging->products()->attach($productId);
        }
        if($request->brand_id){
            $brandId = $request->brand_id;
            $brand = Brand::find($brandId);
            $brand->products()->attach($productId);
        }
        if($request->category_id){
            $categoryId = $request->category_id;
            $category = Category::find($categoryId);
            $category->products()->attach($productId);
        }
        if($request->storage_id){
            $storageId = $request->storage_id;
            $storage = Storage::find($storageId);
            $storage->products()->attach($productId);
        }
        $userLog = UserLog::create([
            'user_id'=>Auth::user()->id,
            'action'=>'created a product named '.$productName,
            'created_at' => now(),
        ]);
        return response(['data'=>$product],Response::HTTP_CREATED);
    }
    private function attributesOfProduct($request,$productId){

        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = Product::with(
            'categories',
            'brands',
            'types',
            'potencies',
            'packagings'
        )
        ->where('id',$request->get('product_id'))
        ->get();
        $total_row = $data->count();
        $categories = Category::all();
        $brands = Brand::all();
        $types = Type::all();
        $potencies = Potency::all();
        $packagings = Packaging::all();
        $id = '';
        if($total_row > 0){
            $output = '';
            foreach($data as $row){
                $id = $row->id;
               if($row->categories()->first()['name'] != ''){
                    $output .= '<label for="category">Category:</label>';
                    $output .= '<select name="category_id" id="category" class="form-control">';
                    foreach($categories as $category){
                        $output .= '
                            <option value="'.$category->id.'">'.$category->name.'</option>
                        ';  
                    }
                    $output .= '</select>';
                }
                if($row->categories()->first()['name'] == ''){
                    $output .= '<label for="category">Category:</label>';
                    $output .= '<select name="category_id" id="category" class="form-control">';
                    $output .= '<option value="null">null</option>';
                    foreach($categories as $category){
                        $output .= '
                            <option value="'.$category->id.'">'.$category->name.'</option>
                        ';  
                    }
                    $output .= '</select>';
                }
                if($row->brands()->first()['name'] != ''){
                    $output .= '<label for="brand">Brand:</label>';
                    $output .= '<select name="brand_id" id="brand" class="form-control">';
                    foreach($brands as $brand){
                        $output .= '
                            <option value="'.$brand->id.'">'.$brand->name.'</option>
                            
                        ';  
                    }
                    $output .= '</select>';
                }
                if($row->brands()->first()['name'] == ''){
                    $output .= '<label for="brand">Brand:</label>';
                    $output .= '<select name="brand_id" id="brand" class="form-control">';
                    $output .= '<option value="null">null</option>';
                    foreach($brands as $brand){
                        $output .= '
                            <option value="'.$brand->id.'">'.$brand->name.'</option>
                            
                        ';  
                    }
                    $output .= '</select>';
                }
                if($row->types()->first()['name'] != ''){
                    $output .= '<label for="type">Type:</label>';
                    $output .= '<select name="type_id" id="type" class="form-control">';
                    foreach($types as $type){
                        $output .= '
                            <option value="'.$type->id.'">'.$type->name.'</option>
                        ';  
                    }
                    $output .= '</select>';
                }
                if($row->types()->first()['name'] == ''){
                    $output .= '<label for="type">Type:</label>';
                    $output .= '<select name="type_id" id="type" class="form-control">';
                    $output .= '<option value="null">null</option>';
                    foreach($types as $type){
                        $output .= '
                            <option value="'.$type->id.'">'.$type->name.'</option>
                        ';  
                    }
                    $output .= '</select>';
                }
                if($row->potencies()->first()['name'] != ''){
                    $output .= '<label for="potency">Potency:</label>';
                    $output .= '<select name="potency_id" id="potency" class="form-control">';
                    foreach($potencies as $potency){
                        $output .= '
                            <option value="'.$potency->id.'">'.$potency->name.'</option>
                        ';  
                    }
                    $output .= '</select>';
                }
                if($row->potencies()->first()['name'] == ''){
                    $output .= '<label for="potency">Potency:</label>';
                    $output .= '<select name="potency_id" id="potency" class="form-control">';
                    $output .= '<option value="null">null</option>';
                    foreach($potencies as $potency){
                        $output .= '
                            <option value="'.$potency->id.'">'.$potency->name.'</option>
                        ';  
                    }
                    $output .= '</select>';
                }
                if($row->packagings()->first()['name'] != ''){
                    $output .= '<label for="packaging">Packaging:</label>';
                    $output .= '<select name="packaging_id" id="packaging" class="form-control">';
                    foreach($packagings as $packaging){
                        $output .= '
                            <option value="'.$packaging->id.'">'.$packaging->name.'</option>
                        ';  
                    }
                    $output .= '</select>';
                }
                if($row->packagings()->first()['name'] == ''){
                    $output .= '<label for="packaging">Packaging:</label>';
                    $output .= '<select name="packaging_id" id="packaging" class="form-control">';
                    $output .= '<option value="null">null</option>';
                    foreach($packagings as $packaging){
                        $output .= '
                            <option value="'.$packaging->id.'">'.$packaging->name.'</option>
                        ';  
                    }
                    $output .= '</select>';
                }
                $output .= '
                    <label for="quantity">Barcode:</label>
                    <input type="text" name="barcode" id="barcode" class="form-control" value="'.$row->barcode.'">
                ';
                $output .= '
                    <label for="quantity">Product Name:</label>
                    <input type="text" name="name" id="name" class="form-control" value="'.$row->name.'">
                ';
                $output .= '
                    <label for="quantity">Description:</label>
                    <input type="text" name="description" id="description" class="form-control" value="'.$row->description.'">
                ';
                $output .= '
                    <label for="quantity">Quantity:</label>
                    <input type="text" name="quantity" id="quantity" class="form-control" value="'.$row->quantity.'">
                ';
                $output .= '
                    <label for="quantity">Purchased Price:</label>
                    <input type="text" name="purchase_price" id="purchase_price" class="form-control" value="'.$row->PurchasedPriceAsCurrency.'">
                ';
                $output .= '
                    <label for="quantity">Resell Price:</label>
                    <input type="text" name="retail_price" id="retail_price" class="form-control" value="'.$row->PriceAsCurrency.'">
                ';
                $output .= '
                    <label for="quantity">Expiration Date:</label>
                    <input type="date" name="expiration" id="expiration" class="form-control" value="'.$row->expiration->format('Y-m-d').'">
                ';
            }
        }
        
        $data = array(
            'product' => $output,
            'product_id' => $id,
        );
        return json_encode($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $product = Product::findOrFail($id);
        if($request->type_id != null){
            $typeId = $request->type_id;
            $type = Type::find($typeId);
            $type->products()->attach($product->id);
        }
        if($request->type_id == null){
            return false;
        }
        if($request->potency_id){
            $potencyId = $request->potency_id;
            $potency = Potency::find($potencyId);
            $potency->products()->attach($product->id);
        }
        if($request->packaging_id){
            $packagingId = $request->packaging_id;
            $packaging = Packaging::find($packagingId);
            $packaging->products()->attach($product->id);
        }
        if($request->brand_id){
            $brandId = $request->brand_id;
            $brand = Brand::find($brandId);
            $brand->products()->attach($product->id);
        }
        if($request->category_id){
            $categoryId = $request->category_id;
            $category = Category::find($categoryId);
            $category->products()->attach($product->id);
        }
        $product->update($this->dataValidation());
        return response([],Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
    }
    private function dataValidation(){
        return request()->validate([
            'description'=>'required',
            'retail_price'=>'required',
            'quantity'=>'required',
            'name'=>'',
            'expiration' => '',
            'barcode'=>'',
            'purchase_price'=>'',
        ]);
    }
    public function getAllTypes(){
        return Type::all();
    }
    public function getAllPotencies(){
        return Potency::all();
    }
    public function getAllPackagings(){
        return Packaging::all();
    }
    public function getAllBrands(){
        return Brand::all();
    }
    public function getAllCategories(){
        return Category::all();
    }
    public function cashierView(){
        $category = Product::with(
            'categories',
            'brands',
            'types',
            'potencies',
            'packagings'
        )
        ->where('quantity','>',0)
        ->get();
        return view('cashier.index',compact('category'));
    }
    public function liveSearchProduct(Request $request){
        if($request->ajax()){
            $output = '';
            $query = $request->get('query');
            $data = Product::where('barcode', 'like', '%'.$query.'%')
                    ->orWhere('name','like','%'.$query.'%')
                    ->orWhere('description','like','%'.$query.'%')
                    ->where('quantity','>',0)
                    ->get();
            $total_row = $data->count();
            if($total_row == 1){
                $count = 1;
                $product_id = $data[0]->id;
            }
            elseif ($total_row > 1) {
                $count = 2;
                $product_id = 0;
                foreach ($data as $row) {
                    $output .= '
                        <tr>
                            <td>'.$row->id.'</td>
                            <td>'.$row->categories()->first()['name'].'</td>
                            <td>'.$row->brands()->first()['name'].'</td>
                            <td>'.$row->name.'</td>
                            <td>'.$row->barcode.'</td>
                            <td>'.$row->description.'</td>
                            <td>'.$row->PriceAsCurrency.'</td>
                            <td>'.$row->quantity.'</td>
                            <td>'.$row->expiration.'</td>
                            <td>'.$row->potencies()->first()['name'].'</td>
                            <td>'.$row->types()->first()['name'].'</td>
                            <td>'.$row->packagings()->first()['name'].'</td>
                        </tr>
                    ';
                }
            }
            else{
                $count = 0;
                $product_id = "No Product";
            }
            $data = array(
                'count' => $count,
                'dataTable' => $output,
                'product_id' => $product_id,
            );
            return json_encode($data);
        }
    }
    public function addToInvoiceSideCard(Request $request){
        $product = Product::find($request->get('product_id'));
        $quantity = $request->get('product_quantity');
        $total_row = $product->count();
        if($total_row > 0){
            $total_price_value = $product->retail_price * $quantity;
            $amount = new \NumberFormatter("%.2n",\NumberFormatter::CURRENCY);
            $formatted = $amount->format($total_price_value/100);
            $totalPrice = preg_replace( '/[^0-9,"."]/', '', $formatted );
            $output = '
                <tr>
                    <td>'.$product->id.'</td>
                    <td>'.$product->barcode.'</td>
                    <td>'.$product->name.'</td>
                    <td>'.$product->description.'</td>
                    <td>'.$quantity.'</td>
                    <td>'.$totalPrice.'</td>
                </tr>
            ';
            $product = array(
                'item' => $output,
                'total_price' => $totalPrice,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'sum_total' => $total_price_value/100
            );
            return json_encode($product);
        }
    }
}
