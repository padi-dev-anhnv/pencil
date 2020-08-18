<template>
  <!-- <li class="flexb"> -->
    <div >
      <input
        style="display:none"
        type="file"
        name="fileUpload"
        :ref="'file' + index + i"
        @change="onFileChange($event,index, i)"
        :accept="fileExt"
      />
      <div class="uploadimg" v-if="file.link">
        <img v-if="file.thumbnail" :src="file.thumbnail" width="566" height="573" />
        <button class="deletebtn" @click.prevent="deleteFile(index, i)">
          <span>削除</span>
        </button>
      </div>
      <div class="selectfile" v-else>
        <label class="mainbtn ulbtn" @click="uploadFile(index,i)">ファイルを選択してください</label>
      </div>
    </div>
  <!-- </li> -->
</template>

<script>
import guideStore from "../../../stores/guideStore";
import constFileExt from "../../../stores/constFileExt";
export default {
  props : ['index', 'i'],
  computed : {
    inscription(){
      return guideStore.products[this.index].inscription
    },
    file(){
      return guideStore.products[this.index].inscription.files[this.i]
    },
    fileExt(){
      let ext = constFileExt.map(fileExt => "." + fileExt);
      return ext.join(",")
    }
  },
  methods : {
    uploadFile(index,i){
      let fileName = 'file' + index + i;
      this.$refs[fileName].click();
      // this.$refs[fileName].click();
    },
    async onFileChange(e,index,i){
      // index : order of product
      // i : order of file in product
      /*
      let fileTemp = e.target.files[0];
      this.file.fileUpload = fileTemp; 
      this.file.link = 'fileSelected'
      this.file.thumbnail =  URL.createObjectURL(fileTemp);
      */
      let fileTemp = e.target.files[0];
      let fileExt = fileTemp.name.slice((fileTemp.name.lastIndexOf(".") - 1 >>> 0) + 2);
      let thumbnail = '';
      if(['jpg', 'jpeg', 'gif', 'png'].includes(fileExt))
        thumbnail = URL.createObjectURL(fileTemp);
      else
        thumbnail = 'https://via.placeholder.com/1740x1445?text=' + fileExt
      let holderFile = {fileUpload : fileTemp, link : 'file', thumbnail }
      
      Vue.set(this.inscription.files, i, holderFile)

      /*
      this.inscription.files[i].fileUpload = fileTemp;
      this.inscription.files[i].link = 'fileSelected'
      this.inscription.files[i].thumbnail =  URL.createObjectURL(fileTemp);
      */



      // console.log(file)

      // let fileUploaded = await createFileProduct(file);
      // Vue.set(this.inscription.files, i, fileUploaded.data)
    },
    deleteFile(index, i){
      Vue.set(this.inscription.files, i, {})
    }
  }
};
</script>