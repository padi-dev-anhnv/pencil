<template>
  <ul class="edit-list">
    <li class="sec">
      <h2 class="formctttl">作業要領</h2>
      <div class="formctbox">
        <ul>
          <li>
            <span class="before">作業</span>
            <input
              v-model="workExist"
              type="radio"
              name="task"
              value="0"
              id="task01"
              class="disabled_on"
            />
            <input
              v-model="workExist"
              type="radio"
              name="task"
              value="1"
              id="task02"
              class="disabled_off"
            />
            <label for="task01" class="after radioset disabled_trgr_on">
              <span class="radioarea">
                <span></span>
              </span>
              <span class="labeltxt">無</span>
            </label>
            <label for="task02" class="after radioset disabled_trgr_off">
              <span class="radioarea">
                <span></span>
              </span>
              <span class="labeltxt">有</span>
            </label>
            <label class="after radioset disabled_tgt">
              <span class="radioarea">
                <input v-model="procedure.work" type="radio" name="task_dtl" value="noStdReturn" />
                <span></span>
              </span>
              <span class="labeltxt">規格戻し無し</span>
            </label>
            <label class="after radioset disabled_tgt">
              <span class="radioarea">
                <input v-model="procedure.work" type="radio" name="task_dtl" value="hasStdReturn" />
                <span></span>
              </span>
              <span class="labeltxt">規格戻し有り</span>
            </label>
            <label class="after radioset disabled_tgt">
              <span class="radioarea">
                <input v-model="procedure.work" type="radio" name="task_dtl" value="noShipment" />
                <span></span>
              </span>
              <span class="labeltxt">同送品無し</span>
            </label>
            <label class="after radioset disabled_tgt">
              <span class="radioarea">
                <input v-model="procedure.work" type="radio" name="task_dtl" value="sameDelivery" />
                <span></span>
              </span>
              <span class="labeltxt">同送品有り</span>
            </label>
          </li>
          <li v-for="n in 6" :key="n">
            <label class="before">
              <span class="labeltxt">包装材品名</span>
              <input type="text" name v-model="procedure.materialArray[n-1].name" class="w30" />
            </label>
            <label class="before">
              <span class="labeltxt">枚数</span>
              <input type="text" name v-model="procedure.materialArray[n-1].numb" />
            </label>
          </li>

          <li>
            <input
              v-model="baggingExist"
              type="radio"
              name="bag"
              value="0"
              id="bag01"
              class="disabled_on"
            />
            <input
              v-model="baggingExist"
              type="radio"
              name="bag"
              value="1"
              id="bag02"
              class="disabled_off"
            />
            <span class="before">袋詰め</span>
            <label for="bag01" class="after radioset disabled_trgr_on">
              <span class="radioarea disabled_trgr_on">
                <span></span>
              </span>
              <span class="labeltxt">無</span>
            </label>
            <label for="bag02" class="after radioset disabled_trgr_off">
              <span class="radioarea disabled_trgr_off">
                <span></span>
              </span>
              <span class="labeltxt">有</span>
            </label>
            <label class="after disabled_tgt">
              <input type="text" v-model="procedure.bagging_content" />
              <span class="labeltxt">本</span>
            </label>
            <span class="before disabled_tgt">/ 止め方</span>
            <label class="after radioset disabled_tgt">
              <span class="radioarea">
                <input type="radio" name="bag_dtl" v-model="procedure.bagging" value="stapler" />
                <span></span>
              </span>
              <span class="labeltxt">ホッチキス</span>
            </label>
            <label class="after radioset disabled_tgt">
              <span class="radioarea">
                <input type="radio" name="bag_dtl" v-model="procedure.bagging" value="sellotape" />
                <span></span>
              </span>
              <span class="labeltxt">セロテープ</span>
            </label>
          </li>
          <li>
            <span class="before">箱詰め</span>
            <label class="after radioset">
              <span class="radioarea">
                <input v-model="procedure.box" type="radio" name="box" value="0" />
                <span></span>
              </span>
              <span class="labeltxt">無</span>
            </label>
            <label class="after radioset">
              <span class="radioarea">
                <input v-model="procedure.box" type="radio" name="box" value="1" />
                <span></span>
              </span>
              <span class="labeltxt">有</span>
            </label>
            <label class="after">
              <input type="text" name v-model="procedure.box_content" />
            </label>
          </li>
          <li>
            <span class="before">包装</span>
            <label class="after radioset">
              <span class="radioarea">
                <input v-model="procedure.packaging" type="radio" name="package" value="0" />
                <span></span>
              </span>
              <span class="labeltxt">無</span>
            </label>
            <label class="after radioset">
              <span class="radioarea">
                <input v-model="procedure.packaging" type="radio" name="package" value="1" />
                <span></span>
              </span>
              <span class="labeltxt">有</span>
            </label>
          </li>
          <li>
            <input
              v-model="gimmickExist"
              type="radio"
              name="gift"
              value="0"
              id="gift01"
              class="disabled_on"
            />
            <input
              v-model="gimmickExist"
              type="radio"
              name="gift"
              value="1"
              id="gift02"
              class="disabled_off"
            />
            <span class="before">のし掛け</span>
            <label for="gift01" class="after radioset disabled_trgr_on">
              <span class="radioarea">
                <span></span>
              </span>
              <span class="labeltxt">無</span>
            </label>
            <label for="gift02" class="after radioset disabled_trgr_off">
              <span class="radioarea">
                <span></span>
              </span>
              <span class="labeltxt">有</span>
            </label>
            <label class="after radioset disabled_tgt">
              <span class="radioarea">
                <input v-model="procedure.gimmick" type="radio" name="gift_dtl" value="inside" />
                <span></span>
              </span>
              <span class="labeltxt">内のし</span>
            </label>
            <label class="after radioset disabled_tgt">
              <span class="radioarea">
                <input v-model="procedure.gimmick" type="radio" name="gift_dtl" value="outside" />
                <span></span>
              </span>
              <span class="labeltxt">外のし</span>
            </label>
            <label class="after radioset disabled_tgt">
              <span class="radioarea">
                <input v-model="procedure.gimmick" type="radio" name="gift_dtl" value="onlyGimmick" />
                <span></span>
              </span>
              <span class="labeltxt">のし掛けのみ</span>
            </label>
          </li>
          <li>
            <span class="before">先出し出荷</span>
            <label class="after radioset">
              <span class="radioarea">
                <input v-model="procedure.advance_shipment" type="radio" name="pre" value="0" />
                <span></span>
              </span>
              <span class="labeltxt">可</span>
            </label>
            <label class="after radioset">
              <span class="radioarea">
                <input v-model="procedure.advance_shipment" type="radio" name="pre" value="1" />
                <span></span>
              </span>
              <span class="labeltxt">不可</span>
            </label>
          </li>
        </ul>
      </div>
    </li>
    <li class="sec">
      <h2 class="formctttl">注意事項等</h2>
      <div class="formctbox">
        <textarea
          v-model="procedure.note"
          placeholder="上に記入できない包装領域・注意事項を記入してください "
          
          class="h5"
        ></textarea>
      </div>
    </li>
  </ul>
</template>

<script>
import guideStore from "../../../stores/guideStore";
const procedureOption = {
  work: {
    noStdReturn: "規格戻し無し",
    hasStdReturn: "規格戻し有り",
    noShipment: "同送品無し",
    sameDelivery: "同送品有り",
  },
  bagging: {
    stapler: "ホッチキス",
    sellotape: "セロテープ",
  },
  gimmick: {
    inside: "内のし",
    outside: "外のし",
    onlyGimmick: "のし掛けのみ",
  },
};
export default {
  data() {
    return {};
  },
  computed: {
    procedure() {
      return guideStore.procedure;
    },
    workExist: {
      get: function () {
        if (this.procedure.work != 0) return 1;
        else return 0;
      },
      set: function (val) {
        if (val == 0) this.procedure.work = 0;
        else this.procedure.work = "noStdReturn";
      },
    },
    baggingExist: {
      get: function () {
        if (this.procedure.bagging != 0) return 1;
        else return 0;
      },
      set: function (val) {
        if (val == 0) {
          this.procedure.bagging = 0;
          this.procedure.bagging_content = "";
        } else {
          this.procedure.bagging = "stapler";
        }
      },
    },
    boxExist: {
      get: function () {
        if (this.procedure.box != 0) return 1;
        else return 0;
      },
      set: function (val) {
        if (val == 0) {
          this.procedure.box_content = "";
        }
      },
    },
    gimmickExist: {
      get: function () {
        if (this.procedure.gimmick != 0) return 1;
        else return 0;
      },
      set: function (val) {
        if (val == 0) this.procedure.gimmick = 0;
        else this.procedure.gimmick = "inside";
      },
    },
  },
  watch: {
    "procedure.materialArray": {
      handler: function (after, before) {
        if(after){
          let newMaterial = after.filter((mat) => mat.name && mat.numb);
          this.procedure.material = newMaterial;
        }
        
      },
      deep: true,
      immediate: true
    },
  },
  methods: {
    disableWork() {
      this.procedure.work = 0;
    },
  }
};
</script>