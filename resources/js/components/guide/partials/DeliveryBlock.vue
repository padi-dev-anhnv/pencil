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
                            ><input  v-model="delivery.code" type="text" name="" value=""/></label
                        ><span class="before"
                            ><button class="mainbtn minibtn subbtn">
                                送り先コードから自動入力
                            </button></span
                        >
                    </li>
                    <li>
                        <label class="before"
                            ><span class="labeltxt">郵便番号</span
                            ><input type="text" name="" value=""/></label
                        ><span class="before after"
                            ><button class="mainbtn minibtn subbtn">
                                郵便番号から自動入力
                            </button></span
                        ><span class="note"
                            >ハイフン（－）なしで入力してください</span
                        >
                    </li>
                    <li>
                        <label class="before"
                            ><span class="labeltxt">都道府県</span
                            ><select v-model="delivery.district">
                                <option v-for="(city,index) in listCity" :key="index" :value="city.name_en">{{city.name}}</option>
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
import guideStore from "../../../stores/guideStore";
import constVar from "../../../stores/constVar";
export default {
    data() {
        return {
            chk : constVar.chk
        };
	},
	computed:{
		delivery(){
			return guideStore.delivery;
        }, 
        listCity(){
            return guideStore.city;
        }
	}
};
</script>
