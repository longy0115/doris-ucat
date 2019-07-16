<?php

namespace app\wechat\controller;

use service\WechatService;
use think\Log;
/**
 * 微信服务器  验证控制器
 * Class Wechat
 */

class Wechat 
{
    public function index()
    {
        echo cache('openid');
            halt('微信测试');
    }

    //weixin
    public function reply()
    {
        // cache('openid',input('nonce'));
        if (isset($_GET['echostr'])) {     //验证微信
            $this->valid();
        } else { //回复消息 其他操作
            $openid = cache('openid');
            $temId= "vjDCEsAKgrVzSezGK9zZOH50V0MrWwaRKzcr4Ip7HNU";
            $data=array(
                'name'=>"long"
            );
            WechatService::sendTemplate($openid,$temId,$data);
        }
    }

    //微信菜单
    public function getMenu(){
        $menu= WechatService::menuService();
        $res=$menu->all();
        halt($res);
    }

    // 发送模版消息
    /**
     * openId 用户openid
     * temId  公众号创建模版消息生成的模版id
     */
    public function sendTemp(){
        $openid = cache('openid');
        $temId = "vjDCEsAKgrVzSezGK9zZOH50V0MrWwaRKzcr4Ip7HNU";
        $data = array(
            'name' => "long"
        );
        $res=WechatService::sendTemplate($openid, $temId, $data);
        halt($res);
    }

    // 获取jssdk config
    public function getJssdk(){
        $js= WechatService::jsSdk();
        dump($js);
    }

    /**
     * 微信服务器  验证
     */
    public function valid(){
        $echoStr = input("echostr");
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    /**
     * 用于验证是否是微信服务器发来的消息
     * @return bool
     */
    private function checkSignature()
    {
        $signature = input("signature");
        $timestamp = input("timestamp");
        $nonce = input("nonce");
        
        $token = config('wx_info_test.token');
        $tmpArr =array($timestamp, $nonce, $token);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }
}
