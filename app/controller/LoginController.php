<?php


namespace app\controller;


use app\BaseController;
use app\model\UsersModel;
use think\facade\Request;
use think\Cache;


class LoginController extends BaseController
{
    public function index(){
        $token = Request::header('Authorization');
        $data=$this->douserLogin();
        return json($data);

    }
    private function makeToken()
    {
        $str = md5(uniqid(md5(microtime(true)), true)); //生成一个不会重复的字符串
        $strs = sha1($str); //加密
        return $strs;
    }

    public function checkToken()
    {       $user=Request::header('user');
            $users="a".$user;
            $tokens=$this->makeToken();
            cache($users, $tokens, 60*30);//60==60s
            return cache($users);
    }

    public function douserLogin()
    {
        $username=Request::param('username');
        $password=Request::param('password');
        $user=UsersModel::where('username','=',$username)->find();
        if($user){
            if($user->password == $password){
                $tok=$this->checkToken();
                $permissions=power($user->role,[]);
                $arr=[$tok,$user->role,$permissions];
                return $arr;
            }else{
                return 2;
            }
        }else{
            return 0;
        }


    }


}