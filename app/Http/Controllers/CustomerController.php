<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class CustomerController extends Controller
{
    public function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;
    
        $header = ['destination_code', 'postal_code', 'prefecture', 'city', 'address', 'building', 'phone', 'fax'];
        $data = collect();
        $flag = true;
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if($flag) { $flag = false; continue; }
                if (!$header)
                    $header = $row;
                else
                    $data->push( array_combine($header, $row));
            }
            fclose($handle);
        }
    
        return $data;
    }

    public function uploadCustomer(Request $request)
    {
        Customer::truncate();
        $customerArr = $this->csvToArray($request->file('file')->getRealPath());
        foreach ($customerArr->chunk(500) as $chunk)
        {
            Customer::insert($chunk->toArray());
        }
        return response()->json(['success' => true]);
    }

    public function findCustomer(Request $request)
    {
        $result = null;
        $code = $request->code;
        if($request->type == 'destination_code')
            $result = Customer::where('destination_code', $code)->first();
        elseif($request->type ==  'postal_code'){
            $resultPostal = Customer::where('postal_code', $code)->first();
            if(!$resultPostal){
                $json = json_decode(file_get_contents('https://api.zipaddress.net/?zipcode=' . $code), true);
                if($json['code'] == 200){
                    $add = $json['data'];
                    $result = [
                        'prefecture' => $add['pref'],
                        'city' => $add['address'],
                        'address' => '',
                        // 'address' => $add['address'],
                        'postal_code' => $code
                    ];
                }
            }
            else
                $result = $resultPostal;
        }
            
        if($result)
            return response()->json($result);
        else
            return response()->json(['success' => false, 'message' => config('errors.zip_code_not_found')]);
        
    }
}
