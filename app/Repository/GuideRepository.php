<?php
namespace App\Repository;

use Gate;
use App\Guide;
use App\Supplier;
use App\Delivery;
use App\Packaging;
use App\Procedure;
use App\Product;
use App\File;
use App\Services\FileService;
use App\Repository\FileRepository;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class GuideRepository
{
    protected $guide;
    protected $fileService;  
    protected $fileRepo;  

    public function __construct(Guide $guide, FileService $fileService, FileRepository $fileRepository)
    {
        $this->guide = $guide;
        $this->fileService = $fileService;
        $this->fileRepo = $fileRepository;
    }

    public function listSuppliers()
    {
        return Supplier::all();
    }

    public function get($id, $type = 'id')
    {
            
        if($type == 'id')
            $guide = Guide::findOrFail($id)->makeHidden(['first_product']);
        else
            $guide = Guide::where($type, $id)->firstOrFail()->makeHidden(['first_product']);
        
        $delivery = $guide->delivery()->first();
        $packaging = $guide->packaging()->first();
        $procedure = $guide->procedure()->first();
        $files = $guide->files()->get();
        $dupplicate = $guide->dupplicate()->select('created_at', 'id', 'number')->first();
        $office = $guide->office()->select('name', 'id')->first();
        $supplier = $guide->supplier()->select('name', 'id')->first();
        $creator['office'] = $office;

        // hide price if current user is worker
        // if(Gate::denies('author-guide'))
        $user = auth()->user();
        if( $user ){
            if($user->role->type == 'worker')
                $guide->price = false;
        }
            

        return [
            'guide' => $guide,
            'delivery' => $delivery,
            'packaging' => $packaging,
            'procedure' => $procedure,
            'products' => $guide->products,
            'creator' => $creator,
            'supplier' => $supplier,
            'dupplicate' => $dupplicate,
            'files'     => $files
        ];
    }

    public function getMessageProduct($msg)
    {
        for($i = 0; $i < 11; $i++)
        {
            $msg['products.'.$i.'.name'] = '〈枝番'.($i + 1).'〉の品名';
            $msg['products.'.$i.'.color'] = '〈枝番'.($i + 1).'〉の色';
            $msg['products.'.$i.'.qty'] = '〈枝番'.($i + 1).'〉の銘入数量';
            $msg['products.'.$i.'.unit'] = '〈枝番'.($i + 1).'〉の単位';
            $msg['products.'.$i.'.pattern_text.*'] = '〈枝番'.($i + 1).'〉の枝番';
        }
        return $msg;
    }

    public function getMessage()
    {
        $maxArray = [
            'guide.title' => '業者',
            'guide.number' => '指図書No.',
            'guide.store_code' => '店コード',
            'guide.customer_name' => '得意先名',
            'guide.curator' => 'ご担当者様',

            'delivery.receiver' => '送付先名',
            'delivery.destination_code' => '送り先コード',
            'delivery.postal_code' => '送付先名',
            'delivery.phone' => '電話番号',
            'delivery.fax' => 'FAX',
            'full_address' => '住所',

            'packaging.top_font' => '天の書体',
            'packaging.top_color' => '天の印刷色',
            'packaging.bottom_font' => '地の書体',
            'packaging.bottom_color' => '地の印刷色',
            'packaging.top_text' => '天の文字原稿',
            'packaging.bottom_text' => '地の文字原稿',
            'packaging.description' => '梱包説明',
            'packaging.material' => '包装材品名',
            'packaging.number_of_page' => '枚数',

            'procedure.material.*.name' => '包装材品名',
            'procedure.material.*.numb' => '枚数',
            'procedure.bagging_content' => '袋詰め',
            'procedure.note' => '注意事項等',            
            
        ];

        $maxArray = $this->getMessageProduct($maxArray);
        $messages = [];
        $messages['guide.title.required'] = config('errors.title_required');
        foreach($maxArray as $key => $value)
        {
            $messages[$key . '.max'] =  $value . ' (最大の文字数: :max)';
        }
        return $messages;
    }

    public function getRule()
    {
        return [
            'guide.title' => 'required|max:50',
            'guide.number' => 'max:8',
            'guide.store_code' => 'max:17',
            'guide.customer_name' => 'max:9',
            'guide.curator' => 'max:7',

            'delivery.receiver' => 'max:28',
            'delivery.destination_code' => 'max:14',
            'delivery.postal_code' => 'max:28',
            'delivery.phone' => 'max:12',
            'delivery.fax' => 'max:12',
            'full_address' => 'max:32',

            'packaging.top_font' => 'max:11',
            'packaging.top_color' => 'max:11',
            'packaging.bottom_font' => 'max:11',
            'packaging.bottom_color' => 'max:11',
            'packaging.top_text' => 'max:54',
            'packaging.bottom_text' => 'max:54',
            'packaging.description' => 'max:84',
            'packaging.material' => 'max:6',
            'packaging.number_of_page' => 'max:13',

            'procedure.material.*.name' => 'max:12',
            'procedure.material.*.numb' => 'max:12',
            'procedure.bagging_content' => 'max:6',
            'procedure.note' => 'max:244',

            'products.*.name' => 'max:25',
            'products.*.color' => 'max:9',
            'products.*.qty' => 'max:12',
            'products.*.unit' => 'max:4',
            'products.*.pattern_text.*' => 'max:83',
        ];
    }

    public function getFullAddress($request)
    {
        $postal_code = "";
        if($request['delivery']['postal_code'])
            $postal_code = "〒000-0000　";
        
        return $postal_code . $request['delivery']['prefecture']
        . $request['delivery']['city']
        . $request['delivery']['address']
        . $request['delivery']['building']
        ;
    }

    public function create($requests)
    {
        $request = json_decode($requests['data'], true);

        $messages = $this->getMessage();
        $rule = $this->getRule();

        //set validate address
        $request["full_address"] = $this->getFullAddress($request);
        $validator = Validator::make($request, $rule, $messages);
        $validated = $validator->validate();
        // check  

        $request['guide']['key_code'] =  empty($request['guide']['key_code']) ? Str::random(10) : $request['guide']['key_code'] ;
        $author_office = $this->setAuthorOffice($request['guide'], $request['doDupplicate']);
        $request['guide']['user_id'] = $author_office['user_id'];
        // if($author_office['office_id'])
        // $request['guide']['office_id'] = $author_office['office_id'];
        $request['guide']['office'] = $author_office['office'];
        $products = $request['products'];
        $guideRequest = $request['guide'];
        $deliveryRequest = $request['delivery'];
        $packagingRequest = $request['packaging'];
        $procedureRequest = $request['procedure'];
        $originalFiles = $request['originalFiles'];
        $guideRequest = $this->setNullGuide($guideRequest);
        $packagingRequest = $this->setNullPackaging($packagingRequest);

        $guide = $this->guide::updateOrCreate(['id' => $guideRequest['id']], $guideRequest);
        $guide->delivery()->updateOrCreate(['id' => $deliveryRequest['id']], $deliveryRequest);
        $guide->packaging()->updateOrCreate(['id' => $packagingRequest['id']], $packagingRequest);
        $guide->procedure()->updateOrCreate(['id' => $procedureRequest['id']], $procedureRequest);

        // handle file attach product guide
        if($request['doDupplicate'] == true){
            $guide->key_code = Str::random(10);
            $guide->old_creator = null;
            $products = $this->dupplicateGuideFile($products, $guide->id);
        }
        else{
            $used_file = $this->setGuideFile($products, $guide->id);
            $this->deleteDetachedFile($originalFiles, $used_file);            
        }
        // handle upload files
        $fileUpload = isset($requests['filesUpload']) ? $requests['filesUpload'] : [] ;
        $map_upload = $this->uploadFileGuide($fileUpload, $guide->id);
        $products = $this->mapFileGuide($products, $map_upload);
        $guide->products = $products; 
        $guide->save();
        
        
        return ['success' => true, 'id' => $guide->id , 'map_upload' => $map_upload];
    }

    public function setAuthorOffice($guide, $doDupplicate)
    {
        $result = [];
        if(auth()->user()->role->type == 'admin' && isset($guide['user_id']) && $doDupplicate != true){
            $result['user_id'] = $guide['user_id'];
            $result['office'] = $guide['office'];
        }            
        else{
            $result['user_id'] = auth()->user()->id;
            $result['office'] = null;
            if(auth()->user()->office)
                $result['office'] = auth()->user()->office->name;
        }
                  
        return $result;
    }

    public function setOffice($user_id)
    {

    }

    public function setGuideFile($products, $guide_id)
    {
        $array_file = [];
        foreach($products as $product)
        {
            foreach($product['files'] as $file)
            {
                if(isset($file['id']))
                {
                    $array_file[] = $file['id'];
                }
            }
        }

        return $array_file;
    } 

    public function dupplicateGuideFile($products, $guide_id)
    {
        $mapFileId = [];
        foreach($products as $pindex => $product)
        {
            foreach($product['files'] as $findex => $file)
            {
                if(isset($file['id']))
                {
                    $array_file[] = $file['id'];
                    $file_guide = File::find($file['id']);
                    $newFile = $file_guide->replicate();
                    $newFile->guide_id = $guide_id;
                    $newFile->user_id = auth()->user()->id;
                    $newFile->save();
                    $mapFileId[$file_guide->id] = $newFile->id;
                    // change product structure with new file id
                    $products[$pindex]['files'][$findex]['id'] = $newFile->id;

                    // $fileService = new FileService;
                    $this->fileService->dupplicateFile(File::$fileDir, $newFile->link);
                    $fileThumbnail = File::hasThumbnail($newFile->link) ;
                    if(isset($fileThumbnail['thumbnail']))
                        $this->fileService->dupplicateFile(File::$fileThumbnail, $fileThumbnail['thumbnail']);
                    
                }
            }
        }
        // return [ 'map' => $mapFileId, 'products' =>  $products] ; 
        return $products;
    } 

    /*
    public function updateProduct($id, $products)
    {
        
        $guide = $this->guide::find($id);
        $guide->products = $products;
        $guide->save();
    }
    */

    public function deleteDetachedFile($originalFiles, $used_file)
    {
        foreach($originalFiles as $file)
        {
            if(!in_array($file['id'], $used_file))
            {
                File::destroy($file['id']);
            }
        }
    }

    public function changeExport($guide_id)
    {
        $guide = $this->guide::findOrFail($guide_id);
        if (Gate::denies('update', $guide)) {
            return false;
        }
        $guide->export = !$guide->export;
        $guide->save();
    }

    public function uploadFileGuide($files, $guide_id)
    {
        $map_upload = [];
        if(!empty($files)){
            foreach($files as $key => $file)
            {
                $file_uploaded = $this->fileService->uploadFile($file);
                $file_info = [
                    'name'  => $file_uploaded['file_name'],
                    'type' =>  $file_uploaded['type'],
                    'link' => $file_uploaded['link'],
                    'guide_id' => $guide_id,
                    'material' => 'guide',
                    'id' => 0
                ];
                $new_file =  $this->fileRepo->create($file_info);
                $map_upload[$key] = $new_file->id;
            }
        }
        return $map_upload;
    }

    public function mapFileGuide($products, $map_upload){
        foreach($products as $indexPro =>  $product)
        {
            foreach($product['files'] as $indexFile =>$file)
            {
                $updatedFile = [];
                if(isset($file['id']))
                    $updatedFile['id'] =  $file['id'];
                else{
                    if(isset($file['uploading']))
                        $updatedFile['id'] = $map_upload[$file['uploading']];
                }
                $products[$indexPro]['files'][$indexFile] = $updatedFile; 
            }
        }
        return $products;
    }

    

    public function setNullGuide($guide)
    {
        $guide['last_date'] = $guide['last_date'] ? $guide['last_date'] : null;
        $guide['shipping_date'] = $guide['shipping_date'] ? $guide['shipping_date'] : null;
        $guide['received_date'] = $guide['received_date'] ? $guide['received_date'] : null;
        return $guide;
    }
    public function setNullPackaging($guide)
    {
        $guide['number_of_page'] = $guide['number_of_page'] ? $guide['number_of_page'] : null;
        return $guide;
    }
    
    
    public function search($request)
    {
        
        $query = $this->guide::query();
        $query->hasPer();

        $arrayFilter = ['office', 'worker', 'creator','orderDateFrom', 'orderDateTo', 'shippingDateFrom', 'shippingDateTo', 'receivedDateFrom', 'receivedDateTo', 'keyword'];
        foreach($arrayFilter as $filter)
        {
            if(isset($request[$filter]))
                call_user_func_array(array($query, $filter), array($request[$filter]));
        }
        $sortArray = json_decode($request['sort'], true);
        $query->sortArray($sortArray);
        $guides = $query->with('delivery', 'supplier')->paginate($request['ppp']);
        return $guides;
    }

    public function is_admin()
    {
        if(auth()->user()->role->type == 'admin')
            return true;
        else
            return false;
    }

    public function is_author($id)
    {
        if(auth()->user()->id == $id)
            return true;
        else
            return false;
    }

    public function delete($id)
    {
        $guide = $this->guide::findOrFail($id);
        if (Gate::denies('update', $guide)) {
            return false;
        }
        $files = $guide->files;
        foreach($files as $file){
            $file->delete();
        }
        $guide->delete();            
        return true;
        /*
        $has_per = false;
        if($this->is_admin())
            $has_per = true;
        if($this->is_author($guide->user_id))
            $has_per = true;
        if($has_per){            
            $files = $guide->files;
            foreach($files as $file){
                $file->delete();
            }
            $guide->delete();
            
            return true;
        }            
        else
            return false;
            */
    }

    public function showPdf($id, $price)
    {
        $guide = Guide::select('key_code')->findOrFail($id);
        // $route = route('guide.html', ['id' => $id, 'price' => $price]);
        $route = route('guide.html', ['id' => $guide->key_code, 'price' => $price]);
        $pdf = Browsershot::url($route)
        ->noSandbox()
        ->format('A4')->pdf();
        return $pdf;
    }
}


?>