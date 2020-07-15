@extends('layout.main')
@section('title', '三菱鉛筆九州販売株式会社システム管理画面 | アカウント管理')
@section('page','setting')
@section('content')
<div id="content">
	<h2 class="page_ttl">アカウント管理</h2>
	<button onclick="location.href='account_add.html'" class="mainbtn mainbtn2" id="btn_new">新規作成</button>

	<div id="account-list" class="sec">

		<!-- リストここから -->
		<ul class="listtable">
			<li>
				<ul>
					<li>氏名</li>
					<li>権限</li>
					<li>ID</li>
					<li>営業所</li>
					<li>操作</li>
				</ul>
			</li>
			@foreach($users as $user)
			<li>
				<ul>
					<li>{{$user->name}}</li>
					<li>{{ $user->role->name}}</li>
					<li>{{$user->username}}</li>
					<li>{{$user->sale_office}}</li>
					<li><button onclick="location.href='account_edit.html'" class="editbtn"><span>編集</span></button><label for="popup_delete" class="deletebtn"><span>削除</span></label></li>
				</ul>
			</li>
			@endforeach
		</ul>
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

<div id="pwrap_delete" class="popup_wrap">
	<input id="popup_delete" type="checkbox">
	<div class="overlay">
		<label for="popup_delete" class="popup_closearea"></label>
		<article class="popup_box">
			<label for="popup_delete" class="popup_closebtn">×</label>
			<header class="popup_header delete_hd">
				<div class="ph_inner">
					<h3 class="popup_ttl">アカウント削除</h3>
					<p class="popup_dscrpt">鈴木一郎</p>
				</div>
			</header>
			<div class="popup_ctt">
				<div class="popup_cttinner">
					<p class="popup_txt">削除しますか？</p>
					<ul class="btn_box btn2box">
						<li><label for="popup_delete" class="mainbtn">はい</label></li>
						<li><label for="popup_delete" class="mainbtn subbtn">いいえ</label></li>
					</ul>
				</div>
			</div>
		</article>
	</div>
</div>
@endsection