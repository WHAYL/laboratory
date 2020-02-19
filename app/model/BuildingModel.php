<?php


namespace app\model;


use think\Model;

class BuildingModel extends Model
{
        protected $name='building';
    //反向关联admins表
    public function admins(){
        $data=$this->belongsTo(AdminsModel::class,'admins_id','id');
        return $data;
    }

    //正向关联laboratorys表
    public function laboratorys(){
        $data=$this->hasMany(LaboratorysModel::class,'building_id','id');
        return $data;
    }

}