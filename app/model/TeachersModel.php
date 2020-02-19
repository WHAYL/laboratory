<?php


namespace app\model;


use think\Model;

class TeachersModel extends Model
{
        protected $name='teachers';
    //反向关联users表
    public function users(){
        $data=$this->belongsTo(UsersModel::class,'users_id','id');
        return $data;
    }
}