<template>
    <!-- <li class="flexb"> -->
    <div
        :id="'drop-area' + index + '' + i"
        :class="{ 'area-dragging': dragging }"
    >
        <input
            style="display:none"
            type="file"
            name="fileUpload"
            :ref="'file' + index + i"
            @change="onFileChange($event, index, i)"
            :accept="fileExt"
        />
        <label
            @click="openEditModal(file.id, index, i)"
            :for="file.id ?  'popup_editfile' : ''"
            class="uploadimg"
            v-if="file.link"
        >
            <img
                v-if="file.thumbnail"
                :src="file.thumbnail"
                width="566"
                height="573"
            />
            <button
                v-show="!file.id"
                class="deletebtn"
                @click.prevent="deleteFile(index, i)"
            >
                <span>削除</span>
            </button>
        </label>
        <div class="selectfile" v-else>
            <label v-show="canEdit" class="mainbtn ulbtn" @click="uploadFile(index, i)"
                >ファイルを選択してください</label
            >
        </div>
    </div>
    <!-- </li> -->
</template>

<script>
import guideStore, {
    deleteFileTemp,
    setFileUpload,
    setDeleteFile
} from "../../../stores/guideStore";

import fileStore, {
    openAddModal,
    setCurrentUser,
    openEditModal
} from "../../../stores/fileStore";
import constFileExt from "../../../stores/constFileExt";
export default {
    props: ["index", "i"],
    data() {
        return {
            dragging: false
        };
    },
    computed: {
        inscription() {
            return guideStore.products[this.index].inscription;
        },
        file() {
            return guideStore.products[this.index].inscription.files[this.i];
        },
        fileExt() {
            let ext = constFileExt.map(fileExt => "." + fileExt);
            return ext.join(",");
        },
        canEdit(){
            return guideStore.canEdit;
        }
    },
    methods: {
        uploadFile(index, i) {
            let fileName = "file" + index + i;
            this.$refs[fileName].click();
            // this.$refs[fileName].click();
        },
        setFileUpload(file, index, i) {
            let fileTemp = file;
            let fileExt = fileTemp.name.slice(
                ((fileTemp.name.lastIndexOf(".") - 1) >>> 0) + 2
            );
            let thumbnail = "";
            if (["jpg", "jpeg", "gif", "png"].includes(fileExt))
                thumbnail = URL.createObjectURL(fileTemp);
            else
                thumbnail =
                    "https://via.placeholder.com/1740x1445?text=" + fileExt;
            let holderFile = { fileUpload: fileTemp, link: "file", thumbnail };
            setFileUpload(index, i, holderFile);
            // Vue.set(this.inscription.files, i, holderFile)
        },
        async onFileChange(e, index, i) {
            // index : order of product
            // i : order of file in product
            this.setFileUpload(e.target.files[0], index, i);
        },
        deleteFile(index, i) {
            deleteFileTemp(index, i);
            return false;
            // Vue.set(this.inscription.files, i, {})
        },

        openEditModal(id, index, i) {
            setDeleteFile(index, i);
            openEditModal(id);
        }
    },
    mounted() {
        let dropArea = document.getElementById(
            "drop-area" + this.index + "" + this.i
        );
        dropArea.ondragover = dropArea.ondragenter = evt => {
            this.dragging = true;
            evt.preventDefault();
        };
        dropArea.ondragleave = () => {
            this.dragging = false;
        };
        dropArea.ondrop = evt => {
            let fileName = evt.dataTransfer.files[0].name;
            let fileExtension = fileName.replace(/^.*\./, "");
            if (constFileExt.includes(fileExtension))
                this.setFileUpload(
                    evt.dataTransfer.files[0],
                    this.index,
                    this.i
                );
            evt.preventDefault();
        };
    }
};
</script>
<style scoped>
.area-dragging .selectfile,
.area-dragging .uploadimg {
    box-shadow: 0 10px 16px 0 rgba(0, 0, 0, 0.2),
        0 6px 20px 0 rgba(0, 0, 0, 0.19) !important;
}
</style>
