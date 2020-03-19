<?php
namespace app\api\model;

use app\api\model\Attachment;
use app\api\model\Message;
use Firebase\JWT\JWT;
use think\Cache;
use think\Collection;
use think\helper\Hash;
use think\Model;
use think\Response;
use app\api\model\UserChild;

class Common extends Model
{

    /**
     * 自动处理传入的参数，根据参数生成查询条件
     * @param array $ignore
     * @param bool $search
     * @return array
     */
    public static function __map($ignore=[],$search=true){
        if(request()->isPost()){
            $data=request()->post();
        }else{
            $data=request()->get();
        }
        if(isset($data['token'])) unset($data['token']);
        $field=self::getTableFields();
        $map=[];
//        if(in_array('status',$field,true)) $map[]=['status','=',1];
        if(in_array('trash',$field,true)) $map[]=['trash','=',0];
        if($search){
            foreach ($data as $key=>$val){
                if(in_array($key,$ignore,true)) continue;
                if(in_array($key,$field,true)){//可以查询
                    if(!empty($val) || $val=='0'){
                        if(is_array($val)){//数组
                            self::handleArr($key,$val,$map);
                        }else{
                            if(!strlen($val)) continue;
                            if($val=='0'){
                                $map[]=[$key,'=',$val];
//                                $map[$key]=$val;
                                continue;
                            }

                            $map[]=[$key,'LIKE',"%{$val}%"];// 如果是文本就模糊查询
//                            if(is_numeric($val)){//如果是数字，就不模糊查询
//                                $map[$key]=[$key,'=',$val];
////                                $map[$key]=$val;
//                            }else{
////                                 $map[]=[$key,'LIKE',"%{$val}%"];// 如果是文本就模糊查询
//                                $map[]=[$key,'LIKE',"%{$val}%"];// 如果是文本就模糊查询
//                            }
                        }
                    }
                }
            }
        }
        //查询条件整为了应对更高版本查询
        return $map;

    }

    public static function handleArr($key,$val,&$data){
        if(strpos($key,'time')!==false){//判断是时间就需要处理时间
            $start=isset($val[0]) ? trim($val[0]) : '';
            $end=isset($val[1])? trim($val[1]) : '';
            if(!empty($start)){//如果开始时间为空，不添加时间查询
                $start=strtotime($start);
                if(empty($end)){//结束时间如果为空就设置当前时间
                    $end=time();
                }else{
                    $end=strtotime($end);
                }
                $data[]=[$key,'BETWEEN',[$start,$end]];
            }

        }else{//如果不是间，有一个为空就不查询，否则按照范围的查询
            $data[]=[$key,'IN',implode(',',$val)];
        }
    }

    public static function getSort(){
        $key=input('sort_key','id','trim');
        $type=input('sort_type',1);
        $type=$type==1?'desc':'asc';
        $field=self::getTableFields();
        if(!in_array($key,$field,true)) $key="id";
        return "{$key} {$type}";
    }

    public static function _tree($list){
        $rtn=[];

        if(!empty($list)){
            foreach ($list as $key=>$value){
                $list[$key]['list']=[];
            }
            foreach ($list as $key=>$val){
                if(isset($list[$val['pid']])){

                    $list[$val['pid']]['list'][]=&$list[$val['id']];//通过引用传递，不停把自己添加到父级中
                }else{
                    $rtn[]=&$list[$val['id']];//通过引用传递吧，数据结构，放到树中
                }
            }

        }
        return $rtn;
    }


}