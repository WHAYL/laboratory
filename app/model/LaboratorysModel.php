<?php


namespace app\model;


use think\Model;

class LaboratorysModel extends Model
{
        protected $name='laboratorys';
    //反向关联building表
    public function building(){
        $data=$this->belongsTo(BuildingModel::class,'building_id','id');
        return $data;
    }

    //正向关联equipments表
    public function equipments(){
        $data=$this->hasMany(EquipmentsModel::class,'laboratorys_id','id');
        return $data;
    }
}