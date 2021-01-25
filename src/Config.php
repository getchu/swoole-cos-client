<?php

namespace ZhuangDeBiao\SwooleCosClient;

class Config extends SplBean
{
    protected $appId;
    protected $secretId;
    protected $secretKey;
    protected $region;
    protected $bucket;
    protected $cdnSecret;

    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @param mixed $appId
     */
    public function setAppId($appId): void
    {
        $this->appId = $appId;
    }

    /**
     * @return mixed
     */
    public function getSecretId()
    {
        return $this->secretId;
    }

    /**
     * @param mixed $secretId
     */
    public function setSecretId($secretId): void
    {
        $this->secretId = $secretId;
    }

    /**
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @param mixed $secretKey
     */
    public function setSecretKey($secretKey): void
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     */
    public function setRegion($region): void
    {
        $this->region = $region;
    }

    /**
     * @return mixed
     */
    public function getBucket()
    {
        return $this->bucket;
    }

    /**
     * @param mixed $bucket
     */
    public function setBucket($bucket): void
    {
        $this->bucket = $bucket;
    }

    /**
     * @return mixed
     */
    public function getCdnSecret()
    {
        return $this->cdnSecret;
    }

    /**
     * @param mixed $cdnSecret
     */
    public function setCdnSecret($cdnSecret): void
    {
        $this->cdnSecret = $cdnSecret;
    }


}
