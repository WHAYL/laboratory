<?php


namespace app\model;


use think\Model;

class AdminsModel extends Model
{
        protected $name='admins';
        //反向关联users表
        public function users(){
            $data=$this->belongsTo(UsersModel::class,'users_id','id');
            return $data;
        }
        //正向关联building表
        public function building(){
            $data=$this->hasOne(BuildingModel::class,'admins_id','id');
            return $data;
        }

}