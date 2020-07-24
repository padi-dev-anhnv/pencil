@extends('layout.main')
@section('title', '三菱鉛筆九州販売株式会社システム管理画面 | ファイルマネージャー')
@section('page','file')
@section('content')
<list-file :user-info='@json(Auth::user())' :user-office='@json(Auth::user()->office)'></list-file>
@endsection