<template>
    <div class="edit-form">
        <form>
            <ul class="edit-list">
                <li class="sec">
                    <h3 class="formctttl">権限</h3>
                    <div class="formctbox">
                        <label
                            class="after radioset"
                            v-for="role in roles"
                            :key="role.id"
                        >
                            <span class="radioarea">
                                <input
                                    type="radio"
                                    name="authority"
                                    :value="role.id"
                                    v-model="user.role_id"
                                />
                                <span></span>
                            </span>
                            <span class="labeltxt">{{ role.name }}</span>
                        </label>
                    </div>
                </li>
                <li class="sec">
                    <h3 class="formctttl">氏名又は会社名</h3>
                    <div class="formctbox">
                        <input
                            type="text"
                            v-model="user.name"
                            name
                            value
                            class="w50"
                        />
                    </div>
                </li>
                <li class="sec">
                    <h3 class="formctttl">営業所名</h3>
                    <div class="formctbox">
                        <input
                            type="text"
                            v-model="user.office"
                            name
                            value
                            class="w15"
                        />
                    </div>
                </li>
                <li class="sec">
                    <h3 class="formctttl">ID</h3>
                    <div class="formctbox">
                        <input type="text" value v-model="user.username" />
                    </div>
                </li>
                <li class="sec">
                    <h3 class="formctttl">パスワード</h3>
                    <div class="formctbox">
                        <input
                            type="text"
                            name
                            value
                            class="w30"
                            v-model="user.password"
                        />
                    </div>
                </li>
                <li class="sec">
                    <h3 class="formctttl">パスワード確認</h3>
                    <div class="formctbox">
                        <input
                            type="text"
                            name
                            value
                            class="w30"
                            v-model="user.password_confirmation"
                        />
                    </div>
                </li>
            </ul>

            <footer class="list-footer">
                <button class="mainbtn mainbtn" @click.prevent="updateUser">
                    登録
                </button>
            </footer>
        </form>
    </div>
</template>

<script>
export default {
    props: ["edit"],
    data() {
        return {
            user: {
                role_id: "",
                name: "",
                office: "",
                username: "",
                password: "",
                password_confirmation: "",
                id : ""
            },
            roles: []
        };
    },
    methods: {
        loadUser() {
            axios("/user/" + this.edit + '/show').then(
                result => {
                    this.user = result.data;
                    this.user.office = result.data.office.name
                }
            );
        },
        loadRoles(user) {
            axios("/user/roles").then(result => {
                this.roles = result.data;
            });
        },
        updateUser() {
            axios.post("/user", this.user).then(result => {
                if (result.data.status == "ok" && this.edit == 0) {
                    location.href = "/user";
                }
            });
        }
    },
    created() {
        if (this.edit != "0") this.loadUser();
        this.loadRoles();
    }
};
</script>
