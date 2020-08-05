import Vue from "vue";
import Axios from "axios";
import guide from './variables/guide'
import delivery from './variables/delivery'
import packaging from './variables/packaging'
import procedure from './variables/procedure'
import product from './variables/productInit'
import city from './city'
const state = Vue.observable({
    suppliers : [],
    creator : {},
    city,
    guide ,
    delivery ,
    packaging,
    procedure,
    products : [
        
    ]
});

//export const listCity = () => city;
/*
export const listSupplier = () => {
    axios.get('/guide/listSuppliers').then(result => {
        state.suppliers = result.data;
        // console.log(result.data)
    })
}
*/
export const getGuideInfo = (id) => {
    axios.get('/guide/' + id + '/get-guide').then(result => {
        state.guide = result.data.data.guide;
        state.delivery = result.data.data.delivery;
        state.packaging = result.data.data.packaging;
        state.procedure = result.data.data.procedure;
        state.creator = result.data.data.creator;
        // procedure material
        let materialArray = procedure.materialArray;
        let materialGuide = JSON.parse(JSON.stringify(state.procedure.material));
        materialGuide.forEach((mat, index) => {
            materialArray[index] = mat;
        })
        state.procedure.materialArray =  materialArray;
        // array products
        
        result.data.data.products.forEach(prod => {
            
            let initProduct = JSON.parse(JSON.stringify(product));
            const initFileArray = initProduct.inscription.files;
            for(let key in initProduct.info){
               initProduct.info[key] = prod[key];
            }
            for(let key in initProduct.inscription){
                initProduct.inscription[key] = prod[key];
            }

            prod.file_array.forEach((file, index) => {
                initFileArray[index] = file;
            })
            initProduct.id = prod.id; 
            initProduct.inscription.files = initFileArray;            
            initProduct.inscription.font_size_enable = initProduct.inscription.font_size ? 1 : 0
            state.products.push(initProduct)
        })
        
    })
}

export const createGuide = id => {
    let products = [];
    state.products.forEach(product => {
        delete product.inscription.font_size_enable;
        products.push({ id : product.id,...product.info, ...product.inscription})
    }) ;
    let newGuide = {
        guide : {...state.guide},
        delivery : {...state.delivery},
        packaging : {...state.packaging},
        procedure : {...state.procedure},
        products : products,
    } ;
    newGuide.id = id;
//    let newGuide = JSON.parse(JSON.stringify(state));
    axios.post('/guide', newGuide).then(result => {
        console.log(result)
    })

};

export const setCreator = (creator) => {
    state.creator = creator;
}

export const getWorkers = () => {
    axios('/guide/workers').then(result=>{
        state.suppliers = result.data
    })
}

export const addProduct = () =>{
    state.products.push( JSON.parse(JSON.stringify(product)));
}

export default state;
