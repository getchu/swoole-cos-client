<?php


namespace ZhuangDeBiao\SwooleCosClient;

class ObjectClient
{
    /**
     * @var Config
     */
    public $config;

    public $host = '%s.cos.%s.myqcloud.com';

    public $cdn = 'https://%s.file.myqcloud.com';

    public function __construct(Config $cosConfig)
    {
        $this->config = $cosConfig;
        $this->host = sprintf($this->host, $this->config->getBucket(), $cosConfig->getRegion());
        $this->cdn = sprintf($this->cdn, $this->config->getBucket());
    }

    // 上传文件
    public function putObject(string $key, string $filename){
        $requestPath = '/' . ltrim($key , '/');
        try{
            return $this->requestObject('PUT', $requestPath, '', [], $filename);
        }catch (\Exception $e){
            return null;
        }
    }

    // 文件是否存在
    public function headObject(string $key) {
        $requestPath = '/' . ltrim($key , '/');
        try{
            return $this->requestObject('HEAD', $requestPath);
        }catch (\Exception $e){
            return null;
        }
    }

    // 删除文件
    public function deleteObject(string $key) {
        $requestPath = '/' . ltrim($key , '/');
        try{
            return $this->requestObject('DELETE', $requestPath);
        }catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param $method
     * @param $path
     * @param $queryString
     * @param $headers
     * @param string|null $filename
     * @return array
     * @throws \Exception
     */
    private function requestObject(string $method, string $path, string $queryString = '', array $headers = [], ?string $filename = null) :array {
        $method = strtoupper($method);

        if (!is_null($filename)){
            if (!file_exists($filename)){
                throw new \Exception('Cos:file not exists');
            }
            $headers = \array_merge($headers, [
                'Content-Length' =>  filesize($filename),
                'Content-Type' => mime_content_type($filename),
                'Content-MD5' => base64_encode(md5_file($filename, true)), // PUT POST
            ]);
        }
        $headers['Authorization'] = (new Signature($this->config))
            ->createAuthorizationHeader($method, $headers, $path, $queryString);

        $httpClient = new \Swoole\Coroutine\Http\Client($this->host, 80, false);
        $httpClient->set([
            'timeout' => 3600,
            'connect_timeout' => 2,
            'read_timeout' => 60,
            'write_timeout' => 3600
        ]);
        $httpClient->setMethod($method);
        $httpClient->setHeaders($headers);
        if (!is_null($filename)) {
            $httpClient->setData(file_get_contents($filename));
        }
        $httpClient->execute($path . ($queryString ? '?'.$queryString : '') );
        $httpClient->close();

        if ($httpClient->errCode !== 0) {
            throw new \Exception('errorCode:'.$httpClient->errCode.',errorMsg:'.$httpClient->errMsg);
        }
        $body = trim((string) $httpClient->getBody());
        if ($httpClient->getStatusCode() !== 200 && $httpClient->getStatusCode() !== 204) {
            throw new \Exception('statusCode:'.$httpClient->getStatusCode(). (string) $httpClient->getBody());
        }
        return [
            'status' => $httpClient->getStatusCode(),
            'headers' => $httpClient->getHeaders(),
            'body' => strlen($body) > 0 ? XML::toArray($body) : []
        ];
    }

    // 默认CDN链接
    public function getUrl(string $key) :string {
        $requestPath = '/' . ltrim($key , '/');
        return $this->cdn . $requestPath;
    }

    // 临时CDN链接
    public function getTempUrl(string $key) :string {
        $requestPath = '/' . ltrim($key , '/');
        $time = time();
        $signature = md5($this->config->getCdnSecret(). $requestPath .$time, false);
        return $this->cdn . $requestPath.'?sign='.$signature.'&t='.$time;
    }
}
