@extends('layout.main')
@section('title', '三菱鉛筆九州販売株式会社システム管理画面 | アカウント管理')
@section('page','setting')
@section('content')
<div id="content">
	

	<h2 class="page_ttl">アカウント管理</h2>
	<button onclick="location.href='{{ route('user.new') }}'" class="mainbtn mainbtn2" id="btn_new">新規作成</button>

	<div id="account-list" class="sec">
		<list-user></list-user>
		<!-- リストここから -->
		
		<!-- リストここまで -->
	</div>
	<upload-customer />
</div>


@endsection