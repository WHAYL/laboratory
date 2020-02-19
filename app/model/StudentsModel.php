<?php


namespace app\model;


use think\Model;

class StudentsModel extends Model
{
        protected $name='students';
    //反向关联users表
    public function users(){
        $data=$this->belongsTo(UsersModel::class,'users_id','id');
        return $data;
    }
}