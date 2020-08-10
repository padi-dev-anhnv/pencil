<template>
    <li>
        <span class="sub_ttl">仕切価格：</span>
        <label class="before after">
            <span class="labeltxt">単価</span>
            <input type="text" name value />
            <span class="labeltxt">円</span>
        </label>
        <label class="before">
            <span class="labeltxt">数</span>
            <input type="text" name value />
        </label>
        <label class="before">
            <span class="labeltxt">単位</span>
            <input type="text" name value />
        </label>
        <label class="before after">
            <span class="labeltxt">計</span>
            <input type="text" name value />
            <span class="labeltxt">円</span>
        </label>
    </li>
</template>

<script>
export default {
    props : ['ind', 'element'],
    computed : {
        wholesale(){
            return guideStore.price[this.element][this.ind].wholesale
        } ,
        total(){
            if(!isNaN(this.price.cost) && !isNaN(this.price.qty)){
                return this.price.cost * this.price.qty;
            }
            return ""
        }
    }
};
</script>
