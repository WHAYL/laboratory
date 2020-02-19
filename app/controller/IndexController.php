<?php
namespace app\controller;

use app\BaseController;
use app\model\AdminsModel;
use app\model\BuildingModel;
use app\model\EquinfoModel;
use app\model\EquipmentsModel;
use app\model\LaboratorysModel;
use app\model\LabsinfoModel;
use app\model\StudentsModel;
use app\model\TeachersModel;
use think\facade\Config;
use think\facade\Db;
use think\facade\Env;
use app\model\UsersModel;
use think\captcha\facade\Captcha;
use think\facade\Request;

class IndexController extends BaseController
{

    public function index()
    {
        //$data = UsersModel::find(11);//users表正向关联admins表
        //$data = AdminsModel::find(9);//admins表反向关联users表

        //$data = UsersModel::find(3);//users表正向关联teachers表
        //$data = TeachersModel::find(1);//teachers表反向关联users表

        //$data = UsersModel::find(4);//users表正向关联students表
        //$data = StudentsModel::find(1);//students表反向关联users表

        //$data = AdminsModel::find(2);//admins表正向关联building表
        //$data = BuildingModel::find(1);//building表反向关联admins表

        //$data = BuildingModel::find(1);//building表正向关联laboratorys表
        //$data = LaboratorysModel::find(11);//laboratorys表反向关联building表

        //$data = LaboratorysModel::find(1);//laboratorys表正向关联equipments表
        //$data = EquipmentsModel::find(5);//equipments表正向关联laboratorys表

        //return json($data->laboratorys);


        //laboratorys表、building表、equipments表关联查询，通过equipment查询出其他表
        //$datas = EquipmentsModel::with(['laboratorys', 'laboratorys.building.admins.users'])->where('equipment','=','01')->select();
        //修改崇仁楼 102房间 01号机的预约状态
//        foreach ($datas as $data){
//            if($data->laboratorys->building->building==='崇仁楼' and $data->laboratorys->laboratory==='102') {
//                $d=[
//                    'id' => $data->id,
//                    'status' => 0
//                ];
//                $re=Db::name('equipments')->update($d);
//                break;
//            }
//
//
//        }
//        return json($datas);


        //修改崇仁楼 101房间的预约状态
//       $datas = LaboratorysModel::with(['building'])->where('laboratory','=','101')->select();
//        foreach ($datas as $data){
//            if($data->building->building==='崇仁楼') {
//                $d=[
//                    'id' => $data->id,
//                    'status' => 1
//                ];
//                $re=Db::name('laboratorys')->update($d);
//
//                break;
//            }
//
//
//        }
//return json($datas);


        //return json($data->laboratorys->building);


    }
//删除用户
    public function deletes(){
        $t_id=Request::param('t_id');
        $u_id=Request::param('u_id');
//        $teacher=TeachersModel::find($t_id);
//        $data = $teacher->delete();
        $users =UsersModel::find($u_id);
        $data =$users->delete();
        return  json($data);
    }
//查询教师信息
    public function teachers(){
        $user=Request::header('user');
        $users="a".$user;
        if(cache($users))
        {
            $datas = TeachersModel::with(['users'])->select();
            return  json($datas);
        }else{
            $arr=['过期了'];
            return json($arr);
        }

    }

//修改教师信息
    public function updateteacher(){
        $t_id=Request::param('id');
        $name=Request::param('name');
        $gender=Request::param('gender');
        $email=Request::param('email');
        $phone=Request::param('phone');
        $college=Request::param('college');
        $address=Request::param('address');
        $data=[
            'id'    => $t_id,
            'name'  => $name,
            'gender'    => $gender,
            'email' =>$email,
            'phone'  =>$phone,
            'college'   =>$college,
            'address'   =>$address
        ];
        $re=Db::name('teachers')->update($data);
        return json($re);

    }
//添加教师
    public function addteacher(){
        $username=Request::param('username');
        $password=Request::param('password');
        $name=Request::param('name');
        $gender=Request::param('gender');
        $email=Request::param('email');
        $phone=Request::param('phone');
        $college=Request::param('college');
        $address=Request::param('address');

        $find=UsersModel::where('username','=',$username)->find();
        if($find){
            return false;
        }
        //向user表添加记录
        $users=new UsersModel();
        $users->save([
            'username' => $username,
            'password' => $password,
            'role' => '2'
        ]);
        //向teacher表添加记录
        if($users->id){
            $teachers=new TeachersModel();
            $teachers->save([
                'users_id' =>$users->id,
                'name' => $name,
                'gender' => $gender,
                'email' => $email,
                'phone' => $phone,
                'college' => $college,
                'address' => $address
            ]);
        }
        return json($teachers->id);

    }

//查询学生
    public function students(){
        $count=StudentsModel::count();
        $where=Request::param('where');
        if($where){
            $udata = UsersModel::where('username','=',$where)->find();
            if($udata){
                $datas = StudentsModel::with(['users'])->where('users_id','=',$udata->id)->select();
                $datas[0]->count=count($datas);

            }else{
                $datas = StudentsModel::with(['users'])->where('name','=',$where)->select();
                $datas[0]->count=$count;
            }
            return  json($datas);
        } else{
            $page=Request::param('page')-1;
            $datas = StudentsModel::with(['users'])->limit($page*10,10)->select();
            $datas[0]->count=$count;
            return  json($datas);
        }


    }

//修改学生
    public function updatestudent(){
        $s_id=Request::param('id');
        $name=Request::param('name');
        $gender=Request::param('gender');
        $email=Request::param('email');
        $phone=Request::param('phone');
        $college=Request::param('college');
        $specialty=Request::param('specialty');
        $class=Request::param('class');
        $data=[
            'id'    => $s_id,
            'name'  => $name,
            'gender'    => $gender,
            'email' =>$email,
            'phone'  =>$phone,
            'college'   =>$college,
            'specialty'   =>$specialty,
            'class' =>$class
        ];
        $re=Db::name('students')->update($data);
        return json($re);
    }
//添加学生
    public function addstudent(){
        $username=Request::param('username');
        $password=Request::param('password');
        $name=Request::param('name');
        $gender=Request::param('gender');
        $email=Request::param('email');
        $phone=Request::param('phone');
        $college=Request::param('college');
        $specialty=Request::param('specialty');
        $class=Request::param('class');

        $find=UsersModel::where('username','=',$username)->find();
        if($find){
            return false;
        }
        //向user表添加记录
        $users=new UsersModel();
        $users->save([
            'username' => $username,
            'password' => $password,
            'role' => '3'
        ]);
        //向student表添加记录
        if($users->id){
            $student=new StudentsModel();
            $student->save([
                'users_id' =>$users->id,
                'name' => $name,
                'gender' => $gender,
                'email' => $email,
                'phone' => $phone,
                'college' => $college,
                'specialty'   =>$specialty,
                'class' =>$class
            ]);
        }
        return json($student->id);
    }

//查询管理员
    public function manager(){
        $user=Request::header('user');
        $users="a".$user;
        if(cache($users))
        {
            $datas = AdminsModel::with(['users'])->select();

            $arrlength=count($datas);
            for($x=0;$x<$arrlength;$x++)
            {
                $building=BuildingModel::where('admins_id','=',$datas[$x]->id)->field('building')->find();
                if($building)
                    $datas[$x]->building=$building->building;
                else
                    $datas[$x]->building="无";
            }
            return  json($datas);
        }else{
            $arr=['过期了'];
            return json($arr);
        }

    }
//修改管理员
    public function updatemanager(){
        $a_id=Request::param('id');
        $name=Request::param('name');
        $gender=Request::param('gender');
        $email=Request::param('email');
        $phone=Request::param('phone');
        $address=Request::param('address');

        $building=Request::param('building');

        $data=[
            'id'    => $a_id,
            'name'  => $name,
            'gender'    => $gender,
            'email' =>$email,
            'phone'  =>$phone,
            'address'   =>$address,
        ];
        $re=Db::name('admins')->update($data);
        if($building!='无'){
            $datas=[
                'admins_id' => $a_id
            ];
            $data=[
                'admins_id' => null
            ];
            Db::name('building')->where('admins_id','=',$a_id)->update($data);
            Db::name('building')->where('building','=',$building)->update($datas);
            return json(1);
        }else{
            $data=[
                'admins_id' => null
            ];
            Db::name('building')->where('admins_id','=',$a_id)->update($data);
            return json(1);
        }



    }
//添加管理员
    public function addmanager(){
        $asername=Request::param('username');
        $password=Request::param('password');

        $name=Request::param('name');
        $gender=Request::param('gender');
        $email=Request::param('email');
        $phone=Request::param('phone');
        $address=Request::param('address');

        $building=Request::param('building');


        $find=UsersModel::where('username','=',$asername)->find();
        if($find){
            return false;
        }
        //向user表添加记录
        $users=new UsersModel();
        $users->save([
            'username' => $asername,
            'password' => $password,
            'role' => '1'
        ]);
        //向admins表添加记录
        if($users->id){
            $admin=new AdminsModel();
            $admin->save([
                'users_id' =>$users->id,
                'name' => $name,
                'gender' => $gender,
                'email' => $email,
                'phone' => $phone,
                'address' =>$address,
            ]);
        }
        if($building!='无'){
            if($admin->id){
                $datas=[
                    'admins_id' => $admin->id,
                ];
                $res=Db::name('building')->where('building','=',$building)->update($datas);
            }
            return json($res);
        }else{
            return json($users->id);
        }

    }

//查询楼栋
    public function building(){
        $datas = BuildingModel::with(['admins'])->select();
        return json($datas);
    }
//删除楼栋
    public function deletebuilding(){
        $buildingname=Request::param('name');
        $data=BuildingModel::where('building','=',$buildingname)->delete();
        return json($data);
    }
//修改楼栋
    public function updatebuilding(){
        $buildingid=Request::param('id');
        $buildingname=Request::param('building');
        $status=Request::param('status');
        $adid=Request::param('adid');
        if($status=='开放'){
            $status=1;
        }else{
            $status=0;
        }
        if($adid==-1){
            $adid=null;
        }
        $data=[
            'id'=>$buildingid,
            'building'=>$buildingname,
            'admins_id'=>$adid,
            'status'=>$status,
        ];
        $datas=[
            'admins_id'=>null,
        ];
        if($adid!=-1)
            Db::name('building')->where('admins_id','=',$adid)->update($datas);
        $re=Db::name('building')->update($data);
        return json($re);
    }
//添加楼栋
    public function addbuilding(){

        $buildingname=Request::param('building');
        $status=Request::param('status');
        $adid=Request::param('adid');
        if($status=='开放'){
            $status=1;
        }else{
            $status=0;
        }
        if ($adid==-1){
            $adid=null;
        }
        $data=[
            'building'=>$buildingname,
            'admins_id'=>$adid,
            'status'=>$status,
        ];

        $datas=[
            'admins_id'=>null,
        ];
        Db::name('building')->where('admins_id','=',$adid)->update($datas);

        $building=new BuildingModel();
        $building->save($data);
        return json($building->id);
    }

//查询实验室
    public function laboratory(){
        $datas = LaboratorysModel::with(['building'])->select();
        return json($datas);
    }
//查询已开放实验室
    public function olaboratory(){
        $datas = LaboratorysModel::with(['building'])->where('status','not in',[2])->select();
        return json($datas);
    }
//删除实验室
    public function deletelaboratory(){
        $building=Request::param('building');
        $room=Request::param('room');
        $id=Request::param('id');
        $re=LaboratorysModel::where('id','=',$id)->delete();
        return json($re);
    }
//修改状态
    public function updatestatus(){
        $id=Request::param('id');
        $status=Request::param('status');
        $re=LaboratorysModel::update([
                'id' =>$id,
                'status' =>$status
            ]
        );
        return json($re);

    }
//添加实验室
    public function addlaboratory(){
        $id=Request::param('building');
        $room=Request::param('room');
        $status=Request::param('status');
        $data=[
            'building_id' =>$id,
            'laboratory'    =>$room,
            'status'    =>$status
        ];
        $rs=Db::name('laboratorys')->where('building_id','=',$id)->where('laboratory','=',$room)->find();
        if(!$rs)
        {
            $laboratory=new LaboratorysModel();
            $re=$laboratory->save($data);
            return json($re);
        }else{
            return false;
        }
    }

//查询设备
    public function equipments(){

        //laboratorys表、building表、equipments表关联查询，通过equipment查询出其他表
        $datas = EquipmentsModel::with(['laboratorys', 'laboratorys.building'])->select();
        return json($datas);
    }
//添加设备
    public function addequipment(){
        $builid=Request::param('builid');
        $room=Request::param('room');
        $equipment=Request::param('equipment');
        $status=Request::param('status');
        //查询楼栋实验室id
        $datas = LaboratorysModel::where('building_id','=',$builid)->where('laboratory','=',$room)->field('id')->find();

        //添加设备
        $rs=Db::name('equipments')->where('laboratorys_id','=',$datas->id)->where('equipment','=',$equipment)->find();
        $data=[
            'laboratorys_id' =>$datas->id,
            'equipment'    =>$equipment,
            'status'    =>$status
        ];
        if(!$rs)
        {
            $equipment=new EquipmentsModel();
            $re=$equipment->save($data);
            return json($re);
        }else{
            return false;
        }


    }
//修改设备状态
    public function updateequipment(){
        $id=Request::param('id');
        $status=Request::param('status');
        $re=EquipmentsModel::update([
                'id' =>$id,
                'status' =>$status
            ]
        );
        return json($re);
    }
//删除设备
    public function deleteequipment(){
        $id=Request::param('id');
        $re=EquipmentsModel::where('id','=',$id)->delete();
        return json($re);
    }


//实验室预约

        public function experimental(){

            $buildings=Request::param('building');
            $starttime=Request::param('starttime');
            $endtime=Request::param('endtime');

            $arr=[];
            for($i=0;$i<count($buildings);$i++){
                array_push($arr,$buildings[$i][1]);
            }
            $data = LabsinfoModel::where('laboratory','in',$arr)->select();


            for($i=0;$i<count($data);$i++){
                if(($starttime>=$data[$i]->starttime and $starttime<=$data[$i]->endtime) or ($endtime>=$data[$i]->starttime and $endtime<=$data[$i]->endtime)){
                    $arr=array_diff($arr, [$data[$i]->laboratory]);
                }
                if(($data[$i]->starttime>=$starttime and $data[$i]->starttime<=$endtime) or ($data[$i]->starttime>=$endtime and $data[$i]->endtime<=$endtime)){
                    $arr=array_diff($arr, [$data[$i]->laboratory]);
                }

            }
            return json($arr);
        }

        public function quer(){
            $username=Request::param('username');
            $role=Request::param('role');
            $laboratory=Request::param('laboratory');
            $starttime=Request::param('starttime');
            $endtime=Request::param('endtime');


            $data=[
                'username'=>$username,
                'laboratory'=>$laboratory,
                'starttime'=>$starttime,
                'endtime'=>$endtime,
                'status'=>0
                

            ];

            $labsinfo=new LabsinfoModel();
            $labsinfo->save($data);
            if($labsinfo->id){
                $re=LaboratorysModel::update([
                        'id' =>$laboratory,
                        'status' =>1
                    ]
                );
                return json($re);
            }

        }


//查询明天可预约设备
        public function queryequ(){

            $da=[];
            $date=date(strtotime("+1 day"));//明天的时间戳
            $s = strtotime(date('Y-m-d').'00:00:00');//今天
            //查询出明天有预约的实验室
            $data=LabsinfoModel::where('starttime','<=',$date)->where('starttime','<=',$s)->field('laboratory')->select();
            for($i=0;$i<count($data);$i++){
                array_push($da,$data[$i]->laboratory);
            }
            //查询出明天之前可预约的设备
            $re=EquipmentsModel::with(['laboratorys', 'laboratorys.building'])->where('laboratorys_id','not in',$da)->where('status','not in',[2])->select();
            return json($re);

        }
        //查询该时间段 所选设备中可用设备
        public function isequ(){

            $buildings=Request::param('building');
            $starttime=Request::param('starttime');
            $endtime=Request::param('endtime');

            $datas=LabsinfoModel::where('starttime','<=',$endtime)->field('laboratory')->select();
            $da=[];
            for($j=0;$j<count($datas);$j++){
                array_push($da,$datas[$j]->laboratory);
            }
            $arr=[];
            for($i=0;$i<count($buildings);$i++){
                if(in_array($buildings[$i][1],$da)){
                    continue;
                }else{
                    array_push($arr,$buildings[$i][2]);
                }
            }
            $data = EquinfoModel::where('equipments','in',$arr)->select();


            for($i=0;$i<count($data);$i++){
                if(($starttime>=$data[$i]->starttime and $starttime<=$data[$i]->endtime) or ($endtime>=$data[$i]->starttime and $endtime<=$data[$i]->endtime)){
                    $arr=array_diff($arr, [$data[$i]->equipments]);
                }
                if(($data[$i]->starttime>=$starttime and $data[$i]->starttime<=$endtime) or ($data[$i]->starttime>=$endtime and $data[$i]->endtime<=$endtime)){
                    $arr=array_diff($arr, [$data[$i]->equipments]);
                }

            }
            return json($arr);
        }

        //写入预约的设备
        public function inserequipment(){
            $username=Request::param('username');
            $role=Request::param('role');
            $equipments=Request::param('equipments');
            $starttime=Request::param('starttime');
            $endtime=Request::param('endtime');
            $data=[
                'username'=>$username,
                'equipments'=>$equipments,
                'starttime'=>$starttime,
                'endtime'=>$endtime,
                'status'=>1

            ];
            $equinfo=new EquinfoModel();
            $equinfo->save($data);
            if($equinfo->id){
                $re=EquipmentsModel::update([
                        'id' =>$equipments,
                        'status' =>1
                    ]
                );
                return json($re);
            }



        }}
