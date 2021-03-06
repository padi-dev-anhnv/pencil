@extends('layout.main')
@section('title', '三菱鉛筆九州販売株式会社システム管理画面 | アカウント管理')
@section('page','home')
@section('content')

    @can('create', App\Guide::class)
        <button onclick="location.href='{{ route('guide.create')}}'" class="mainbtn mainbtn2" id="btn_new">指図書新規作成</button>
        <list-guide editable="1"  :user="{{ auth()->user() }}" />
    @endcan
    @cannot('create', App\Guide::class)
        <list-guide editable="0" :user="{{ auth()->user() }}"/>
    @endcannot
	
    	


@endsection