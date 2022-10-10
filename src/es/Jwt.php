<?php
/**
 * 作者：本
 * 创建时间：2022/10/4 17:08
 * 格言：如果你是这个房间中最聪明的，那么你走错房间了
 */

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtServices
{

    /**
     * @Desc:
     * @param $uid
     * @param $exp
     * @return string
     * 由 PhpStorm 创建
     * @author: 章政
     * @Date Time: 2022/10/4 17:18
     * 描述：JWT加密 用户ID 过期时间
     */
    public static function setJwt(int $uid , int $exp = 7200)
    {
        $payload = [
            'uid' => $uid ,
            'exp' => time() + $exp
        ];
        $jwt = JWT::encode($payload, config('setting.privateKey'), 'RS256');
        return $jwt;
    }

    /**
     * @Desc:
     * @param $token
     * @return array|\stdClass|null
     * 由 PhpStorm 创建
     * @author: 章政
     * @Date Time: 2022/10/4 17:18
     * 描述：解密JWT
     */
    public static function getJwt(string $token)
    {
        $decoded = JWT::decode($token, new Key(config('setting.publicKey'), 'RS256'));
        $decoded && $decoded = (array)$decoded;
        return $decoded;
    }
}
