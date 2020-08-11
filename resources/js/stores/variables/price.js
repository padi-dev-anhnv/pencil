const info = {'cost' : '' , 'qty' : '' , 'unit' : '', 'total' : ''};

let element1 = {
    'base_price' : '本体価格',
    'version_charge1' : '版代',
    'version_charge2' : '版代',
    'version_charge3' : '版代',
    'invoice1' : '銘入代',
    'invoice2' : '銘入代',
    'invoice3' : '銘入代',
    'box_paper1' : 'のし箱・紙',
    'box_paper2' : 'のし箱・紙',
    'box_paper3' : 'のし箱・紙',
    'printing1' : '印刷代',
    'printing2' : '印刷代',
    'printing3' : '印刷代',
};

let element2 = {
    'release' : 'ばらし・戻',
    'sticker' : 'シール剥貼',
    'box' : '箱詰め',
    'bagging' : '袋詰め',
    'seal' : 'シール詰',
    'gimmick' : 'のし掛け',
    'packaging' : '包装',
};
for(let ele in element1){
    let eleName = element1[ele]
    element1[ele] = {
        price : JSON.parse(JSON.stringify(info)),
        wholesale : JSON.parse(JSON.stringify(info)),
        name : eleName
    }
}
for(let ele in element2){
    let eleName = element2[ele]
    element2[ele] = {
        price : JSON.parse(JSON.stringify(info)),
        wholesale : JSON.parse(JSON.stringify(info)),
        name : eleName
    }
}

let totalPrice = {
    subTotalEle1 : {"subPrice":0,"subQty":0,"subTotal":0},
    subTotalEle2 : {"subPrice":0,"subQty":0,"subTotal":0},
    subWholesaleEle1 : {"subPrice":0,"subQty":0,"subTotal":0},
    subWholesaleEle2 : {"subPrice":0,"subQty":0,"subTotal":0},
    finalMargin : 0,
    finalPrice : 0,
    finalWholesale : 0,
    
}

let specialValue = {
    number : '',
    rate : ''
}

export default {
    element1,
    element2,
    totalPrice,
    specialValue
}