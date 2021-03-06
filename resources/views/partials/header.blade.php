<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>@yield('title')</title>
<link href="{{ asset('style.css') }}" rel="stylesheet" type="text/css">
<!-- フッター固定 -->
<!-- <script type="text/javascript" src="{{ asset('js/footerFixed.js') }}"></script> -->
<!-- フッター固定 -->
</head>

<body id="@yield('page','home')">
	
	<div id="wrapper">
		
		<!-- ヘッダーここから -->
		<header id="header">
		<h1 class="logo"><a href="{{ route('guide') }}"><img src="{{ asset('images/logo.png') }}" alt="uni MITSUBISHI PENCIL"></a></h1>
		  <div id="adminbar">マスター：{{ auth()->user()->name}}<a href="{{ route('logout') }}">ログアウト</a></div>
		<nav id="gnav">

		<ul>
			@php
					$current_group = request()->route()->getName();
					$nav = [
						'guide' => [ 'link' => route('guide') , 'name' => '指図書一覧',  'perm' => App\Guide::class ] ,
						'file' =>  [ 'link' => route('file') , 'name' => 'ファイルマネージャー', 'perm' => App\File::class ] ,
						'user' =>  [ 'link' => route('user') , 'name' => 'アカウント管理', 'perm' => App\User::class ]	
					];
					foreach($nav as $key => $value)
					{
						if(!isset($value['perm']) || Auth::user()->can('list',$value['perm']) ){	
							echo '<li>';
							if($current_group != $key)
								echo '<a href="'. $value['link'] .'">';
							echo $value['name'] ;
							if($current_group != $key)
								echo '</a>';
							echo '</li>';
						}
					}

			@endphp
		</ul>

			
		</nav>

		</header>
		<!-- ヘッダーここまで -->