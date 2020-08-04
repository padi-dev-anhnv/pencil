
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>三菱鉛筆九州販売株式会社システム管理画面 | ログイン</title>
<link href="{{ asset('style.css') }}" rel="stylesheet" type="text/css">
</head>

<body id="page-login">
	

	<div class="login_wrap">
		<header id="user_login">
			<h1 class="logo"><img src="{{ asset('images/logo.png') }}" alt="uni MITSUBISHI PENCIL"></h1>
			<h2>ユーザーログイン</h2>
		</header>

		<div class="login_content">
			<form action="{{ route('postLogin') }}" method="POST">
                @csrf
				<h3>ユーザーアカウント</h3>
				<input name="username" value="" type="text" required>

				<h3>パスワード</h3>
				<input name="password" value="" type="text" required>

				<input value="ログイン" class="loginbtn" type="submit">

			</form>
		</div>
	</div>



</body>
</html>
