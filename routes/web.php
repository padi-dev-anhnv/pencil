<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'GuideController@homepage');

Route::get('login', 'UserController@login')->name('login');
Route::get('logout', 'UserController@logout')->name('logout');
Route::post('login', 'UserController@postLogin')->name('postLogin');

Route::group(['prefix' => 'user', 'middleware' =>['can:list,\App\User', 'active_user'] ], function(){
    Route::view('/', 'pages.user.index')->name('user');
    Route::post('/', 'UserController@create');
    Route::get('/{id}/show', 'UserController@show');
    Route::view('/{id}/edit', 'pages.user.edit');
    Route::view('/create', 'pages.user.new')->name('user.new');
    Route::get('/get-list', 'UserController@list');
    Route::post('/delete', 'UserController@delete');
    Route::get('/roles', 'UserController@getRoles');
    Route::post('/upload-customer-csv', 'CustomerController@uploadCustomer');
});

Route::group(['prefix' => 'file', 'middleware' =>['can:list,\App\File', 'active_user'] ], function(){
    Route::view('/', 'pages.file.index')->name('file');    
    Route::post('/', 'FileController@create');
    Route::post('/upload', 'FileController@upload');
    Route::post('/upload-multi', 'FileController@upload_multi');
    Route::get('/search', 'FileController@search');
    Route::get('/{id}/show', 'FileController@show');    
    Route::get('/{id}/download', 'FileController@download');
    Route::post('/delete', 'FileController@delete');
    Route::get('/user-per-file', 'UserController@listUserPerFile');
});

Route::group(['prefix' => 'guide', 'middleware' =>['can:list,\App\Guide', 'active_user'] ], function(){
    Route::get('/', 'GuideController@index')->name('guide');
    Route::post('/', 'GuideController@create');
    Route::post('/update-product', 'GuideController@updateProduct');
    Route::get('/{id}/edit', 'GuideController@edit')->name('guide.edit');
    Route::view('/{id}/dupplicate', 'pages.guide.dupplicate')->middleware('can:create,\App\Guide')->name('guide.dupplicate');
    Route::get('/{id}/get-guide', 'GuideController@getGuide');
    Route::view('/create', 'pages.guide.new')->middleware('can:create,\App\Guide')->name('guide.create'); 
    Route::get('/listSuppliers', 'GuideController@listSuppliers');
    Route::get('/search', 'GuideController@search');    
    Route::get('/workers', 'UserController@getWorkers');    
    Route::get('/offices', 'UserController@getOffices');
    Route::post('/delete', 'GuideController@delete');
    Route::post('/clone', 'GuideController@clone');
    Route::post('/change-export', 'GuideController@changeExport');
    Route::get('/find-customer', 'CustomerController@findCustomer');
    Route::get('/{id}/show/{price}', 'GuideController@showPdf')->name('guide.show');
    
});
Route::get('/{id}/show-html/{price}', 'GuideController@showPdfHtml')->name('guide.html');

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
Route::get('/ff', function(){
    $user = App\User::firstOrNew(['name' => 'Hika Ru']);
    if(isset($user->username)){

    }
    else{
        $office = App\Office::firstOrCreate(['name' => 'pikachiu']);
        $user->office_id = $office->id;
        $user->status = 1;
        $user->password = 'toetoe';
        $user->role_id = 4;
        $user->username = 'user2';

    }
    $user->save();
    // dd($user);
    dd("fsd");
    $path = public_path('files');
    //   $files = File::allFiles(storage_path('app/public/files/'));
      $files = scandir(storage_path('app/public/files/'));
      setlocale(LC_ALL,'en_US.UTF-8');
      foreach($files as $file)
      {
          if($file != '.' && $file != '..'){
            $suffix = Str::random(7);
            $fileArray = pathinfo($file);
            if(empty($fileArray['extension']))
                continue;
            $newFile = strtolower(trim($fileArray['filename'] . '-'.$suffix.'.'.$fileArray['extension']));
            echo $newFile . "<br />";
            File::copy(storage_path('app/public/files/'.$file) , storage_path('app/public/co/'.$newFile));
          }
      }
});
/*
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
function parseGuide($guide)
{
    $guide['user_id'] = 1;
    $guide['customer_name'] = $guide['company_name_1_old'] . $guide['company_name_2_old'] ;
    $arrayDate = ['created_at', 'last_date', 'shipping_date', 'received_date'];
    $guide['last_exist'] = $guide['last_exist'] ? true : false ;
    $guide['key_code'] = Str::random(10) ;
    foreach($arrayDate as $date)
    {
        if($guide[$date] != '0000-00-00'){
            $datete = Carbon::parse( $guide[$date]);
            $guide[$date] =  $datete->format('Y-m-d');
        }
        else{
            $guide[$date] = null;
        }
    }  
    unset($guide['main_id_old']);
    unset($guide['contact_name_old']);
    unset($guide['company_name_1_old']);
    unset($guide['company_name_2_old']);
    unset($guide['creation_date_2_old']);
    return $guide;
}

function parseDelivery($delivery, $guide_id, $address)
{
    $chk = 0;
    switch($delivery['office_chk']){
        case "営業所入り" : 
            $chk = 3;
            break;
        case "帳合店直送" : 
            $chk = 2;
            break;
        default : 
            $chk = 1;
            break;
    }
    $delivery['guide_id'] = $guide_id;
    $delivery['office_chk'] = $chk;
    $zip_code = $delivery['postal_code'];
    if($zip_code)
    {
        $delivery['prefecture'] = $address[$zip_code][2] != 'NULL' ? $address[$zip_code][2] : null ;
    }

    unset($delivery['municipality_old']);
    return $delivery;
}

function parsePackaging($packaging, $guide_id)
{
    $packaging['guide_id'] = $guide_id;
    $packaging['printing'] = $packaging['printing'] ? 1  : 0;
    $packaging['proofreading'] = $packaging['proofreading'] ? 1  : 0;
    $packaging['number_of_page'] = $packaging['number_of_page'] ?  $packaging['number_of_page']  :  null;
    $packaging['top_text'] = '';    
    $packaging['bottom_text'] = '';
    for($i = 1 ; $i < 4; $i++)
    {
        $packaging['top_text'] .= $packaging['packaging_heaven_' . $i . '_old'] ? $packaging['packaging_heaven_' . $i . '_old'] . '
' : '';
        unset($packaging['packaging_heaven_' . $i . '_old']);
    }
    for($i = 1 ; $i < 4; $i++)
    {
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
    foreach($deleteList as $del)
    {
        unset($packaging[$del]);
    }

    return $packaging;
}

function parseProcedure($procedure, $guide_id,  $const_proce)
{

    $procedure['guide_id'] = $guide_id;

    $material = [];
    for($i = 1; $i < 4; $i++)
    {
        if($procedure['packing_name_' .$i. '_old'])
            $material[] = ['name' => $procedure['packing_name_' .$i. '_old'] , 'numb' => $procedure['sheet_num_2_' .$i. '_old']];
        unset($procedure['packing_name_' .$i. '_old']);
        unset($procedure['sheet_num_2_' .$i. '_old']);
    }
    $procedure['material'] = json_encode($material);
    $procedure['box'] = $procedure['box'] ==  '無' ? 0 : 1 ;
    $procedure['packaging'] = $procedure['packaging'] ==  '無' ? 0 : 1 ;
    // $procedure['gimmick'] = $procedure['gimmick'] ==  '無' ? 0 : 1 ;
    $procedure['advance_shipment'] = $procedure['advance_shipment'] ==  '無' ? 0 : 1 ;

    $work  = $procedure['work'] == '無' ? 0 : ( in_array($procedure['work'], $const_proce['procedure_work']) ? array_search( $procedure['work'],$const_proce['procedure_work']) : 'noStdReturn' ) ;
    $bagging = $procedure['bagging'] == '無' ? 0 : ( $procedure['stop_date_old'] ? array_search( $procedure['stop_date_old'],$const_proce['procedure_bagging']) : 'stapler' ) ;
    $gimmick = $procedure['gimmick'] == '無' ? 0 : ( $procedure['expands_over_date_old'] ? array_search($procedure['expands_over_date_old'],$const_proce['procedure_gimmick'] ) : 'inside' ) ;

    $procedure['bagging'] = $bagging; 
    $procedure['gimmick'] = $gimmick;
    $procedure['work'] = $work;

    $deleteList = [
        'stop_date_old',
        'expands_over_date_old'
    ];
    foreach($deleteList as $del)
    {
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
                $products[] = [
                    'name' => $product['product_name_' . $i . '_old'],
                    'color' => $product['color_' . $i . '_old'],
                    'qty' => $product['inscription_num_' . $i . '_old'],
                    'unit' => $product['unit_' . $i . '_old'],
                    'shipping_date' => $datete->format('Y-m-d'),
                ];
            }
        }
        return $products;
    }

    function parseProductInscription($product, $const_proce, $body)
    {
        $inscription = [];
        $inscription['body'] = ($product['inscription_date_old'] == '無' || empty($product['inscription_date_old'])) ? 0 :  array_search($product['inscription_date_old'], $body);
        $inscription['direction'] = $product['inscription_direction_old']  ? array_search($product['inscription_direction_old'], $const_proce['direction']) : 'side';
        $inscription['proofreading'] = $product['proofreading_old']  ? array_search(trim($product['proofreading_old']), $const_proce['proofreading']) : 'unnecessary';
        $inscription['method'] =  $product['inscription_method_old'];
        $inscription['work'] =  $product['inscription_work_old'];
        $inscription['typeface'] =  $product['inscription_font_old'];
        $inscription['font_size'] = ($product['inscription_date_old'] == '一　任' || empty($product['inscription_date_old'])) ? 0 : 1;

        $printing_color = [];
        for ($i = 1; $i < 4; $i++) {
            $str = '';
            $str .= $product['print_1_text_' . $i . '_old'];
            $str .= $product['print_2_text_' . $i . '_old'];
            $str .= $product['print_dic_' . $i . '_old'];
            $printing_color[] = $str;
        }
        $inscription['printing_color'] = $printing_color;
        $inscription['pattern_type'] = 1;
        $inscription['pattern_text'] = [$product['pen_content_old'], '', ''];
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

    function parseProductUploadFile($photos)
    {
        
        $photoArray = [];
        foreach($photos as $photo){
            if($photo && !empty(trim($photo['link']))){
                $old_path = storage_path('app/public/old/'.$photo['link']);
                if(is_file($old_path)){
                    $suffix = Str::random(7);
                    $fileArray = pathinfo($photo['link']);
                    $newFile = strtolower(trim($fileArray['filename'] . '-'.$suffix.'.'.$fileArray['extension']));
                    File::copy($old_path, storage_path('app/public/files/'.$newFile));
                    $id = App\File::insertGetId(
                        [
                            'user_id' => 1,
                            'office' => '',
                            'name' => $photo['link'],
                            'link' => $newFile,
                            'description' => $photo['description'],
                            'material' => 'guide',
                            'guide_id' => 1,
                            'type' => strtolower($fileArray['extension']),
                            'created_at' => '2020-09-11',
                        ]
                    );
                    $photoArray[] = ['id' => $id];
                    $GLOBALS['files'][] = $id;                    
                }
                else
                    $photoArray[] = '';
            }
            else
                $photoArray[] = '';
            
        }
        return $photoArray;
    }

    function parseProduct($product, $const_proce, $body)
    {

        $products = parseProductAll($product);
        $inscription = parseProductInscription($product, $const_proce, $body);
        $photos = parseProductFile($product);       
        // $inscription['files'] = $photos;
        // $inscription['files'] = 
        $GLOBALS['files'] = [];
        foreach ($products as $key => $product) {
            $file = parseProductUploadFile($photos);
            // dd($file);
            $inscription['files'] = $file;
            $products[$key] = array_merge($product, $inscription);
        }
        return $products;
    }
Route::get('/csv', function(){
dd("fsdf");
    DB::statement("SET foreign_key_checks = 0");
    DB::table('guides')->truncate() ;
    DB::table('deliveries')->truncate() ;
    DB::table('procedures')->truncate() ;
    DB::table('packagings')->truncate() ;
    DB::table('files')->truncate() ;
    
    // read file address db 
    $address = [];
    $j = 0;
    $path_address = base_path("resources/zipcode-database/address.csv"); 
    $address_res = fopen($path_address,"r");
    while (($filedata = fgetcsv($address_res, 5000, ",")) !== FALSE) {
        $num = count($filedata );
        for ($c=0; $c < $num; $c++) {
            $address[$filedata[1]][] = $filedata [$c];
        }
        $j++;

    }
    // read file db guide
    $path = base_path("resources/pending-database/*.csv"); 
    
    $baseStructure = config('oldstructure');
    $const_proce = config('const');
    $body = [
        '1' => '１面',
        '1b' => '２行１版',
        '2' => '２面',
        '3' => '３面',
        '4' => '４面',
        '5' => '5面',
        '6' => '６面',
    ];
    $newStructure = [];
    foreach (array_slice(glob($path),0,2) as $filePath) {
        $file = fopen($filePath,"r");
        // $importData_arr = array();
        $i = 0;
        while (($filedata = fgetcsv($file, 5000, ",")) !== FALSE) {
            $num = count($filedata );
            for ($c=0; $c < $num; $c++) {
                // $importData_arr[$i][] = $filedata [$c];

                $key = $baseStructure[$c]['new'] ? $baseStructure[$c]['new'] : $baseStructure[$c]['old'] . '_old';
                $newStructure[$i][$baseStructure[$c]['table']][$key] = $filedata [$c];
                // $newStructure[$i][] = $baseStructure
            }
            $i++;

        }

        
    //    var_dump($newStructure);
        $chunks = array_chunk($newStructure, 5000);
        foreach($chunks as $rows){
            foreach($rows as $row){     
                $guide = parseGuide($row['guide']);
                $products = parseProduct($row['product'], $const_proce, $body);
                $guide['products'] =  json_encode($products) ; 
                $newGuideId = App\Guide::insertGetId($guide);                
                $delivery =  parseDelivery($row['delivery'],$newGuideId, $address);
                $packaging =  parsePackaging($row['packaging'],$newGuideId);
                $procedure =  parseProcedure($row['procedure'],$newGuideId, $const_proce);
                App\Delivery::insert($delivery);
                App\Packaging::insert($packaging);
                App\Procedure::insert($procedure);
                foreach($GLOBALS['files'] as $id)
                {
                    $file = App\File::find($id);
                    $file->guide_id = $newGuideId;
                    $file->save();
                }
            }
        }
       dd("inserted");
    }
});
*/
/*
use Intervention\Image\ImageManagerStatic as Image;
Route::get('/thumbnail', function(){
    $file_folder = storage_path('app/public/files/');
    foreach(glob($file_folder.'*.{jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF}',GLOB_BRACE) as $filename){
        echo storage_path('app/public/files/' . basename($filename));
        $file_name = pathinfo(basename($filename), PATHINFO_FILENAME);
        $extension = pathinfo(basename($filename), PATHINFO_EXTENSION);
        $thumbnail_name = $file_name . '-thumbnail.'.$extension;
        Image::make(public_path('storage/files/'.basename($filename)) )->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('storage/thumbnail/'.basename($thumbnail_name)) );
    }
});
*/