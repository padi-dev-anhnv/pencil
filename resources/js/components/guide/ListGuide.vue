<template>
  <div>
			<search-form></search-form>
			<list-result></list-result>
  </div>
</template>

<script>

import {getOffices, getWorkers, doSearch, getPpp} from '../../stores/listGuideStore'

export default {
  created(){
    getPpp();
    getOffices();
    getWorkers();
    doSearch();
  }
};
</script>