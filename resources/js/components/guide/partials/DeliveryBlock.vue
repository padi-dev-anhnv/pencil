<template>
    <ul class="edit-list">
        
        <li class="sec">
            <h3 class="formctttl">送付先名</h3>
            <div class="formctbox">
                <label class="before"
                    ><input type="text" v-model="delivery.receiver" class="w50"/></label
                ><span>様</span>
            </div>
        </li>
        <li class="sec">
            <h3 class="formctttl">帳合い先CHK</h3>
            <div class="formctbox">
                <select v-model="delivery.office_chk" >
                    <option v-for="ofchk in chk" :value="ofchk.eng" :key="ofchk.eng">{{ ofchk.jap }}</option>
                </select>
            </div>
        </li>
        <li class="sec">
            <h3 class="formctttl">住所</h3>
            <div class="formctbox">
                <ul>
                    <li>
                        <label class="before"
                            ><span class="labeltxt">送り先コード</span
                            ><input  v-model="delivery.destination_code" type="text" name="" value=""/></label
                        ><span class="before"
                            ><button class="mainbtn minibtn subbtn" @click.prevent="findCustomer('destination_code', delivery.destination_code)">
                                送り先コードから自動入力
                            </button>
                            <span v-show="loadingDest"><span class="lds-dual-ring loader-dark loader-sm" ></span></span>
                            </span
                        >
                    </li>
                    <li>
                        <label class="before"
                            ><span class="labeltxt">郵便番号</span
                            ><input type="text"  v-model="delivery.postal_code"/></label
                        ><span class="before after"
                            ><button class="mainbtn minibtn subbtn"  @click.prevent="findCustomer('postal_code', delivery.postal_code)">
                                郵便番号から自動入力
                            </button>
                            <span v-show="loadingPostal"><span class="lds-dual-ring loader-dark loader-sm" ></span></span>
                            </span
                        ><span class="note"
                            >ハイフン（－）なしで入力してください</span
                        >
                    </li>
                    <li>
                        <label class="before"
                            ><span class="labeltxt">都道府県</span
                            ><select v-model="delivery.prefecture">
                                <option value="">選択してください</option>
                                <option v-for="(city,index) in listCity" :key="index" :value="city.name">{{city.name}}</option>
                            </select></label
                        >
                    </li>
                    <li>
                        <label class="before"><span class="labeltxt">市区町村</span>
						<input
                                type="text"
                                name=""
                                  v-model="delivery.city"
                                class="w30"/>
								</label
                        ><label class="before after"
                            ><span class="labeltxt">番地</span
                            ><input type="text" name=""   v-model="delivery.address" /></label
                        ><label class="before after"
                            ><span class="labeltxt">ビル名</span
                            ><input type="text" name=""   v-model="delivery.building" class="w30"
                        /></label>
                    </li>
                </ul>
            </div>
        </li>
        <li class="sec">
            <h3 class="formctttl">電話番号</h3>
            <div class="formctbox">
                <input type="text" name=""  v-model="delivery.phone" class="w30" />
            </div>
        </li>
        <li class="sec">
            <h3 class="formctttl">FAX</h3>
            <div class="formctbox">
                <input type="text" name="" v-model="delivery.fax" class="w30" />
            </div>
        </li>
    </ul>
</template>

<script>
import guideStore, { findCustomer} from "../../../stores/guideStore";
import constVar from "../../../stores/constVar";
export default {
    data() {
        return {
            chk : constVar.chk,
            loadingDest : false,
            loadingPostal : false
        };
	},
	computed:{
		delivery(){
			return guideStore.delivery;
        }, 
        listCity(){
            return guideStore.city;
        }
    }, 
    methods : {
        async findCustomer(type, code){
            if(type == 'destination_code')
                this.loadingDest = true;
            if(type == 'postal_code')
                this.loadingPostal = true;
            await findCustomer(type, code)
            this.loadingDest = this.loadingPostal = false;
        }
    }
};
</script>
