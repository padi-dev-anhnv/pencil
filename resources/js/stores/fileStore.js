import Vue from "vue";
import Axios from "axios";
import { findIndex } from "lodash";
const state = Vue.observable({
    selectedId: 0,
    deleteId : 0,
    currentFile: {},
    currentUser: {
        name: "",
        office: ""
    },
    file: {
        office: "",
        user: "",
        // number: "",
        name: "",
        link: "",
        thumbnail: "",
        type : "",
        description: "",
        tags: "",
        material: "office",
        id: 0 , 
        guideNumber : "",
        fileUpload : null
    },
    listFiles : [],
    actionNew: 0,
    totalPage : 0,
    currentPage : 1,
    ppp : 10,
});


export const openEditModal = id => {
    state.actionNew = 0; 
    state.selectedId = id;
    setDefaultFile();
    axios("/file/" + id + "/show").then(result => {
        for (var key in state.file) {
            state.file[key] = result.data[key];
        }
        state.file.guideNumber = result.data.number_guide;
    });
};


export const openAddModal = user => {
    state.actionNew = 1;
    setDefaultFile();
    state.file.user = user.name;
    state.file.office = user.office;
};

/*
export const setSelectedId = id => {
    state.selectedId = id;
    setDefaultFile();
    axios("/file/" + id + "/show").then(result => {
        for (var key in state.file) {
            state.file[key] = result.data[key];
        }
        state.file.guideNumber = result.data.number_guide;
    });
};
*/
export const doSearch = (searchFilter) =>{
    searchFilter.page = state.currentPage ; 
    searchFilter.sort = state.sort ; 
    searchFilter.ppp = state.ppp  
    axios("/file/search", { params: searchFilter }).then(result => {
        state.listFiles = result.data.data;
        state.totalPage = result.data.total ? result.data.last_page : 0
    });
}

let setDefaultFile = () =>{
    for (var key in state.file) {
        state.file[key] = "";
    }
    state.file.material = "office"
}

let upload = async (file) => {
    let formData = new FormData();
    formData.append("file", file);
    return axios
        .post("/file/upload", formData, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        })
        .then(function(result) {
            state.file.link = result.data.file_name,
            state.file.thumbnail = result.data.file_thumbnail
            state.file.type = result.data.type
            return {
                link : result.data.file_name,
                thumbnail : result.data.file_thumbnail,
                type : result.data.type,
            }
        })
        .catch(function() {
            console.log("FAILURE!!");
        });
    
};

export const uploadFile = (file) => {
    upload(file)
}
/*
export const setFileUserOffice = user => {
    state.actionNew = 1;
    setDefaultFile();
    state.file.user = user.name;
    state.file.office = user.office;
};
*/

export const setCurrentUser = user => {
    state.currentUser = user;
};

export const getPpp = () => {
    if(localStorage.getItem("ppp-file")){
        state.ppp = localStorage.getItem("ppp-file");
    }        
    else{
        localStorage.setItem("ppp-file", 10)
        state.ppp = 10
    }
}

export const createFile = async () =>{

    let formData = new FormData();
    for(let key in state.file){
        formData.append(key, state.file[key]);
    }
    return axios
        .post("/file", formData, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        })
        .then(result => {
            if(state.actionNew == 1){
                state.listFiles.unshift(result.data)
            }                
            else{
                let findex = state.listFiles.findIndex(file => file.id == result.data.id);  
                Vue.set(state.listFiles, findex, result.data)
            }
            
            return result;
        });

}

export const createFileProduct = async (file) =>{
    let fileUploaded = await upload(file);
    let newFile = { 
        link : fileUploaded.link,
        material : 'guide',
        type : fileUploaded.type,
        id : 0
    }
    return axios.post('/file', newFile).then(result => {
        return result;
    })
}

export const setDeleteId = () => {
    state.deleteId = state.selectedId;
}

export const doDelete = () => {
    axios.post('/file/delete', { id : state.deleteId}).then(result => {
        if(result.data.success == true){
            let findex = state.listFiles.findIndex(file => file.id == state.deleteId);            
            Vue.delete(state.listFiles, findex)
        }

    })
}

export const deleteAttach = () => {
    state.file.link = "";
}

export default state;
