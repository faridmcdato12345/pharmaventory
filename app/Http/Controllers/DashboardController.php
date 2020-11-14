<?php
namespace App\Http\Controllers;


use App\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(){
        settype($yesterdayPrice, "integer");        
        settype($nowPrice,"integer");
        settype($thisWeekPrice,"integer");
        $yesterdayInvoice = Invoice::whereDate('created_at',Carbon::yesterday())->get();
        foreach($yesterdayInvoice as $data){
            $result = $data->products->retail_price * $data->quantity;
            $yesterdayPrice += $result / 100;
        }
        $nowInvoice = Invoice::whereDate('created_at',Carbon::now())->get();
        foreach($nowInvoice as $data){
            $result = $data->products->retail_price * $data->quantity;
            $nowPrice += $result/100;
        }
        $thisWeekInvoice = Invoice::whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->get();
        foreach($thisWeekInvoice as $data){
            $result = $data->products->retail_price * $data->quantity;
            $thisWeekPrice += $result/100;
        }
        return view('admin.index',compact('yesterdayPrice','nowPrice','thisWeekPrice'));
    }
}