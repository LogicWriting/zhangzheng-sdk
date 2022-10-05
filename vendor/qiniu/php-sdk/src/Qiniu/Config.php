<?php
namespace Qiniu;

final class Config
{
    const SDK_VER = '7.7.0';

    const BLOCK_SIZE = 4194304; //4*1024*1024 分块上传块大小，该参数为接口规格，不能修改

    const RSF_HOST = 'rsf.qiniu.com';
    const API_HOST = 'api.qiniu.com';
    const RS_HOST = 'rs.qiniu.com';      //RS Host
    const UC_HOST = 'uc.qbox.me';              //UC Host
    const RTCAPI_HOST = 'http://rtc.qiniuapi.com';
    const ARGUS_HOST = 'ai.qiniuapi.com';
    const CASTER_HOST = 'pili-caster.qiniuapi.com';
    const SMS_HOST="https://sms.qiniuapi.com";
    const RTCAPI_VERSION = 'v3';
    const SMS_VERSION='v1';

    // Zone 空间对应的存储区域
    public $region;
    //BOOL 是否使用https域名
    public $useHTTPS;
    //BOOL 是否使用CDN加速上传域名
    public $useCdnDomains;
    /**
     * @var Region
     */
    public $zone;
    // Zone Cache
    private $regionCache;

    // 构造函数
    public function __construct(Region $z = null)
    {
        $this->zone = $z;
        $this->useHTTPS = false;
        $this->useCdnDomains = false;
        $this->regionCache = array();
    }

    public function getUpHost($accessKey, $bucket)
    {
        $region = $this->getRegion($accessKey, $bucket);
        if ($this->useHTTPS === true) {
            $scheme = "https://";
        } else {
            $scheme = "http://";
        }

        $host = $region->srcUpHosts[0];
        if ($this->useCdnDomains === true) {
            $host = $region->cdnUpHosts[0];
        }

        return $scheme . $host;
    }

    public function getUpHostV2($accessKey, $bucket)
    {
        list($region, $err) = $this->getRegionV2($accessKey, $bucket);
        if ($err != null) {
            return array(null, $err);
        }

        if ($this->useHTTPS === true) {
            $scheme = "https://";
        } else {
            $scheme = "http://";
        }

        $host = $region->srcUpHosts[0];
        if ($this->useCdnDomains === true) {
            $host = $region->cdnUpHosts[0];
        }

        return array($scheme . $host, null);
    }

    public function getUpBackupHost($accessKey, $bucket)
    {
        $region = $this->getRegion($accessKey, $bucket);
        if ($this->useHTTPS === true) {
            $scheme = "https://";
        } else {
            $scheme = "http://";
        }

        $host = $region->cdnUpHosts[0];
        if ($this->useCdnDomains === true) {
            $host = $region->srcUpHosts[0];
        }

        return $scheme . $host;
    }

    public function getUpBackupHostV2($accessKey, $bucket)
    {
        list($region, $err) = $this->getRegionV2($accessKey, $bucket);
        if ($err != null) {
            return array(null, $err);
        }

        if ($this->useHTTPS === true) {
            $scheme = "https://";
        } else {
            $scheme = "http://";
        }

        $host = $region->cdnUpHosts[0];
        if ($this->useCdnDomains === true) {
            $host = $region->srcUpHosts[0];
        }

        return array($scheme . $host, null);
    }

    public function getRsHost($accessKey, $bucket)
    {
        $region = $this->getRegion($accessKey, $bucket);

        if ($this->useHTTPS === true) {
            $scheme = "https://";
        } else {
            $scheme = "http://";
        }

        return $scheme . $region->rsHost;
    }

    public function getRsHostV2($accessKey, $bucket)
    {
        list($region, $err) = $this->getRegionV2($accessKey, $bucket);
        if ($err != null) {
            return array(null, $err);
        }

        if ($this->useHTTPS === true) {
            $scheme = "https://";
        } else {
            $scheme = "http://";
        }

        return array($scheme . $region->rsHost, null);
    }

    public function getRsfHost($accessKey, $bucket)
    {
        $region = $this->getRegion($accessKey, $bucket);

        if ($this->useHTTPS === true) {
            $scheme = "https://";
        } else {
            $scheme = "http://";
        }

        return $scheme . $region->rsfHost;
    }

    public function getRsfHostV2($accessKey, $bucket)
    {
        list($region, $err) = $this->getRegionV2($accessKey, $bucket);
        if ($err != null) {
            return array(null, $err);
        }

        if ($this->useHTTPS === true) {
            $scheme = "https://";
        } else {
            $scheme = "http://";
        }

        return array($scheme . $region->rsfHost, null);
    }

    public function getIovipHost($accessKey, $bucket)
    {
        $region = $this->getRegion($accessKey, $bucket);

        if ($this->useHTTPS === true) {
            $scheme = "https://";
        } else {
            $scheme = "http://";
        }

        return $scheme . $region->iovipHost;
    }

    public function getIovipHostV2($accessKey, $bucket)
    {
        list($region, $err) = $this->getRegionV2($accessKey, $bucket);
        if ($err != null) {
            return array(null, $err);
        }

        if ($this->useHTTPS === true) {
            $scheme = "https://";
        } else {
            $scheme = "http://";
        }

        return array($scheme . $region->iovipHost, null);
    }

    public function getApiHost($accessKey, $bucket)
    {
        $region = $this->getRegion($accessKey, $bucket);

        if ($this->useHTTPS === true) {
            $scheme = "https://";
        } else {
            $scheme = "http://";
        }

        return $scheme . $region->apiHost;
    }

    public function getApiHostV2($accessKey, $bucket)
    {
        list($region, $err) = $this->getRegionV2($accessKey, $bucket);
        if ($err != null) {
            return array(null, $err);
        }

        if ($this->useHTTPS === true) {
            $scheme = "https://";
        } else {
            $scheme = "http://";
        }

        return array($scheme . $region->apiHost, null);
    }

    private function getRegion($accessKey, $bucket)
    {
        $cacheId = "$accessKey:$bucket";

        if (isset($this->regionCache[$cacheId])) {
            $region = $this->regionCache[$cacheId];
        } elseif (isset($this->zone)) {
            $region = $this->zone;
            $this->regionCache[$cacheId] = $region;
        } else {
            $region = Zone::queryZone($accessKey, $bucket);
            if (is_array($region)) {
                list($region, $err) = $region;
                if ($err != null) {
                    throw new \Exception($err->message());
                }
            }
            $this->regionCache[$cacheId] = $region;
        }
        return $region;
    }

    private function getRegionV2($accessKey, $bucket)
    {
        $cacheId = "$accessKey:$bucket";

        if (isset($this->regionCache[$cacheId])) {
            $region = $this->regionCache[$cacheId];
        } elseif (isset($this->zone)) {
            $region = $this->zone;
            $this->regionCache[$cacheId] = $region;
        } else {
            $region = Zone::queryZone($accessKey, $bucket);
            if (is_array($region)) {
                list($region, $err) = $region;
                return array($region, $err);
            }
            $this->regionCache[$cacheId] = $region;
        }

        return array($region, null);
    }
}
