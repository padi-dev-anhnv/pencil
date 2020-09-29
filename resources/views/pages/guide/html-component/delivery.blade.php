@php 
$chk = Config::get('const.chk');
$address = '';
$address .= $delivery->postal_code ? "〒".$delivery->postal_code ."　" : "";
$address .= $delivery->prefecture;
$address .= $delivery->city;
$address .= $delivery->address;
$address .= $delivery->building;

$receive_chk = '';
/*
if($delivery->office_chk == 1)
	$receive_chk = $delivery->receiver;
else
	$receive_chk = $chk[$delivery->office_chk-1]['jap'];
*/
$receive_chk = $chk[$delivery->office_chk-1]['jap'];
@endphp
		<ul class="table2 table thin content">
		  <li class="tr">
			  <ul class="thtd">
				  <li class="th">送り先コード</li>
				  <li class="td">{{ $delivery->destination_code}}</li>
				  <li class="th">送付先</li>
				  <li class="td">{{ $delivery->receiver}}</li>
			  </ul>
		  </li>
		  <li class="tr">
			  <ul class="thtd">
				  <li class="th">電話番号</li>
				  <li class="td">{{ $delivery->phone}}</li>
				  <li class="th">送付先住所</li>
				  <li class="td">{{$address}} </li>
			  </ul>
		  </li>
		  <li class="tr">
			  <ul class="thtd">
				  <li class="th">FAX</li>
				  <li class="td">{{ $delivery->fax}}</li>
				  <li class="th">配送区分</li>
				  <li class="td">{{ $receive_chk }}</li>
			  </ul>
		  </li>
		</ul>
    </div>