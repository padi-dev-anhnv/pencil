<template>
    <div class="edit-form">
        <form>
            <guide-block :action='action' />
            <delivery-block />
            <packaging-block />
            <procedure-block />
            <product-block :action="action" />
            <price-block />
            <!-- <file-modal /> -->
            <footer class="list-footer" v-show="editBtn">
				<footer class="list-footer">
                    <span class="lds-dual-ring loader-light" v-if="loading"></span>
					<span class="mainbtn" @click.prevent="createGuide" v-else>
                        <span>保存</span>
                    </span>
				</footer>
			</footer>
        </form>
    </div>

</template>

<script>
import guideStore, {createGuide, getGuideInfo, setCreator, setAction, setCloneId, setDateNo} from "../../stores/guideStore";
export default {
    props : ['id', 'action', 'creator', 'clone_id', 'user'],
    data(){
        return {
            groupInput : null,
            pressShift : false
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
                
        },
        loading(){
            return guideStore.loading
        }
    },
    methods:{
        createGuide(){
            createGuide(this.id)
        },
        indexInClass(node) {
            let className = node.className;
            let num = 0;
            for (let i = 0; i <this.groupInput.length; i++) {
                if (this.groupInput[i] === node) {
                return num + 1;
                }
                num++;
            }
            return -1;
        },
        pushClass(){
            let allInput = document.querySelectorAll("input[type=text], select, input[type=date], textarea");
            for(let i = 0 ; i < allInput.length; i++){
                if(! allInput[i].disabled){
                    let currentClass = allInput[i].className;
                    allInput[i].className = currentClass + ' guide-input'
                }
                    
            };
        },
        addKeyListener()
        {
            window.addEventListener('keydown', (e) => {
                if (e.key == 'Shift') {
                    this.pressShift = true;
                }
            })
            window.addEventListener('keyup', (e) => {
                if (e.key == 'Shift') {
                    this.pressShift = false;
                }
            })

            window.addEventListener('keydown', (e) => {          
            
                if (e.key == 'Enter') {
                    let currentTagName = e.target.tagName;
                    if(['INPUT', 'SELECT', 'TEXTAREA'].includes(currentTagName))
                    {
                        if(currentTagName == 'TEXTAREA' && this.pressShift == true)
                            return false;
                        let nextInput = this.groupInput[this.indexInClass(e.target)];
                        nextInput.focus();
                    }
                }

            });
        }
    },
    async mounted(){
        setAction(this.action);
        if(['edit', 'dupplicate'].includes(this.action))
            await getGuideInfo(this.id);
        if(['new', 'dupplicate'].includes(this.action))
            setCreator(this.creator)
        if(['dupplicate'].includes(this.action)){
            setCloneId(this.clone_id)
            setDateNo();
        }
        this.pushClass();
        this.groupInput = document.getElementsByClassName('guide-input');
        this.addKeyListener();      
            
    }
}
</script>