<template>
    <div>
        <header class="sec-header edit-header">
                <nav class="pagenav flexend">
                    <ul class="pagenation">
                        <paginate
                            v-model="currentPage"
                            :page-count="totalPage"
                            :prev-text="''"
                            :next-text="''"
                            :click-handler="loadUser"
                            :container-class="'className'"
                        >
                            <span slot="prevContent"
                                >Changed previous button</span
                            >
                            <span slot="nextContent">Changed next button</span>
                            <span slot="breakViewContent">･･･</span>
                        </paginate>
                    </ul>
                    <select v-model="ppp" @change="changePpp">
                        <option value="100">100件表示</option>
                        <option value="50">50件表示</option>
                        <option value="30">30件表示</option>
                        <option value="10">10件表示</option>
                    </select>
                </nav>
            </header>
        <ul class="listtable">
            <li>
                <ul>
                    <li>氏名</li>
                    <li>権限</li>
                    <li>ID</li>
                    <li>営業所</li>
                    <li>操作</li>
                </ul>
            </li>
            <li v-if="loading">
                <div style="text-align : center; padding : 15px 0px"><div class="lds-dual-ring"></div>  </div>
            </li>
            <li v-else>
                <ul v-for="user in users" :key="user.username">
                    <li>{{ user.name }}</li>
                    <li>{{ user.role.name }}</li>
                    <li>{{ user.username }}</li>
                    <li>
                        <template v-if="user.office">
                            {{ user.office.name }}
                        </template>
                    </li>
                    <li>
                        <button
                            :onclick="
                                'location.href=\'/user/' + user.id + '/edit\''
                            "
                            class="editbtn"
                        >
                            <span>編集</span>
                        </button>

                        <label
                            for="popup_delete"
                            class="deletebtn"
                            @click="confirmDelete(user)"
                        >
                            <span>削除</span>
                        </label>
                    </li>
                </ul>
            </li>
        </ul>
        <div id="pwrap_delete" class="popup_wrap">
            <input id="popup_delete" type="checkbox" />
            <div class="overlay">
                <label for="popup_delete" class="popup_closearea"></label>
                <article class="popup_box">
                    <label for="popup_delete" class="popup_closebtn">×</label>
                    <header class="popup_header delete_hd">
                        <div class="ph_inner">
                            <h3 class="popup_ttl">アカウント削除</h3>
                            <p class="popup_dscrpt">{{ deleteUser }}</p>
                        </div>
                    </header>
                    <div class="popup_ctt">
                        <div class="popup_cttinner">
                            <p class="popup_txt">削除しますか？</p>
                            <ul class="btn_box btn2box">
                                <li>
                                    <label
                                        for="popup_delete"
                                        class="mainbtn"
                                        @click="doDelete"
                                        >はい</label
                                    >
                                </li>
                                <li>
                                    <label
                                        for="popup_delete"
                                        class="mainbtn subbtn"
                                        >いいえ</label
                                    >
                                </li>
                            </ul>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            users: [],
            deleteId: 0,
            page: 1,
            loading : false,
            totalPage : 0, 
            currentPage : 1, 
            ppp : 10

        };
    },
    methods: {
        loadUser() {
            this.loading = true;
            let searchFilter = {}
            searchFilter.page = this.currentPage ; 
            searchFilter.ppp = this.ppp  ;
            axios("/user/get-list", { params: searchFilter }).then(result => {
                this.loading = false;
                this.users = result.data.data;
                this.totalPage = result.data.total ? result.data.last_page : 0
            }).catch(err => {
                this.loading = false;
            });
        },
        confirmDelete(user) {
            this.deleteId = user.id;
        },
        doDelete() {
            if (this.deleteId) {
                axios
                    .post("/user/delete", { id: this.deleteId })
                    .then(result => {
                        this.deleteId = 0;
                        this.loadUser();
                    });
            }
        },
        changePpp(){
            localStorage.setItem("ppp-user", this.ppp);
            this.currentPage = 1;
            this.loadUser();
        },
        loadPpp(){
            if(localStorage.getItem("ppp-user")){
                this.ppp = localStorage.getItem("ppp-user");
            }        
            else{
                localStorage.setItem("ppp-user", 10)
                this.ppp = 10
            }
        }
    },
    computed: {
        deleteUser() {
            if (this.deleteId != 0)
                return this.users.find(user => user.id == this.deleteId).name;
            else return "";
        },
        
    },
    created() {
        this.loadPpp();
        this.loadUser();
    }
};
</script>
