<?php
// 应用公共文件

function json_return($data=[],$code=200,$msg=""){
    $rtn=[
        "code"=>$code,
        "msg"=>$msg,
        "time"=>time(),
        "data"=>$data,
    ];
//    ob_clean();
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:GET, POST, PUT, OPTIONS");
    header("Access-Control-Allow-Headers:sign,token,timestamp,Origin,X-Requested-With,Content-Type,Accept");
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($rtn);
    exit;
}
