<template>
    <div class="edit-form">
        <form>
            <guide-block />
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
import {createGuide, setCreator} from "../../stores/guideStore";
export default {
    props : ['creator', 'id', 'action'],
    data(){
        return {

        }
    },
    methods:{
        createGuide(){
            createGuide(0)
        },
        /*
        setCreator(creator){
            setCreator(creator)
        }
        */
    },
    created(){
    //    getWorkers();
        setCreator(this.creator)
    }
}
</script>