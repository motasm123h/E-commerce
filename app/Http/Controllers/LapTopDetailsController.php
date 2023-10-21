<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laptop_details;
use App\Models\Product;

class LapTopDetailsController extends Controller
{

    //CREATE LAPTOP DETAILS
    //FOR THIS I NEED THE LAPTOP ID AND THE INFORMATION OF THE LAPTOP
    public function createLapTopDetails(Request $request, $laptop_id)
    {
        $atter = $request->validate([
            'Processor_Generation' => ['required'],
            'Processor_Family' => ['required'],
            'Processor_Speed' => ['required'],
            'Processor_Cash' => ['required'],
            'Number_Of_Coures' => ['required'],
            'Ram_Capacity' => ['required'],
            'Memory_Type' => ['required'],
            'Storage_Capacity' => ['required'],
            'Storage_Type' => ['required'],
            'Graphic_Manufacturer' => ['required'],
            'Graphic_Model' => ['required'],
            'Graphic_Memory_Source' => ['required'],
            'Display_Size' => ['required'],
            'Displa_Technology' => ['required'],
            'Display_Resolution' => ['required'],
            'Keyboard' => ['required'],
            'Keyboard_Backlight' => ['required'],
            'Ports' => ['required'],
            'Optical_Drive' => ['required'],
            // 'Camera' => ['required'],
            // 'Audio' => ['required'],
            // 'Case_Model' => ['required'],
            // 'Light_Type' => ['required'],
            // 'Power_Supply' => ['required'],
            // 'multiMedia' => ['required'],
            'Networking' => ['required'],
            'Battery_Number_Of_Cells' => ['required'],
            'Operation_System' => ['required'],
            'Warranty' => ['required'],
        ]);


        $lapTopDetails = Laptop_details::create([
            'product_id' => $laptop_id,
            'Processor_Generation' => $atter['Processor_Generation'],
            'Processor_Family' => $atter['Processor_Family'],
            'Processor_Speed' => $atter['Processor_Speed'],
            'Processor_Cash' => $atter['Processor_Cash'],
            'Number_Of_Coures' => $atter['Number_Of_Coures'],
            'Ram_Capacity' => $atter['Ram_Capacity'],
            'Memory_Type' => $atter['Memory_Type'],
            'Storage_Capacity' => $atter['Storage_Capacity'],
            'Storage_Type' => $atter['Storage_Type'],
            'Graphic_Manufacturer' => $atter['Graphic_Manufacturer'],
            'Graphic_Model' => $atter['Graphic_Model'],
            'Graphic_Memory_Source' => $atter['Graphic_Memory_Source'],
            'Display_Size' => $atter['Display_Size'],
            'Displa_Technology' => $atter['Displa_Technology'],
            'Display_Resolution' => $atter['Display_Resolution'],
            'Keyboard' => $atter['Keyboard'],
            'Keyboard_Backlight' => $atter['Keyboard_Backlight'],
            'Ports' => $atter['Ports'],
            'Optical_Drive' => $atter['Optical_Drive'],
            'Audio' => $request->input('Audio'),
            'Camera' => $request->input('Camera'),

            'Case_Model' => $request->input('Case_Model'),
            'Light_Type' => $request->input('Light_Type'),
            'Power_Supply' => $request->input('Power_Supply'),
            'multiMedia' => $request->input('MultiMedia'),

            'Networking' => $atter['Networking'],
            'Battery_Number_Of_Cells' => $atter['Battery_Number_Of_Cells'],
            'Operation_System' => $atter['Operation_System'],
            'Warranty' => $atter['Warranty'],
        ]);


        return response()->json([
            'laptop' => $lapTopDetails
        ]);
    }

    //THIS IS FOR GET THE LAPTOP DETAILS FROM
    //FOR DOING THIS I NEED THE ID OF THE LAPTOP
    public function getLaptopWithDetails($laptop_id)
    {
        $product = Product::where('id', $laptop_id)->first();



        $laptops = Product::where('id', '=', $laptop_id)
            ->select()
            ->with(['discounts' => function ($query) {
                $query->select('id', 'percentage_off', 'product_id');
            }])
            ->with(['Details' => function ($query) {
                $query->select('*');
            }])
            ->with(['images' => function ($query) {
                $query->select('*');
            }])
            ->get();


        foreach ($laptops as $laptop) {
            if (isset($laptop->discounts[0])) {
                $discountedPrice = $laptop->price - (($laptop->price * $laptop->discounts[0]->percentage_off) / 100);
                $laptop->final_price = round($discountedPrice, 2);
                $laptop->percentage_off = $laptop->discounts[0]->percentage_off;
                $laptop->discount_id = $laptop->discounts[0]->id;
            } else {
                $laptop->final_price = round($laptop->price, 2);
            }
        }
        foreach ($laptops as $laptop) {
            unset($laptop->discounts);
        }


        return response()->json([
            'laptops' => $laptops,
        ]);
    }

    //edit laptop
    public function editLaptopDetails(Request $request, $laptop_id)
    {
        $laptop = Laptop_details::where('product_id', $laptop_id)->first();

        $laptopProcessor_Generation = $request->input('Processor_Generation') ?? $laptop['Processor_Generation'];
        $laptopProcessor_Family = $request->input('Processor_Family') ?? $laptop['Processor_Family'];
        $laptopProcessor_Speed = $request->input('Processor_Speed') ?? $laptop['Processor_Speed'];
        $laptopProcessor_Cash = $request->input('Processor_Cash') ?? $laptop['Processor_Cash'];
        $laptopNumber_Of_Coures = $request->input('Number_Of_Coures') ?? $laptop['Number_Of_Coures'];
        $laptopRam_Capacity = $request->input('Ram_Capacity') ?? $laptop['Ram_Capacity'];
        $laptopMemory_Type = $request->input('Memory_Type') ?? $laptop['Memory_Type'];
        $laptopStorage_Capacity = $request->input('Storage_Capacity') ?? $laptop['Storage_Capacity'];
        $laptopStorage_Type = $request->input('Storage_Type') ?? $laptop['Storage_Type'];
        $laptopGraphic_Manufacturer = $request->input('Graphic_Manufacturer') ?? $laptop['Graphic_Manufacturer'];
        $laptopGraphic_Model = $request->input('Graphic_Model') ?? $laptop['Graphic_Model'];
        $laptopGraphic_Memory_Source = $request->input('Graphic_Memory_Source') ?? $laptop['Graphic_Memory_Source'];
        $laptopDisplay_Size = $request->input('Display_Size') ?? $laptop['Display_Size'];
        $laptopDispla_Technology = $request->input('Displa_Technology') ?? $laptop['Displa_Technology'];
        $laptopDisplay_Resolution = $request->input('Display_Resolution') ?? $laptop['Display_Resolution'];
        $laptopKeyboard = $request->input('Keyboard') ?? $laptop['Keyboard'];
        $laptopKeyboard_Backlight = $request->input('Keyboard_Backlight') ?? $laptop['Keyboard_Backlight'];
        $laptopPorts = $request->input('Ports') ?? $laptop['Ports'];
        $laptopOptical_Drive = $request->input('Optical_Drive') ?? $laptop['Optical_Drive'];
        $laptopCamera = $request->input('Camera') ?? $laptop['Camera'];
        $laptopAudio = $request->input('Audio') ?? $laptop['Audio'];
        $laptopNetworking = $request->input('Networking') ?? $laptop['Networking'];
        $laptopBattery_Number_Of_Cells = $request->input('Battery_Number_Of_Cells') ?? $laptop['Battery_Number_Of_Cells'];
        $laptopOperation_System = $request->input('Operation_System') ?? $laptop['Operation_System'];
        $laptopWarranty = $request->input('Warranty') ?? $laptop['Warranty'];


        $laptop->update([
            'Processor_Generation' => $laptopProcessor_Generation,
            'Processor_Family' => $laptopProcessor_Family,
            'Processor_Speed' => $laptopProcessor_Speed,
            'Processor_Cash' => $laptopProcessor_Cash,
            'Number_Of_Coures' => $laptopNumber_Of_Coures,
            'Ram_Capacity' => $laptopRam_Capacity,
            'Memory_Type' => $laptopMemory_Type,
            'Storage_Capacity' => $laptopStorage_Capacity,
            'Storage_Type' => $laptopStorage_Type,
            'Graphic_Manufacturer' => $laptopGraphic_Manufacturer,
            'Graphic_Model' => $laptopGraphic_Model,
            'Graphic_Memory_Source' => $laptopGraphic_Memory_Source,
            'Display_Size' => $laptopDisplay_Size,
            'Displa_Technology' => $laptopDispla_Technology,
            'Display_Resolution' => $laptopDisplay_Resolution,
            'Keyboard' => $laptopKeyboard,
            'Keyboard_Backlight' => $laptopKeyboard_Backlight,
            'Ports' => $laptopPorts,
            'Optical_Drive' => $laptopOptical_Drive,
            'Camera' => $laptopCamera,
            'Audio' => $laptopAudio,


            'Case_Model' => $request->input('Case_Model') ?? $laptop['Case_Model'],
            'Light_Type' => $request->input('Light_Type') ?? $laptop['Light_Type'],
            'Power_Supply' => $request->input('Power_Supply') ?? $laptop['Power_Supply'],
            'multiMedia' => $request->input('MultiMedia') ?? $laptop['MultiMedia'],



            'Networking' => $laptopNetworking,
            'Battery_Number_Of_Cells' => $laptopBattery_Number_Of_Cells,
            'Operation_System' => $laptopOperation_System,
            'Warranty' => $laptopWarranty,
        ]);

        return response()->json([
            'laptop' => $laptop
        ]);
    }
}
