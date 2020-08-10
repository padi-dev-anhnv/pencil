<template>
  <div>
			<search-form ></search-form>
			<list-result :editable="editable"></list-result>
      <guide-modal-delete />
  </div>
</template>

<script>

import {getOffices, getWorkers, doSearch, getPpp, setCurrentUser} from '../../stores/listGuideStore'

export default {
  props:['editable','user'],
  created(){
    setCurrentUser(this.user);
    getPpp();
    getOffices();
    getWorkers();
    doSearch();
  }
};
</script>