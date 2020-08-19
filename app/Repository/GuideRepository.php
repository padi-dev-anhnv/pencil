<?php
namespace App\Repository;

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

    public function get($id)
    {
        $guide = Guide::findOrFail($id)->makeHidden(['first_product']);
        $delivery = $guide->delivery()->first();
        $packaging = $guide->packaging()->first();
        $procedure = $guide->procedure()->first();
        $files = $guide->files()->get();
        $dupplicate = $guide->dupplicate()->select('created_at', 'id', 'number')->first();
        $creator = $guide->creator()->select('name', 'id')->first();
        $office = $guide->office()->select('name', 'id')->first();
        // $products = $guide->products()->get();
        $creator['office'] = $office;

        return [
            'guide' => $guide,
            'delivery' => $delivery,
            'packaging' => $packaging,
            'procedure' => $procedure,
            'products' => $guide->products,
            'creator' => $creator,
            'dupplicate' => $dupplicate,
            'files'     => $files
        ];
    }

    public function create($requests)
    {
        $request = json_decode($requests['data'], true);

        $author_office = $this->setAuthorOffice($request['guide'], $request['doDupplicate']);
        $request['guide']['user_id'] = $author_office['user_id'];
        if($author_office['office_id'])
            $request['guide']['office_id'] = $author_office['office_id'];
        // $request['guide']['user_id'] = auth()->user()->id;
        /*
        if(auth()->user()->office)
            $request['guide']['office_id'] = auth()->user()->office->id;
            */
        // $request['guide']['products'] = $request['products'];
        
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
            $products = $this->dupplicateGuideFile($products, $guide->id);
            // $dupplicate_product = $this->dupplicateGuideFile($products, $guide->id);
            // $products = $dupplicate_product['products'];
            // $map_file_id = $dupplicate_product['map'];
            // $this->updateProduct($guide->id, $products);
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
            $result['office_id'] = $guide['office_id'];
        }            
        else{
            $result['user_id'] = auth()->user()->id;
            $result['office_id'] = null;
            if(auth()->user()->office)
                $result['office_id'] = auth()->user()->office->id;
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
    

    /*
    public function edit($request)
    {        
        $guide = $this->guide::find($request['id']);
        if(auth()->user()->id != $guide['user_id'] && auth()->user()->role->type != 'admin')
            return false;
        $guideRequest = $request['guide'];
        $deliveryRequest = $request['delivery'];
        $packagingRequest = $request['packaging'];
        $procedureRequest = $request['procedure'];
        $productsRequest = $request['products'];
        $guideRequest['user_id'] = auth()->user()->id;
        $guide->update($guideRequest);
        // dd($guideRequest);
        $guide->delivery()->update($deliveryRequest);
        $guide->packaging()->update($packagingRequest);
        $procedure = Procedure::where('guide_id',$request['id'])->first();
        $procedure->fill($procedureRequest);
        $guide->procedure()->save($procedure);

        foreach($productsRequest as $product)
        {
            $array_file = [];
            $guide_product = $guide->products()->updateOrCreate(['id' =>$product['id']],$product);
            foreach($product['files'] as $file)
            {
                if(count($file) > 0){
                    $file = File::find($file['id']);
                    $guide_product->files()->save($file);
                }
            }  
        //    $guide_product->files()->sync($array_file);

        }
    }
*/
    
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
        $guides = $query->with('delivery', 'supplier', 'office')->paginate($request['ppp']);
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
        $has_per = false;
        if($this->is_admin())
            $has_per = true;
        if($this->is_author($guide->user_id))
            $has_per = true;
        if($has_per){
            $guide->delete();
            return true;
        }            
        else
            return false;
    }

    /*
    public function clone($id)
    {
        $guide = $this->guide::with('delivery', 'packaging', 'procedure', 'products')->findOrFail($id);
        $new_guide = $guide->replicate();
        // $new_guide->clone_id = $id;
        $new_guide->save();
        $array_info = ['delivery', 'packaging', 'procedure'] ; 
        foreach($array_info as $info){
            $new_info = $guide->$info->replicate();
            $new_info->guide_id = $new_guide->id;
            $new_info->save();
        }        

        foreach($guide->products as $product)
        {
            $new_product = $product->replicate();
            $new_product->guide_id = $new_guide->id;
            $new_product->save();
        }
    }
    */
}


?>