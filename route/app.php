<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});


Route::post('signin','login/index');//登录

Route::post('deleteteacher','index/deletes');//删除教师
Route::post('updateteacher','index/updateteacher');//修改教师
Route::post('addteacher','index/addteacher');//添加教师

Route::post('deletestudent','index/deletes');//删除学生
Route::post('updatestudent','index/updatestudent');//修改学生
Route::post('addstudent','index/addstudent');//添加学生

Route::post('deletemanager','index/deletes');//删除管理员
Route::post('updatemanager','index/updatemanager');//修改管理员
Route::post('addmanager','index/addmanager');//添加管理员

Route::post('deletebuilding','index/deletebuilding');//删除楼栋
Route::post('updatebuilding','index/updatebuilding');//修改楼栋
Route::post('addbuilding','index/addbuilding');//添加楼栋

Route::post('deletelaboratory','index/deletelaboratory');//删除实验室
Route::post('updatestatus','index/updatestatus');//修改实验室状态
Route::post('addlaboratory','index/addlaboratory');//添加实验室

Route::post('addequipment','index/addequipment');//添加实验室设备
Route::post('updateequipment','index/updateequipment');//修改实验室设备状态
Route::post('deleteequipment','index/deleteequipment');//删除实验室设备


Route::post('experimental','index/experimental');//实验室预约查询
Route::post('quer','index/quer');//实验室预约


Route::post('isequ','index/isequ');//查询时间段内可用设备
Route::post('inserequipment','index/inserequipment');//设备预约



Route::get('teachers', 'index/teachers');//查询教师
Route::get('students', 'index/students');//查询学生
Route::get('manager', 'index/manager');//查询管理员
Route::get('building', 'index/building');//查询楼栋
Route::get('laboratory', 'index/laboratory');//查询实验室
Route::get('olaboratory', 'index/olaboratory');//查询已开放实验室
Route::get('equipments', 'index/equipments');//查询设备
Route::get('queryequ', 'index/queryequ');//查询明天可预约设备



