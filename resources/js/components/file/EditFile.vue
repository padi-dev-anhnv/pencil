<template>
    <div id="pwrap_editfile" class="popup_wrap">
      <input id="popup_editfile" type="checkbox" />
      <div class="overlay">
        <label for="popup_editfile" class="popup_closearea"></label>
        <article class="popup_box widebox">
          <label for="popup_editfile" class="popup_closebtn">×</label>
          <header class="popup_header">
            <div class="ph_inner">
              <h3 class="popup_ttl">編集・ダウンロード</h3>
            </div>
          </header>
          <div class="popup_ctt">
            <div class="popup_cttinner">
              <ul class="form-list">
                <li class="fli">
                  <label class="before">
                    <span class="labeltxt">氏名</span>
                    <input v-model="currentFile.user" type="text"  class="w20" disabled />
                  </label>
                  <label class="before">
                    <span class="labeltxt">営業所</span>
                    <input  v-model="currentFile.office" type="text"  class="w20"  disabled />
                  </label>
                  <span v-show="currentFile.material == 'guide'">指図書No.{{ currentFile.guideNumber }}</span>
                </li>
                <li class="fli">
                  <label class="before">
                    <span class="labeltxt">ファイル名（タイトル名）</span>
                    <input v-model="currentFile.name" type="text" class="w30" />
                  </label>
                    <label v-show="currentFile.material != 'guide'" class="after radioset">
                      <span class="radioarea">
                        <input v-model="currentFile.material" type="radio" name="doctype" value="office" />
                        <span></span>
                      </span>
                      <span class="labeltxt">本社資料</span>
                    </label>
                    <label v-show="currentFile.material != 'guide'" class="after radioset">
                      <span class="radioarea">
                        <input  v-model="currentFile.material" type="radio" name="doctype" value="other" />
                        <span></span>
                      </span>
                      <span class="labeltxt">その他資料</span>
                    </label>
                </li>
              </ul>
              <div class="flexb">
                <div class="fileimg">
                  <div class="uploadimg">
                    <img :src="currentFile.thumbnail" width="1740" height="1445" alt />
                    <input style="display:none" type="file" name="fileUpload" ref="file" @change="onFileChange" />
                    <button class="deletebtn" @click="uploadFile">
                      <span>削除</span>
                    </button>
                  </div>
                </div>
                <div class="filetxt">
                  <ul class="form-list">
                    <li class="fli">
                      ファイル説明文
                      <br />
                      <textarea v-model="currentFile.description" class="h3">春日東通学校の卒業記念について作成したボールペン。</textarea>
                    </li>
                    <li class="fli">
                      タグ付け
                      <br />
                      <textarea  v-model="currentFile.tags" class="h3">鉛筆　ボールペン　学校　卒業</textarea>
                    </li>
                  </ul>
                </div>
              </div>
              <ul class="btn_box btn3box">
                <li>
                  <a class="mainbtn dlbtn"  :href="'file/' +  this.currentFile.id + '/download'">ファイルダウンロード</a>
                </li>
                <li>
                  <label for="popup_editfile" class="mainbtn subbtn">戻る</label>
                </li>
                <li>
                  <label class="mainbtn mainbtn2" @click="updateFile">編集して保存</label>
                  <label for="popup_editfile" class="mainbtn mainbtn2" style="display:none" ref="closeModal2">編集して保存</label>
                </li>
              </ul>
            </div>
          </div>
        </article>
      </div>
    </div>
</template>

<script>
import fileStore, { setSelectedId, createFile, uploadFile } from "../../stores/fileStore";

export default {
  methods : {
   async updateFile(){
     fileStore.actionNew = 0;
          let result = createFile().then(result => {
              this.$refs.closeModal2.click();
          });
    },
    uploadFile(){
            this.$refs.file.click();
    },
    onFileChange(e) {
            let file = e.target.files[0];
            uploadFile(file);
    }
  },
  computed:{
    currentFile(){
      return fileStore.file
    },
    
  }

}
</script>