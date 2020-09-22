<template>
    <div id="content">
        <div id="order-list" class="sec">
            <header class="sec-header edit-header flexb">
                <sort-form />
                <nav class="pagenav">
                    <ul class="pagenation">
                        <paginate
                            v-model="currentPage"
                            :page-count="totalPage"
                            :prev-text="''"
                            :next-text="''"
                            :click-handler="searchPage"
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

            <!-- リストここから -->
            <ul class="listtable">
                <li>
                    <ul>
                        <li v-if="editable == 1">出荷</li>
                        <li>作成日時</li>
                        <li>業者</li>
                        <li>指図書番号</li>
                        <li>得意先</li>
                        <li>件名</li>
                        <li>営業所名</li>
                        <li>担当者</li>
                        <li>送り先コード</li>
                        <li>送り先名</li>
                        <li>納入先</li>
                        <li>出荷予定日</li>
                        <li>納品日</li>
                        <li>商品名</li>
                        <li>指図書ダウンロード</li>
                        <li>操作</li>
                    </ul>
                </li>
                <div v-if="loading" style="text-align : center; padding : 15px 0px"><div class="lds-dual-ring black small"></div>  </div>
                             
                <single-result v-else v-for="guide in guides"
                        :key="guide.id"
                        :data-id="guide.id"
                        :guide="guide"
                        :editable="editable"
                         />
                    
            </ul>
            <!-- リストここまで -->
        </div>
    </div>
</template>

<script>
import listGuideStore, {
    doSearch,
    setDelete,
    cloneGuide
} from "../../../stores/listGuideStore";
export default {
    props: ["editable"],
    computed: {
        loading(){
            return listGuideStore.loading
        },
        guides() {
            return listGuideStore.guides;
        },
        totalPage() {
            return listGuideStore.totalPage;
        },
        currentPage: {
            // return listGuideStore.currentPage
            get: function() {
                return listGuideStore.currentPage;
            },
            // setter
            set: function(newValue) {
                listGuideStore.currentPage = newValue;
            }
        },

        user() {
            return listGuideStore.user;
        },
        ppp: {
            get: function() {
                return listGuideStore.ppp;
            },
            set: function(newValue) {
                localStorage.setItem("ppp", newValue);
                listGuideStore.ppp = newValue;
                listGuideStore.currentPage = 1;
                doSearch();
            }
        }
    },
    methods: {
        searchPage(page) {
            this.currentPage = page;
            doSearch();
        },
        setDelete(id) {
            setDelete(id);
        },
        cloneGuide(id) {
            cloneGuide(id);
        }
    }
};
</script>
