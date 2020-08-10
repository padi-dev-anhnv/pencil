<template>
  <div class="price_list sec">
    <h3 class="sec_ttl">銘入料金 (単位：円)</h3>
    <ul class="edit-list">
      <li class="sec" v-for="(ele1, index) in price.element1" :key="index">
        <h4 class="formctttl">{{ ele1.name }}</h4>
        <div class="formctbox">
          <ul>
            <price-price :ind="index" element="element1" typePrice="price" typeName="原価" />
            <price-price :ind="index" element="element1" typePrice="wholesale" typeName="仕切価格" />
          </ul>
        </div>
      </li>

      <li class="sec">
        <h4 class="formctttl">小計</h4>
        <div class="formctbox">
          <ul>
            <li>
              <span class="sub_ttl">原価：</span>
              単価
              {{ subTotalEle1.subPrice }}円 / 数
              {{ subTotalEle1.subQty }} / 計
              {{ subTotalEle1.subTotal }}円
            </li>
            <li>
              <span class="sub_ttl">仕切価格：</span>
              単価
              {{ subWholesaleEle1.subPrice }}円 / 数
              {{ subWholesaleEle1.subQty }} / 計
              {{ subWholesaleEle1.subTotal }}円
            </li>
          </ul>
        </div>
      </li>
    </ul>

    <h3 class="sec_ttl">手作業</h3>
    <ul class="edit-list">
      <li class="sec" v-for="(ele2, index) in price.element2" :key="index">
        <h4 class="formctttl">{{ ele2.name }}</h4>
        <div class="formctbox">
          <ul>
            <price-price :ind="index" element="element2" typePrice="price" typeName="原価" />
            <price-price :ind="index" element="element2" typePrice="wholesale" typeName="仕切価格" />
          </ul>
        </div>
      </li>
      <li class="sec">
        <h4 class="formctttl">小計</h4>
        <div class="formctbox">
          <ul>
            <li>
              <span class="sub_ttl">原価：</span>単価 {{ subTotalEle2.subPrice }}円 / 数
              {{ subTotalEle2.subQty }} / 計 {{ subTotalEle2.subTotal }}円
            </li>
            <li>
              <span class="sub_ttl">仕切価格：</span>単価
              {{ subWholesaleEle2.subPrice }}円 / 数 {{ subWholesaleEle2.subQty }} / 計 {{ subWholesaleEle2.subTotal }}円
            </li>
          </ul>
        </div>
      </li>
    </ul>
    <p class="sec total">
      〈総合計〉 原価：
      <strong>{{ finalPrice }}円</strong> / 仕切価格：
      <strong>{{ finalWholesale }}円</strong>
      <br />〈差益〉
      <strong>{{ finalMargin }}円</strong>
    </p>

    <ul class="edit-list">
      <li class="sec">
        <h4 class="formctttl">特値適用</h4>
        <div class="formctbox">
          <ul>
            <li>
              <label class="before">
                <span class="labeltxt">No.</span>
                <input type="text" name value />
              </label>
              <label class="before after">
                <span class="labeltxt">掛け率</span>
                <input type="text" name value />
                <span class="labeltxt">％</span>
              </label>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import guideStore, { countByEle, countSubTotal} from "../../../stores/guideStore";
export default {
  data() {
    return {
      // price : guideStore.price
    };
  },
  computed: {
    price() {
      return guideStore.price;
    },
    subTotalEle1() {
       return this.countByEle("element1", "price");
    },
    subWholesaleEle1() {
      return this.countByEle("element1", "wholesale");
    },
    subTotalEle2() {
      return this.countByEle("element2", "price");
    },
    subWholesaleEle2() {
      return this.countByEle("element2", "wholesale");
    },
    finalPrice(){
      return this.subTotalEle1.subTotal + this.subTotalEle2.subTotal ;
    },
    finalWholesale(){
      return this.subWholesaleEle1.subTotal + this.subWholesaleEle2.subTotal ;
    },
    finalMargin(){
      return this.finalWholesale - this.finalPrice;
    }
  },
  watch : {
    
    subTotalEle1(val){
      this.price.totalPrice.subTotalEle1 = val
    },
    subWholesaleEle1(val){
      this.price.totalPrice.subWholesaleEle1 = val
    },
    subTotalEle2(val){
      this.price.totalPrice.subTotalEle2 = val
    },
    subWholesaleEle2(val){
      this.price.totalPrice.subWholesaleEle2 = val
    },
    finalPrice(val){
      this.price.totalPrice.finalPrice = val
    },
    finalWholesale(val){
      this.price.totalPrice.finalWholesale = val
    },
    finalMargin(val){
      this.price.totalPrice.finalMargin = val
    }
  },
  methods: {
    
    countByEle(eleNumb, typePrice) {
      let subPrice = 0,
        subQty = 0,
        subTotal = 0;

      for (let ele in this.price[eleNumb]) {
        subPrice += this.countSubTotal(eleNumb, ele, typePrice, "cost");
        subQty += this.countSubTotal(eleNumb, ele, typePrice, "qty");
        subTotal += this.countSubTotal(eleNumb, ele, typePrice, "total");
      }
      return {
        subPrice,
        subQty,
        subTotal,
      };
    },
    countSubTotal(eleNumb, ele, typePrice, type) {
      let tempPrice = parseInt(this.price[eleNumb][ele][typePrice][type]);
      if (!isNaN(tempPrice)) return parseInt(tempPrice);
      return 0;
    },
    
  },
};
</script>
