<template>
  <ul class="edit-list">
    <li class="sec" v-if="action != 'new'">
      <h3 class="formctttl">ステータス</h3>
      <div class="formctbox">
        <select v-model="guide.export">
          <option value="0">納品前</option>
          <option value="1">納品済</option>
        </select>
      </div>
    </li>
    <li class="sec">
      <h3 class="formctttl">作成日時</h3>
      <div class="formctbox">
        <label class="dateset">
          <input type="date" v-model="guide.created_at" />
        </label>
      </div>
    </li>
    <li class="sec">
      <h3 class="formctttl">前回</h3>
      <div class="formctbox">
        <select v-model="guide.last_exist">
          <option value="0" selected>無</option>
          <option value="1">有</option>
        </select>
      </div>
    </li>
    <li class="sec">
      <h3 class="formctttl">前回発注日</h3>
      <div class="formctbox">
        <label class="dateset">
          <input type="date" v-model="guide.last_date" />
        </label>
      </div>
    </li>
    <li class="sec">
      <h3 class="formctttl">前回指図書No.</h3>
      <div class="formctbox">
        <input type="text" name v-model="guide.last_numb" />
      </div>
    </li>
    <li class="sec">
      <h3 class="formctttl">件名</h3>
      <div class="formctbox">
        <input type="text" v-model="guide.title" name value class="w50"  />
      </div>
    </li>
    <li class="sec">
      <h3 class="formctttl">営業所名</h3>
      <div class="formctbox">
        <!-- <input v-if="creator.office" type="text" name="" v-model="creator.office.name"  disabled class="w15" />
        <input v-else type="text" name="" disabled class="w15" />-->
        <input type="text" name v-model="guideOffice" class="w15" disabled />
      </div>
    </li>
    <li class="sec">
      <h3 class="formctttl">担当者</h3>
      <div class="formctbox">
        <input type="text" name v-model="guideAuthor" disabled class="w15" />
      </div>
    </li>
    <li class="sec">
      <h3 class="formctttl">指図書No.</h3>
      <div class="formctbox">
        <input type="text" v-model="guide.number" value  />
      </div>
    </li>
    <li class="sec">
      <h3 class="formctttl">業者選択</h3>
      <div class="formctbox">
        <select v-model="guide.supplier_id">
          <option value="null">選択してください</option>
          <option v-for="sup in suppliers" :value="sup.id" :key="sup.id">{{ sup.name }}</option>
        </select>
      </div>
    </li>
    <li class="sec">
      <h3 class="formctttl">店コード</h3>
      <div class="formctbox">
        <input type="text" v-model="guide.store_code"  />
      </div>
    </li>

    <li class="sec">
      <h3 class="formctttl">得意先名</h3>
      <div class="formctbox">
        <label class="before">
          <input type="text" name v-model="guide.customer_name" class="w50" />
        </label>
        <span>様</span>
      </div>
    </li>
    <li class="sec">
      <h3 class="formctttl">ご担当者様</h3>
      <div class="formctbox">
        <label class="before">
          <input type="text" name v-model="guide.curator" class="w15"  />
        </label>
        <span>様</span>
      </div>
    </li>
    <li class="sec">
      <h3 class="formctttl">出荷希望日</h3>
      <div class="formctbox">
        <label class="dateset">
          <input type="date" v-model="guide.shipping_date" />
        </label>
      </div>
    </li>
    <li class="sec">
      <h3 class="formctttl">納期日</h3>
      <div class="formctbox">
        <label class="dateset">
          <input type="date" v-model="guide.received_date" />
        </label>
      </div>
    </li>
  </ul>
</template>

<script>
import guideStore, { getWorkers } from "../../../stores/guideStore";
export default {
  props : ['action'],
  data() {
    return {};
  },
  computed: {
    guide() {
      return guideStore.guide;
    },
    suppliers() {
      return guideStore.suppliers;
    },
    creator() {
      return guideStore.creator;
    },
    dupplicate() {
      return guideStore.dupplicate;
    },
    guideOffice() {
      if (["new", "dupplicate"].includes(guideStore.action))
        return guideStore.creator.office ? guideStore.creator.office.name : "";
      else return guideStore.guide.office;
    },
    guideAuthor() {
      if (["new", "dupplicate"].includes(guideStore.action))
        return guideStore.creator.name;
      else {
        if(guideStore.guide.creator)
          return guideStore.guide.creator.name;
        return "";
      }
        
    },
  },
  created() {
    getWorkers();
  },
};
</script>
