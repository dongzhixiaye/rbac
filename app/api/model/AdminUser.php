<?php
namespace app\api\model;

use app\api\model\Attachment;
use app\api\model\Message;
use app\common\model\Common;
use Firebase\JWT\JWT;
use think\Cache;
use think\Collection;
use think\helper\Hash;
use think\Model;
use think\Response;
use app\api\model\UserChild;

class AdminUser extends \app\api\model\Common
{

    protected $autoWriteTimestamp = true;//自动写入时间戳

    // 对密码进行加密
    public function setPasswordAttr($value)
    {
        return password_hash((string)$value,PASSWORD_BCRYPT);
    }

    /**
     * @param int $type 1:管理员，2:老师，3：学生
     * @return array|bool
     */
    public static function login($type=1)
    {
        $msg='';
        $code=203;
        $token='';
        $username=input('param.username','','trim');
        $pw=input('param.password','','trim');
        if($type==1){
            $user=self::where('email',$username)->whereOr('username',$username)->whereOr('mobile',$username)->find();
        }else{
            $user=self::where('email',$username)->whereOr('mobile',$username)->find();
        }

        $rtn=[];

        if(empty($user)){
            $msg=lang("user_not_exist");
        }else{

            if($user['status']!=1 || !$user['activation_status']){
                $msg=lang("user_ban");
            }else{
                if(!Limit::checkSyncLogin($user,$type)){
                    return false;
                }
                if(Hash::check((string)$pw,$user['password'])){//验证码密码

                    $rtn=[
                        'id'=>$user->id,
                        'username'=>$user->username,
                        'nickname'=>$user->nickname,
                        'email'=>$user->email,
                        'mobile'=>$user->mobile,
                        'avatar'=>$user->avatar,
                        'role'=>$user->role,
                        'last_login_time'=>$user->last_login_time,
                        'last_login_time'=>$user->last_login_time,
                        'time_zone'=>$user->time_zone,
                        'default_language'=>$user->default_language,
                        'code'=>$user->code,
                        'first_name'=>$user->first_name,
                        'last_name'=>$user->last_name,
                        'skype'=>$user->skype,
                        'whatsapp'=>$user->whatsapp,
                        'invitation_code'=>$user->invitation_code,
                        'invitration_count'=>$user->invitration_count,
                        'invitration'=>$user->invitration,//注册的时候选填的邀请码，在第一次下单的时候使用
                        'money'=>$user->money,
                        'poster'=>config('server_url').$user->poster,
                        'audit_status'=>$user->audit_status,//老师是否已经被审核通过，如果没有通过无法使用核心功能，1：通过
                        'support_email'=>config('support_email'),

                    ];

                    if($rtn['avatar']){
                        $avatar=Attachment::get($rtn['avatar']);
                        if(!empty($avatar)) $rtn['avatar_path']=$avatar['path'];
                        if(!is_file("./uploads/".$avatar['source_file'])) $rtn['avatar_path']="";
                    }else{
                        $rtn['avatar_path']="";
                    }
                    //获取站内信未读数量
                    $read_status_count = Message::where(['uid_receive'=>$user->id,'receive_type'=>2,'read_status'=>1])->count();
                    $rtn['read_status_count']=$read_status_count;

                    if($user->user_type==3){
                        $user_child_id=UserChild::where('user_id',$user->id)->order('default_select desc')->value('id');   
                        $rtn['user_child_id']=$user_child_id;
                    }
                    $rtn['type']=$user->user_type;
                    $type=$user->user_type;
                    Limit::clearLimitRecored($user,$type);
                    unset($rtn['passwords']);
                    $msg=lang("Login_success");
                    $rtn['token']=base64_encode(JWT::encode(["uid"=>$user['id'],"type"=>$type,"time"=>time()],config('jwt_key')));
                    cache($user['id'].'_'.$type.'_info',$rtn,config('app.maintain_login_time'));
                }else{
                    $msg=lang("password_error");
                }
            }
        }

        return ['msg'=>$msg,'rtn'=>$rtn];
    }

    public static function vali($data){
        if(isset($data['id']) && empty($data['id'])) return lang("update_id");
        if(isset($data['passwords'])) {
            if(strlen($data['passwords'])<=6 || strlen($data['passwords'])>=20){
                return lang("password_length");
            }
        }

        return true;
    }
    //头像
    public function ava(){
        return $this->hasOne('Attachment','id','avatar')->field('path,id');
    }


}