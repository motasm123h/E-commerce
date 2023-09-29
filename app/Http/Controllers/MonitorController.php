<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Monitordetails;
use App\Models\Product;


class MonitorController extends Controller
{
    public function make_the_Monitor_Details(Request $request,$product_id){
        $atter = $request->validate([
            'Display_Size'=>['required'],
            'Displa_Technology'=>['required'],
            'Display_Resolution'=>['required'],
            // 'Contrast_Ratio',
            // 'Response_Time',
            // 'Signal_Frequency',
            // 'Multimedia_Speakers',
            'Ports'=>['required'],
            'Warranty'=>['required'],
        ]);
        
        $monitor = Monitordetails::create([
            'product_id'=>$product_id,
            'Display_Size'=>$atter['Display_Size'],
            'Displa_Technology'=>$atter['Displa_Technology'],
            'Display_Resolution'=>$atter['Display_Resolution'],
            'Contrast_Ratio'=>$request->input('Contrast_Ratio'),
            'Response_Time'=>$request->input('Response_Time'),
            'Signal_Frequency'=>$request->input('Signal_Frequency'),
            'Multimedia_Speakers'=>$request->input('Multimedia_Speakers'),
            'Ports'=>$atter['Ports'],
            'Warranty'=>$atter['Warranty'],
        ]);
  
        return response()->json([
            'monitor'=>$monitor
        ]);
    } 

    public function getMonitorWithDetails($monitor_id){
        $monitors=Product::where('id','=',$monitor_id)
        ->select()
        ->with(['discounts' => function ($query) {
                $query->select('id','percentage_off','product_id');
            }])
        ->with(['MonitorDetails'=>function($query){
                $query->select('*');
        }])    
        ->get();


        foreach($monitors as $monitor) 
        {
            if(isset($monitor->discounts[0]))
            {
                $discountedPrice = $monitor->price - (($monitor->price * $monitor->discounts[0]->percentage_off) / 100);   
                $monitor->final_price = round($discountedPrice, 2);
                $monitor->percentage_off = $monitor->discounts[0]->percentage_off;
                $monitor->discount_id = $monitor->discounts[0]->id;
            } 
            else {
                $monitor->final_price = round($monitor->price, 2);
            }
        }
        foreach($monitors as $monitor) 
        {
           unset($monitor->discounts);
        }


        return response()->json([
            'monitors'=>$monitors,
            ]);
    }

    public function monitorEdit(Request $request ,$product_id){
        $monitor = Monitordetails::where('product_id',$product_id)->first();

        $monitor->update([
            'Display_size'=>$request->input('Display_size') ?? $monitor['Display_size'],
            'Displa_Technology'=>$request->input('Displa_Technology') ?? $monitor['Displa_Technology'],
            'Display_Resolution'=>$request->input('Display_Resolution') ?? $monitor['Display_Resolution'],

            'Contrast_Ratio'=>$request->input('Contrast_Ratio') ?? $monitor['Contrast_Ratio'],
            'Response_Time'=>$request->input('Response_Time') ?? $monitor['Response_Time'],
            'Signal_Frequency'=>$request->input('Signal_Frequency') ?? $monitor['Signal_Frequency'],
            'Multimedia_Speakers'=>$request->input('Multimedia_Speakers') ?? $monitor['Multimedia_Speakers'],

            'Ports'=>$request->input('Ports') ?? $monitor['Ports'],
            'Warranty'=>$request->input('Warranty') ?? $monitor['Warranty'],
        ]);

        return response()->json([
            'mointor' => $monitor
        ]);
    }
}
