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
        {'eng' : 'インクジェット' , 'jap' :  'インクジェット'},
        {'eng' : 'ドット' , 'jap' :  'ドット'},
        {'eng' : 'シルク' , 'jap' :  'シルク'},
        {'eng' : 'パッド' , 'jap' :  'パッド'},
        {'eng' : 'レーザー' , 'jap' :  'レーザー'},
        {'eng' : '他：低温焼付け印刷' , 'jap' :  '他：低温焼付け印刷'},
    ],
    insc_work : [
        {'eng' : 'パック出し' , 'jap' :  'パック出し'},
        {'eng' : 'シール剥し' , 'jap' :  'シール剥し'},
        {'eng' : 'キャップ回し' , 'jap' :  'キャップ回し'},
        {'eng' : '値札タグ外し' , 'jap' :  '値札タグ外し'},
        {'eng' : 'その他' , 'jap' :  'その他'},
    ],
    insc_typeface : [
        {'eng' : '一任' , 'jap' :  '一任'},
        {'eng' : '指定書体' , 'jap' :  '指定書体'},
        {'eng' : '明朝' , 'jap' :  '明朝'},
        {'eng' : '角ゴシック' , 'jap' :  '角ゴシック'},
        {'eng' : '丸ゴシック' , 'jap' :  '丸ゴシック'},
        {'eng' : '筆記体' , 'jap' :  '筆記体'},
        {'eng' : '行書体' , 'jap' :  '行書体'},
        {'eng' : '楷書' , 'jap' :  '楷書'},
        {'eng' : '他：書き起こし' , 'jap' :  '他：書き起こし'},
    ]
}

export default constVar;