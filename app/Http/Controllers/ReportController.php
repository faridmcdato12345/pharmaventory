<?php

namespace App\Http\Controllers;

use Throwable;
use App\Invoice;
use App\Product;
use App\Business;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    public function inventoryReport(){
        return view('admin.report.inventory.index');
    }
    public function expireSpecificDate(Request $request){
        try {
            $products = Product::whereDate('expiration',$request->input('exp'))->firstOrFail();
            return response(['data'=>$products],Response::HTTP_OK);
        } catch (Throwable $err) {
            return response([],Response::HTTP_NOT_FOUND);
        }
    }
    public function goToResultDays($day){
        $products = Product::whereDate('expiration',$day)->get();
        return view('admin.report.inventory.result.days',compact('products'));
    }
    public function quantityCheck(Request $request){
        try {
            $products = Product::where('quantity','<=',$request->input('val'))->firstOrFail();
            return response(['data'=>$products],Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response([],Response::HTTP_NOT_FOUND);
        }
    }
    
    public function goToResultQuantity($quantity){
        $products = Product::where('quantity','<=',$quantity)->get();
        return view('admin.report.inventory.result.quantity',compact('products','quantity'));
    }
    public function reportForNextSixMonths(){
        $dateNow = strtotime(date("Y-m-d"));
        $dateNextSixMonths = date('Y-m-d',strtotime("+6 month", $dateNow));
        
        try {
            $products = Product::where('expiration',$dateNextSixMonths)->get();
            return view('admin.report.inventory.result.six_months',compact('products'));
        } catch (Throwable $th) {
            return $th;
        }
    }
    public function outOfStocks(){
        try {
            $products = Product::where('quantity',0)->get();
            return view('admin.report.inventory.result.out_of_stocks',compact('products'));
        } catch (Throwable $th) {
            return $th;
        }
    }
    public function stockCount(){
        $products = Product::all();
        return view('admin.report.inventory.result.stock_count',compact('products'));
    }
    public function sales(){
        return view('admin.report.sales.index');
    }
    public function salesDate(Request $request){
        $invoices = Invoice::whereBetween('created_at',[$request->input('from_date'),$request->input('to_date')])->get();
        settype($totalSales,"integer");
        foreach ($invoices as $invoice) {
            $totalSales += ($invoice->products->retail_price * $invoice->quantity);   
            $totalSales = $totalSales/100;
        }
        if($invoices->isEmpty()){
            return redirect()->route('sales.report')->with('errors','No sales from '.$request->input('from_date').' to '.$request->input('to_date'));
        }
        else{
            return view('admin.report.sales.show',compact('invoices','totalSales'));
        }
        
    }
    public function showSales(Request $request){
        $invoices = Invoice::whereBetween('created_at',[$request->input('from_date'),$request->input('to_date')])->get();
        settype($totalSales,"integer");
        settype($totalPurchaseCost, "integer");
        settype($revenue,"integer");
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
        $from_date = Carbon::parse($from_date)->format('m/d/yy');
        $to_date = Carbon::parse($to_date)->format('m/d/yy');
        foreach ($invoices as $invoice) {
            $totalSales += ($invoice->products->retail_price * $invoice->quantity);
            $totalPurchaseCost += ($invoice->products->purchase_price * $invoice->quantity);
            $revenue += ($totalSales - $totalPurchaseCost);
            // $totalSales = $totalSales/100;
            // $totalPurchaseCost = $totalPurchaseCost/100;
            // $revenue = $revenue/100;
        }
        if($invoices->isEmpty()){
            return redirect()->route('sales.report')->with('errors','No sales from '.$request->input('from_date').' to '.$request->input('to_date'));
        }
        else{
            $totalSales = $totalSales/100;
            $totalPurchaseCost = $totalPurchaseCost/100;
            $revenue = $revenue/100;
            return view('admin.report.sales.print',compact(
                'invoices',
                'totalSales',
                'from_date',
                'to_date',
                'totalPurchaseCost',
                'revenue'
            ));
        }
    }
    public function outOfStockPrint(){
        $products = Product::where('quantity',0)->get();
        $business = Business::all();
        $date = Carbon::now()->format('m/d/yy');
        return view('admin.printable.report.outofstock',compact('products','business','date'));
    }
    public function stockCountPrint(){
        $products = Product::where('quantity','!=',0)->get();
        settype($totalInvestment,"integer");
        settype($totalRevenue,"integer");
        foreach($products as $product){
            $totalInvestment += ($product->purchase_price * $product->quantity);
            $totalRevenue += ($product->retail_price * $product->quantity);
        }
        $totalInvestment = $totalInvestment/100;
        $totalRevenue = $totalRevenue/100;
        $business = Business::all();
        $date = Carbon::now()->format('m/d/yy');
        return view('admin.printable.report.stock_count',compact('products','business','date','totalRevenue','totalInvestment'));
    }
    public function quantityCheckReport($quantity){
        $products = Product::where('quantity','<=',$quantity)->get();
        settype($totalInvestment,"integer");
        settype($totalRevenue,"integer");
        foreach($products as $product){
            $totalInvestment += ($product->purchase_price * $product->quantity);
            $totalRevenue += ($product->retail_price * $product->quantity);
        }
        $totalInvestment = $totalInvestment/100;
        $totalRevenue = $totalRevenue/100;
        $business = Business::all();
        $date = Carbon::now()->format('m/d/yy');
        return view('admin.printable.report.quantity',compact('products','business','date','totalRevenue','totalInvestment'));
    }
    public function printReportForNextSixMonths(){
        $dateNow = strtotime(date("Y-m-d"));
        $dateNextSixMonths = date('Y-m-d',strtotime("+6 month", $dateNow));
        try {
            $products = Product::where('expiration',$dateNextSixMonths)->get();
            settype($totalInvestment,"integer");
            settype($totalRevenue,"integer");
            foreach($products as $product){
                $totalInvestment += ($product->purchase_price * $product->quantity);
                $totalRevenue += ($product->retail_price * $product->quantity);
            }
            $totalInvestment = $totalInvestment/100;
            $totalRevenue = $totalRevenue/100;
            $business = Business::all();
            $date = Carbon::now()->format('m/d/yy');
            return view('admin.printable.report.sixmonths',compact('products','business','date','totalRevenue','totalInvestment'));
        } catch (Throwable $th) {
            return $th;
        }
    }
}
