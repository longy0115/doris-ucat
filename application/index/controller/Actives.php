<?php
namespace app\index\controller;
use app\index\model\Actives as MActives;
class Actives {
  // 旅游
  public function getTravels () {
    $MActives = new MActives;
    $result = $MActives->getTravels();
    return json(['Data'=>$result,'Code'=>1,'Message'=>'']);
  }
  public function getMyTravels () {
    $MActives = new MActives;
    $result = $MActives->getMyTravels();
    return json(['Data'=>$result,'Code'=>1,'Message'=>'']);
  }
  public function getTravelDetail () {
    $MActives = new MActives;
    $result = $MActives->getTravelDetail();
    // echo $MActives->getLastSql();
    return json(['Data'=>$result,'Code'=>1,'Message'=>'']);
  }

  // 运动
  public function getSports () {
    $MActives = new MActives;
    $result = $MActives->getSports();
    return json(['Data'=>$result,'Code'=>1,'Message'=>'']);
  }
  public function getMySports () {
    $MActives = new MActives;
    $result = $MActives->getMySports();
    return json(['Data'=>$result,'Code'=>1,'Message'=>'']);
  }
  public function getSportDetail () {
    $MActives = new MActives;
    $result = $MActives->getSportDetail();
    return json(['Data'=>$result,'Code'=>1,'Message'=>'']);
  }
  
  // 发布 旅游/运动
  public function postActive () {
    $MActives = new MActives;
    $result = $MActives->postActive();
    return json($result);
  }
}