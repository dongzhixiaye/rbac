<?php
namespace app\document\controller;

use app\api\controller\Common;
use app\BaseController;

class Index extends Common
{
    /**
     * 更新api接口生成api 解析配置文件yaml文件
     */
    public function index()
    {
        $api_controller=base_path().'api/controller';//控制器目录
        $save_path=root_path().'public/doc/document.yaml';//yaml 配置文件保存位置
        $res=\OpenApi\scan($api_controller);//扫描控制器
        $yaml=$res->toYaml();//获取yaml数据
        $rtn=file_put_contents($save_path,$yaml);//保存yaml数据
        if($rtn){//自动跳转到接口展示页面
//            $this->redirect('/doc/index.html?key='.rand());
           return  redirect('/doc/index.html?key='.rand());
        }
    }

    public function pw()
    {
        $version='4.3.1';
        if(!empty($version) && version_compare($version,'4.3.0','<')){
            return $this->json(0,"Please upgrade the app, otherwise it cannot be used");
        }

        $pwd=password_hash((string)'admin',PASSWORD_BCRYPT);
        $pwd1=password_hash((string)'admin',PASSWORD_BCRYPT);
        echo $pwd.'||||||';
        echo password_verify('admin',$pwd1);
        echo password_verify('admin',$pwd);
        return $this->json(['12312'],203);
    }
}
