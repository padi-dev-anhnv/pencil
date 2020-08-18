<template>
  <form>
    <label>発注日</label>
    <select v-model="sort.orderDate">
      <option value="">選択してください</option>
      <option value="desc">新しい順</option>
      <option value="asc">古い順</option>
    </select>

    <label>出荷予定日</label>
    <select v-model="sort.shippingDate">
      <option value="">選択してください</option>
      <option value="desc">新しい順</option>
      <option value="asc">古い順</option>
    </select>

    <label>納品予定日</label>
    <select v-model="sort.receivedDate">
      <option value="">選択してください</option>
      <option value="desc">新しい順</option>
      <option value="asc">古い順</option>
    </select>

    <button class="mainbtn" @click.prevent="doSearch">実行</button>
  </form>
</template>

<script>
import listGuideStore, { doSearch } from "../../../stores/listGuideStore";
export default {
  computed : {
    sort(){
      return listGuideStore.sort;
    }
  },
  methods : {
    doSearch(){
      doSearch();
    }
  }
};
</script>