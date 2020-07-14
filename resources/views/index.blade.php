@extends('layout.main')
@section('title', '三菱鉛筆九州販売株式会社システム管理画面 | 指図書一覧')

@section('content')
<button onclick="location.href='order_add.html'" class="mainbtn mainbtn2" id="btn_new">指図書新規作成</button>
			<!-- ページトップ検索窓 -->
			<div id="top_search">
				<form>
					<input type="text" placeholder="キーワード検索" name="" value="" required>
					<input type="submit" value="" class="searchbtn">	
				</form>
				<label for="search_plus" class="btn_plus"></label>
			</div>
			<!-- ページトップ検索窓 -->
			
			<!-- 検索条件追加 -->
			<input type="checkbox" id="search_plus">
			<label for="search_plus" class="btn_minus"></label>
			<div id="top_search_plus" class="search-form">
				<form>
					<ul class="form-list">
						<li class="fli">
							<ul class="checklist">
								<li>
									<label class="checkset"><input type="checkbox" name="search_ctt"><svg xmlns="http://www.w3.org/2000/svg" width="49.85" height="33.93" viewBox="0 0 49.85 33.93" class="icon_check"><polyline class="cls-1" points="3.08 10.81 21.13 27.73 46.74 3.25"/></svg><span>営業所</span></label>
									<select>
										<option value="">選択してください</option>
										<option value="福岡">福岡</option>
										<option value="大分">大分</option>
										<option value="宮崎">宮崎</option>
									</select>
								</li>
								<li>
									<label class="checkset"><input type="checkbox" name="search_ctt"><svg xmlns="http://www.w3.org/2000/svg" width="49.85" height="33.93" viewBox="0 0 49.85 33.93" class="icon_check"><polyline class="cls-1" points="3.08 10.81 21.13 27.73 46.74 3.25"/></svg><span>担当者</span></label>
									<select>
										<option value="">選択してください</option>
										<option value="田中">田中</option>
										<option value="佐藤">佐藤</option>
										<option value="鈴木">鈴木</option>
									</select>
								</li>
								<li>
									<label class="checkset"><input type="checkbox" name="search_ctt"><svg xmlns="http://www.w3.org/2000/svg" width="49.85" height="33.93" viewBox="0 0 49.85 33.93" class="icon_check"><polyline class="cls-1" points="3.08 10.81 21.13 27.73 46.74 3.25"/></svg><span>業者</span></label>
									<select>
										<option value="">選択してください</option>
										<option value="ABC鉛筆">ABC鉛筆</option>
										<option value="YBAペンシル">YBAペンシル</option>
									</select>
								</li>
							</ul>
						</li>
						<li class="fli">
							<ul class="checklist">
								<li>
									<label class="checkset"><input type="checkbox" name="search_ctt"><svg xmlns="http://www.w3.org/2000/svg" width="49.85" height="33.93" viewBox="0 0 49.85 33.93" class="icon_check"><polyline class="cls-1" points="3.08 10.81 21.13 27.73 46.74 3.25"/></svg><span>発注日</span></label>
									<label class="dateset"><input type="date"></label><span class="datetxt">～</span><label class="dateset"><input type="date"></label>
								</li>
							</ul>
						</li>
						<li class="fli">
							<ul class="checklist">
								<li>
									<label class="checkset"><input type="checkbox" name="search_ctt"><svg xmlns="http://www.w3.org/2000/svg" width="49.85" height="33.93" viewBox="0 0 49.85 33.93" class="icon_check"><polyline class="cls-1" points="3.08 10.81 21.13 27.73 46.74 3.25"/></svg><span>出荷予定日</span></label>
									<label class="dateset"><input type="date"></label><span class="datetxt">～</span><label class="dateset"><input type="date"></label>
								</li>
								<li>
									<label class="checkset"><input type="checkbox" name="search_ctt"><svg xmlns="http://www.w3.org/2000/svg" width="49.85" height="33.93" viewBox="0 0 49.85 33.93" class="icon_check"><polyline class="cls-1" points="3.08 10.81 21.13 27.73 46.74 3.25"/></svg><span>納品予定日</span></label>
									<label class="dateset"><input type="date"></label><span class="datetxt">～</span><label class="dateset"><input type="date"></label>
								</li>
							</ul>
						</li>
						<li class="fli">
							<ul class="checklist">
								<li>
									<label class="checkset"><input type="checkbox" name="search_ctt"><svg xmlns="http://www.w3.org/2000/svg" width="49.85" height="33.93" viewBox="0 0 49.85 33.93" class="icon_check"><polyline class="cls-1" points="3.08 10.81 21.13 27.73 46.74 3.25"/></svg><span>キーワード</span></label>
									<input type="text" class="w15"><span class="texttxt">AND</span><input type="text" class="w15">
								</li>
							</ul>
						</li>
					</ul>
					<input type="submit" value="検索" class="mainbtn">
				</form>
			</div>
			<!-- 検索条件追加 -->
			
			<!-- コンテンツここから -->
			<div id="content">
			
			  <div id="order-list" class="sec">
				  <header class="sec-header edit-header flexb">
						<form>
							<label>発注日</label>
							<select>
								<option value="新しい順">新しい順</option>
								<option value="古い順">古い順</option>
							</select>	

							<label>出荷予定日</label>
							<select>
								<option value="早い順">早い順</option>
								<option value="サンプルテキスト">サンプルテキスト</option>
							</select>	

							<label>納品予定日</label>
							<select>
								<option value="早い順">早い順</option>
								<option value="サンプルテキスト">サンプルテキスト</option>
							</select>	

						  <button class="mainbtn">実行</button>
					  </form>
					  
				    <nav class="pagenav">
						<ul class="pagenation">
							<li>1</li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">5</a></li>
							<li>･･･</li>
							<li><a href="#">10</a></li>
						</ul>
						<select>
							<option value="100件表示">100件表示</option>
							<option value="50件表示">50件表示</option>
							<option value="30件表示">30件表示</option>
							<option value="10件表示">10件表示</option>
						</select>	
					  </nav>
                </header>

				  <!-- リストここから -->
					<ul class="listtable">
						  <li>
							  <ul>
								  <li>作成日時</li>
								  <li>業者</li>
								  <li>指図書番号</li>
								  <li>得意先</li>
								  <li>件名</li>
								  <li>営業所名</li>
								  <li>担当者</li>
								  <li>送り先コード</li>
								  <li>送り先名</li>
								  <li>納入先</li>
								  <li>出荷予定日</li>
								  <li>納品日</li>
								  <li>商品名</li>
								  <li>指図書ダウンロード</li>
								  <li>操作</li>
							  </ul>
						  </li>
						  <li>
							  <ul>
								  <li>2020/04/10</li>
								  <li>ABC鉛筆</li>
								  <li>122345</li>
								  <li>高宮中学校PTA</li>
								  <li>高宮中学校PTA</li>
								  <li>福岡</li>
								  <li>田中</li>
								  <li>1234</li>
								  <li>高宮中学校</li>
								  <li>高宮中学校</li>
								  <li>2020/04/15</li>
								  <li>2020/04/30</li>
								  <li>スタイルフィット</li>
								  <li><a href="#">PDF(料金有）</a><br>
									  <a href="#">PDF(料金無）</a></li>
								  <li><button onclick="location.href='order_edit.html'" class="editbtn"><span>編集</span></button><button onclick="location.href=''" class="copybtn"><span>複製</span></button><button onclick="location.href=''" class="deletebtn"><span>削除</span></button></li>
						    </ul>
						  </li>
						  <li class="done">
							  <ul>
								  <li>2020/03/30</li>
								  <li>ABC鉛筆</li>
								  <li>654321</li>
								  <li>春日東中学校PTA</li>
								  <li>春日東中学校PTA</li>
								  <li>福岡</li>
								  <li>田中</li>
								  <li>6543</li>
								  <li>春日東中学校</li>
								  <li>春日東中学校</li>
								  <li>2020/04/15</li>
								  <li>2020/04/30</li>
								  <li>アドバンス</li>
								  <li><a href="#">PDF(料金有）</a><br>
									  <a href="#">PDF(料金無）</a></li>
								  <li><button onclick="location.href='order_edit.html'" class="editbtn"><span>編集</span></button><button onclick="location.href=''" class="copybtn"><span>複製</span></button><button onclick="location.href=''" class="deletebtn"><span>削除</span></button></li>
						    </ul>
						  </li>
						  <li class="done">
							  <ul>
								  <li>2020/03/11</li>
								  <li>YBAペンシル</li>
								  <li>789654</li>
								  <li>佐伯子供会</li>
								  <li>佐伯子供会</li>
								  <li>大分</li>
								  <li>佐藤</li>
								  <li>8907</li>
								  <li>大分営業所</li>
								  <li>大分営業所</li>
								  <li>2020/03/20</li>
								  <li>2020/04/15</li>
								  <li>スタイルフィット</li>
								  <li><a href="#">PDF(料金有）</a><br>
									  <a href="#">PDF(料金無）</a></li>
								  <li><button onclick="location.href='order_edit.html'" class="editbtn"><span>編集</span></button><button onclick="location.href=''" class="copybtn"><span>複製</span></button><button onclick="location.href=''" class="deletebtn"><span>削除</span></button></li>
						    </ul>
						  </li>
						  <li class="done">
							  <ul>
								  <li>2020/03/05</li>
								  <li>ABC鉛筆</li>
								  <li>665875</li>
								  <li>株式会社ウェブニクス</li>
								  <li>株式会社ウェブニクス</li>
								  <li>福岡</li>
								  <li>鈴木</li>
								  <li>3452</li>
								  <li>株式会社ウェブニクス</li>
								  <li>株式会社ウェブニクス</li>
								  <li>2020/03/03</li>
								  <li>2020/03/20 </li>
								  <li>スタイルフィット</li>
								  <li><a href="#">PDF(料金有）</a><br>
									  <a href="#">PDF(料金無）</a></li>
								  <li><button onclick="location.href='order_edit.html'" class="editbtn"><span>編集</span></button><button onclick="location.href=''" class="copybtn"><span>複製</span></button><button onclick="location.href=''" class="deletebtn"><span>削除</span></button></li>
						    </ul>
						  </li>
					</ul>
					<!-- リストここまで -->
				</div>
            			
            </div>
			<!-- コンテンツここまで -->
@endsection