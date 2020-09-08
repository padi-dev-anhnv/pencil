<template>
    <div>
        <div class="top_btn">
            <label
                for="popup_editfile"
                class="mainbtn mainbtn2"
                id="btn_new"
                @click="openAddModal"
                >新規作成</label
            >
        </div>

        <!-- 検索条件追加 -->
        <div class="search-form">
            <form>
                <ul class="form-list">
                    <li class="sub_ttl">項目を選択して検索してください</li>
                    <li class="fli">
                        <ul class="checklist">
                            <li>
                                <label class="checkset">
                                    <input
                                        type="checkbox"
                                        v-model="search.office.enable"
                                        name="search_ctt"
                                    />
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="49.85"
                                        height="33.93"
                                        viewBox="0 0 49.85 33.93"
                                        class="icon_check"
                                    >
                                        <polyline
                                            class="cls-1"
                                            points="3.08 10.81 21.13 27.73 46.74 3.25"
                                        />
                                    </svg>
                                    <span>営業所</span>
                                </label>
                                <select v-model="search.office.value">
                                    <option value="">選択してください</option>
                                    <option
                                        :value="office.name"
                                        v-for="office in listOffice"
                                        :key="office.id"
                                        >{{ office.name }}</option
                                    >
                                </select>
                            </li>
                            <li>
                                <label class="checkset">
                                    <input
                                        type="checkbox"
                                        name="search_ctt"
                                        v-model="search.author.enable"
                                    />
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="49.85"
                                        height="33.93"
                                        viewBox="0 0 49.85 33.93"
                                        class="icon_check"
                                    >
                                        <polyline
                                            class="cls-1"
                                            points="3.08 10.81 21.13 27.73 46.74 3.25"
                                        />
                                    </svg>
                                    <span>担当者</span>
                                </label>
                                <select v-model="search.author.value">
                                    <option value="">選択してください</option>
                                    <option
                                        :value="author.id"
                                        v-for="author in listAuthor"
                                        :key="author.id"
                                        >{{ author.name }}</option
                                    >
                                </select>
                            </li>
                        </ul>
                    </li>
                    <li class="fli">
                        <ul class="checklist">
                            <li>
                                <label class="checkset">
                                    <input
                                        type="checkbox"
                                        name="search_ctt"
                                        v-model="search.date.enable"
                                    />
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="49.85"
                                        height="33.93"
                                        viewBox="0 0 49.85 33.93"
                                        class="icon_check"
                                    >
                                        <polyline
                                            class="cls-1"
                                            points="3.08 10.81 21.13 27.73 46.74 3.25"
                                        />
                                    </svg>
                                    <span>アップロード日</span>
                                </label>
                                <label class="dateset">
                                    <input
                                        type="date"
                                        v-model="search.date.dateFrom"
                                    />
                                </label>
                                <span class="datetxt">～</span>
                                <label class="dateset">
                                    <input
                                        type="date"
                                        v-model="search.date.dateTo"
                                    />
                                </label>
                            </li>
                        </ul>
                    </li>
                    <li class="fli">
                        <ul class="checklist">
                            <li>
                                <label class="checkset">
                                    <input
                                        v-model="material"
                                        value="guide"
                                        type="checkbox"
                                        name="search_ctt"
                                    />
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="49.85"
                                        height="33.93"
                                        viewBox="0 0 49.85 33.93"
                                        class="icon_check"
                                    >
                                        <polyline
                                            class="cls-1"
                                            points="3.08 10.81 21.13 27.73 46.74 3.25"
                                        />
                                    </svg>
                                    <span>指図書フォルダ</span>
                                </label>
                            </li>
                            <li>
                                <label class="checkset">
                                    <input
                                        v-model="material"
                                        value="office"
                                        type="checkbox"
                                        name="search_ctt"
                                    />
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="49.85"
                                        height="33.93"
                                        viewBox="0 0 49.85 33.93"
                                        class="icon_check"
                                    >
                                        <polyline
                                            class="cls-1"
                                            points="3.08 10.81 21.13 27.73 46.74 3.25"
                                        />
                                    </svg>
                                    <span>本社資料</span>
                                </label>
                            </li>
                            <li>
                                <label class="checkset">
                                    <input
                                        v-model="material"
                                        value="other"
                                        type="checkbox"
                                        name="search_ctt"
                                    />
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="49.85"
                                        height="33.93"
                                        viewBox="0 0 49.85 33.93"
                                        class="icon_check"
                                    >
                                        <polyline
                                            class="cls-1"
                                            points="3.08 10.81 21.13 27.73 46.74 3.25"
                                        />
                                    </svg>
                                    <span>その他資料</span>
                                </label>
                            </li>
                        </ul>
                    </li>
                    <li class="fli">
                        <ul class="checklist">
                            <li>
                                <label class="checkset">
                                    <input
                                        type="checkbox"
                                        name="search_ctt"
                                        v-model="search.keyword.enable"
                                    />
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="49.85"
                                        height="33.93"
                                        viewBox="0 0 49.85 33.93"
                                        class="icon_check"
                                    >
                                        <polyline
                                            class="cls-1"
                                            points="3.08 10.81 21.13 27.73 46.74 3.25"
                                        />
                                    </svg>
                                    <span>キーワード</span>
                                </label>
                                <label class="after">
                                    <input
                                        v-model="search.keyword.value"
                                        type="text"
                                        class="w50"
                                        placeholder="会社名・件名・画像名等を入力"
                                    />
                                </label>
                            </li>
                        </ul>
                    </li>
                </ul>
                <input
                    type="submit"
                    value="検索"
                    class="mainbtn"
                    @click.prevent="doSearchFile(true)"
                />
            </form>
        </div>
        <!-- 検索条件追加 -->

        <!-- コンテンツここから -->
        <div id="content">
            <header class="sec-header edit-header">
                <nav class="pagenav flexend">
                    <ul class="pagenation">
                        <paginate
                            v-model="currentPage"
                            :page-count="totalPage"
                            :prev-text="''"
                            :next-text="''"
                            :click-handler="doSearchFile"
                            :container-class="'className'"
                        >
                            <span slot="prevContent"
                                >Changed previous button</span
                            >
                            <span slot="nextContent">Changed next button</span>
                            <span slot="breakViewContent">･･･</span>
                        </paginate>
                    </ul>
                    <select v-model="ppp">
                        <option value="100">100件表示</option>
                        <option value="50">50件表示</option>
                        <option value="30">30件表示</option>
                        <option value="10">10件表示</option>
                    </select>
                </nav>
            </header>
            <div id="file-list" class="sec">
                <!-- リストここから -->
                 <div v-if="searching" style="text-align : center; padding : 15px 0px"><div class="lds-dual-ring"></div>  </div>
                <ul class="flex" v-else>
                    <li v-for="file in files" :key="file.id">
                        <div class="upld_date">{{ file.created_at }}</div>
                        <div for="popup_imgdtl" class="thumb">
                            <label
                                @click="openEditModal(file.id)"
                                for="popup_editfile"
                                class="imgbox"
                            >
                                <img
                                    :src="file.thumbnail"
                                    width="500"
                                    height="829"
                                    alt="イメージ"
                                />
                            </label>
                            <!-- <div class="file_type">
                                <img src="/images/file_pdf.svg" alt="PDF" />
                            </div> -->
                        </div>
                        <div class="file_ttl">{{ file.name }}</div>
                    </li>
                </ul>
                <!-- リストここまで -->
            </div>
        </div>

        <file-modal @reset-search="resetFilter" />
        <file-delete />
	
		<!-- 削除確認 -->
		
		<!-- 削除確認 -->
	
		<input id="popup_cancel" name="editfile" type="radio" class="cancel">
	<!-- 画像詳細閲覧・ダウンロードポップアップ -->

    </div>
</template>

<script>
import fileStore, {
    openAddModal,
    setCurrentUser,
    openEditModal,
    doSearch,
    getPpp
} from "../../stores/fileStore";

export default {
    props: ["userInfo", "userOffice"],
    data() {
        return {
            search: {
                author: { enable: false, value: "" },
                office: { enable: false, value: "" },
                date: { enable: false, dateFrom: "", dateTo: "" },
                keyword: { enable: false, value: "" }
            },
            material: [],
            newFile: {},
            listOffice: [],
            listAuthor: []
        };
    },
    computed: {
        files() {
            return fileStore.listFiles;
        },
        searchFilter() {
            let search = {};
            if (this.search.office.enable && this.search.office.value)
                search.office = this.search.office.value;
            if (this.search.author.enable && this.search.author.value)
                search.author = this.search.author.value;
            if (this.search.keyword.enable)
                search.keyword = this.search.keyword.value;
            if (this.search.date.enable) {
                search.dateFrom = this.search.date.dateFrom;
                search.dateTo = this.search.date.dateTo;
            }
            if (this.material.length > 0)
                search.material = this.material.join(",");

            return search;
        },
        selectedId() {
            return fileStore.selectedId;
        },
        totalPage() {
            return fileStore.totalPage;
        },
        currentPage: {
            get: function() {
                return fileStore.currentPage;
            },
            // setter
            set: function(newValue) {
                fileStore.currentPage = newValue;
            }
        },
        ppp: {
            get: function() {
                return fileStore.ppp;
            },
            set: function(newValue) {
                localStorage.setItem("ppp-file", newValue);
                fileStore.ppp = newValue;
                fileStore.currentPage = 1;
                this.doSearchFile();
            }
        },
        searching(){
            return fileStore.searching
        }
    },
    methods: {
        doSearchFile(resetPage=false) {
            if(resetPage == true)
              fileStore.currentPage = 1;
            doSearch(this.searchFilter);
        },
        loadListOffice() {
            axios("/guide/offices").then(result => {
                this.listOffice = result.data;
            });
        },
        loadListAuthor() {
            axios("/file/user-per-file").then(result => {
                this.listAuthor = result.data;
            });
        },
        selectFile(id) {
            setSelectedId(id);
        },
        setUser() {
            let user = {
                name: this.userInfo.name,
                office: this.userOffice ? this.userOffice.name : ""
            };
            setCurrentUser(user);
        },
        /*
        setFileUserOffice() {
            let user = {
                name: this.userInfo.name,
                office: this.userOffice.name
            };
            setFileUserOffice(user);
        }
        */
       openAddModal(){
           let user = {
                name: this.userInfo.name,
                office: this.userOffice ? this.userOffice.name : ""
            };
           openAddModal(user);
       },
       openEditModal(id){
           openEditModal(id);
       },
       resetFilter(){
           this.search = {
                author: { enable: false, value: "" },
                office: { enable: false, value: "" },
                date: { enable: false, dateFrom: "", dateTo: "" },
                keyword: { enable: false, value: "" }
            }
            this.material = [];
            fileStore.currentPage = 1;
            this.doSearchFile();
       }
    },
    created() {
        getPpp();
        this.doSearchFile();
        this.loadListOffice();
        this.loadListAuthor();
        this.setUser();
    }
};
</script>
