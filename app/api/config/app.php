<?php
// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

return [
   'jwt_key'=>'newairgroup_0317',//token 秘钥
   'open_token_auth'=>false,//是否验证
   'auth_power_validate'=>true,//是否权限验证
   'server_url'=>"http://marketing.api.newairtek.com",//是否验证
   'maintain_login_time'=>7*1*24*3600,// 登录有效期
   'visit_record'=>true,// 操作记录
   'page_num'=>20,// 操作记录
    'super_admin'=>[1],
    //上传配置
    'uploads'=>[
        'repeat_uploads'=>false,//是否禁止重复上传true禁止，false 为允许
        'upload_dir'=>'./uploads',//文件上传目录，网站根目录下的uploads
        'img_suffix'=>["BMP","JPG","JPEG","PNG","GIF"],
        'sub_dir'=>['','avatar','images','order'],
        'validate'=>'filesize:1*1024*1024|fileExt:csv,doc,docx,dot,dtd,dwg,dxf,gif,jp2,jpe,jpeg,jpg,json,mp2,mp3,mp4,mpeg,mpg,mpp,ogg,pdf,png,pot,pps,ppt,pptx,rtf,svf,tif,txt,wdb,wps,xlc,xlm,xls,xlt,xlw,xml,zip,rar,tar,gz',
    ],
];
