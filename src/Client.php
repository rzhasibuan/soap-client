<?php namespace Sugeng\Soap;

use Carbon\Carbon;
use nusoap_client;
use Sugeng\Soap\Exceptions\SoapClientException;

/**
 * Created By: Sugeng
 * Date: 1/26/17
 * Time: 10:52
 */
class Client
{
    protected $client;
    protected $config;
    protected $proxy;
    protected $token;

    /**
     * Client constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->validateConfig($config);

        $this->config = $config;

        $this->client = new nusoap_client($this->config['url'], true);

        return $this->init();
    }

    /**
     * @return mixed
     */
    public function token()
    {
        $this->validateToken();

        return $this->token;
    }

    /**
     * @return mixed
     */
    public function proxy()
    {
        return $this->proxy;
    }

    /**
     * @return $this
     */
    public function make()
    {
        return $this;
    }

    /**
     * @return nusoap_client|object
     */
    protected function init()
    {
        $this->proxy = $this->client->getProxy();

        if (is_null($this->proxy)) return $this->client;

        return $this;
    }

    /**
     * @internal param $proxy
     */
    protected function authenticate()
    {
        $token = $this->proxy->GetToken($this->config['username'], $this->config['password']);

        cache([$this->config['token-name'] => $token], Carbon::now()->addMinute(60));

        $this->token = $token;
    }

    /**
     * @param $configs
     * @throws SoapClientException
     */
    protected function validateConfig($configs)
    {
        foreach ($configs as $key => $config) {
            if (empty ($config)) throw new SoapClientException("Configuration for {$key} not valid/empty");
        }
    }

    /**
     * @internal param $proxy
     * @internal param $token
     */
    protected function validateToken()
    {
        if (!is_null($this->token = cache()->get($this->config['token-name']))) {
            $code = $this->proxy->GetExpired($this->token);

            if ($code['error_code'] == 100) {
                cache()->forget($this->config['token-name']);
                $this->authenticate();
            }
        } else {
            $this->authenticate();
        }
    }
}