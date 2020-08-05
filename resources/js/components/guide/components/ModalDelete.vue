<template>
    <div id="pwrap_delete" class="popup_wrap">
		<input id="popup_delete" type="checkbox">
		<div class="overlay">
			<label for="popup_delete" class="popup_closearea"></label>
			<article class="popup_box">
				<label for="popup_delete" class="popup_closebtn">×</label>
				<header class="popup_header delete_hd">
					<div class="ph_inner">
						<h3 class="popup_ttl">削除</h3>
						<p class="popup_dscrpt">指図書番号：{{ deleteGuide.number }}</p>
					</div>
				</header>
				<div class="popup_ctt">
					<div class="popup_cttinner">
						<p class="popup_txt">本当に削除してもいいですか？</p>
						<ul class="btn_box btn2box">
							<li><label for="popup_delete" class="mainbtn" @click="doDelete">はい</label></li>
							<li><label for="popup_delete" class="mainbtn mainbtn2 subbtn">いいえ</label></li>
						</ul>
					</div>
				</div>
			</article>
		</div>
	</div>
</template>
<script>
import listGuideStore, { doDelete } from '../../../stores/listGuideStore'
export default {
    computed : {
        deleteGuide(){
            return listGuideStore.deleteGuide;
        }
    },
    methods : {
        doDelete(){
            doDelete();
        }
    }
}
</script>