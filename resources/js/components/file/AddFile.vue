<template>
    <div id="pwrap_addfile" class="popup_wrap">
      <input id="popup_addfile" type="checkbox" />
      <div class="overlay">
        <label for="popup_addfile" class="popup_closearea"></label>
        <article class="popup_box widebox">
          <label for="popup_addfile" class="popup_closebtn">×</label>
          <header class="popup_header file_new_hd">
            <div class="ph_inner">
              <h3 class="popup_ttl">新規ファイル追加</h3>
            </div>
          </header>
          <div class="popup_ctt">
            <div class="popup_cttinner">
              <ul class="form-list">
                <li class="fli">
                  <label class="before">
                    <span class="labeltxt">氏名</span>
                    <input v-model="newFile.user" type="text" name value class="w20" disabled />
                  </label>
                  <label class="before">
                    <span class="labeltxt">営業所</span>
                    <input v-model="newFile.office" type="text" name value class="w20" disabled />
                  </label>
                  
                </li>
                <li class="fli">
                  <label class="before">
                    <span class="labeltxt">ファイル名（タイトル名）</span>
                    <input v-model="newFile.name" type="text" name value class="w30" />
                  </label>
                  <label class="after radioset">
                    <span class="radioarea">
                      <input v-model="newFile.material" type="radio" name="doctypen" value="office" />
                      <span></span>
                    </span>
                    <span class="labeltxt">本社資料</span>
                  </label>
                  <label class="after radioset">
                    <span class="radioarea">
                      <input  v-model="newFile.material" type="radio" name="doctypen" value="other" />
                      <span></span>
                    </span>
                    <span class="labeltxt">その他資料</span>
                  </label>
                </li>
              </ul>
              <div class="flexb">
                <div class="fileimg">
                  <div class="selectfile">
                    <div class="dropfile">
                      <button class="mainbtn ulbtn" @click="uploadFile">ファイルを選択してください</button>
                      <p>ファイルをドロップしてアップロードできます</p>
                      <input style="display:none" type="file" name="fileUpload" ref="file" @change="onFileChange" />
                    </div>
                  </div>
                </div>
                <div class="filetxt">
                  <ul class="form-list">
                    <li class="fli">
                      ファイル説明文
                      <br />
                      <textarea v-model="newFile.description" class="h3"></textarea>
                    </li>
                    <li class="fli">
                      タグ付け
                      <br />
                      <textarea  v-model="newFile.tags" class="h3"></textarea>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="btn_box">
                <label class="mainbtn" @click="createFile">保存</label>
                <label for="popup_addfile" class="mainbtn" style="display:none" ref="closeModal">保存</label>
              </div>
            </div>
          </div>
        </article>
      </div>
    </div>
</template>
<script>
import fileStore, { setSelectedId, uploadFile, createFile } from "../../stores/fileStore";
export default {
    data(){
        return {

        }
    },
    computed:{
      newFile(){
        return fileStore.file
      }
    },
    methods : {
        uploadFile(){
            this.$refs.file.click();
        },
        onFileChange(e) {
            let file = e.target.files[0];
            uploadFile(file);
        },
        async createFile(){
          fileStore.actionNew = 1;
          let result = createFile().then(result => { 
              this.$refs.closeModal.click();
          });
        }
    }
}
</script>