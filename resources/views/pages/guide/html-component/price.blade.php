<div class="body-a4">
<div id="pdf3">
	
	<header id="header">
		<h1 class="logo"><img src="{{ asset('pdf/images/logo.png')}}" width="380" height="55" alt="uni MITSUBISHI PENCIL"></h1>
		<h2 class="page_ttl">指図書No.{{ $no }}　{{ $total_page }}/{{ $total_page }}</h2>
	</header>
	
	<main id="main">
        @php 
            function format_price($numb)
            {
				$val = number_format(intval($numb));
                return $val == 0 ? "" : $val ;
            }
        @endphp
		<div id="price" class="sec">
			<div class="tablebox">
				<div class="flexs b_bottom">
					<div class="caption"></div>
					<ul class="table">
						<li class="tr">
							<ul class="thtd">
								<li class="th b_right"><strong>原価</strong></li>
								<li class="th"><strong>仕切価格</strong></li>
							</ul>
						</li>
						<li class="tr">
							<ul class="thtd">
								<li class="th">単価</li>
								<li class="th">数</li>
								<li class="th">単位</li>
								<li class="th b_right">計</li>
								<li class="th">単価</li>
								<li class="th">数</li>
								<li class="th">単位</li>
								<li class="th">計</li>
							</ul>
						</li>
					</ul>
                </div>
                
                @foreach($price['element1'] as $key => $element)
                @if(!(preg_match("/(box_paper|invoice|printing|version_charge)/i", $key ) &&  preg_match("/(2|3)/i", $key )))
				<div class="flexs">
					<h3 class="caption">{{ $element['name']}}</h3>
					<ul class="table td_center">
                @endif
						<li class="tr">
							<ul class="thtd">
								<li class="td yen">{{  format_price($element['price']['cost']) }}</li>
								<li class="td">{{ format_price($element['price']['qty'])  }}</li>
								<li class="td">{{ $element['price']['unit']}}</li>
								<li class="td yen b_right">{{ format_price($element['price']['total']) }}</li>
								<li class="td yen">{{ $element['wholesale']['cost']}}</li>
								<li class="td">{{ format_price($element['wholesale']['qty']) }}</li>
								<li class="td">{{$element['wholesale']['unit']}}</li>
								<li class="td yen">{{format_price($element['wholesale']['total'])}}</li>
							</ul>
                        </li>
                @if(!(preg_match("/(box_paper|invoice|printing|version_charge)/i", $key ) &&  preg_match("/(1|2)/i", $key )))        
					</ul>
                </div>
                @endif
                
                @endforeach

				<div class="flexs">
					<h3 class="caption subtotal">小計</h3>
					<ul class="table td_center">
						<li class="tr">
							<ul class="thtd">
								<li class="td yen">{{format_price($price['totalPrice']['subTotalEle1']['subPrice'])}}</li>
								<li class="td">{{format_price($price['totalPrice']['subTotalEle1']['subQty'])}}</li>
								<li class="td"></li>
								<li class="td yen b_right">{{format_price($price['totalPrice']['subTotalEle1']['subTotal'])}}</li>
								<li class="td yen">{{format_price($price['totalPrice']['subWholesaleEle1']['subPrice'])}}</li>
								<li class="td">{{format_price($price['totalPrice']['subWholesaleEle1']['subQty'])}}</li>
								<li class="td"></li>
								<li class="td yen">{{format_price($price['totalPrice']['subWholesaleEle1']['subTotal'])}}</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		
		<div id="manual" class="sec">
			<h3 class="ctt_ttl">手作業</h3>
			<div class="tablebox">
				<div class="flexs b_bottom">
					<div class="caption"></div>
					<ul class="table">
						<li class="tr">
							<ul class="thtd">
								<li class="th b_right"><strong>原価</strong></li>
								<li class="th"><strong>仕切価格</strong></li>
							</ul>
						</li>
						<li class="tr">
							<ul class="thtd">
								<li class="th">単価</li>
								<li class="th">数</li>
								<li class="th">単位</li>
								<li class="th b_right">計</li>
								<li class="th">単価</li>
								<li class="th">数</li>
								<li class="th">単位</li>
								<li class="th">計</li>
							</ul>
						</li>
					</ul>
                </div>
                @foreach($price['element2'] as $key => $element)
				<div class="flexs">
					<h4 class="caption">{{ $element['name']}}</h4>
					<ul class="table td_center">
						<li class="tr">
							<ul class="thtd">
                                <li class="td yen">{{  format_price($element['price']['cost']) }}</li>
								<li class="td">{{ format_price($element['price']['qty'])  }}</li>
								<li class="td">{{ $element['price']['unit']}}</li>
								<li class="td yen b_right">{{ format_price($element['price']['total']) }}</li>
								<li class="td yen">{{ $element['wholesale']['cost']}}</li>
								<li class="td">{{ format_price($element['wholesale']['qty']) }}</li>
								<li class="td">{{$element['wholesale']['unit']}}</li>
								<li class="td yen">{{format_price($element['wholesale']['total'])}}</li>
							</ul>
						</li>
					</ul>
                </div>
                @endforeach
                @for($i = 0 ; $i < 2; $i++)
				<div class="flexs b_bottom">
					<div class="caption"></div>
					<ul class="table td_center">
						<li class="tr">
							<ul class="thtd">
								<li class="td yen"></li>
								<li class="td"></li>
								<li class="td"></li>
								<li class="td yen b_right"></li>
								<li class="td yen"></li>
								<li class="td"></li>
								<li class="td"></li>
								<li class="td yen"></li>
							</ul>
						</li>
					</ul>
                </div>
                @endfor
				<div class="flexs">
					<h4 class="caption subtotal">小計</h4>
					<ul class="table td_center">
						<li class="tr">
							<ul class="thtd">
                                <li class="td yen">{{format_price($price['totalPrice']['subTotalEle2']['subPrice'])}}</li>
								<li class="td">{{format_price($price['totalPrice']['subTotalEle2']['subQty'])}}</li>
								<li class="td"></li>
								<li class="td yen b_right">{{format_price($price['totalPrice']['subTotalEle2']['subTotal'])}}</li>
								<li class="td yen">{{format_price($price['totalPrice']['subWholesaleEle2']['subPrice'])}}</li>
								<li class="td">{{format_price($price['totalPrice']['subWholesaleEle2']['subQty'])}}</li>
								<li class="td"></li>
								<li class="td yen">{{format_price($price['totalPrice']['subWholesaleEle2']['subTotal'])}}</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		
		<div id="total">
			<ul class="table td_center bold">
				<li class="tr">
					<ul class="thtd">
						<li class="th">総合計</li>
						<li class="td yen">{{ format_price($price['totalPrice']['finalPrice']) }}</li>
						<li class="td yen">{{ format_price($price['totalPrice']['finalWholesale']) }}</li>
					</ul>
				</li>
				<li class="tr">
					<ul class="thtd">
						<li class="th">差益</li>
						<li class="td yen">{{ format_price($price['totalPrice']['finalMargin']) }}</li>
					</ul>
				</li>
				<li class="tr">
					<ul class="thtd">
						<li class="th">特値適用</li>
						<li class="td numb">{{ $price['specialValue']['number'] }}</li>
						<li class="td percent">{{ $price['specialValue']['rate'] }}0</li>
					</ul>
				</li>
			</ul>
		</div>
		
	</main>
	
</div>
</div>