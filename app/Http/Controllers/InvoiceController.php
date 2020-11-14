<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Product;
use App\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datas = json_decode($request->getContent());
        $productId = '';
        $productQuantity = '';
        $productInvoice = '';
        foreach($datas as $data){
            DB::table('invoices')->insert([
                'product_id'=>$data->product_id,
                'quantity'=>$data->quantity,
                'invoice_number'=>$data->invoice_number,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
            $this->updateTheProduct($data->quantity,$data->product_id);
        }
        $newInvoice = Invoice::latest()->first();
        return response(['data'=>$newInvoice->invoice_number],Response::HTTP_CREATED);
    }
    private function updateTheProduct($quantity,$productId){
        $product = Product::findOrFail($productId);
        $product->quantity -= $quantity;
        $product->update();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        return $invoice;
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function showSpecificInvoice($invoiceNumber){
        $invoices = Invoice::where('invoice_number',$invoiceNumber)->get();
        $business = Business::all();
        settype($total,"integer");
        foreach ($invoices as $invoice) {
            $total += $invoice->products->retail_price * $invoice->quantity;
        }
        $total = $total/100;
        return view('admin.printable.invoice.index',compact('invoices','business','total'));
    }

    public function allInvoice(){
        $invoices = Invoice::select('invoice_number')->distinct()->get();
        if(Auth::user()->role_id == 1){
            return view('admin.invoice.index',compact('invoices'));
        }
        else{
            return view('cashier.invoice.index',compact('invoices'));
        }
        
    }

    public function showInvoice($id){
        settype($total,"integer");
        settype($capital,"integer");
        $invoices = Invoice::where('invoice_number',$id)->get();
        if($invoices->isEmpty()){
            return redirect()->route('invoice.all');
        }
        foreach ($invoices as $invoice) {
            $total += $invoice->products->retail_price * $invoice->quantity;
            $capital += $invoice->products->purchase_price * $invoice->quantity;
        }
        $total = $total/100;
        $capital = $capital/100;
        if(Auth::user()->role_id == 1){
            return view('admin.invoice.show',compact('invoices','total','capital'));
        }
        else{
            return view('cashier.invoice.show',compact('invoices','total','capital'));
        }
    }

    public function returnProduct(Request $request){
        $product = Product::findOrFail($request->product_id);
        $product->quantity += $request->quantity;
        $invoice = Invoice::findOrFail($request->invoice_id);
        $invoice->delete();
        $product->update();
        return response(['data'=>$product],Response::HTTP_OK);
    }
}
