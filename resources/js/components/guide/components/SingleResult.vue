<template>
    <li :class="{ done : done}">
        <ul>
            <li>{{ guide.created_at }}</li>
            <li>{{ guide.supplier.name }}</li>
            <li>{{ guide.number }}</li>
            <li>{{ guide.customer_name }}</li>
            <li>{{ guide.title }}</li>
            <li v-if="guide.office">{{ guide.office.name }}</li>
            <li v-else></li>
            <li>{{ guide.creator.name }}</li>
            <li>
                <template v-if="guide.delivery">
                    {{ guide.delivery.destination_code }}
                </template>
            </li>
            <li>{{ receiver }}</li>
            <li>{{ chk }}</li>
            <li>{{ guide.shipping_date }}</li>
            <li>{{ guide.received_date }}</li>
            <li>
                <template v-if="guide.first_product">
                    {{ guide.first_product[0].name }}
                </template>
            </li>
            <li>
                <a :href="'/guide/'+guide.key_code+'/show/has-price'" target="_blank">PDF(料金有）</a>
                <br />
                <a :href="'/guide/'+guide.key_code+'/show/no-price'" target="_blank">PDF(料金無）</a>
            </li>
            <li v-if="editable == 1">
                <button title="編集"
                    :onclick="'location.href=\'/guide/' + guide.id + '/edit\''"
                    :class="canEdit ? 'editbtn' :  'viewbtn'"
                >
                    <span>編集</span>
                </button>
                <button title="書コピー"
                    :onclick="
                        'location.href=\'/guide/' + guide.id + '/dupplicate\''
                    "
                    class="copybtn"
                >
                    <span>複製</span>
                </button>
                <label title="削除" v-show="canEdit"
                    for="popup_delete"
                    class="deletebtn"
                    @click="setDelete(guide.id)"
                >
                    <span>削除</span>
                </label>
            </li>
            <li v-else>
                <button
                    :onclick="'location.href=\'/guide/' + guide.id + '/edit\''"
                    class="viewbtn"
                >
                    <span>閲覧</span>
                </button>
            </li>
        </ul>
    </li>
</template>

<script>
import listGuideStore, {
    setDelete
} from "../../../stores/listGuideStore";
import constVar from "../../../stores/constVar";
export default {
    props : ['guide', 'editable'],
    computed : {
        user(){
            return listGuideStore.user
        },
        canEdit(){
            if(this.guide.user_id == this.user.id || this.user.role.type == 'admin'){
                return true;
            }
            return false;
        },
        receiver(){
            if(!this.guide.delivery)
                return '';
            return this.guide.delivery.receiver;
        },
        chk(){
            //return this.guide.delivery.office_chk == 1 ? this.guide.delivery.receiver : this.guide.delivery.office_chk;
            if(!this.guide.delivery)
                return '';
            if(this.guide.delivery.office_chk == 1)
                return this.guide.delivery.receiver;
            let officeChk = constVar.chk.find(chk => chk.eng == this.guide.delivery.office_chk)
            return officeChk.jap;
           
        },
        done(){
            if(this.guide.received_date == null)
                return false;
            let received_date = new Date(this.guide.received_date);
            if(received_date < new Date())
                return true;
            return false;
        }
    },
    methods : {        
        setDelete(id) {
            setDelete(id);
        },
    }
};
</script>
