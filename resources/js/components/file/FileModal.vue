<template>
    <div id="pwrap_editfile" class="popup_wrap">
      <input id="popup_editfile" type="checkbox" />
      <div class="overlay">
        <label for="popup_editfile" class="popup_closearea"></label>
        <article class="popup_box widebox">
          <label for="popup_editfile" class="popup_closebtn">×</label>
          <header v-if="actionNew" class="popup_header file_new_hd">
            <div class="ph_inner">
              <h3 class="popup_ttl">新規ファイル追加</h3>
            </div>
          </header>
          <header v-else class="popup_header">
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
                    <input v-model="currentFile.user" type="text" name  class="w20" disabled />
                  </label>
                  <label class="before">
                    <span class="labeltxt">営業所</span>
                    <input  v-model="currentFile.office" type="text" name  class="w20"  disabled />
                  </label>
                </li>
                <li class="fli">
                  <label class="before">
                    <span class="labeltxt">ファイル名（タイトル名）</span>
                    <input v-model="currentFile.name" type="text" class="w30" />
                  </label>
                </li>
              </ul>
              <div class="flexb">
                <div class="fileimg">
                  <div class="uploadimg">
                    <img :src="currentFile.thumbnail" width="1740" height="1445" alt />
                    <button class="deletebtn">
                      <span>削除</span>
                    </button>
                  </div>
                </div>
                <div class="filetxt">
                  <ul class="form-list">
                    <li class="fli">
                      ファイル説明文
                      <br />
                      <textarea v-model="currentFile.description" class="h3"></textarea>
                    </li>
                    <li class="fli">
                      タグ付け
                      <br />
                      <textarea  v-model="currentFile.tags" class="h3"></textarea>
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
                  <label for="popup_editfile" class="mainbtn mainbtn2">編集して保存</label>
                </li>
              </ul>
            </div>
          </div>
        </article>
      </div>
    </div>
</template>

<script>
import fileStore, { setSelectedId } from "../../stores/fileStore";

export default {
  methods : {
    uploadFile(){
            this.$refs.file.click();
        },
        onFileChange(e) {
            let file = e.target.files[0];
            this.newFile.file = file;
        },
        createFile(){
            let formData = new FormData();
            for ( let key in this.newFile ) {
                formData.append(key, this.newFile[key]);
            }
            axios.post( '/file',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
                ).then(function(){
                    
                })
                .catch(function(){
                console.log('FAILURE!!');
            });
        }
  },
  computed:{
    file(){
      return fileStore.file
    },
    actionNew(){
      return fileStore.actionNew
    }
  }

}
</script>