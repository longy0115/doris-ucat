<?php
namespace app\index\model;
use think\Model;
use think\Db;
use \think\Request;
class Actives extends Model {
  // 旅游
  public function getTravels () {
    $list = Db::table('travels')->select();
    halt(session('id'));
    return $list;
  }
  public function getMyTravels () {
    $id = Request::instance()->param('user_id');
    $list = Db::table('travels')->where('user_id', $id)->select(); 
    return $list;
  }
  public function getTravelDetail () {
    $id = Request::instance()->route('id');
    $list = Db::view('travel_detail','*')
            ->view('travels','title,author,user_id,submission_date,url','travel_detail.travel_id=travels.id','LEFT')
            ->where('travel_id', $id)
            ->find();
    return $list;
  }

  //运动
  public function getSports () {
    $list = Db::table('sports')->select(); 
    return $list;
  }
  public function getMySports () {
    $id = Request::instance()->param('user_id');
    $list = Db::table('sports')->where('user_id', $id)->select(); 
    return $list;
  }
  public function getSportDetail () {
    $id = Request::instance()->route('id');
    $list = Db::view('sport_detail','*')
            ->view('sports','title,author,content,user_id,submission_date','sport_detail.sport_id=sports.id','LEFT')
            ->where('sport_id', $id)
            ->find();
    return $list;
  }

  // 发布 旅游 运动
  public function postActive () {
    // 参数格式
    // {
    //   type: '',
    //   formData: {
    //     titile: '',
    //     address
    //   }
    // }
    
    $type = input('type');
    
    halt( cache('id'));
    $listData = ['title'=>input('title'), 'user_id'=>session('id')];
    $detailData = ['address'=>input('address'), 'free'=>input('free'), 'start_date'=>input('start_date'), 'end_date'=>input('end_date'),'apply_end_date'=>input('apply_end_date'), 'position'=>input('position'),'enter_number'=>input('enter_number'),'content'=>input('content')];
    $flag = false;
    if ($type == 'travel') {
      $LId = Db::table('travels')->insertGetId($listData);
      if ($LId) {
        $detailData['travel_id'] = $LId;
        $DId = Db::table('travel_detail')->insertGetId($detailData);
        if ($DId) {
          $flag = true;
        } else {
          // 删除之前插入列表中的数据 ---因为：详情没有插入成功的 --事件回滚
          Db::table('travels')->delete($LId);
        }
      }
    } else if ($type == 'sport') {
      $LId = Db::table('sports')->insertGetId($listData);
      if ($LId) {
        $detailData['sport_id'] = $LId;
        $DId = Db::table('sport_detail')->insertGetId($detailData);
        if ($DId) {
          $flag = true;
        } else {
          // 删除之前插入列表中的数据
          Db::table('sports')->delete($LId);
        }
      }
    }
    if ($flag) {
      return ['Code'=>1,'Message'=>'发布成功'];
    } else {
      return ['Code'=>0,'Message'=>'发布失败'];
    }
  }
}