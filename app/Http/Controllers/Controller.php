<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function dataValidate(){
        return request()->validate([
            'name'=>'required',
        ]);
    }
    public function productsAttribute($value){
        $data = DB::table($value)->get();
        $output = '';
        $select = '<option value="">---Select attribute here---</option>';
        foreach($data as $row){
            $output .= '
                <tr>
                    <td>'.$row->name.'</td>
                </tr>
                
            ';
            $select .= '
                <option value="'.$row->id.'">'.$row->name.'</option>
            ';
        }
        $data = array(
            'attribute' => $output,
            'data' => $select,
            'model' => $value,
        );
        return json_encode($data);
    }
}
