@extends('layout.main')
@section('title', '三菱鉛筆九州販売株式会社システム管理画面 | 指図書編集')
@section('page','order_edit')
@section('content')
<div id="content">
	<h2 class="page_ttl">銘入・印刷・包装指図書 </h2>    
		<single-guide id="{{ request()->id }}" action="edit"></single-guide>
    </div> 
@endsection