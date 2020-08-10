<template>
    <li>
        <span class="sub_ttl">{{ typeName }}：</span>
        <label class="before after">
            <span class="labeltxt">単価</span>
            <input type="text" v-model="price.cost" />
            <span class="labeltxt">円</span>
        </label>
        <label class="before">
            <span class="labeltxt">数</span>
            <input type="text" v-model="price.qty" />
        </label>
        <label class="before">
            <span class="labeltxt">単位</span>
            <input type="text" v-model="price.unit" />
        </label>
        <label class="before after">
            <span class="labeltxt">計</span>
            <input type="text" v-model="total" disabled />
            <span class="labeltxt">円</span>
        </label>
    </li>
</template>

<script>
import guideStore from "../../../stores/guideStore";
export default {
    props : ['ind', 'element', 'typePrice', 'typeName'],
    computed : {
        price(){
            return guideStore.price[this.element][this.ind][this.typePrice];
        },
        total(){
            if(this.price.cost && this.price.qty && !isNaN(this.price.cost) && !isNaN(this.price.qty)){
                return this.price.cost * this.price.qty;
            }
            return ""
        }
    },
    watch :{
        total(val){
            this.price.total = val;
        }
    }
};
</script>
