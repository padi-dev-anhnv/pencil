<div class="body-a4">
<header id="header">
	<h1 class="logo"><img src="{{ asset('pdf/images/logo.png')}}" width="380" height="55" alt="uni MITSUBISHI PENCIL"></h1>
	<h2 class="page_ttl">指図書No.{{$no}}　{{ 2 + $page }}/{{ $total_page }}</h2>
</header>

<div id="pdf2">
	<main id="main">
		@php
		$body_inscription = Config::get('const.body_inscription');
		$direction = Config::get('const.direction');
		$proofreading = Config::get('const.proofreading');
		@endphp
		<ul id="imglist" class="flexbs">

			@for($i = $from ; $i <  $to; $i++)
			@php
			$product = $products[$i];
			$final_body = $product['body'] == "0" ? "無" : $body_inscription[$product['body']];
			$final_direction = $direction[$product['direction']];
			$final_proofreading = $proofreading[$product['proofreading']];
			$final_insc_method = $product['method'];
			$final_insc_work = $product['work'];
			$final_insc_typeface = $product['typeface'];
			$final_font_size = $product['font_size'] == "0" ? "一任" : $product['font_size'];
			$final_printing_color = implode(" ", $product['printing_color']);
			$final_photo = "pdf/images/pen_temp-0".$product['pattern_type'].".svg";
			@endphp
			@if($product['name'])
			<li class="illi bbox fbox2">
				<h3 class="product_name">{{$product['name']}}（{{$product['color']}}）</h3>
				<div class="imgview"><img src="{{ asset($final_photo)}}" alt=""></div>
				<div class="flexbs">
					<div class="bbox red">
						@foreach($product['pattern_text'] as $text)
						@switch($loop->index)
						@case(0)
						<span>①</span>
						@break
						@case(1)
						<span>②</span>
						@break
						@case(2)
						<span>③</span>
						@break
						@case(3)
						<span>④</span>
						@break
						@case(4)
						<span>⑤</span>
						@break
						@case(5)
						<span>⑥</span>
						@break

						@endswitch
						{{ $text }}<br>
						@endforeach
					</div>
					<div class="point_list">
						<h3 class="ctt_ttl">本体銘入要領</h3>
						<ul class="table td_center thin">
							<li class="tr">
								<ul class="thtd">
									<li class="th">本体銘入</li>
									<li class="td">{{ $final_body }}</li>
								</ul>
							</li>
							<li class="tr">
								<ul class="thtd">
									<li class="th">銘入方向</li>
									<li class="td">{{ $final_direction }}</li>
								</ul>
							</li>
							<li class="tr">
								<ul class="thtd">
									<li class="th">校正</li>
									<li class="td">{{ $final_proofreading }}</li>
								</ul>
							</li>
							<li class="tr">
								<ul class="thtd">
									<li class="th">銘入方式</li>
									<li class="td">{{ $final_insc_method}}</li>
								</ul>
							</li>
							<li class="tr">
								<ul class="thtd">
									<li class="th">銘入作業</li>
									<li class="td">{{ $final_insc_work}}</li>
								</ul>
							</li>
							<li class="tr">
								<ul class="thtd">
									<li class="th">銘入書体</li>
									<li class="td">{{ $final_insc_typeface}}</li>
								</ul>
							</li>
							<li class="tr">
								<ul class="thtd">
									<li class="th">文字サイズ</li>
									<li class="td">{{ $final_font_size}} </li>
								</ul>
							</li>
							<li class="tr">
								<ul class="thtd">
									<li class="th">印刷色</li>
									<li class="td">{{ $final_printing_color }} </li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</li>
			@endif
			@endfor

		</ul>

	</main>
</div>
</div>