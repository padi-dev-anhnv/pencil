<template>
  <div class="product_edit sec">
    <ul class="edit-list">
      <li class="addbtn_box">
        <span class="total">
          銘入合計数量：
          <strong>{{ totalProduct }}P</strong>
        </span>
        <button @click.prevent="addProduct" class="mainbtn addbtn">追加</button>
      </li>
      <li class="sec" v-for="(product, index) in products" :key="index + '-info'">
        <h3 class="formctttl">本体銘入要領〈枝番{{index + 1}}〉</h3>
        <div class="formctbox">
          <ul>
            <li>
              <label class="before">
                <span class="labeltxt">品名</span>
                <input type="text" v-model="product.info.name" class="w30" />
              </label>
              <label class="before">
                <span class="labeltxt">色</span>
                <input type="text"  v-model="product.info.color" class="w20" />
              </label>
            </li>
            <li>
              <label class="before">
                <span class="labeltxt">銘入数量</span>
                <input type="text"  v-model="product.info.qty" />
              </label>
              <label class="before">
                <span class="labeltxt">単位</span>
                <input type="text"  v-model="product.info.unit" />
              </label>
              <label class="before dateset">
                <span class="labeltxt">出荷日</span>
                <input type="date"  v-model="product.info.shipping_date" />
              </label>
              <label class="before dateset">
                <span class="labeltxt">商品入荷予定</span>
                <input type="date"  v-model="product.info.received_date" />
              </label>
            </li>
          </ul>
        </div>
        <div class="btnbox_righttop">
          <button class="deletebtn" @click.prevent="removeProduct(index)">
            <span>削除</span>
          </button>
        </div>
      </li>

      <li class="sec" v-for="(product, index) in products" :key="index">
        <h3 class="formctttl">〈枝番{{index + 1}}〉</h3>
        <div class="formctbox">
          <ul>
            <li class="sub_ttl">{{ product.info.name | nameProductFilter }}</li>
            <li>
              <span class="before">本体銘入</span>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='product.inscription.body' value="0" />
                  <span></span>
                </span>
                <span class="labeltxt">無</span>
              </label>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='product.inscription.body' value="1" />
                  <span></span>
                </span>
                <span class="labeltxt">1面</span>
              </label>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='product.inscription.body' value="1b" />
                  <span></span>
                </span>
                <span class="labeltxt">2行1版</span>
              </label>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='product.inscription.body' value="2" />
                  <span></span>
                </span>
                <span class="labeltxt">2面</span>
              </label>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='product.inscription.body' value="3" />
                  <span></span>
                </span>
                <span class="labeltxt">3面</span>
              </label>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='product.inscription.body' value="4" />
                  <span></span>
                </span>
                <span class="labeltxt">4面</span>
              </label>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='product.inscription.body' value="5" />
                  <span></span>
                </span>
                <span class="labeltxt">5面</span>
              </label>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='product.inscription.body' value="6" />
                  <span></span>
                </span>
                <span class="labeltxt">6面</span>
              </label>
            </li>
            <li>
              <span class="before">銘入方向</span>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='product.inscription.direction' value="side" />
                  <span></span>
                </span>
                <span class="labeltxt">横</span>
              </label>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='product.inscription.direction' value="vertical" />
                  <span></span>
                </span>
                <span class="labeltxt">縦</span>
              </label>
            </li>
            <li>
              <span class="before">校正</span>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='product.inscription.proofreading' value="unnecessary" />
                  <span></span>
                </span>
                <span class="labeltxt">不要</span>
              </label>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio"  v-model='product.inscription.proofreading' value="body" />
                  <span></span>
                </span>
                <span class="labeltxt">本体校正</span>
              </label>
              <label class="after radioset">
                <span class="radioarea">
                  <input type="radio" v-model='product.inscription.proofreading' value="data" />
                  <span></span>
                </span>
                <span class="labeltxt">データ</span>
              </label>
            </li>
            <li>
              <label class="before">
                <span class="labeltxt">銘入方式</span>
                <select  v-model='product.inscription.method'>
                  <option v-for="(method,index) in listInscrMethod" :key='index' :value="method.eng">{{method.jap}}</option>
                </select>
              </label>
              <label class="before">
                <span class="labeltxt">銘入作業</span>
                <select v-model='product.inscription.work'>
                  <option v-for="(method,index) in listInscrWork" :key='index' :value="method.eng">{{method.jap}}</option>
                </select>
              </label>
              <label class="before">
                <span class="labeltxt">銘入書体</span>
                <select v-model='product.inscription.typeface'>
                  <option v-for="(method,index) in listInscrTypeFace" :key='index' :value="method.eng">{{method.jap}}</option>
                </select>
              </label>
            </li>
            <li>
              <input type="radio"  :name="'fontsize' + index" @click="disableFontSize(product.inscription)" v-model="product.inscription.font_size_enable" value="0" :id="'fontsize01' + index" class="disabled_on" />
              <input type="radio" checked  :name="'fontsize' + index"  v-model="product.inscription.font_size_enable" value="1" :id="'fontsize02' + index" class="disabled_off" />
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
                <input type="text" v-model="product.inscription.font_size" />
                <span class="labeltxt">PT</span>
              </label>
            </li>
            <li>
              <span class="before">印刷色</span>
              <label v-for="n in 3" class="before after" :key="n">
                <span class="labeltxt">{{ n }}</span>
                <input type="text" v-model="product.inscription.printing_color[n-1]" />
                <span class="labeltxt">DIC</span>
              </label>
            </li>
            <li>
              <label class="before">
                <span class="labeltxt">パターン切替</span>
                <select v-model="product.inscription.pattern_type" @change="changePattern($event,index)">
                  <option v-for="(pattern, n) in listPatternType" :key="n" :value="pattern.eng">{{ pattern.jap}}</option>
                </select>
              </label>
            </li>
            <li class="flexb">
              <div class="imgbox">
                <img :src="'/images/pen_temp-0' + product.inscription.pattern_type +'.svg'" :ref="'photo' + index" />
              </div>
              <div class="txtbox">
                <ul v-if="product.inscription.pattern_text.length > 1">
                  <li v-for="(textPt,index) in product.inscription.pattern_text" :key="index">
                    <label class="box100">
                      <span class="labeltxt">{{ index + 1 | circleFilter}}</span>
                      <input type="text" class="w100per"  v-model="product.inscription.pattern_text[index]" />
                    </label>
                  </li>
                </ul>
                <textarea v-else name="" class="h5" v-model="product.inscription.pattern_text[0]"></textarea>
                <ul class="note">
                  <li>再注文の場合も、前回通りはやめて全て記入して下さい。</li>
                  <li>マーク・指定文字などの場合、完全な清刷り（黒又は赤）を添付してください。</li>
                </ul>
              </div>
            </li>
            <li>完成図や、ロゴマーク、素材等をアップロードしてください</li>
            <li class="flexb">
              <template v-for="(file, i ) in product.inscription.files"  >
                <input style="display:none" type="file" name="fileUpload" :ref="'file' + index + i" @change="onFileChange($event,index, i)" />
                <div class="fbox3" v-if="file.id">
                  <div class="uploadimg">
                    <img v-if="file.thumbnail" :src="file.thumbnail" width="566" height="573" />
                    <button class="deletebtn" @click.prevent="deleteFile(index, i)">
                      <span>削除</span>
                    </button>
                  </div>
                </div>
                <div class="fbox3" v-else>
                  <div class="selectfile">
                    <label class="mainbtn ulbtn" @click="uploadFile(index,i)">ファイルを選択してください</label>
                  </div>
                </div>
              </template>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import guideStore , { addProduct } from "../../../stores/guideStore";
import { createFileProduct } from "../../../stores/fileStore";
import constVar from "../../../stores/constVar";
export default {
  props : ['action'],
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
      if(value.trim() == "")
        return constVar.noProductName;
      else
        return value;
    },
    circleFilter(val){
      switch(val){
         case 1 : 
          return '①';
        case 2 : 
          return '②';
        case 3 : 
          return '③';
        case 4 : 
          return '④';
        case 5 : 
          return '⑤';
        case 6 : 
          return '⑥';
      }
       
    }
  },
  computed: {
    products() {
      return guideStore.products;
    },
    productInit() {
      return guideStore.productInit;
    },
    fontSizeExist(product){
      return product.inscription.font_size;
    },
    totalProduct(){
      return this.products.length;
    }
  },
  methods : {
    addProduct(){
      addProduct();
    },
    disableFontSize(insc){
      insc.font_size = ''
    },
    removeProduct(index){
      this.products.splice(index,1)
    },
    changePattern(event, index){
      this.products[index].inscription.pattern_text = [];
      let indexPattern = 0;
      let thisPattern = constVar.pattern_type.find((type, index) => {  if(type.eng == event.target.value){ indexPattern = index + 1; return true ; }  } );
      for(let i = 0; i < thisPattern.total; i++)
        this.products[index].inscription.pattern_text.push('');
    //  this.$refs['photo' + index][0].src="/images/pen_temp-0" + indexPattern   + ".svg"
    },
    uploadFile(index,i){
      let fileName = 'file' + index + i
      this.$refs[fileName][0].click();
    },
    async onFileChange(e,index,i){
      // index : order of product
      // i : order of file in product
      let file = e.target.files[0];
      let fileUploaded = await createFileProduct(file);
      Vue.set(this.products[index].inscription.files, i, fileUploaded.data)
    },
    deleteFile(index, i){
      Vue.set(this.products[index].inscription.files, i, {})
    }
  },
  created(){
    if(this.action == 'new')
       addProduct();
  }
};
</script>
