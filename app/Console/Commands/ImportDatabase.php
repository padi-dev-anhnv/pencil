<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File as FileManager;
use App\File;
use App\Guide;
use App\Delivery;
use App\Procedure;
use App\Packaging;
use App\Office;
use App\User;
use DB;

class ImportDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:database {--limit=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Database from file CSV';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $file_guide = [];
    protected $created_at = '';
    protected $path_address = '';
    protected $body = [
        '1' => '１面',
        '1b' => '２行１版',
        '2' => '２面',
        '3' => '３面',
        '4' => '４面',
        '5' => '5面',
        '6' => '６面',
    ];

    protected $office = '';
    protected $user_id = 1;
    protected $use_upload_file = true;

    public function __construct()
    {
        parent::__construct();
        setlocale(LC_ALL,'en_US.UTF-8');
        $this->path_address = base_path("resources/pending-database/address.csv");
    }

    public function generateOneAuthor()
    {
        $office = Office::firstOrCreate(['name' => 'GuideCreator']);
        // $this->office = $office;
        $user = User::create([
            'name' => 'GuideCreator',
            'username' => 'guide_creator',
            'role_id' => 4,
            'office_id' => $office->id,
            'password' => '123456m@'
        ]);
        $this->user_id = $user->id;
    }

    public function generateAuthor($office, $user_name)
    {
        $office = Office::firstOrCreate(['name' => $office]);
        $this->office =  $office->name;
        /*
        $new_office = $office;
        $user = User::firstOrNew(['name' => $user_name]);
        if(isset($user->username)){

        }
        else{
            $office = Office::firstOrCreate(['name' => $office]);
            $user->office_id = $office->id;
            $user->status = 1;
            $user->password = '123456m@';
            $user->role_id = 4;
            $user->username = strtolower('user' . '_' . Str::random(4));
            $new_office = $office->name;
        }
        $user->save();
        $this->office = $new_office;
        $this->user_id = $user->id;
        return $user->id;
        */
    }

    public function parseGuide($guide)
    {
        $this->generateAuthor($guide['office'], $guide['contact_name_old']);
        $user_id = $this->user_id;
        $guide['user_id'] = $user_id;
        $guide['customer_name'] = $guide['company_name_1_old'] . $guide['company_name_2_old'];
        $arrayDate = ['created_at', 'last_date', 'shipping_date', 'received_date'];
        $guide['last_exist'] = $guide['last_exist'] ? true : false;
        $guide['key_code'] = Str::random(10);
        $guide['export'] = 1;
        foreach ($arrayDate as $date) {
            if ($guide[$date] != '0000-00-00') {
                $datete = Carbon::parse($guide[$date]);
                $guide[$date] =  $datete->format('Y-m-d');
            } else {
                $guide[$date] = null;
            }
        }
        $this->created_at = $guide['created_at'];

        // push all guide to one account
        $guide['old_creator'] =  $guide['contact_name_old'];

        unset($guide['main_id_old']);
        unset($guide['contact_name_old']);
        unset($guide['company_name_1_old']);
        unset($guide['company_name_2_old']);
        unset($guide['creation_date_2_old']);
        return $guide;
    }

    public function parseDelivery($delivery, $guide_id, $address)
    {
        $chk = 0;
        switch ($delivery['office_chk']) {
            case "営業所入り":
                $chk = 3;
                break;
            case "帳合店直送":
                $chk = 2;
                break;
            default:
                $chk = 1;
                break;
        }
        $delivery['guide_id'] = $guide_id;
        $delivery['office_chk'] = $chk;
        $zip_code = $delivery['postal_code'];
        if ($zip_code) {
            if(!empty($address[$zip_code]))
                $delivery['prefecture'] = $address[$zip_code][2] != 'NULL' ? $address[$zip_code][2] : null;
        }
        unset($delivery['municipality_old']);
        return $delivery;
    }

    public function parsePackaging($packaging, $guide_id)
    {
        $packaging['guide_id'] = $guide_id;
        $packaging['printing'] = $packaging['printing'] ? ( $packaging['printing'] == '無' ? 0 : 1 ) : null;
        $packaging['proofreading'] = $packaging['proofreading'] ? ( $packaging['proofreading'] == '無' ? 0 : 1 ) : null;;
        $packaging['number_of_page'] = $packaging['number_of_page'] ?  $packaging['number_of_page']  :  null;
        $packaging['top_text'] = '';
        $packaging['bottom_text'] = '';
        for ($i = 1; $i < 4; $i++) {
            $packaging['top_text'] .= $packaging['packaging_heaven_' . $i . '_old'] ? $packaging['packaging_heaven_' . $i . '_old'] . '
' : '';
            unset($packaging['packaging_heaven_' . $i . '_old']);
        }
        for ($i = 1; $i < 4; $i++) {
            $packaging['bottom_text'] .= $packaging['packaging_ground_' . $i . '_old'] ? $packaging['packaging_ground_' . $i . '_old'] . '
' : '';
            unset($packaging['packaging_ground_' . $i . '_old']);
        }

        $deleteList = [
            'packaging_name_2_old',
            'sheet_num_2_old',
            'packaging_name_3_old',
            'sheet_num_3_old',
            'font_ground_2_old',
            'print_color_ground_2_old',
            'font_ground_3_old',
            'print_color_ground_3_old',
        ];
        foreach ($deleteList as $del) {
            unset($packaging[$del]);
        }

        return $packaging;
    }

    function parseProcedure($procedure, $guide_id,  $const_proce)
    {

        $procedure['guide_id'] = $guide_id;

        $material = [];
        for ($i = 1; $i < 4; $i++) {
            if ($procedure['packing_name_' . $i . '_old'])
                $material[] = ['name' => $procedure['packing_name_' . $i . '_old'], 'numb' => $procedure['sheet_num_2_' . $i . '_old']];
            unset($procedure['packing_name_' . $i . '_old']);
            unset($procedure['sheet_num_2_' . $i . '_old']);
        }
        $procedure['material'] = json_encode($material);
        $procedure['box'] = $procedure['box'] ? ( $procedure['box'] == '無' ? 0 : 1 ) : null;
        $procedure['packaging'] = $procedure['packaging'] ? ( $procedure['packaging'] == '無' ? 0 : 1 ) : null;
        $procedure['advance_shipment'] = $procedure['advance_shipment'] ? ( $procedure['advance_shipment'] == '無' ? 0 : 1 ) : null;        
        $work  = $procedure['work'] ? ( $procedure['work'] == '無' ? 0 :  (in_array($procedure['work'], $const_proce['procedure_work']) ? array_search($procedure['work'], $const_proce['procedure_work']) : 1) ) : null;
        $bagging  = $procedure['bagging'] ? ( $procedure['bagging'] == '無' ? 0 :  (in_array(trim($procedure['stop_date_old']), $const_proce['procedure_bagging']) ? array_search(trim($procedure['stop_date_old']), $const_proce['procedure_bagging']) : 1) ) : null;

        if(trim($procedure['expands_over_date_old'] == 'のし掛のみ')){
            $procedure['expands_over_date_old'] = 'のし掛けのみ';
        }
        
        $gimmick = $procedure['gimmick'] ? ( $procedure['gimmick'] == '無' ? 0 :  (in_array(trim($procedure['expands_over_date_old']), $const_proce['procedure_gimmick']) ? array_search(trim($procedure['expands_over_date_old']), $const_proce['procedure_gimmick']) : 1) ) : null;
        
           
        $procedure['bagging_content'] = $procedure['bagging_content'] != 0 ? $procedure['bagging_content'] : '';
        $procedure['bagging'] = $bagging;
        $procedure['gimmick'] = $gimmick;
        $procedure['work'] = $work;

        $deleteList = [
            'stop_date_old',
            'expands_over_date_old'
        ];
        foreach ($deleteList as $del) {
            unset($procedure[$del]);
        }

        return $procedure;
    }

    function parseProductAll($product)
    {
        $products = [];
        for ($i = 1; $i < 7; $i++) {
            if ($product['product_name_' . $i . '_old']) {
                $datete = Carbon::parse($product['ship_date_' . $i . '_old']);
                $shipping_date = $product['ship_date_' . $i . '_old'] != "0000-00-00" ? $datete->format('Y-m-d') : '';
                $products[] = [
                    'name' => $product['product_name_' . $i . '_old'],
                    'color' => $product['color_' . $i . '_old'],
                    'qty' => $product['inscription_num_' . $i . '_old'],
                    'unit' => $product['unit_' . $i . '_old'],
                    'shipping_date' => $shipping_date,
                ];
            }
        }
        return $products;
    }

    function parseProductInscription($product, $const_proce, $body)
    {
        $inscription = [];
        $inscription['body'] = $product['inscription_date_old'] ?  ($product['inscription_date_old'] == '無' ? 0 :  array_search($product['inscription_date_old'], $body)) : '';
        $inscription['direction'] = $product['inscription_direction_old'] ? array_search($product['inscription_direction_old'], $const_proce['direction']) : '';
        if($product['proofreading_old'] == '不　　要')
            $product['proofreading_old'] = '不要';
        if($product['inscription_font_old'] == '一　任')
            $product['inscription_font_old'] = '一任' ;
        if($product['inscription_font_old'] == '明　朝')
            $product['inscription_font_old'] = '明朝' ;   
        $inscription['proofreading'] = $product['proofreading_old']  ? array_search($product['proofreading_old'], $const_proce['proofreading']) : '';
        $inscription['method'] =  $product['inscription_method_old'] ? array_search($product['inscription_method_old'], $const_proce['insc_method']) + 1 : '';
        $inscription['work'] =  $product['inscription_work_old'] ? array_search($product['inscription_work_old'], $const_proce['insc_work'])+ 1 : '';
        $inscription['typeface'] =  $product['inscription_font_old'] ? array_search($product['inscription_font_old'], $const_proce['insc_typeface1'])+ 1  : '';
        $inscription['font_size'] = $product['font_size_old'] ? ( $product['font_size_old'] == '一　任' ? 0 : 1) : '';  

        $printing_color = [];
        for ($i = 1; $i < 4; $i++) {
            $str = '';
            $str .= $product['print_1_text_' . $i . '_old'];
            $str .= $product['print_2_text_' . $i . '_old'];
            $str .= $product['print_dic_' . $i . '_old'];
            $printing_color[] = $str;
        }
        $inscription['printing_color'] = $printing_color;
        $inscription['pattern_type'] = 7;
        $inscription['pattern_text'] = [$product['pen_content_old']];
        return $inscription;
    }

    function parseProductFile($product)
    {
        $photos = [];
        $can_bonus = true;
        for ($i = 1; $i < 4; $i++) {
            if (!empty($product['img_url_' . $i . '_old'])){
                $photos[] = [
                    'link' => $product['img_url_' . $i . '_old'],
                    'description' => $product['img_name_' . $i . '_old']
                ]
                ;
            }
                
            else if ($can_bonus && !empty($product['img_name_old']))
                $photos[] = [ 'link' => $product['img_name_old'] ] ;
            else
                $photos[] = [];
        }
        return $photos;
    }

    public function parseProductUploadFile($photos)
    {
        /*
        foreach($photos as $photo){
            if($photo && !empty(trim($photo['link']))){
                $suffix = Str::random(7);
                $fileArray = pathinfo($photo['link']);
                if( preg_match('/[\x{4E00}-\x{9FBF}\x{3040}-\x{309F}\x{30A0}-\x{30FF}]/u', $fileArray['filename'])){
                    FileManager::put(storage_path('app/public/files/'.$photo['link']),'John Doe');
                }
            }
        }
*/
        if(!$this->use_upload_file)
            return [];
        $photoArray = [];
        foreach($photos as $photo){
            if($photo && !empty(trim($photo['link']))){
                // echo $photo['link'];
                $old_path = storage_path('app/public/old/'.$photo['link']);
                echo "Copy file : " . $old_path . " \n";
                // if(file_exists($old_path)){
                try{
                    $suffix = Str::random(7);
                    $fileArray = pathinfo($photo['link']);
                    if(empty($fileArray['extension']))
                        continue;
                    $newFile = strtolower(trim($fileArray['filename'] . '-'.$suffix.'.'.$fileArray['extension']));
                    FileManager::copy($old_path, storage_path('app/public/files/'.$newFile));
                    $id = File::insertGetId(
                        [
                            'user_id' => $this->user_id,
                            'office' => $this->office,
                            'name' => $photo['link'],
                            'link' => $newFile,
                            'description' => !empty($photo['description']) ? $photo['description'] : '',
                            'material' => 'guide',
                            'guide_id' => 1,
                            'type' => strtolower($fileArray['extension']),
                            'created_at' => $this->created_at
                        ]
                    );
                    $photoArray[] = ['id' => $id];
                    $this->file_guide[] = $id;                    
                }
                catch (\Exception $e){
                    echo "File not found : " . $photo['link'] . " \n";
                    $photoArray[] = '';
                }
                    
            }
            else
                $photoArray[] = '';
            
        }
        return $photoArray;
    }

    public function parseProduct($product, $const_proce, $body)
    {

        $products = $this->parseProductAll($product);
        $inscription = $this->parseProductInscription($product, $const_proce, $body);
        $photos = $this->parseProductFile($product);
        $inscription['files'] = $photos;
        $this->file_guide = [];
        
        foreach ($products as $key => $product) {
            $file = $this->parseProductUploadFile($photos);
            $inscription['files'] = $file;
            $products[$key] = array_merge($product, $inscription);
        }
        return $products;
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function clearOldData()
    {
        DB::statement("SET foreign_key_checks = 0");
        DB::table('guides')->truncate();
        DB::table('deliveries')->truncate();
        DB::table('procedures')->truncate();
        DB::table('packagings')->truncate();
        DB::table('files')->truncate();
        DB::table('users')->whereNotIn('role_id', [1])->delete();
    }

    public function handle()
    {
        $limit = $this->option('limit');
        $start = now();
        $this->comment("Start migrating");
        // clear all database for guide
        $this->clearOldData();
        $this->generateOneAuthor();
        // read file address db 
        $address = [];        
        $address_res = fopen($this->path_address, "r");
        while (($filedata = fgetcsv($address_res, 5000, ",")) !== FALSE) {
            $num = count($filedata);
            for ($c = 0; $c < $num; $c++) {
                $address[$filedata[1]][] = $filedata[$c];
            }
        }
        // read file db guide
        $path_guide = base_path("resources/pending-database/guide.csv");
        $baseStructure = config('oldstructure');
        $const_proce = config('const');        

        $newStructure = [];
            $file = fopen($path_guide, "r");
            $i = 0;
            while (($filedata = fgetcsv($file, 5000, ",")) !== FALSE) {
                $num = count($filedata);
                for ($c = 0; $c < $num; $c++) {
                    $key = $baseStructure[$c]['new'] ? $baseStructure[$c]['new'] : $baseStructure[$c]['old'] . '_old';
                    $newStructure[$i][$baseStructure[$c]['table']][$key] = $filedata[$c];
                }
                $i++;
            }

            $chunks = array_chunk($newStructure, 5000);
            $done = 0;
            foreach ($chunks as $rows) {
                foreach ($rows as $row) {
                    if ($done == 0){
                        $done++;
                        continue;
                    } 
                    $guide = $this->parseGuide($row['guide']);
                    $products = $this->parseProduct($row['product'], $const_proce, $this->body);
                    $guide['products'] =  json_encode($products);
                    $newGuideId = Guide::insertGetId($guide);
                    $delivery =  $this->parseDelivery($row['delivery'], $newGuideId, $address);
                    $packaging =  $this->parsePackaging($row['packaging'], $newGuideId);
                    $procedure =  $this->parseProcedure($row['procedure'], $newGuideId, $const_proce);
                    Delivery::insert($delivery);
                    Packaging::insert($packaging);
                    Procedure::insert($procedure);
                    foreach($this->file_guide as $id)
                    {
                        $file_product = File::find($id);
                        $file_product->guide_id = $newGuideId;
                        $file_product->save();
                    }

                    $done++; 
                    if($done % 1000 == 0)
                        echo "Migrated ". $done . " records \n";
                    if($limit != null && $done > $limit )
                        break;
                }
                
                
            }
            $this->info("Migrate database is completed");
            $time = $start->diffInSeconds(now());
            $this->comment("Processed in $time seconds");
    }
}
