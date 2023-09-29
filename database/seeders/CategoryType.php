<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Section;
use App\Models\User;
use App\Models\Color;
use App\Models\Sector;
use Illuminate\Support\Facades\Hash;


class CategoryType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=User::create([
            'email'=>'userTest2@gmail.com',
            'name'=>'userTest',
            'password'=>Hash::make('0959860097'),
            'role'=>1
        ]);
        $token = $user->createToken('secret')->plainTextToken;

        Color::create([
            'R' => "255",
            'G' => "171",
            'B' => "64",
            'A' => "1",
        ]);
        // Log or display the generated token
        echo "Generated Token: " . $token . "\n";

        Category::create([
            'type'=>'LapTop'
        ]);

        Category::create([
            'type'=>'DeskTop'
        ]);
        
        Category::create([
            'type'=>'Monitor'
        ]);

        Category::create([
            'type'=>'Storage'
        ]);

        Category::create([
            'type'=>'Audio'
        ]);

        Category::create([
            'type'=>'Software'
        ]);

        Category::create([
            'type'=>'Accessories'
        ]);
        
        Category::create([
            'type'=>'Printer'
        ]);
        
        Category::create([
            'type'=>'Hardware'
        ]);
        
        Category::create([
            'type'=>'Gamming'
        ]);


/*********** */
        Section::create([
            'category_id'=>1,
            'section_type'=>'Every Day Use Laptop'
        ]);
        Section::create([
            'category_id'=>1,
            'section_type'=>'Busniess Laptop'
        ]);
        Section::create([
            'category_id'=>1,
            'section_type'=>'Gamming Laptop'
        ]);
        Section::create([
            'category_id'=>1,
            'section_type'=>'Light Weight Laptop'
        ]);
        Section::create([
            'category_id'=>1,
            'section_type'=>'Touch Screen Laptop'
        ]);
        
////////************** */
        Section::create([
            'category_id'=>2,
            'section_type'=>'All In One'
        ]);
        Section::create([
            'category_id'=>2,
            'section_type'=>'Gamming & Pc'
        ]);
        Section::create([
            'category_id'=>2,
            'section_type'=>'Pc & WorksStation'
        ]);

        
/************* */
        Section::create([
            'category_id'=>3,
            'section_type'=>'Gamming Mointor'
        ]);
        Section::create([
            'category_id'=>3,
            'section_type'=>'Tvs'
        ]);
    



/**************** */

        Section::create([
            'category_id'=>4,
            'section_type'=>'Internal Storage'
        ]);

                    Sector::create([
                        'section_id'=>11,
                        'name'=>'HDD Internal Storage'
                    ]);
                    Sector::create([
                        'section_id'=>11,
                        'name'=>'SSD Internal Storage'
                    ]);
                    
                

        Section::create([
            'category_id'=>4,
            'section_type'=>'External Storage'
        ]);


                    Sector::create([
                        'section_id'=>12,
                        'name'=>'Porable Storage'
                    ]);
                    Sector::create([
                        'section_id'=>12,
                        'name'=>'Networkable Storage'
                    ]);


        Section::create([
            'category_id'=>4,
            'section_type'=>'Flash & Memory Card'
        ]);

                    Sector::create([
                        'section_id'=>13,
                        'name'=>'USB Flash Drives'
                    ]);
                    Sector::create([
                        'section_id'=>13,
                        'name'=>'Memory Cards'
                    ]);


/******************* */
        Section::create([
            'category_id'=>5,
            'section_type'=>'Wired HeadSet'
        ]);

        Section::create([
            'category_id'=>5,
            'section_type'=>'Wirless HeadSet'
        ]);

        Section::create([
            'category_id'=>5,
            'section_type'=>'Wired Earphone'
        ]);

        Section::create([
            'category_id'=>5,
            'section_type'=>'Wirless Earphone'
        ]);

        Section::create([
            'category_id'=>5,
            'section_type'=>'Bluetooth Speakers'
        ]);

        Section::create([
            'category_id'=>5,
            'section_type'=>'Multimedia Speakers'
        ]);

        Section::create([
            'category_id'=>5,
            'section_type'=>'Sub Woofers'
        ]);






 /***************** */
        Section::create([
            'category_id'=>6,
            'section_type'=>'Operation System'
        ]);

        Section::create([
            'category_id'=>6,
            'section_type'=>'Office Products'
        ]);

        Section::create([
            'category_id'=>6,
            'section_type'=>'Virus Protection'
        ]);

        Section::create([
            'category_id'=>6,
            'section_type'=>'Design Software'
        ]);

/***** */
        Section::create([
            'category_id'=>7,
            'section_type'=>'Bags & Cases'
        ]);
        Section::create([
            'category_id'=>7,
            'section_type'=>'Keyboard'
        ]);
        Section::create([
            'category_id'=>7,
            'section_type'=>'Mouse'
        ]);
        Section::create([
            'category_id'=>7,
            'section_type'=>'Pointer'
        ]);
        Section::create([
            'category_id'=>7,
            'section_type'=>'Computer Cables & Converters'
        ]);
        Section::create([
            'category_id'=>7,
            'section_type'=>'Laptop Batteries & Chargers'
        ]);
        Section::create([
            'category_id'=>7,
            'section_type'=>'Cast Product'
        ]);
        Section::create([
            'category_id'=>7,
            'section_type'=>'Laptop Cooling Satnds'
        ]);
        Section::create([
            'category_id'=>7,
            'section_type'=>'Power Extentions'
        ]);
        Section::create([
            'category_id'=>7,
            'section_type'=>'DVDs & CDs'
        ]);







/******************** */
        Section::create([
            'category_id'=>8,
            'section_type'=>'Scanner'
        ]);
    
        Section::create([
            'category_id'=>8,
            'section_type'=>'Leaser Printer'
        ]);
    
        Section::create([
            'category_id'=>8,
            'section_type'=>'Inkjet Printer'
        ]);


//************ */
        Section::create([
            'category_id'=>9,
            'section_type'=>'RAM'
        ]);
               Sector::create([
                    'section_id'=>38,
                    'name'=>'RAM For Desktop'
                ]);
               Sector::create([
                    'section_id'=>38,
                    'name'=>'RAM For Laptop'
                ]);
            //    Sector::create([
            //         'section_id'=>38,
            //         'name'=>'RAM For Server'
            //     ]);


        Section::create([
            'category_id'=>9,
            'section_type'=>'Computer Components'
        ]);
                Sector::create([
                    'section_id'=>39,
                    'name'=>'Graphic Cards'
                ]);
                Sector::create([
                    'section_id'=>39,
                    'name'=>'Motherboard'
                ]);
                Sector::create([
                    'section_id'=>39,
                    'name'=>'Cases & Towers'
                ]);
                Sector::create([
                    'section_id'=>39,
                    'name'=>'Fans & cooling'
                ]);
                Sector::create([
                    'section_id'=>39,
                    'name'=>'Power Supplies'
                ]);
                Sector::create([
                    'section_id'=>39,
                    'name'=>'Optical Driver'
                ]);

        Section::create([
            'category_id'=>9,
            'section_type'=>'Processors'
        ]);
                Sector::create([
                    'section_id'=>40,
                    'name'=>'INTEl CPU'
                ]);
                Sector::create([
                    'section_id'=>40,
                    'name'=>'AMD CPU'
                ]);
    //************ */
        Section::create([
            'category_id'=>10,
            'section_type'=>'Gamming Mouse'
        ]);
        Section::create([
            'category_id'=>10,
            'section_type'=>'Gamming Keyboard'
        ]);
        Section::create([
            'category_id'=>10,
            'section_type'=>'Gamming Headset'
        ]);
        Section::create([
            'category_id'=>10,
            'section_type'=>'Gamming Bags'
        ]);
    
    }
}
