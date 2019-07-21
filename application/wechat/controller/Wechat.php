<?php

namespace app\wechat\controller;

use service\WechatService;
use service\JsonService;
use service\CacheService;
/**
 * 微信服务器  验证控制器
 * Class Wechat
 */

class Wechat 
{
    public function index()
    {
        dump(UPLOAD_PATH);
        echo '<br>';
        echo CacheService::get('mid');
        echo '<br>';
        echo WechatService::uploadDir('wechat/images');
        halt('微信测试');
    }

    //weixin
    public function reply()
    {
        // cache('openid',input('nonce'));
        if (isset($_GET['echostr'])) {     //验证微信
            $this->valid();
        } else { //回复消息 其他操作
            ob_clean();
            WechatService::serve();
        }
    }

    //微信菜单
    public function getMenu(){
        $menu= WechatService::menuService();
        $res=$menu->current();

        JsonService::successful('ok',$res);
    }

    // 删除菜单
    public function delMenu(){
        $menu_id=input('id',null);
        $menu = WechatService::menuService();
        $res = $menu->destroy($menu_id);
        JsonService::successful('ok', $res);
    }

    // 创建菜单
    public function addMenu(){
        $buttons = [
            [
                "type" => "click",
                "name" => "今日歌曲",
                "key"  => "V1001_TODAY_MUSIC"
            ],
            [
                "name"       => "菜单",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "搜索",
                        "url"  => "http://www.baidu.com/"
                    ],
                    [
                        "type" => "view",
                        "name" => "doris",
                        "url"  => "http://wx.ucat.club/wx-home.html"
                    ]
                ],
            ],
        ];
        $menu = WechatService::menuService();
        $res = $menu->add($buttons);
        JsonService::successful('ok', $res);
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
        JsonService::successful('ok', $res);
    }

    // 获取jssdk config
    /**
     * url 前端使用url
     * debug 定义是否打开
     * apis 自定义jssdk接口列表
     */
    public function getJssdk(){
        $url=input('url');
        $debug=input('debug',false);
        $apis=input('apis','');
        $apiList=$apis?explode(',',$apis):[];
        $res= WechatService::jsSdk($url,$apiList,$debug);
        JsonService::successful('ok', $res);
    }

    /**
     * 下载素材并保存到服务器
     * 返回 地址
     */
    public function getMaterial(){
        $materialId=input('mid','');
        CacheService::set('mid', $materialId);
        $res=WechatService::getMaterial($materialId);
        JsonService::successful('ok', $res);
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
        
        $token = config('wechat_config.token');
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
