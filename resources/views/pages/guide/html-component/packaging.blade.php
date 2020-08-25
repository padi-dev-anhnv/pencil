<div class="flexbs sec">
		<div id="box" class="flexbs">
			<div class="imgbox"><img src="{{ asset('pdf/images/box.svg')}}" alt="図"></div>
			<div class="txtbox">
				<div class="flexbs">
					<div class="box_info">
						<h3 class="ctt_ttl">天</h3>
						<ul class="table td_center">
							<li class="tr">
								<ul class="thtd">
									<li class="th">書体</li>
									<li class="td">{{ $packaging->top_font}}</li>
								</ul>
							</li>
							<li class="tr">
								<ul class="thtd">
									<li class="th">印刷色</li>
									<li class="td">{{ $packaging->top_color}}</li>
								</ul>
							</li>
						</ul>
					</div>
					<p class="bbox red">{{ $packaging->top_text}}</p>
				</div>
				<div class="flexbs">
					<div class="box_info">
						<h3 class="ctt_ttl">地</h3>
						<ul class="table td_center">
							<li class="tr">
								<ul class="thtd">
									<li class="th">書体</li>
									<li class="td">{{ $packaging->bottom_font}}</li>
								</ul>
							</li>
							<li class="tr">
								<ul class="thtd">
									<li class="th">印刷色</li>
									<li class="td">{{ $packaging->bottom_color}}</li>
								</ul>
							</li>
						</ul>
					</div>
					<p class="bbox red">{{ $packaging->bottom_text}}</p>
				</div>
			</div>
		</div>
		
		<div id="pack_dscrp">
			<h3 class="ctt_ttl">梱包説明</h3>
			<p class="bbox">{{ $packaging->description }}</p>
		</div>
	</div>
	
	<div class="flexbs sec">
		
		<div id="packing_material">
			<h3 class="ctt_ttl">包装資材印刷要領</h3>
			<ul class="table td_md">
				<li class="tr">
					<ul class="thtd">
						<li class="th">包装材品名</li>
						<li class="td">{{ $packaging->material }}</li>
					</ul>
				</li>
				<li class="tr">
					<ul class="thtd">
						<li class="th">枚数</li>
						<li class="td">{{ $packaging->number_of_page }}</li>
					</ul>
				</li>
				<li class="tr">
					<ul class="thtd">
						<li class="th">包装材印刷</li>
						<li class="td">{{ $packaging->printing == 1 ? '有' : '無'}}</li>
					</ul>
				</li>
				<li class="tr">
					<ul class="thtd">
						<li class="th">校正</li>
						<li class="td">{{ $packaging->proofreading == 1 ? '有' : '無'}}</li>
					</ul>
				</li>
			</ul>
		</div>