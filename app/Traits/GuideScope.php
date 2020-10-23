<?php
namespace App\Traits;

trait GuideScope
{
    public function scopeOffice($query, $office_id)
    {
        return $query->where('office', $office_id);
    }

    public function scopeWorker($query, $worker_id)
    {
        return $query->where('supplier_id',$worker_id);
    }

    public function scopeCreator($query, $keyword)
    {
        /*
        return $query->whereHas('creator', function($queryb)  use ($keyword){
            $queryb->where('name', 'LIKE','%'.$keyword.'%');
        });
        */
        return $query->where('old_creator', $keyword)->orWhereHas('creator', function($queryb)  use ($keyword){
            $queryb->where('name', 'LIKE','%'.$keyword.'%');
        });
    }

    public function scopeOrderDateFrom($query, $date)
    {
        return $query->whereDate('created_at','>=', $date);
    }

    public function scopeOrderDateTo($query, $date)
    {
        return $query->whereDate('created_at','<=', $date);
    }

    public function scopeShippingDateFrom($query, $date)
    {
        return $query->whereHas('delivery', function($queryb)  use ($date){
            return $queryb->whereDate('shipping_date','>=', $date);
        });
    }

    public function scopeShippingDateTo($query, $date)
    {
        return $query->whereHas('delivery', function($queryb)  use ($date){
            return $queryb->whereDate('shipping_date','<=', $date);
        });
    }

    public function scopeReceivedDateFrom($query, $date)
    {
        return $query->whereHas('delivery', function($queryb)  use ($date){
            return $queryb->whereDate('received_date','>=', $date);
        });
    }

    public function scopeReceivedDateTo($query, $date)
    {
        return $query->whereHas('delivery', function($queryb)  use ($date){
            return $queryb->whereDate('received_date','<=', $date);
        });
    }

    public function scopeHasPer($query)
    {
        $type = auth()->user()->role->type;
        $arrayAllow = ['admin', 'instruction_manager'];
        if(in_array($type, $arrayAllow))
            return false ; 
        $current_id = auth()->user()->id;
        return $query->where('user_id', $current_id)
                    ->orWhere('supplier_id', $current_id);
    }

    public function scopeIsWorker($query)
    {
        return $query->orWhere('supplier_id', auth()->user()->id);
    }

    public function scopeSortArray($query , $array)
    {
        if(!$array['orderDate'] && !$array['shippingDate'] && !$array['receivedDate'])
            $query->orderBy('id', 'desc');
        if(!empty($array['orderDate']))
            $query->orderBy('created_at', $array['orderDate']);
        if(!empty($array['shippingDate']))
            $query->orderBy('shipping_date', $array['shippingDate']);
        if(!empty($array['receivedDate']))
            $query->orderBy('received_date', $array['receivedDate']);
    }

    public function scopeKeyword($query, $keyword)
    {
        $keyword = array_filter($keyword);
        if(empty($keyword)) return false ;
        $query->whereLike($this->keywordSearch, $keyword);
    }
}
?>