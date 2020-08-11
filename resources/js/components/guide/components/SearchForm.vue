<template>
  <div>
    <div id="top_search">
      <form>
        <input type="text" placeholder="キーワード検索" v-model="search.keyword1" required />
        <input @click.prevent="doSearch(false)" type="submit" value class="searchbtn" />
      </form>
      <label for="search_plus" class="btn_plus"></label>
    </div>
    <!-- ページトップ検索窓 -->

    <!-- 検索条件追加 -->
    <input type="checkbox" id="search_plus" />
    <label for="search_plus" class="btn_minus"></label>
    <div id="top_search_plus" class="search-form">
      <form>
        <ul class="form-list">
          <li class="fli">
            <ul class="checklist">
              <li>
                <label class="checkset">
                  <input type="checkbox"  v-model="search.office.enabled" name="search_ctt" />
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="49.85"
                    height="33.93"
                    viewBox="0 0 49.85 33.93"
                    class="icon_check"
                  >
                    <polyline class="cls-1" points="3.08 10.81 21.13 27.73 46.74 3.25" />
                  </svg>
                  <span>営業所</span>
                </label>
                <select v-model="search.office.value">
                  <option value>選択してください</option>
                  <option v-for="office in search.offices" :value="office.id" :key="office.id">{{ office.name }}</option>
                </select>
              </li>
              <li>
                <label class="checkset">
                  <input type="checkbox" v-model="search.worker.enabled" name="search_ctt" />
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="49.85"
                    height="33.93"
                    viewBox="0 0 49.85 33.93"
                    class="icon_check"
                  >
                    <polyline class="cls-1" points="3.08 10.81 21.13 27.73 46.74 3.25" />
                  </svg>
                  <span>業者</span>
                </label>
                <select  v-model="search.worker.value" :disabled="disabledSearchWorker">
                  <option value>選択してください</option>
                  <option v-for="worker in search.workers"  :value="worker.id" :key="worker.id">{{ worker.name}}</option>
                </select>
              </li>
              <li>
                <label class="checkset">
                  <input type="checkbox" name="search_ctt"  v-model="search.creator.enabled" />
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="49.85"
                    height="33.93"
                    viewBox="0 0 49.85 33.93"
                    class="icon_check"
                  >
                    <polyline class="cls-1" points="3.08 10.81 21.13 27.73 46.74 3.25" />
                  </svg>
                  <span>担当者</span>
                </label>
                <input v-model="search.creator.value" type="text" class="w15" />
              </li>
            </ul>
          </li>
          <li class="fli">
            <ul class="checklist">
              <li>
                <label class="checkset">
                  <input type="checkbox" v-model="search.orderDate.enabled" name="search_ctt" />
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="49.85"
                    height="33.93"
                    viewBox="0 0 49.85 33.93"
                    class="icon_check"
                  >
                    <polyline class="cls-1" points="3.08 10.81 21.13 27.73 46.74 3.25" />
                  </svg>
                  <span>発注日</span>
                </label>
                <label class="dateset">
                  <input type="date"  v-model="search.orderDate.from" />
                </label>
                <span class="datetxt">～</span>
                <label class="dateset">
                  <input type="date"  v-model="search.orderDate.to" />
                </label>
              </li>
            </ul>
          </li>
          <li class="fli">
            <ul class="checklist">
              <li>
                <label class="checkset">
                  <input type="checkbox" name="search_ctt"  v-model="search.shippingDate.enabled" />
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="49.85"
                    height="33.93"
                    viewBox="0 0 49.85 33.93"
                    class="icon_check"
                  >
                    <polyline class="cls-1" points="3.08 10.81 21.13 27.73 46.74 3.25" />
                  </svg>
                  <span>出荷予定日</span>
                </label>
                <label class="dateset">
                  <input type="date"  v-model="search.shippingDate.from" />
                </label>
                <span class="datetxt">～</span>
                <label class="dateset">
                  <input type="date"  v-model="search.shippingDate.to" />
                </label>
              </li>
              <li>
                <label class="checkset">
                  <input type="checkbox" name="search_ctt"   v-model="search.receivedDate.enabled" />
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="49.85"
                    height="33.93"
                    viewBox="0 0 49.85 33.93"
                    class="icon_check"
                  >
                    <polyline class="cls-1" points="3.08 10.81 21.13 27.73 46.74 3.25" />
                  </svg>
                  <span>納品予定日</span>
                </label>
                <label class="dateset">
                  <input type="date"  v-model="search.receivedDate.from" />
                </label>
                <span class="datetxt">～</span>
                <label class="dateset">
                  <input type="date" v-model="search.receivedDate.to" />
                </label>
              </li>
            </ul>
          </li>
          <li class="fli">
            <ul class="checklist">
              <li>
                <label class="checkset">
                  <input type="checkbox" name="search_ctt"  v-model="search.advancedKey.enabled" />
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="49.85"
                    height="33.93"
                    viewBox="0 0 49.85 33.93"
                    class="icon_check"
                  >
                    <polyline class="cls-1" points="3.08 10.81 21.13 27.73 46.74 3.25" />
                  </svg>
                  <span>キーワード</span>
                </label>
                <input type="text" class="w15"  v-model="search.advancedKey.firstKey" />
                <span class="texttxt">AND</span>
                <input type="text" class="w15" v-model="search.advancedKey.secondKey" />
              </li>
            </ul>
          </li>
        </ul>
        <input @click.prevent="doSearch(true)" type="submit" value="検索" class="mainbtn" />
      </form>
    </div>
  </div>
</template>

<script>

import listGuideStore, { doSearch, setSearchWorker } from '../../../stores/listGuideStore'

export default {
    props : [],
    data(){
        return {

        }
    },
    computed : {
        search(){
            return listGuideStore.search;
        },
        disabledSearchWorker(){
          return this.search.disabledSearchWorker;
        },
        role(){
          return listGuideStore.user.role
        }
    },
    methods : {
      doSearch(advancedSearch){
        this.search.advancedSearch = advancedSearch;
        doSearch()
      }
    },
    created(){
      if(this.role.type == "worker"){
        setSearchWorker()
      }
    }
}
</script>