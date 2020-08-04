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
        orderDate : 'desc',
        shippingDate : 'desc',
        receivedDate : 'desc',
    },
    guides : [

    ],
    totalPage : 0,
    currentPage : 1,
    ppp : 10
   
});

export const getOffices = () => {
    axios('/user/offices').then(result=>{
        state.search.offices = result.data
    })
}

export const getWorkers = () => {
    axios('/user/workers').then(result=>{
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
    searchs.page = state.currentPage ; 
    searchs.sort = state.sort ; 
    searchs.ppp = state.ppp
    axios('/guide/search', { params: searchs }).then(result => {
        console.log(result.data)
        state.guides = result.data.data;
        state.totalPage = result.data.total ? result.data.last_page : 0
    })
}

export default state;