const constVar = {
    body_inscription : {
        '1' : '1面',
        '1b' : '2行1版',
        '2' : '2面',
        '3' : '3面',
        '4' : '4面',
        '5' : '5面',
        '6' : '6面',
    },
    direction : {
        'side' : '横',
        'vertical' : '縦'
    },
    proofreading : {
        'unnecessary' : '不要',
        'body': '本体校正',
        'data' : 'データ'
    },
    chk : [
        {'eng' : '1' , 'jap' :  '得意先直送'},
        {'eng' : '2' , 'jap' :  '帳合店直送'},
        {'eng' : '3' , 'jap' :  '営業所入り'}
    ],
   pattern_type : [
    {'eng' : 1 , 'jap' :  '右利きボールペン', 'total' : 3},
    {'eng' : 2 , 'jap' :  '左利きボールペン', 'total' : 3},
    {'eng' : 3 , 'jap' :  '右利きボールペングリップ付', 'total' : 5},
    {'eng' : 4 , 'jap' :  '左利きボールペングリップ付', 'total' : 5},
    {'eng' : 5 , 'jap' :  '六角鉛筆', 'total' : 6},
    {'eng' : 6 , 'jap' :  '五角鉛筆', 'total' : 5},
    {'eng' : 7 , 'jap' :  'フリー', 'total' : 1},
],
    noProductName : "品名未入力",
    insc_method : [
        {'eng' : '1' , 'jap' :  'インクジェット'},
        {'eng' : '2' , 'jap' :  'ドット'},
        {'eng' : '3' , 'jap' :  'シルク'},
        {'eng' : '4' , 'jap' :  'パッド'},
        {'eng' : '5' , 'jap' :  'レーザー'},
        {'eng' : '6' , 'jap' :  '他：低温焼付け印刷'},
        {'eng' : '7' , 'jap' :  'インクジェット'},
        {'eng' : '8' , 'jap' :  'パッド'},
        {'eng' : '9' , 'jap' :  'レーザー'},
        {'eng' : '10' , 'jap' :  'グラボ、'},
        {'eng' : '11' , 'jap' :  'その他、'},
    ],
    insc_work : [
        {'eng' : '1' , 'jap' :  'パック出し'},
        {'eng' : '2' , 'jap' :  'シール剥し'},
        {'eng' : '3' , 'jap' :  'キャップ回し'},
        {'eng' : '4' , 'jap' :  '値札タグ外し'},
        {'eng' : '5' , 'jap' :  'その他'},
    ],
    insc_typeface : [
        {'eng' : '1' , 'jap' :  '一任'},
        {'eng' : '2' , 'jap' :  '指定書体'},
        {'eng' : '3' , 'jap' :  '明朝'},
        {'eng' : '4' , 'jap' :  '角ゴシック'},
        {'eng' : '5' , 'jap' :  '丸ゴシック'},
        {'eng' : '6' , 'jap' :  '筆記体'},
        {'eng' : '7' , 'jap' :  '行書体'},
        {'eng' : '8' , 'jap' :  '楷書'},
        {'eng' : '9' , 'jap' :  '他：書き起こし'},
    ]
}

export default constVar;