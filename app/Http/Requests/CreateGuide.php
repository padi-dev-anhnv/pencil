<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateGuide extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $guideValidate = [
            /*
            'guide.title' => 'required',
            'guide.created_at' => 'required',
            'guide.office' => 'required',
            'guide.number' => 'required',
            */
            'guide.supplier_id' => 'required|numeric|gt:0',
            /*
            'guide.store_code' => 'required',
            'guide.customer_name' => 'required',
            'guide.curator' => 'required',
            'guide.shipping_date'=> 'required',
            'guide.received_date'=> 'required',
            */
        ];

        $deliveryValidate = [
            'delivery.receiver'=> 'required',
            'delivery.office_chk'=> 'required',
            'delivery.district'=> 'required',
            'delivery.city'=> 'required',
            'delivery.address'=> 'required',
            'delivery.building'=> 'required',
            'delivery.phone'=> 'required',
            'delivery.fax'=> 'required',
        ];


        $packagingValidate = [
            'packaging.printing'=> 'required',
            'packaging.proofreading'=> 'required',
            'packaging.material'=> 'required',
            'packaging.number_of_page'=> 'required|numeric',
            'packaging.top_font'=> 'required',
            'packaging.top_color'=> 'required',
            'packaging.top_text'=> 'required',
            'packaging.bottom_font'=> 'required',
            'packaging.bottom_color'=> 'required',
            'packaging.bottom_text'=> 'required',
        ];

        $procedureValidate = [
            'procedure.work'=> 'required',
            'procedure.bagging'=> 'required',
            'procedure.box'=> 'required',
            'procedure.packaging'=> 'required',
            'procedure.gimmick'=> 'required',
            'procedure.advance_shipment'=> 'required',
            'procedure.material'=> 'required|array|min:1',
        ];

        $productValidate = [
            'products.*.name'=> 'required',
            'products.*.color'=> 'required',
            'products.*.qty'=> 'required|numeric',
            'products.*.unit'=> 'required',
            'products.*.shipping_date'=> 'required',
            'products.*.received_date'=> 'required',
        ];

        return array_merge(
            $guideValidate
        //    $deliveryValidate,
        //    $packagingValidate,
        //    $procedureValidate,
        //    $productValidate
        );
    }
}
