import Vue from "vue";
import Axios from "axios";
const state = Vue.observable({
    search : {
        keyword1 : '',
        advancedSearch : false,
        office : { enabled : false , value : ''},
        worker : { enabled : false , value : ''},
        creator : { enabled : false , value : ''},
        orderDate : { enabled : false , from : '', to : ''},
        shippingDate : { enabled : false , from : '', to : ''},
        receivedDate : { enabled : false , from : '', to : ''},
        advancedKey : { enabled : false , firstKey : '', secondKey : ''},        
        offices : [],
        workers : []
    },
    sort : {
        orderDate : '',
        shippingDate : '',
        receivedDate : '',
    },
    guides : [

    ],
    totalPage : 0,
    currentPage : 1,
    ppp : 10,
    deleteGuide : {
        id : 0,
        number : 0
    },
    user : {},
    disabledSearchWorker : false,
    loading : false,
   
});

export const getOffices = () => {
    axios('/guide/offices').then(result=>{
        state.search.offices = result.data
    })
}

export const getWorkers = () => {
    axios('/guide/workers').then(result=>{
        state.search.workers = result.data
    })
}

export const getPpp = () => {
    if(localStorage.getItem("ppp")){
        state.ppp = localStorage.getItem("ppp");
    }        
    else{
        localStorage.setItem("ppp", 10)
        state.ppp = 10
    }
}

export const doSearch = () => {
    let searchs = {}
    if(state.search.advancedSearch){  
        let group1 =['office', 'worker', 'creator'];
        let group2 =['orderDate', 'shippingDate', 'receivedDate'];
        group1.forEach(val => { if(state.search[val].enabled) searchs[val] = state.search[val].value })
        group2.forEach(val => { 
            if(state.search[val].enabled){ 
                if(state.search[val].from)
                    searchs[val + 'From'] = state.search[val].from ;
                if(state.search[val].to )
                    searchs[val + 'To'] = state.search[val].to 
            }
        })
        if(state.search.advancedKey.enabled)
            searchs.keyword = [state.search.advancedKey.firstKey, state.search.advancedKey.secondKey];

    }
    else{
        searchs.keyword = [state.search.keyword1];
    }

    searchs.page = state.currentPage ; 
    searchs.sort = state.sort ; 
    searchs.ppp = state.ppp  
    postSearch(searchs);

}
const postSearch = (searchs) =>{
    state.loading = true;
    axios('/guide/search', { params: searchs }).then(result => {
        state.loading = false;
        state.guides = result.data.data;
        state.totalPage = result.data.total ? result.data.last_page : 0
    })
}

export const setDelete = (id) => {
    state.deleteGuide.id = id;
    let guide = state.guides.find(guide => guide.id == id)
    state.deleteGuide.number = guide.number;
}

export const doDelete = () =>{
    axios.post('/guide/delete', { id: state.deleteGuide.id }).then(result => {
        if(result.data.success == true){
            state.currentPage = 1 ; 
            doSearch();
        }
        
    })
}

export const cloneGuide = (id) =>{
    axios.post('/guide/clone', { id: id }).then(result => {
        if(result.data.success == true){
            state.currentPage = 1 ; 
            doSearch();
        }
        
    })
}

export const setSearchWorker = () => {
    state.search.worker.enabled = true;
    state.search.worker.value = state.user.id;
    state.search.disabledSearchWorker = true;
}

export const setCurrentUser = (user) => {
    state.user = user;
}

export default state;