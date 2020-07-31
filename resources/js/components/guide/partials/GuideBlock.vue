<template>
    <ul class="edit-list">
        <li class="sec">
            <h3 class="formctttl">作成日時</h3>
            <div class="formctbox">
                <label class="dateset"
                    ><input type="date" v-model="guide.created_at"
                /></label>
            </div>
        </li>
        <li class="sec">
            <h3 class="formctttl">前回</h3>
            <div class="formctbox">
                <select v-model="guide.last_exist">
                    <option value="0" selected>無</option>
                    <option value="1">有</option>
                </select>
            </div>
        </li>
        <li class="sec">
            <h3 class="formctttl">前回発注日</h3>
            <div class="formctbox">
                <label class="dateset"
                    ><input type="date" v-model="guide.last_date"
                /></label>
            </div>
        </li>
        <li class="sec">
            <h3 class="formctttl">前回指図書No.</h3>
            <div class="formctbox">
                <input type="text" name="" v-model="guide.last_numb" />
            </div>
        </li>
        <li class="sec">
            <h3 class="formctttl">件名</h3>
            <div class="formctbox">
                <input
                    type="text"
                    v-model="guide.title"
                    name=""
                    value=""
                    class="w50"
                />
            </div>
        </li>
        <li class="sec">
            <h3 class="formctttl">営業所名</h3>
            <div class="formctbox">
                <input type="text" name="" v-model="guide.office" class="w15" />
            </div>
        </li>
        <li class="sec">
            <h3 class="formctttl">担当者</h3>
            <div class="formctbox">
                <input type="text" name="" v-model="guide.assign" class="w15" />
            </div>
        </li>
        <li class="sec">
            <h3 class="formctttl">指図書No.</h3>
            <div class="formctbox">
                <input type="text" v-model="guide.number" value="" />
            </div>
        </li>
        <li class="sec">
            <h3 class="formctttl">業者選択</h3>
            <div class="formctbox">
                <select v-model="guide.supplier_id">
                    <option value="">選択してください</option>
                    <option
                        v-for="sup in suppliers"
                        :value="sup.id"
                        :key="sup.id"
                        >{{ sup.name }}</option
                    >
                </select>
            </div>
        </li>
        <li class="sec">
            <h3 class="formctttl">店コード</h3>
            <div class="formctbox">
                <input type="text" v-model="guide.store_code" />
            </div>
        </li>

        <li class="sec">
            <h3 class="formctttl">得意先名</h3>
            <div class="formctbox">
                <input type="text" name=""  v-model="guide.customer_name" class="w50" />
            </div>
        </li>
        <li class="sec">
            <h3 class="formctttl">ご担当者様</h3>
            <div class="formctbox">
                <input type="text" name=""   v-model="guide.curator" class="w15" />
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
    computed: {
        guide() {
            return guideStore.guide;
        },
        suppliers() {
            return guideStore.suppliers;
        }
    }
};
</script>
