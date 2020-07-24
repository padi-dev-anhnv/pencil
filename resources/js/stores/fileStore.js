import Vue from "vue";
import Axios from "axios";
import { findIndex } from "lodash";
const state = Vue.observable({
    selectedId: 0,
    currentFile: {},
    currentUser: {
        name: "",
        office: ""
    },
    file: {
        office: "",
        user: "",
        number: "",
        name: "",
        link: "",
        thumbnail: "",
        type : "",
        description: "",
        tags: "",
        material: "",
        id: 0
    },
    listFiles : [],
    actionNew: 0
});
export const setSelectedId = id => {
    state.selectedId = id;
    setDefaultFile();
    axios("/file/" + id + "/show").then(result => {
        for (var key in state.file) {
            state.file[key] = result.data[key];
        }
    });
};

export const doSearch = (searchFilter) =>{
    axios("/file/search", { params: searchFilter }).then(result => {
        state.listFiles = result.data.data;
    });
}

let setDefaultFile = () =>{
    for (var key in state.file) {
        state.file[key] = "";
    }
}

export const setFileUserOffice = user => {
    setDefaultFile();
    state.file.user = user.name;
    state.file.office = user.office;
};

export const setCurrentUser = user => {
    state.currentUser = user;
};

export const uploadFile = file => {
    let formData = new FormData();
    formData.append("file", file);
    axios
        .post("/file/upload", formData, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        })
        .then(function(result) {
            state.file.link = result.data.file_name,
            state.file.thumbnail = result.data.file_thumbnail
            state.file.type = result.data.type
        })
        .catch(function() {
            console.log("FAILURE!!");
        });
};

export const createFile = async () =>{
    return axios.post('/file', state.file).then(result => {
        if(state.actionNew == 1)
            state.listFiles.unshift(result.data)
        else{
           let findex = state.listFiles.findIndex(file => file.id == result.data.id);  
            Vue.set(state.listFiles, findex, result.data)
        }
           
        return result;
    })
}

export default state;
