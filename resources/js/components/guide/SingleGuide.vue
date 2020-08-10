<template>
    <div class="edit-form">
        <form>
            <guide-block />
            <delivery-block />
            <packaging-block />
            <procedure-block />
            <product-block :action="action" />
            <price-block />
            <footer class="list-footer">
				<footer class="list-footer">
					<button class="mainbtn" @click.prevent="createGuide">保存</button>
				</footer>
			</footer>
        </form>
    </div>

</template>

<script>
import {createGuide, getGuideInfo, setCreator, setAction, setCloneId} from "../../stores/guideStore";
export default {
    props : ['id', 'action', 'creator', 'clone_id'],
    data(){
        return {

        }
    },
    methods:{
        createGuide(){
            createGuide(this.id)
        }
    },
    async created(){
        setAction(this.action);
        if(['edit', 'dupplicate'].includes(this.action))
            await getGuideInfo(this.id);
        if(['new', 'dupplicate'].includes(this.action))
            setCreator(this.creator)
        if(['dupplicate'].includes(this.action))
            setCloneId(this.clone_id)
            
    }
}
</script>