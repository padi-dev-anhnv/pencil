@php 
$last_date = $guide->last_date ? date('Y/m/d', strtotime($guide->last_date))  : "" ; 
$shipping_date = $guide->shipping_date ? date('Y/m/d', strtotime($guide->shipping_date))  : "" ; 
$received_date = $guide->received_date ? date('Y/m/d', strtotime($guide->received_date))  : "" ; 
@endphp

<div class="body-a4">
<header id="header">
		<h1 class="logo"><img src="{{ asset('pdf/images/logo.png')}}" width="380" height="55" alt="uni MITSUBISHI PENCIL"></h1>
		<h2 class="page_ttl">指図書No.{{$no}}　1/{{ $total_page}}</h2>
	</header>
<main id="main">
	
	<div id="info" class="sec">
	  <header id="info_header">
		  <ul class="order_info content">
			  <li>作成日：{{  date('Y/m/d', strtotime($guide->created_at)) }}</li>
			  <li>指図書No.{{$no}}</li>
			  <li>件名：{{ $guide->title }}</li>
			  <li>前回：{{ $guide->last_exist == 1 ? '有' : '無'}}</li>
			  <li>前回発注日：{{ $last_date }}</li>
			  <li>前回指図書No:{{ $guide->last_numb}}</li>
		  </ul>
		  <ul class="charge_info">
			  <li>営業所：{{ isset($creator->office) ? $creator->office->name : "" }}</li>
			  <li>担当者：{{ $creator->name}}</li>
		  </ul>
		</header>
		<ul class="table thin td_center content">
		  <li class="tr">
			  <ul class="thtd">
				  <li class="th">店コード</li>
				  <li class="th">業者</li>
				  <li class="th">得意先名</li>
				  <li class="th">ご担当者様</li>
				  <li class="th">出荷希望日</li>
				  <li class="th">納期日</li>
			  </ul>
		  </li>
		  <li class="tr">
			  <ul class="thtd">
				  <li class="td">{{ $guide->store_code }}</li>
				  <li class="td">{{ $supplier->name }}</li>
				  <li class="td">{{ $guide->customer_name}}</li>
				  <li class="td">{{ $guide->curator }}</li>
				  <li class="td">{{ $shipping_date }}</li>
				  <li class="td">{{ $received_date }}</li>
			  </ul>
		  </li>
		</ul>