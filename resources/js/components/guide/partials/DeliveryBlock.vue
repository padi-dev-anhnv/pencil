<template>
    <ul class="edit-list">
        <li class="sec">
            <h3 class="formctttl">出荷希望日</h3>
            <div class="formctbox">
                <label class="dateset"><input type="date" v-model="delivery.shipping_date" /></label>
            </div>
        </li>
        <li class="sec">
            <h3 class="formctttl">納期日</h3>
            <div class="formctbox">
                <label class="dateset"><input type="date"  v-model="delivery.received_date" /></label>
            </div>
        </li>
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
                <select v-model="delivery.office_chk">
                    <option value="得意先直送">得意先直送</option>
                    <option value="帳合店直送">帳合店直送</option>
                    <option value="営業所入り">営業所入り</option>
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
                            ><input type="text" name="" value=""/></label
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
export default {
    data() {
        return {};
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
