<template>
    <div>
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
            <li>
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
            page: 1
        };
    },
    methods: {
        loadUser() {
            axios("/user/get-list", { params: { page: this.page } }).then(
                result => {
                   this.users = result.data.data;
                }
            );
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
        }
    },
    computed: {
        deleteUser() {
            if (this.deleteId != 0)
                return this.users.find(user => user.id == this.deleteId).name;
            else return "";
        }
    },
    created() {
        this.loadUser();
    }
};
</script>
