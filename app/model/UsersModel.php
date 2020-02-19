<?php

namespace app\model;
use think\Model;
use think\model\relation\HasOne;

class UsersModel extends Model
{
    //模型加后缀要指定对应数据表
    protected $name='users';

    //正向关联admins表
    public function admins(){
        $data = $this->hasOne(AdminsModel::class,'users_id','id');
        return $data;
    }
    //正向关联teachers表
    public function teachers(){
        $data = $this->hasOne(TeachersModel::class,'users_id','id');
        return $data;
    }
    //正向关联students表
    public function students(){
        $data = $this->hasOne(StudentsModel::class,'users_id','id');
        return $data;
    }

}