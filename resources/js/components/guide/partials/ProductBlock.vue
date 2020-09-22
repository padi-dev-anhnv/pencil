<template>
  <div class="product_edit sec">
    <ul class="edit-list">
      <li class="addbtn_box">
        <span class="total">
          銘入合計数量：
          <strong>{{ totalProduct }}P</strong>
        </span>
        <span @click.prevent="addProduct" class="mainbtn addbtn">追加</span>
      </li>
      
      <product-info v-for="index in totalProduct" :key="index + '-info'" :indexv="index" :total="totalProduct" />
      <product-inscription v-for="index in totalProduct" :key="index + '-inscription'" :indexv="index" />

      
    </ul>
  </div>
</template>

<script>
import guideStore , { addProduct } from "../../../stores/guideStore";
import { createFileProduct } from "../../../stores/fileStore";
import constVar from "../../../stores/constVar";
export default {
  props : ['action'],
  data() {
    return {
    };
  },
  computed: {
    products() {
      return guideStore.products;
    },
    productInit() {
      return guideStore.productInit;
    },
    /*
    fontSizeExist(product){
      return product.inscription.font_size;
    },
    */
    totalProduct(){
      return guideStore.products.length;
    }
  },
  methods : {
    addProduct(){
      addProduct();
    }
  },
  created(){
    if(this.action == 'new')
       addProduct();
  }
};
</script>
