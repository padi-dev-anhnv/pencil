import Vue from "vue";
import Axios from "axios";
import guide from './variables/guide'
import delivery from './variables/delivery'
import packaging from './variables/packaging'
import procedure from './variables/procedure'
import product from './variables/productInit'
import price from './variables/price'
import city from './city'


const state = Vue.observable({
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
    price,
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
        // dupplicate
        let dupplicate = result.data.data.dupplicate
        if(dupplicate){
            state.dupplicate = dupplicate
            state.dupplicate.exist = 1
        }
            
    })
}

export const createGuide = async (id) => {
    
    await uploadMulti();
    let products = [];
    state.products.forEach(product => {
        delete product.inscription.font_size_enable;
        products.push({ id : product.id,...product.info, ...product.inscription})
    }) ;
    let guideInfo = {...state.guide};
    guideInfo.price =  {...state.price};
    let newGuide = {
        guide : guideInfo,
        delivery : {...state.delivery},
        packaging : {...state.packaging},
        procedure : {...state.procedure},
        products : products,
        // price : {...state.price},
    } ;
    newGuide.id = id;
//    let newGuide = JSON.parse(JSON.stringify(state));
    axios.post('/guide', newGuide).then(result => {
        console.log(result)
    })

};

let uploadMulti = async() => {

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
                await axios.post("/file", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(result => {
                    state.products[i].inscription.files[j] = { id : result.data.id }
                });
            }      
        }
    }
    


    /*
    if(count > 0){
        return axios
        .post("/file", formData, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        })
        .then(result => {
            console.log(result)
        });
    }
    */
}

export const setCreator = (creator) => {
    console.log(creator)
    state.creator = creator;
    // state.guide.office = creator.
}

export const setAction = (action) => {
    state.action = action;
}

export const setCloneId = (id) => {
    state.guide.clone_id = id;
    state.dupplicate = {
        exist : 1,
        created_at : state.guide.created_at,
        number : state.guide.number
    }
}

export const getWorkers = () => {
    axios('/guide/workers').then(result=>{
        state.suppliers = result.data
    })
}

export const addProduct = () =>{
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

export const findCustomer = (type = 'destination_code', code ) => {
    axios.get('/guide/find-customer', {params: { type, code }}).then(result => {
        let arrAddress = ['address', 'building', 'city', 'fax', 'phone', 'prefecture']
        arrAddress.forEach( key => {
            state.delivery[key] = result.data[key]
        })
    })
}

export default state;
