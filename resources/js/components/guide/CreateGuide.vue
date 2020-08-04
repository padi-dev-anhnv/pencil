<template>
    <div class="edit-form">
        <form>
            <guide-block :creator="creator" />
            <delivery-block />
            <packaging-block />
            <procedure-block />
            <product-block action="new" />
            <footer class="list-footer">
				<footer class="list-footer">
					<button class="mainbtn" @click.prevent="createGuide">保存</button>
				</footer>
			</footer>
        </form>
    </div>

</template>

<script>
import {createGuide} from "../../stores/guideStore";
export default {
    props : ['creator'],
    data(){
        return {

        }
    },
    methods:{
        createGuide(){
            createGuide(0)
        }
    },
    created(){
    //    getWorkers();
    }
}
</script>