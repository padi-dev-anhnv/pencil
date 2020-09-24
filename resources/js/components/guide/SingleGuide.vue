<template>
    <div class="edit-form">
        <form>
            <guide-block :action='action' />
            <delivery-block />
            <packaging-block />
            <procedure-block />
            <product-block :action="action" />
            <price-block />


<!-- <div id="pwrap_editfile2" class="popup_wrap">
		<input id="popup_editfile2" name="editfile" type="radio">
		<div class="overlay">
			<label for="popup_cancel2" class="popup_closearea"></label>
			<article class="popup_box widebox">
				<label for="popup_cancel2" class="popup_closebtn">×</label>
				<header class="popup_header">
					<div class="ph_inner">
						<h3 class="popup_ttl">編集・ダウンロード</h3>
					</div>
				</header>
				<div class="popup_ctt">
					<div class="popup_cttinner">
						<ul class="form-list">
							<li class="fli">
								<label class="before"><span class="labeltxt">氏名</span><input type="text" name="" value="鈴木一郎" class="w20"></label>
								<label class="before"><span class="labeltxt">営業所</span><input type="text" name="" value="本店営業部" class="w20"></label>
								<span>指図書No.654321</span>
							</li>
							<li class="fli">
								<label class="before"><span class="labeltxt">ファイル名（タイトル名）</span><input type="text" name="" value="春日市東中学校ボールペン完成版" class="w30"></label>
							</li>
						</ul>
						<div class="flexb">
							<div class="fileimg">
								<div class="uploadimg"><img src="images/img05.jpg" width="1740" height="1445" alt=""><button class="deletebtn"><span>削除</span></button></div>
							</div>
							<div class="filetxt">
								<ul class="form-list">
									<li class="fli">ファイル説明文<br>
										<textarea class="h3">春日東通学校の卒業記念について作成したボールペン。</textarea>										
									</li>
									<li class="fli">タグ付け<br>
										<textarea class="h3">鉛筆　ボールペン　学校　卒業</textarea>										
									</li>
								</ul>
							</div>
						</div>
						<ul class="btn_box btn3box">
							<li><button class="mainbtn dlbtn">ファイルダウンロード</button></li>
							<li><label for="popup_cancel2" class="mainbtn mainbtn2">編集して保存</label></li>
							<li><label for="popup_deletefile2" class="mainbtn subbtn">削除</label></li>
						</ul>
					</div>
				</div>
			</article>
		</div>
	</div> -->
		<!-- 削除確認 -->
		<!-- <div id="pwrap_deletefile2" class="popup_wrap">
			<input id="popup_deletefile2" name="editfile" type="radio">
			<div class="overlay">
				<label for="popup_cancel2" class="popup_closearea"></label>
				<article class="popup_box">
					<label for="popup_cancel2" class="popup_closebtn">×</label>
					<header class="popup_header delete_hd">
						<div class="ph_inner">
							<h3 class="popup_ttl">削除</h3>
							<p class="popup_dscrpt">春日市東中学校ボールペン完成版</p>
						</div>
					</header>
					<div class="popup_ctt">
						<form>
							<p class="popup_txt">本当に削除してもいいですか？</p>
							<ul class="btn_box btn2box">
								<li><label for="popup_cancel2" class="mainbtn">はい</label></li>
								<li><label for="popup_editfile2" class="mainbtn mainbtn2 subbtn">いいえ</label></li>
							</ul>
						</form>
					</div>
				</article>
			</div>
		</div> -->

            <footer class="list-footer" v-show="editBtn">
				<footer class="list-footer">
                    <span class="lds-dual-ring loader-light" v-if="loading"></span>
					<span class="mainbtn" @click.prevent="createGuide" v-else>
                        <span>保存</span>
                    </span>
				</footer>
			</footer>
        </form>
        
	<file-modal></file-modal>
    <file-delete page="guide" />
    <input id="popup_cancel" name="editfile" type="radio" class="cancel">
    </div>

</template>

<script>
import guideStore, {createGuide, getGuideInfo, setCreator, setAction, setCloneId, setDateNo} from "../../stores/guideStore";
export default {
    props : ['id', 'action', 'creator', 'clone_id', 'user'],
    data(){
        return {
            groupInput : null,
            pressShift : false
        }
    },
    computed: {
        creatorGuide(){
            return guideStore.creator;
        }, 
        editBtn(){
            if(this.action == 'edit' && this.user.id != this.creatorGuide.id && this.user.role.type != 'admin')
                return false;
            return true;
                
        },
        loading(){
            return guideStore.loading
        }
    },
    methods:{
        createGuide(){
            createGuide(this.id)
        },
        indexInClass(node) {
            let className = node.className;
            let num = 0;
            for (let i = 0; i <this.groupInput.length; i++) {
                if (this.groupInput[i] === node) {
                return num + 1;
                }
                num++;
            }
            return -1;
        },
        pushClass(){
            let allInput = document.querySelectorAll("input[type=text], select, input[type=date], textarea");
            for(let i = 0 ; i < allInput.length; i++){
                if(! allInput[i].disabled){
                    let currentClass = allInput[i].className;
                    allInput[i].className = currentClass + ' guide-input'
                }
                    
            };
        },
        addKeyListener()
        {
            window.addEventListener('keydown', (e) => {
                if (e.key == 'Shift') {
                    this.pressShift = true;
                }
            })
            window.addEventListener('keyup', (e) => {
                if (e.key == 'Shift') {
                    this.pressShift = false;
                }
            })

            window.addEventListener('keydown', (e) => {          
            
                if (e.key == 'Enter') {
                    let currentTagName = e.target.tagName;
                    if(['INPUT', 'SELECT', 'TEXTAREA'].includes(currentTagName))
                    {
                        if(currentTagName == 'TEXTAREA' && this.pressShift == true)
                            return false;
                        let nextInput = this.groupInput[this.indexInClass(e.target)];
                        nextInput.focus();
                    }
                }

            });
        }
    },
    async mounted(){
        setAction(this.action);
        if(['edit', 'dupplicate'].includes(this.action))
            await getGuideInfo(this.id);
        if(['new', 'dupplicate'].includes(this.action))
            setCreator(this.creator)
        if(['dupplicate'].includes(this.action)){
            setCloneId(this.clone_id)
            setDateNo();
        }
        this.pushClass();
        this.groupInput = document.getElementsByClassName('guide-input');
        this.addKeyListener();      
            
    }
}
</script>