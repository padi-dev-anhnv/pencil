import Vue from "vue";
import Axios from "axios";
// import puppeteer from "puppeteer";
// const puppeteer = require('puppeteer')
import guide from './variables/guide'
import delivery from './variables/delivery'
import packaging from './variables/packaging'
import procedure from './variables/procedure'
import product from './variables/productInit'
import price from './variables/price'
import city from './city'


const state = Vue.observable({
    loading : false,
    action : 'new',
    suppliers : [],
    creator : {
        office : {}
    },
    dupplicate : {
        exist : 0,
        created_at : '',
        number : ''
    },
    city,
    guide ,
    delivery ,
    packaging,
    procedure,
    products : [
        
    ],
    originalFiles : [],
    price,
    doDupplicate : false,
    fileNotClone : []
});

export const getGuideInfo = async (id) => {
    await axios.get('/guide/' + id + '/get-guide').then(result => {
        console.log(result)
        state.guide = result.data.data.guide;
        state.delivery = result.data.data.delivery;
        state.packaging = result.data.data.packaging;
        state.procedure = result.data.data.procedure;
        state.creator = result.data.data.creator;
        state.price = result.data.data.guide.price;
        // state.originalFiles = {...result.data.data.files }
        state.originalFiles = result.data.data.files.map(file => {
            return { id : file.id }
        })
        // procedure material
        let materialArray = procedure.materialArray;
        let materialGuide = JSON.parse(JSON.stringify(state.procedure.material));
        materialGuide.forEach((mat, index) => {
            materialArray[index] = mat;
        })
        state.procedure.materialArray =  materialArray;

        productToGuide(result.data.data.products, result.data.data.files);
        // array products
        /*
        result.data.data.products.forEach(prod => {
            let initProduct = JSON.parse(JSON.stringify(product));
            // put info part
            for(let key in initProduct.info){
               initProduct.info[key] = prod[key];
            }
            // put inscription part
            for(let key in initProduct.inscription){
                initProduct.inscription[key] = prod[key] ? prod[key] : '';
            }
            
            // put product part
            initProduct.inscription.files.forEach((file, index) => {
                if(file.id){
                    let fileGuide = result.data.data.files.find(fi => fi.id == file.id);
                    initProduct.inscription.files[index] = {...fileGuide}
                    
                }
            })
            
            initProduct.inscription.font_size_enable = initProduct.inscription.font_size ? 1 : 0
            state.products.push(initProduct)
        })
        */

            
    })
}

let productToGuide = (products, files) => {
    products.forEach(prod => {
        let initProduct = JSON.parse(JSON.stringify(product));
        // put info part
        for(let key in initProduct.info){
           initProduct.info[key] = prod[key];
        }
        // put inscription part
        for(let key in initProduct.inscription){
            initProduct.inscription[key] = prod[key] ? prod[key] : '';
        }
        
        // put product part
        initProduct.inscription.files.forEach((file, index) => {
            if(file.id){
                let fileGuide = files.find(fi => fi.id == file.id);
                initProduct.inscription.files[index] = {...fileGuide}                
            }
            else{
                initProduct.inscription.files[index] = {}
            }
        })
        
        initProduct.inscription.font_size_enable = initProduct.inscription.font_size ? 1 : 0
        state.products.push(initProduct)
    })
}

export const createGuide = async (id) => {
    
//    await uploadMulti();
    let products = mergeProduct();  
    let guideInfo = {...state.guide};
    guideInfo.price =  {...state.price};
    let newGuide = {
        guide : guideInfo,
        delivery : {...state.delivery},
        packaging : {...state.packaging},
        procedure : {...state.procedure},
        products : products,
        originalFiles : state.originalFiles,
        doDupplicate : state.doDupplicate
        // price : {...state.price},
    } ;
    newGuide.id = id;
    if(state.doDupplicate == true){
        newGuide = removeIdDupplicate(newGuide);
    }
    
    state.loading = true;
    let formData = prepareFormData(newGuide);
    await axios.post('/guide', formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
      }).then(async result => {
        if(result.data.map_upload.length > 0)
            updateUploadFileId(result.data.map_upload)
    })
    /*
    await axios.post('/guide', newGuide).then(async result => {
        if(result.data.success == true){
            if(result.data.map.length > 0 && state.doDupplicate == true)
                mapFileId(result.data.map);
            await uploadMulti(result.data.id);
        }
            
    });
    */
    state.loading = false;
};

let updateUploadFileId = (mapId) => {
    state.products.forEach(product => {
        product.inscription.files.forEach(file => {
            if( typeof file.uploading !== 'undefined'){
                file.id = mapId[file.uploading];
                delete file.uploading;
                delete file.fileUpload;
            }
                
        })
    })
}

let prepareFormData = (newGuide) =>{
    const formData = new FormData()

    // append fileUpload
    let filesUpload = [];
    let pos = 0 ; 
    for(let i = 0; i < state.products.length; i ++ )
    {
        for(let j = 0; j < state.products[i].inscription.files.length  ; j ++ )
        {
            let file = state.products[i].inscription.files[j];
            if(file.fileUpload){ 
                filesUpload.push(file.fileUpload); 
                formData.append('filesUpload[' + pos + ']', file.fileUpload)
                file.uploading = pos;
                pos++;
            }
        }
    }
    formData.append('data', JSON.stringify(newGuide));
    return formData;
}

let mapFileId = (mapId) => {
    state.products.forEach(product => {
        product.inscription.files.forEach(file => {
            file.id = mapId[file.id];
        })
    })
}

let removeIdDupplicate = (newGuide) => {
    // delete newGuide.guide.guide_id;
    delete newGuide.delivery.guide_id;
    delete newGuide.packaging.guide_id;
    delete newGuide.procedure.guide_id;
    newGuide.guide.id = 0 ;
    newGuide.delivery.id = 0;
    newGuide.packaging.id = 0;
    newGuide.procedure.id = 0;
    return newGuide;
}

//not use
let uploadMulti = async(id) => {
    let hasUpload = false;
    for(let i = 0; i < state.products.length; i ++ )
    {
        for(let j = 0; j < state.products[i].inscription.files.length  ; j ++ )
        {
            let file = state.products[i].inscription.files[j];
            if(file.fileUpload){            
                let formData = new FormData();
                let fileName = file.fileUpload.name.split('.').slice(0, -1).join('.');
                formData.append('fileUpload', file.fileUpload)
                formData.append('name', fileName )
                formData.append('material', 'guide' )
                formData.append('id', 0 )
                formData.append('guide_id', id )
                await axios.post("/file", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(result => {
                    if(result.data.id){
                        hasUpload = true;
                        //    state.fileNotClone.push(result.data.id);
                        state.products[i].inscription.files[j] = { id : result.data.id }
                    }
                        
                
                });
            }      
        }
    }
    if(hasUpload == true)
        await updateGuideProduct(id);

}

let updateGuideProduct = async (guideId) => {
    let products = mergeProduct();    
    await axios.post('/guide/update-product', { id : guideId, products : products }).then(result => {
        
    });
}

let mergeProduct = () => {
    let products = [];
    state.products.forEach(product => {
        delete product.inscription.font_size_enable;
        products.push({...product.info, ...product.inscription})
    }) ;
    return products;
}

export const setCreator = (creator) => {

    state.creator = creator;
}

export const setAction = (action) => {
    state.action = action;
}

export const setCloneId = (id) => {
    state.guide.last_exist = 1;
    state.guide.last_date = state.guide.created_at;
    state.guide.last_numb = state.guide.number;
    state.doDupplicate = true;
    /*
    state.guide.clone_id = id;
    state.dupplicate = {
        exist : 1,
        created_at : state.guide.created_at,
        number : state.guide.number
    }
    */
}

export const getWorkers = () => {
    axios('/guide/workers').then(result=>{
        state.suppliers = result.data
    })
}

export const addProduct = () =>{
    if(state.products.length < 12)
        state.products.push( JSON.parse(JSON.stringify(product)));
}

export const removeProduct = (index) =>{
    state.products.splice(index,1)
}


// handle price 

const countByEleState = (eleNumb, typePrice) =>  {
    let subPrice = 0,
      subQty = 0,
      subTotal = 0;

    for (let ele in state.price[eleNumb]) {
      subPrice += countSubTotalState(eleNumb, ele, typePrice, "cost");
      subQty += countSubTotalState(eleNumb, ele, typePrice, "qty");
      subTotal += countSubTotalState(eleNumb, ele, typePrice, "total");
    }
    return {
      subPrice,
      subQty,
      subTotal,
    };
  }

const countSubTotalState = (eleNumb, ele, typePrice, type) => {
    let tempPrice = parseInt(state.price[eleNumb][ele][typePrice][type]);
    if (!isNaN(tempPrice)) return parseInt(tempPrice);
    return 0;
  }

export const countByEle = countByEleState;
export const countSubTotal = countSubTotalState;


// const function 

export const findCustomer = (type = 'destination_code', code ) => {
    axios.get('/guide/find-customer', {params: { type, code }}).then(result => {
        if(result.data.success == false){
            
        }
        else{
            let arrAddress = ['address', 'building', 'city', 'fax', 'phone', 'prefecture', 'destination_code', 'postal_code']
            arrAddress.forEach( key => {
                state.delivery[key] = result.data[key]
            })
        }
        
    })
}

export default state;
