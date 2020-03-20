<?php

namespace app\api\controller\v1;

use app\api\model\Attachment;
use app\api\model\LoginRecord;
use app\common\controller\Common;
use app\common\model\AdminUser;
use app\common\model\Handle;
use app\creative\model\Limit;
use Firebase\JWT\JWT;
use think\Cache;
use think\Controller;
use think\Exception;
use think\exception\ValidateException;
use think\facade\Filesystem;
use think\Loader;
use think\Request;
use app\BaseController;

class Upload extends \app\api\controller\Auto
{

    /**
     *
     * * @OA\Post(
     *     tags={"admin"},
     *     path=".upload/",
     *     summary="上传文件",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={"file":"上传的文件","sub_key":"1","oss":"0","token":"ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6STFOaUo5LmV5SjFhV1FpT2pFc0luUnBiV1VpT2pFMU9EUTFNakE0TWpGOS4weFdTWUpHVEVwVERCQWRNX1d1d0tTN2xLQ3dMZHhueGZGaTh4WlpudkZN","timestamp":"1511234567"}
     *             )
     *         ),
     *
     *     description="file:上传的文件,type:crop 裁切，如果不裁切，可以不传或者传空，只有图片可以裁切。sub_key:子目录，0：没有子目录，1：头像文件相关目录，2：普通图片相关目录，3：订单附件相关目录，oss:是否直接上传到OSS服务器，后期扩展使用"
     *     ),

    @OA\Response(
    response=200,
    description="正常；请求已完成"
    ),
    @OA\Response(
    response=204,
    description="正常；无响应 — 已接收请求，但不存在要回送的信息"
    ),

    @OA\Response(
    response=302,
    description="已找到 — 请求的数据临时具有不同 URI",
    ),
    @OA\Response(
    response=401,
    description="未授权 — 未授权客户机访问数据"
    ),
    @OA\Response(
    response=404,
    description="找不到 — 服务器找不到给定的资源；文档不存在"
    ),

    @OA\Response(
    response=500,
    description="服务器错误"
    ),
     * )
     *
     * 新建角色
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function index(Request $request){
        if($request->isPost()){
            //获取配置
            $upload_dir=config('app.uploads.upload_dir');
            $validate=config('app.uploads.validate');
            $sub_dir_arr=config('app.uploads.sub_dir');
            $repeat_uploads=config('app.uploads.repeat_uploads');
            $handle_type=input('post.type','');
            //获取子目录
            $sub_key=input('sub_key','0');
            $sub_dir='';
            if(isset($sub_dir_arr[$sub_key])){
                $sub_dir=$sub_dir_arr[$sub_key];
                if(!empty($sub_dir)) $upload_dir=$upload_dir.'/'.$sub_dir;
            }
            $insert=[];
            //保存文件
            $files=$this->request->file();
            if(empty($files)){
                return $this->json($this->request->post(),'400',"无法获取文件");
            }
            try {
                validate(['image'=>$validate])
                    ->check($files);
                foreach($files as $file) {
                    $file_name= Filesystem::disk('public')->putFile( $sub_dir, $file);
                    $savename[] = $file_name;
                    //保存图片
                    $insert_data=[
                        'uid'=>$this->_uid,
                        'name'=>$file->getOriginalName(),
                        'module'=>$sub_dir,
                        'path'=>$file_name,
                        'ext'=>$file->getOriginalExtension(),
                        'status'=>1
                    ];
                    $insert=Attachment::create($insert_data);

                }
//                $insert_data['path']=config('app.server_url')."/storage/".$insert_data['path'];
                return $this->json($insert,'',"上传成功");

            } catch (ValidateException $e) {
                return $this->json("",400,$e->getMessage());
            }

        }else{
            return $this->json('',401,"请求类型不正确");
        }
    }


}
