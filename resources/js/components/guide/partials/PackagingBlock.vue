<template>
  <ul class="edit-list">
    <li class="sec">
      <h3 class="formctttl">包装資材印刷要領</h3>
      <div class="formctbox">
        <ul>
          <li>
            <span class="before">包装材印刷</span>
            <label class="after radioset">
              <span class="radioarea">
                <input type="radio" name="print" value="0" v-model="packaging.printing" />
                <span></span>
              </span>
              <span class="labeltxt">無</span>
            </label>
            <label class="after radioset">
              <span class="radioarea">
                <input type="radio" name="print" value="1" v-model="packaging.printing" />
                <span></span>
              </span>
              <span class="labeltxt">有</span>
            </label>
          </li>
          <li>
            <span class="before">校正</span>
            <label class="after radioset">
              <span class="radioarea">
                <input type="radio" name="proofreading" value="0"  v-model="packaging.proofreading" />
                <span></span>
              </span>
              <span class="labeltxt">無</span>
            </label>
            <label class="after radioset">
              <span class="radioarea">
                <input type="radio" name="proofreading" value="1"  v-model="packaging.proofreading" />
                <span></span>
              </span>
              <span class="labeltxt">有</span>
            </label>
          </li>
          <li>
            <label class="before">
              <span class="labeltxt">包装材品名</span>
              <input type="text"   v-model="packaging.material"  class="w30" />
            </label>
          </li>
          <li>
            <label class="before">
              <span class="labeltxt">枚数</span>
              <input type="text"   v-model="packaging.number_of_page" value />
            </label>
          </li>
        </ul>
      </div>
    </li>
    <li class="sec">
      <h3 class="formctttl">天</h3>
      <div class="formctbox">
        <ul>
          <li>
            <label class="before">
              <span class="labeltxt">書体</span>
              <input type="text" name v-model="packaging.top_font" class="w30" />
            </label>
          </li>
          <li>
            <label class="before">
              <span class="labeltxt">印刷色</span>
              <input type="text" v-model="packaging.top_color" value />
            </label>
          </li>
          <li>
            <textarea v-model="packaging.top_text" placeholder="文字原稿を入力してください。" class="h3"></textarea>
          </li>
        </ul>
      </div>
    </li>
    <li class="sec">
      <h3 class="formctttl">地</h3>
      <div class="formctbox">
        <ul>
          <li>
            <label class="before">
              <span class="labeltxt">書体</span>
              <input type="text"  v-model="packaging.bottom_font" value class="w30" />
            </label>
          </li>
          <li>
            <label class="before">
              <span class="labeltxt">印刷色</span>
              <input type="text"  v-model="packaging.bottom_color" value />
            </label>
          </li>
          <li>
            <textarea  v-model="packaging.bottom_text" placeholder="文字原稿を入力してください。" class="h3"></textarea>
          </li>
        </ul>
      </div>
    </li>
    <li class="sec">
      <h2 class="formctttl">梱包説明</h2>
      <div class="formctbox">
        <textarea  v-model="packaging.description" placeholder="梱包説明を入力してください。"  class="h3"></textarea>
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
		packaging(){
			return guideStore.packaging;
		}
	}
};
</script>
