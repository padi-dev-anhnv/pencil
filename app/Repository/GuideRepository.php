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
        $products = $guide->products()->get();
        
        return [
            'guide' => $guide,
            'delivery' => $delivery,
            'packaging' => $packaging,
            'procedure' => $procedure,
            'products' => $products
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
        
        $guide = $this->guide::create($guideRequest);
        $delivery = new Delivery($deliveryRequest);
        $packaging = new Packaging($packagingRequest);
        $procedure = new Procedure($procedureRequest);

        $guide->delivery()->save($delivery);
        $guide->packaging()->save($packaging);
        $guide->procedure()->save($procedure);

        foreach($productsRequest as $product)
        {
            $new_product = new Product($product);
            $array_file = [];
            $guide->products()->save($new_product);      
            foreach($product['files'] as $file)
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
}


?>