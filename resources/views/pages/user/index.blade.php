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
	<div id="code-upload" class="sec">
		<h3 class="sec_ttl">送り先コード管理</h3>
		<div class="txtbox">
			<p>送り先コードを上書きします。ファイルを選択してアップロードしてください。</p>
			<p class="note">送り先コードは、CSVファイルの内容をデータベースに上書きしますのでご注意ください。</p>
		</div>
		<ul class="btn2box">
			<li><button onclick="location.href=''" class="mainbtn mainbtn2">ファイルを選択</button></li>
			<li><button onclick="location.href=''" class="mainbtn ulbtn">アップロード</button></li>
		</ul>
	</div>

</div>


@endsection