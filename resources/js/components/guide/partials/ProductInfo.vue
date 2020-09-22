<template>
  <li class="sec" >
        <h3 class="formctttl">本体銘入要領〈枝番{{index + 1}}〉</h3>
        <div class="formctbox">
          <ul>
            <li>
              <label class="before">
                <span class="labeltxt">品名</span>
                <input type="text" v-model="info.name" class="w30" />
              </label>
              <label class="before">
                <span class="labeltxt">色</span>
                <input type="text"  v-model="info.color" class="w20" />
              </label>
            </li>
            <li>
              <label class="before">
                <span class="labeltxt">銘入数量</span>
                <input type="text"  v-model="info.qty" />
              </label>
              <label class="before">
                <span class="labeltxt">単位</span>
                <input type="text"  v-model="info.unit" />
              </label>
              <label class="before dateset">
                <span class="labeltxt">出荷日</span>
                <input type="date"  v-model="info.shipping_date" />
              </label>
              <label class="before dateset">
                <span class="labeltxt">商品入荷予定</span>
                <input type="date"  v-model="info.received_date" />
              </label>
            </li>
          </ul>
        </div>
        <div class="btnbox_righttop" v-show="total > 1">
          <span class="deletebtn" @click.prevent="removeProduct(index)">
            <span>削除</span>
          </span>
        </div>
      </li>
</template>

<script>
import guideStore, { removeProduct } from "../../../stores/guideStore";
export default {
  props : ['indexv', 'total'],
  computed : {
    info(){
      return guideStore.products[this.index].info
    },
    index(){
      return this.indexv - 1;
    }
  },
  methods : {    
    removeProduct(index){
      removeProduct(index)
      // this.products.splice(index,1)
    },
  }
};
</script>