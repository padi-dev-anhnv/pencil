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
              <span slot="prevContent">Changed previous button</span>
              <span slot="nextContent">Changed next button</span>
              <span slot="breakViewContent">･･･</span>
            </paginate>
            <!-- 
							<li v-for="page in totalPage" :key="page">
								<a v-if="page != currentPage" href="#" @click.prevent="searchPage(page)">{{page}}</a>
								<template v-else>{{page}}</template>
							</li>

							<li>1</li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">5</a></li>
							<li>･･･</li>
            <li><a href="#">10</a></li>-->
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
        <li>
          <ul v-for="guide in guides" :key="guide.id" :data-id="guide.id">
            <li>{{ guide.created_at }}</li>
            <li>{{ guide.supplier.name }}</li>
            <li>{{ guide.number }}</li>
            <li>{{ guide.customer_name }}</li>
            <li>{{ guide.title}}</li>
            <li>{{ guide.office }}</li>
            <li>{{ guide.creator.name }}</li>
            <li><template v-if="guide.delivery">{{ guide.delivery.code}}</template></li>
            <li>{{ guide.delivery.receiver }}</li>
            <li>高宮中学校</li>
            <li>{{ guide.delivery.shipping_date }}</li>
            <li>{{ guide.delivery.received_date }}</li>
            <li>
              <template v-if="guide.first_product">{{ guide.first_product.name}}</template>
            </li>
            <li>
              <a href="#">PDF(料金有）</a>
              <br />
              <a href="#">PDF(料金無）</a>
            </li>
            <li>
              <button onclick="location.href='order_edit.html'" class="editbtn">
                <span>編集</span>
              </button>
              <button onclick="location.href=''" class="copybtn">
                <span>複製</span>
              </button>
              <label for="popup_delete" class="deletebtn">
                <span>削除</span>
              </label>
            </li>
          </ul>
        </li>
      </ul>
      <!-- リストここまで -->
    </div>
  </div>
</template>

<script>
import listGuideStore, { doSearch } from "../../../stores/listGuideStore";
export default {
  computed: {
    guides() {
      return listGuideStore.guides;
    },
    totalPage() {
      return listGuideStore.totalPage;
    },
    currentPage: {
      // return listGuideStore.currentPage
      get: function () {
        return listGuideStore.currentPage;
      },
      // setter
      set: function (newValue) {
        listGuideStore.currentPage = newValue;
      },
	},
	ppp : {
      get: function () {
        return listGuideStore.ppp;
      },
      set: function (newValue) {
		localStorage.setItem("ppp", newValue)
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
    }
  },
};
</script>