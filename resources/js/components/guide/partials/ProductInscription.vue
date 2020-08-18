<template>
  <li class="sec">
        <h3 class="formctttl">〈枝番{{index + 1}}〉</h3>
        <div class="formctbox">
          <ul>
            <li class="sub_ttl">{{ productName | nameProductFilter }}</li>
            <li>
              <span class="before">本体銘入</span>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='inscription.body' value="0" />
                  <span></span>
                </span>
                <span class="labeltxt">無</span>
              </label>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='inscription.body' value="1" />
                  <span></span>
                </span>
                <span class="labeltxt">1面</span>
              </label>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='inscription.body' value="1b" />
                  <span></span>
                </span>
                <span class="labeltxt">2行1版</span>
              </label>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='inscription.body' value="2" />
                  <span></span>
                </span>
                <span class="labeltxt">2面</span>
              </label>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='inscription.body' value="3" />
                  <span></span>
                </span>
                <span class="labeltxt">3面</span>
              </label>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='inscription.body' value="4" />
                  <span></span>
                </span>
                <span class="labeltxt">4面</span>
              </label>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='inscription.body' value="5" />
                  <span></span>
                </span>
                <span class="labeltxt">5面</span>
              </label>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='inscription.body' value="6" />
                  <span></span>
                </span>
                <span class="labeltxt">6面</span>
              </label>
            </li>
            <li>
              <span class="before">銘入方向</span>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='inscription.direction' value="side" />
                  <span></span>
                </span>
                <span class="labeltxt">横</span>
              </label>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='inscription.direction' value="vertical" />
                  <span></span>
                </span>
                <span class="labeltxt">縦</span>
              </label>
            </li>
            <li>
              <span class="before">校正</span>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='inscription.proofreading' value="unnecessary" />
                  <span></span>
                </span>
                <span class="labeltxt">不要</span>
              </label>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio"  v-model='inscription.proofreading' value="body" />
                  <span></span>
                </span>
                <span class="labeltxt">本体校正</span>
              </label>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='inscription.proofreading' value="data" />
                  <span></span>
                </span>
                <span class="labeltxt">データ</span>
              </label>
            </li>
            <li>
              <label class="before">
                <span class="labeltxt">銘入方式</span>
                <select  v-model='inscription.method'>                  
                  <option value="">選択してください</option>
                  <option v-for="(method,index) in listInscrMethod" :key='index' :value="method.eng">{{method.jap}}</option>
                </select>
              </label>
              <label class="before">
                <span class="labeltxt">銘入作業</span>
                <select v-model='inscription.work'>                  
                  <option value="">選択してください</option>
                  <option v-for="(method,index) in listInscrWork" :key='index' :value="method.eng">{{method.jap}}</option>
                </select>
              </label>
              <label class="before">
                <span class="labeltxt">銘入書体</span>
                <select v-model='inscription.typeface'>                  
                  <option value="">選択してください</option>
                  <option v-for="(method,index) in listInscrTypeFace" :key='index' :value="method.eng">{{method.jap}}</option>
                </select>
              </label>
            </li>
            <li>
              <input type="radio"  :name="'fontsize' + index" @click="disableFontSize(inscription)" v-model="inscription.font_size_enable" value="0" :id="'fontsize01' + index" class="disabled_on" />
              <input type="radio" checked  :name="'fontsize' + index"  v-model="inscription.font_size_enable" value="1" :id="'fontsize02' + index" class="disabled_off" />
              <span class="before">文字サイズ</span>
              <label :for="'fontsize01' + index" class="after radioset disabled_trgr_on">
                <span class="radioarea disabled_trgr_on">
                  <span></span>
                </span>
                <span class="labeltxt">一任</span>
              </label>
              <label :for="'fontsize02' + index" class="after radioset disabled_trgr_off">
                <span class="radioarea disabled_trgr_off">
                  <span></span>
                </span>
                <span class="labeltxt">指定有</span>
              </label>
              <label class="after disabled_tgt">
                <input type="text" v-model="inscription.font_size" />
                <span class="labeltxt">PT</span>
              </label>
            </li>
            <li>
              <span class="before">印刷色</span>
              <label v-for="n in 3" class="before after" :key="n">
                <span class="labeltxt">{{ n }}</span>
                <input type="text" v-model="inscription.printing_color[n-1]" />
                <span class="labeltxt">DIC</span>
              </label>
            </li>
            <li>
              <label class="before">
                <span class="labeltxt">パターン切替</span>
                <select v-model="inscription.pattern_type" @change="changePattern($event,index)">
                  <option v-for="(pattern, n) in listPatternType" :key="n" :value="pattern.eng">{{ pattern.jap}}</option>
                </select>
              </label>
            </li>
            <pattern-guide :inscription="inscription" :index="index" />
            <li>完成図や、ロゴマーク、素材等をアップロードしてください</li>
              <li class="flexb">
            <file-guide class="fbox3" v-for="(file, i ) in inscription.files" :key="i" :index="index" :i="i" />
            </li>
          </ul>
        </div>
      </li>
</template>

<script>
import guideStore from "../../../stores/guideStore";
import { createFileProduct } from "../../../stores/fileStore";
import constVar from "../../../stores/constVar";
export default {
  props : ['indexv'],
  data() {
    return {
      listPatternType : constVar.pattern_type,
      listInscrMethod : constVar.insc_method,
      listInscrWork : constVar.insc_work,
      listInscrTypeFace : constVar.insc_typeface,
    };
  },
  filters:{
    nameProductFilter(value){
      if(value == null) return constVar.noProductName;
      if(value.trim() == "")
        return constVar.noProductName;
      else
        return value;
    },
    
  },
  computed : {
    inscription(){
      return guideStore.products[this.index].inscription
    },
    productName(){
      return guideStore.products[this.index].info.name
    },
    selectedFontSize(){
      if(this.inscription.font_size)
        return 1;
      else
        return 0;
    },
    index(){
      return this.indexv - 1;
    }
  },
  methods : {
    disableFontSize(insc){
      insc.font_size = ''
    },
    changePattern(event, index){
      this.inscription.pattern_text = [];
      let indexPattern = 0;
      let thisPattern = constVar.pattern_type.find((type, index) => {  if(type.eng == event.target.value){ indexPattern = index + 1; return true ; }  } );
      for(let i = 0; i < thisPattern.total; i++)
        this.inscription.pattern_text.push('');
    },
    
  },
};
</script>