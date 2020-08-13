<template>
    <div class="edit-form">
        <form>
            <guide-block />
            <delivery-block />
            <packaging-block />
            <procedure-block />
            <product-block :action="action" />
            <price-block />
            <!-- <file-modal /> -->
            <footer class="list-footer" v-show="editBtn">
				<footer class="list-footer">
					<button class="mainbtn" @click.prevent="createGuide">保存</button>
				</footer>
			</footer>
        </form>
    </div>

</template>

<script>
import guideStore, {createGuide, getGuideInfo, setCreator, setAction, setCloneId} from "../../stores/guideStore";
export default {
    props : ['id', 'action', 'creator', 'clone_id', 'user'],
    data(){
        return {

        }
    },
    computed: {
        creatorGuide(){
            return guideStore.creator;
        }, 
        editBtn(){
            if(this.action == 'edit' && this.user.id != this.creatorGuide.id && this.user.role.type != 'admin')
                return false;
            return true;
                
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