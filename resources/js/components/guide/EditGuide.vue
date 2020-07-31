<template>
    <div class="edit-form">
        <form>
            <guide-block />
            <delivery-block />
            <packaging-block />
            <procedure-block />
            <product-block action="edit" />
            <footer class="list-footer">
				<footer class="list-footer">
					<button class="mainbtn" @click.prevent="createGuide">保存</button>
				</footer>
			</footer>
        </form>
    </div>

</template>

<script>
import {listSupplier, createGuide, getGuideInfo} from "../../stores/guideStore";
export default {
    props : ['id'],
    data(){
        return {

        }
    },
    methods:{
        createGuide(){
            createGuide(this.id)
        }
    },
    created(){
        listSupplier();
        getGuideInfo(this.id);
    }
}
</script>