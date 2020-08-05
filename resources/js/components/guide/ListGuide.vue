<template>
  <div>
			<search-form></search-form>
			<list-result :editable="editable"></list-result>
      <guide-modal-delete />
  </div>
</template>

<script>

import {getOffices, getWorkers, doSearch, getPpp} from '../../stores/listGuideStore'

export default {
  props:['editable'],
  created(){
    getPpp();
    getOffices();
    getWorkers();
    doSearch();
  }
};
</script>