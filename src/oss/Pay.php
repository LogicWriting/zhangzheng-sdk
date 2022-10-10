<?php
/**
 * 作者：本
 * 创建时间：2022/10/9 23:02
 * 格言：如果你是这个房间中最聪明的，那么你走错房间了
 */

/**
 * 作者：本
 * 创建时间：2022/10/8 19:31
 * 格言：如果你是这个房间中最聪明的，那么你走错房间了
 */

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Yansongda\Pay\Pay;

class AlipayController
{
    protected $config = [
        'app_id' => '2021000121619729',
        'notify_url' => 'http://month2.com/api/cut_goodslist',
        'return_url' => 'http://month2.com/api/cut_goodslist',

        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxL8Ved6v9ZX/KBPP3a5TUEupTp69Xcd16CytzGHMitovG5e3Ss7S06o/4jASDMP0IZa8gfDAfTx+Wr+XVBhtARbX0TKa0d6jgSrDM0Hw8awydWpiVs3lY9VcelBcPjT7Ni+YP38zX07o4Kir2oJrRW7bPmuMu/8vKsrxS8RITjL0RM/wRYVIU0Tyf+1CRQn/Iq8wnRHHMxFJZvfpeqEfrF5XtBQxf/kybwVBYQTA/gxQzy0y4tCIK71fULfDq2HNqvQksxb8SGcXASkOwwxegM/s7NWqt9+LtS8+mFfE9941ku8e0RpbPnjhSoFg5kfdhrCNvUlCXpx7saK/sgIxZwIDAQAB',
        // 加密方式： **RSA2**
        'private_key' => 'MIIEowIBAAKCAQEAseAUy+9A70vWL3oLYyQV3lekKV6RgM7LLXhPfeOo7mvVaV5P0kXK5zZdW0R5ycC2VKV9aDjwFezfPY5aIRfdbbEOBIlJURoCGcGmuVrTKpu7fNXgMs2akG+ANETvDEFCDHFkFI3eb9tF1whAIA28vW84mkxmwfVTNHUqUIQwmexyNzdYxOe9InpdoqYMn/zqNz/31uEjo7YGloVAmzHpuaWBR0Bty8BpcYgi6oqiN2kPUxLiadDcX8b6WzOzgc45pyxoR0xOFm+JUDmzNWBDaOOchOTGqW7g09M7V14eHYtYkdfKrgs11Kq4Wchn0ZBLK5Jl4bYNN4X5GxSIgsfPTQIDAQABAoIBAB4cRqj3CVD4z3sd98uCkkkfIOT34z2gw/ggg6RV44TosCm0E2MO+XgGVetbPhqPCs5tbTs1WD796BRtgohTl+I3tJ3D96tI8c4WX/jEjTaLQkOxmNBAycdleJhgiu7SJTIiB8UK9vqMbdgmx2QlryuKJlTIViTDOKCKrO0QU4HaoYmUpVy/uB1fkkTiGGcw3tFRUj0QM4TPdwD8k1Svw+fFqiRo9PAWrtLIcSLTCMy8TLjXaUVItC3woSE1FnD4KRdv4lJy5NSjS+9Afxu2lzSE8M/X2/0ohGWFK3BMhe+z6e0MYmoD848rpmtavkFaYiFdKXk80kODdzAgAqzsVekCgYEA+4Kso2nGXjLWhPvFgiwZWkGj6G7GY5/g1R/ODoq0kecLiurLXqmEDrz+osnaIZfphQAJeuyD7btsEyz+DDKI1inLfKq54A6ZiOtXagOicbyi5Mfgk2MskDNaVzH7mL06FUAmuzZNL/cNQNP0pEEQ9lVG/A91/fCC7e5lmMwq3AMCgYEAtQzquh+d3dOKkFKYytmTlRPtex1IkIxfAS3mH7absmG5zv4ZXzpV2tU6oVPGVy9HklQMijmkxSMo2cEaeoqzIm0Qk6+mhau3KM9MYQDf23o4v8Ajog9IDEa36VPEfoppIbLsvwRm/ebdEpEzHvzMmad3svYmImBPFZ032R+4zm8CgYBtp3pXQL2gwi9vCUoCR/HBvQ6WPv2137WpldVD18uENSR+K4IBQoz11AZ8uN6meNHyD6MSed3HH0iuT5ZvgPTR0qUKNHEXs6XS4TBaYz1Gs0Sd1FsgR0PdltYTYBJedFnHfBGm27TpbZ/UnNRzbH7VtzZcnO0Hiv26eI7JAHLLOwKBgCxY9qISnoO4jmddpAmEFA9fKzuN57loeNj8GjNIcojWQUI/oY1e56rLsinUMHAop5pjNhMhnYegXiBAmbDMiqZzGq1iSCLT9fBsHqRgJ3VGUeI+OTw4DAjdxazElQv98VSM1ErR1Dx7MUmcAW6ks6UrjTlr69ldx+FeelCX4ZfHAoGBALjbo0mZkgfJGz92iH4HM9T2W66GOB0vOxaQ35mJuGDM+2vde3ep2oIT2mD+LPQ1A2OjF3rXacDaSl2qsM8Y8M5RUcRHsSmCuYM6RzJGb7xFfAvLhQv5CZmBAu8PU6g3flKnlLqvzBKZbcfagvRoCZyi96sTSIINTlH5bc1wTHq0',

        'log' => [ // optional
            'file' => './logs/alipay.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
    ];

    public function index($time, $total_price = 0, $subject = "订单主题")
    {
        //composer require symfony/psr-http-message-bridge
        //composer require yansongda/pay:^2.10 -vvv

        $params = request()->all();
        $result = Order::where('id', '=', $params['order_id'])
            ->first();
        $result && $result = $result->toArray();
        $order = [
            'out_trade_no' => $result['created_at'],
            'total_amount' => $result['total_price'],
            'subject' => $result['order_sn'],
        ];

        $alipay = Pay::alipay($this->config);

        return $alipay->web($order)->send();// laravel 框架中请直接 `return $alipay`
    }

    public function return()
    {
        $data = Pay::alipay($this->config)->verify(); // 是的，验签就这么简单！

        // 订单号：$data->out_trade_no
        // 支付宝交易号：$data->trade_no
        // 订单总金额：$data->total_amount
    }

    public function notify()
    {
        $alipay = Pay::alipay($this->config);

        try {
            $data = $alipay->verify(); // 是的，验签就这么简单！

            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况

            Log::debug('Alipay notify', $data->all());
        } catch (\Exception $e) {
            // $e->getMessage();
        }

        return $alipay->success()->send();// laravel 框架中请直接 `return $alipay->success()`
    }

}
