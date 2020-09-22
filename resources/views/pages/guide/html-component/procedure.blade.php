@php
		$procedure_work = Config::get('const.procedure_work');
		$procedure_bagging = Config::get('const.procedure_bagging');
		$procedure_gimmick = Config::get('const.procedure_gimmick');

		
	// 	new method avoid empty value
		$final_work = isset($procedure->work) ?  ( $procedure->work != '0' ? ( isset($procedure_work[$procedure->work]) ? $procedure_work[$procedure->work] : '有') : '無'   ) : "";
		$final_bagging_numb = !empty($procedure->bagging_content) ? $procedure->bagging_content :  '';
		$final_bagging_text = isset($procedure->bagging) ?  ( $procedure->bagging != '0' ? ( isset($procedure_bagging[$procedure->bagging]) ? $procedure_bagging[$procedure->bagging] : '有') : '無'   ) : "";
		$final_bagging = $final_bagging_numb . ' ' . $final_bagging_text ; 
		$final_box = '';
		$final_packaging = isset($procedure->packaging) ? ( $procedure->packaging == 1 ? '有' : '無' ) : "";
		$final_gimmick = isset($procedure->gimmick) ?  ( $procedure->gimmick != '0' ? ( isset($procedure_gimmick[$procedure->gimmick]) ? $procedure_gimmick[$procedure->gimmick] : '有') : '無'   ) : "";
		$final_advance_shipment = isset($procedure->advance_shipment) ? ( $procedure->advance_shipment == 1 ? '有' : '無' ) : "";

	//	$final_work = $procedure->work == "0" ? "無" : $procedure_work[$procedure->work];
	//	$final_bagging = $procedure->bagging == "0" ? "無" : $procedure->bagging_content .  $procedure_bagging[$procedure->bagging];
	//	$final_gimmick = $procedure->gimmick == "0" ? "無" : $procedure_gimmick[$procedure->gimmick];
	//	$final_box = $procedure->box == "0" ? "無" :  str_repeat("●", intval($procedure->box_content)) ;
	//	$final_packaging = $procedure->packaging == "0" ? "無" :  "有" ;
	//	$final_advance_shipment = $procedure->advance_shipment == "0" ? "不可" :  "可" ;	

		@endphp
		<div id="point">
			<h3 class="ctt_ttl">作業要領</h3>
			<div class="flexbs">
				<div class="fbox2">
					<ul class="table td_center material1">
						<li class="tr">
							<ul class="thtd">
								<li class="th">包装材品名</li>
								<li class="th">枚数</li>
							</ul>
						</li>
						@for ($i = 1; $i < 7; $i++)
						<li class="tr">
							<ul class="thtd">
								<li class="td">{{ isset($procedure->material[$i-1]) ?  $procedure->material[$i-1]['name'] : "" }}</li>
								<li class="td">{{ isset($procedure->material[$i-1]) ?  $procedure->material[$i-1]['numb'] : "" }}</li>
							</ul>
						</li>
						@endfor
					</ul>
				</div>
				<div class="fbox2">
					<ul class="table td_center material2">
						<li class="tr">
							<ul class="thtd">
								<li class="th">作業</li>
								<li class="td">{{ $final_work }}</li>
							</ul>
						</li>
						<li class="tr">
							<ul class="thtd">
								<li class="th">袋詰め</li>
								<li class="td">{{ $final_bagging }}</li>
							</ul>
						</li>
						<li class="tr">
							<ul class="thtd">
								<li class="th">箱詰め</li>
								<li class="td">{{$final_box}}</li>
							</ul>
						</li>
						<li class="tr">
							<ul class="thtd">
								<li class="th">包装</li>
								<li class="td">{{$final_packaging}}</li>
							</ul>
						</li>
						<li class="tr">
							<ul class="thtd">
								<li class="th">のし掛け</li>
								<li class="td">{{ $final_gimmick }}</li>
							</ul>
						</li>
						<li class="tr">
							<ul class="thtd">
								<li class="th">先出出荷</li>
								<li class="td">{{ $final_advance_shipment }}</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
	
	</div>
	<div id="product_list" class="sec">
			<ul class="table td_center">
				<li class="tr">
					<ul class="thtd">
						<li class="th">枝番</li>
						<li class="th">品名</li>
						<li class="th">色</li>
						<li class="th">銘入数量</li>
						<li class="th">単位</li>
						<li class="th">出荷日</li>
					</ul>
				</li>
				@for($i = 0; $i< 12; $i++)
				@php
					$numb = $name = $color = $qty = $unit = $date = '';
					if(isset($products[$i]))
					{
						$numb = $products[$i]['name'] ?  $i + 1 : ""; 
						$name = $products[$i]['name'];
						$color = $products[$i]['color'];
						$qty = empty($products[$i]['qty']) ? "" : number_format(intval($products[$i]['qty']));
						$unit = $products[$i]['unit'];
						if($products[$i]['shipping_date'])
							$date = date('Y/m/d', strtotime($products[$i]['shipping_date'])) ;
					}
				@endphp
				<li class="tr">
					<ul class="thtd">
						<li class="td">{{ $numb }}</li>
						<li class="td">{{ $name }}</li>
						<li class="td">{{ $color }}</li>
						<li class="td">{{ $qty }}</li>
						<li class="td">{{ $unit }}</li>
						<li class="td">{{ $date }}</li>
					</ul>
				</li>
				@endfor
			</ul>
	</div>
	
	<div id="notes" class="sec">
		<h3 class="ctt_ttl">注意事項等</h3>
		<p class="bbox">{{ $procedure->note }}</p>
	</div>
	
</main>

</div>