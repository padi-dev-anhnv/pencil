<template>
  <li class="flexb">
    <div class="imgbox">
      <canvas
        ref="canvasPattern"
        width="1000"
        height="394"
        style="
                width: 100%; height: 233;"
      >Your browser does not support the HTML5 canvas tag.</canvas>
      <!-- <img :src="'/images/pen_temp-0' + inscription.pattern_type +'.svg'" :ref="'photo' + index" /> -->
    </div>
    <div class="txtbox">
      <ul v-if="pattern.length > 1">
        <li v-for="(textPt,i) in pattern" :key="i">
          <label class="box100">
            <span class="labeltxt">{{ i + 1 | circleFilter}}</span>
            <input type="text" class="w100per" v-model="pattern[i]" />
          </label>
        </li>
      </ul>
      <textarea v-else name class="h5" v-model="pattern[0]"></textarea>
      <ul class="note">
        <li>再注文の場合も、前回通りはやめて全て記入して下さい。</li>
        <li>マーク・指定文字などの場合、完全な清刷り（黒又は赤）を添付してください。</li>
      </ul>
    </div>
  </li>
</template>

<script>
import guideStore from "../../../stores/guideStore";
import constPatternPos from "../../../stores/constPatternPos";
export default {
  props: ["index"],
  data() {
    return {
      vueCanvas: null,
      imageObj: null,
    };
  },
  computed: {
    pattern() {
      return guideStore.products[this.index].inscription.pattern_text;
    },
    patternType() {
      return guideStore.products[this.index].inscription.pattern_type;
    },
  },
  filters: {
    circleFilter(val) {
      switch (val) {
        case 1:
          return "①";
        case 2:
          return "②";
        case 3:
          return "③";
        case 4:
          return "④";
        case 5:
          return "⑤";
        case 6:
          return "⑥";
      }
    },
  },
  methods: {
    drawPattern(patType, patText) {
      let patternUsed = constPatternPos.find((pat) => pat.id == patType).pattern;
      this.vueCanvas.clearRect(0, 0, 1000, 1000);
      this.vueCanvas.drawImage(this.imageObj, 0, 0, 1000, 394);

      patText.forEach( (pat,indexPat) => {
        this.vueCanvas.font = patternUsed[indexPat].font  + "pt Calibri";
        this.vueCanvas.fillStyle = "white";
        if(patternUsed[indexPat].vertical == false){
            this.vueCanvas.textAlign = "center";
            pat = pat ? pat : '';
            this.vueCanvas.fillText(pat, patternUsed[indexPat].x, patternUsed[indexPat].y); 
        }
        else{
            let str = pat;
            let lines = str ? str.split('') : '';
            let lineheight = 15;
            let a = patternUsed[indexPat].x;
            let b = patternUsed[indexPat].y;
            b = b - Math.round(lines.length * lineheight) / 2;

            for (let j = 0; j < lines.length; j++)
                this.vueCanvas.fillText(lines[j], a, b + (j * lineheight));
        }
               
      });
      
    },
    async loadPhoto() {
      return new Promise((resolve, reject) => {
        let imageObj = new Image();
        imageObj.src = "/images/pen_temp-0" + this.patternType + ".svg";
        imageObj.width = 1000;
        imageObj.height = 394;
        imageObj.onload = () => resolve(imageObj);
      });
    },
  },
  watch: {
    pattern(newVal) {
    //  this.drawPattern(this.patternType, newVal);
    },
    async pattern(newVal) {
        this.imageObj = await this.loadPhoto();
        this.drawPattern(this.patternType, this.pattern);
    },
  },
  async mounted() {
    let canvas = this.$refs["canvasPattern"];
    let context = canvas.getContext("2d");
    this.vueCanvas = context;
    this.imageObj = await this.loadPhoto();
    this.drawPattern(this.patternType, this.pattern);
  },
};
</script>