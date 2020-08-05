<?php
namespace App\Repository;

use App\Guide;
use App\Supplier;
use App\Delivery;
use App\Packaging;
use App\Procedure;
use App\Product;
use Illuminate\Database\Eloquent\Builder;

class GuideRepository
{
    protected $guide;

    public function __construct(Guide $guide)
    {
        $this->guide = $guide;
    }

    public function listSuppliers()
    {
        return Supplier::all();
    }

    public function get($id)
    {
        $guide = Guide::find($id);
        $delivery = $guide->delivery()->first();
        $packaging = $guide->packaging()->first();
        $procedure = $guide->procedure()->first();
        $creator = $guide->creator()->select('name', 'id')->first();
        $products = $guide->products()->get();
        
        return [
            'guide' => $guide,
            'delivery' => $delivery,
            'packaging' => $packaging,
            'procedure' => $procedure,
            'products' => $products,
            'creator' => $creator
        ];
    }

    public function create($request)
    {
        $guideRequest = $request['guide'];
        $deliveryRequest = $request['delivery'];
        $packagingRequest = $request['packaging'];
        $procedureRequest = $request['procedure'];
        $productsRequest = $request['products'];
        $guideRequest['user_id'] = auth()->user()->id;
        
        $delivery = new Delivery($deliveryRequest);
        $packaging = new Packaging($packagingRequest);
        $procedure = new Procedure($procedureRequest);


        $product_array = [];
        foreach($productsRequest as $product)
        {
            $new_product = new Product($product);
            $product_array[] = $new_product;
        }

        
        $guide = $this->guide::create($guideRequest);        
        $guide->delivery()->save($delivery);
        $guide->packaging()->save($packaging);
        $guide->procedure()->save($procedure);

        foreach($product_array as $index => $product)
        {
            $guide->products()->save($product);
            
            $array_file = [];
                  
            foreach($productsRequest[$index]['files'] as $file)
            {
                if(count($file) > 0)
                    $array_file[] = $file['id'];
            }            
            $new_product->files()->sync($array_file);
        }
        return $guide;
    }

    public function edit($request)
    {
        $guideRequest = $request['guide'];
        $deliveryRequest = $request['delivery'];
        $packagingRequest = $request['packaging'];
        $procedureRequest = $request['procedure'];
        $productsRequest = $request['products'];
        $guideRequest['user_id'] = auth()->user()->id;
        $guide = $this->guide::find($request['id']);
        $guide->update($guideRequest);
        $guide->delivery()->update($deliveryRequest);
        $guide->packaging()->update($packagingRequest);
        $procedure = Procedure::where('guide_id',$request['id'])->first();
        $procedure->fill($procedureRequest);
        $guide->procedure()->save($procedure);

        foreach($productsRequest as $product)
        {
            
            $guide_product = $guide->products()->updateOrCreate(['id' =>$product['id']],$product);
            foreach($product['files'] as $file)
            {
                if(count($file) > 0)
                    $array_file[] = $file['id'];
            }  
            $guide_product->files()->sync($array_file);

        }
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
        // $guides = $query->with('delivery', 'supplier')->paginate(2);
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

    public function clone($id)
    {
        $guide = $this->guide::with('delivery', 'packaging', 'procedure', 'products')->findOrFail($id);
        $new_guide = $guide->replicate();
        $new_guide->clone_id = $id;
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
}


?>