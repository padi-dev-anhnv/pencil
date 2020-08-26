<template>
    <div id="code-upload" class="sec">
		<h3 class="sec_ttl">送り先コード管理</h3>
		<div class="txtbox">
			<p>送り先コードを上書きします。ファイルを選択してアップロードしてください。</p>
			<p class="note">送り先コードは、CSVファイルの内容をデータベースに上書きしますのでご注意ください。</p>
		</div>
		<ul class="btn2box">
            <input
                        accept=".csv"
                      style="display:none"
                      type="file"
                      name="fileUpload"
                      ref="file"
                      @change="onFileChange"
                    />
			<li><button class="mainbtn mainbtn2" @click="selectFile">ファイルを選択</button></li>
			<li><button class="mainbtn ulbtn" @click="uploadFile">アップロード</button></li>
		</ul>
	</div>

</template>
<script>
export default {
    data(){
        return{
            file : null
        }
    },
    methods:{
        onFileChange(e){
            let file = e.target.files[0];
            this.file = file;
        },
        selectFile() {
            this.$refs.file.click();
        },
        uploadFile(){
            let formData = new FormData();
            formData.append('file', this.file);
            axios.post('/user/upload-customer-csv', formData, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        }).then(result => {
                alert("Customer CSV is uploaded")
            }).catch(err =>{
                alert("Error")
            })
        }
    }
}
</script>