<template>

  <div id="pwrap_editfile" class="popup_wrap">
    <input id="popup_editfile" name="editfile" type="radio" />
    <div class="overlay">
      <label for="popup_cancel" class="popup_closearea"></label>
      <article class="popup_box widebox">
        <label for="popup_cancel" class="popup_closebtn">×</label>
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
         <div v-if="opening" style="text-align : center; padding : 15px 0px"><div class="lds-dual-ring black small"></div>  </div>
        <div v-else class="popup_ctt">
          <div class="popup_cttinner">
            <ul class="form-list">
              <li class="fli">
                <label class="before">
                  <span class="labeltxt">氏名</span>
                  <input v-model="file.user" type="text" name class="w20" disabled />
                </label>
                <label class="before">
                  <span class="labeltxt">営業所</span>
                  <input v-model="file.office" type="text" name class="w20" disabled />
                </label>
                <span v-show="file.material == 'guide'">指図書No.{{ file.guideNumber }}</span>
              </li>
              <li class="fli">
                <label class="before">
                  <span class="labeltxt">ファイル名（タイトル名）</span>
                  <input v-model="file.name" type="text" class="w30" />
                </label>
                <label class="after radioset" v-show="file.material != 'guide'">
                  <span class="radioarea">
                    <input v-model="file.material" type="radio" name="doctypen" value="office" />
                    <span></span>
                  </span>
                  <span class="labeltxt">本社資料</span>
                </label>
                <label class="after radioset" v-show="file.material != 'guide'">
                  <span class="radioarea">
                    <input v-model="file.material" type="radio" name="doctypen" value="other" />
                    <span></span>
                  </span>
                  <span class="labeltxt">その他資料</span>
                </label>
              </li>
            </ul>
            <div class="flexb">
              <div class="fileimg" id='drop-area'>
                <div class="selectfile" v-if="showUpload">
                  <div class="dropfile">
                    <button class="mainbtn ulbtn" @click="uploadFile">ファイルを選択してください</button>
                    <p>ファイルをドロップしてアップロードできます</p>
                    <input
                      style="display:none"
                      type="file"
                      name="fileUpload"
                      ref="file"
                      @change="onFileChange"
                      :accept="fileExt"
                    />
                  </div>
                </div>

                <div class="uploadimg" v-else>
                  <img :src="file.thumbnail" width="1740" height="1445" alt />
                  <button class="deletebtn" @click="deleteAttach">
                    <span>削除</span>
                  </button>
                </div>
              </div>
              <div class="filetxt">
                <ul class="form-list">
                  <li class="fli">
                    ファイル説明文
                    <br />
                    <textarea v-model="file.description" class="h3"></textarea>
                  </li>
                  <li class="fli">
                    タグ付け
                    <br />
                    <textarea v-model="file.tags" class="h3"></textarea>
                  </li>
                </ul>
                <label for="popup_cancel" class="mainbtn" style="display:none" ref="closeModal">保存</label>
              </div>
            </div>
            <ul class="btn_box" v-if="actionNew">
              <span v-if="updating" class="lds-dual-ring"></span>
              <label v-else class="mainbtn" @click="updateFile(true)" style="width: 20em">保存</label>
            </ul>
            <ul class="btn_box btn3box" v-else>
              <li>
                <a class="mainbtn dlbtn" :href="'file/' + this.file.id + '/download'">ファイルダウンロード</a>
              </li>
              <li>
                <span v-if="updating" class="lds-dual-ring"></span>
                <label v-else class="mainbtn mainbtn2" @click="updateFile">
                  
                  <span>編集して保存</span>
                  
                  </label>
              </li>
              <li>
                <label for="popup_deletefile" class="mainbtn subbtn" @click="setDeleteId">削除</label>
              </li>
            </ul>
          </div>
        </div>
      </article>
    </div>
  </div>
</template>

<script>
import fileStore, { setSelectedId, createFile, setDeleteId, deleteAttach } from "../../stores/fileStore";
import constFileExt from "../../stores/constFileExt";
export default {
  methods: {
    uploadFile() {
      this.$refs.file.click();
    },
    setFileUpload(file){
      let fileTemp = file;
      let fileExt = fileTemp.name.slice((fileTemp.name.lastIndexOf(".") - 1 >>> 0) + 2);
      let thumbnail = '';
      if(['jpg', 'jpeg', 'gif', 'png'].includes(fileExt))
        thumbnail = URL.createObjectURL(fileTemp);
      else
        thumbnail = 'https://via.placeholder.com/1740x1445?text=' + fileExt
      let fileName = file.name.split('.').slice(0, -1).join('.')
      this.file.name = this.file.name ? this.file.name :  fileName;
      this.file.fileUpload = fileTemp;
      this.file.link = 'file';
      this.file.thumbnail = thumbnail;
    },
    onFileChange(e) {
      this.setFileUpload(e.target.files[0] )
    },
    async updateFile(newFile = false) {
      if (newFile == false) fileStore.actionNew = 0;
      let result = createFile().then((result) => {
        if(newFile == true)
          this.$emit('reset-search');        
        if(result)
          this.$refs.closeModal.click();
      });
    },
    setDeleteId(){
      setDeleteId();
    },
    deleteAttach(){
      deleteAttach();
    }
  },
  computed: {
    file() {
      return fileStore.file;
    },
    actionNew() {
      return fileStore.actionNew;
    },
    showUpload() {
      if (this.file.link.length != 0) return false;
      return true;
    },
    updating(){
      return fileStore.updating;
    },
    opening(){
      return fileStore.opening;
    },
    fileExt(){
      let ext = constFileExt.map(fileExt => "." + fileExt);
      return ext.join(",")
    }
  },
  mounted(){
    let dropArea = document.getElementById('drop-area')
    dropArea.ondragover = dropArea.ondragenter = (evt) => {
      this.dragging = true;
      evt.preventDefault();
    };
    dropArea.ondragleave = () => {
      this.dragging = false;
    } 
    dropArea.ondrop = (evt) => {
      let fileName = evt.dataTransfer.files[0].name;
      let fileExtension = fileName.replace(/^.*\./, '');
      if(constFileExt.includes(fileExtension))
        this.setFileUpload(evt.dataTransfer.files[0])
      evt.preventDefault();
    };

  }
};
</script>
