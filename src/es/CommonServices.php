<?php
/**
 * 作者：本
 * 创建时间：2022/10/4 17:08
 * 格言：如果你是这个房间中最聪明的，那么你走错房间了
 */

namespace App\Services;

class CommonServices
{

    /**
     * @Desc:
     * @param $msg
     * @param $data
     * @param $errorcode
     * @return false|string
     * 由 PhpStorm 创建
     * @author: 章政
     * @Date Time: 2022/10/4 17:29
     * 描述：统一返回成功json
     */
    public static function success($msg = 'OK'  , $data = [] , $errorcode = 0)
    {
        return json_encode([
            'msg' => $msg,
            'data' => $data ,
            'errorcode' => $errorcode
        ]);
    }

    /**
     * @Desc:
     * @param $msg
     * @param $errorcode
     * @return false|string
     * 由 PhpStorm 创建
     * @author: 章政
     * @Date Time: 2022/10/4 17:29
     * 描述：统一返回失败json
     */
    public static function fail($msg = ''  , $errorcode = 10000)
    {
        return json_encode([
            'msg' => $msg ,
            'errorcode' => $errorcode
        ]);
    }
    /**
     *
    function throttle(fn, interval) {
    var enterTime = 0;//触发的时间
    var gapTime = interval || 300 ;//间隔时间，如果interval不传，则默认300ms
    return function() {
    var context = this;
    var backTime = new Date();//第一次函数return即触发的时间
    if (backTime - enterTime > gapTime) {
    fn.call(context,arguments);
    enterTime = backTime;//赋值给第一次触发的时间，这样就保存了第二次触发的时间
    }
    };
    }

    function debounce(fn, interval) {
    var timer;
    var gapTime = interval || 1000;//间隔时间，如果interval不传，则默认1000ms
    return function() {
    clearTimeout(timer);
    var context = this;
    var args = arguments;//保存此处的arguments，因为setTimeout是全局的，arguments不是防抖函数需要的。
    timer = setTimeout(function() {
    fn.call(context,args);
    }, gapTime);
    };
    }

    export default {
    throttle,
    debounce
    };
     */

    /**
     * 砍价算法-获取砍价金额
     * @param int $people   砍价人数或次数
     * @param int $amount   砍价总额
     * @param int $min      最低砍价金额 不得低于0
     * @param int $max      最高砍价金额 砍价次数 * 最高砍价金额不得小于砍价总额
     *
     * @return array
     */
    public function getRandomAmount($people = 0, $totalAmount = 0, $min = 0, $max = 0)
    {
        if ($people * $max <= $totalAmount) {
            return false;
        }
        $arr = $this->genRandomAmount($people, $totalAmount, $min, $max);
        // 有几率会因为递归调用超出限制而返回空数组，这里继续重新生成，直到金额正确
        while (empty($arr)) {
            $arr = $this->genRandomAmount($people, $totalAmount, $min, $max);
        }
        return $arr;
    }
//$res = getRandomAmount(10,100,9.00,20.00);
//print_r($res);


    public function geturl($url)
    {
        $headerArray = array("Content-type:application/json;", "Accept:application/json");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output, true);
        return $output;
    }

    public function posturl($url, $data)
    {
        $data = json_encode($data);
        $headerArray = array("Content-type:application/json;charset='utf-8'", "Accept:application/json");
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArray);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return json_decode($output, true);
    }
}
