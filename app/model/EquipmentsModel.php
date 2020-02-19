<?php


namespace app\model;


use think\Model;

class EquipmentsModel extends Model
{
        protected $name='equipments';
    //反向关联laboratorys表
    public function laboratorys(){
        $data=$this->belongsTo(LaboratorysModel::class,'laboratorys_id','id');
        return $data;
    }
}