<template>
  <div id="pwrap_deletefile" class="popup_wrap">
    <input id="popup_deletefile" name="editfile" type="radio" />
    <div class="overlay">
      <label for="popup_cancel" class="popup_closearea"></label>
      <article class="popup_box">
        <label for="popup_cancel" class="popup_closebtn" ref="closeModal">×</label>
        <header class="popup_header delete_hd">
          <div class="ph_inner">
            <h3 class="popup_ttl">削除</h3>
            <p class="popup_dscrpt">{{ fileName }}</p>
          </div>
        </header>
        <div class="popup_ctt">
          <form v-if="canDelete">
            <p class="popup_txt">本当に削除してもいいですか？</p>
            <ul class="btn_box btn2box">
              <li>
                <span v-if="deleting" class="lds-dual-ring"></span>
                <label v-else for="popup_cancel" @click="doDelete" class="mainbtn">はい</label>
              </li>
              <li>
                <label for="popup_editfile" class="mainbtn mainbtn2 subbtn">いいえ</label>
              </li>
            </ul>
          </form>
          <form v-else>
            <p class="popup_txt">指図書に連携していますので、削除できません！</p>
          </form>
        </div>
      </article>
    </div>
  </div>
</template>

<script>
import fileStore, { doDelete } from "../../stores/fileStore";
import { deleteFileTemp } from "../../stores/guideStore";
export default {
    props : ['page'],
    methods:{
        async doDelete(){
          if(this.page == "guide")
            deleteFileTemp()
          else{
            await doDelete();
            this.$refs.closeModal.click();
          }
            
        }
    },
    computed : {
      fileName(){
        return fileStore.file.name;
      },
      canDelete(){
        if(this.page == "guide") return true;
        return fileStore.file.guideId == 0;
      },
      deleting(){        
          return fileStore.deleting;
      }
    }
};
</script>