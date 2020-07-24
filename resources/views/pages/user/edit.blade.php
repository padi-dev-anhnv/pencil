@extends('layout.main')
@section('title', '三菱鉛筆九州販売株式会社システム管理画面 | アカウント編集')
@section('page','accout_edit')
@section('content')
<div id="content">
		<h2 class="page_ttl">アカウント新規追加</h2>
	<form-user edit="{{ request()->id }}"></form-user>
</div>

@endsection