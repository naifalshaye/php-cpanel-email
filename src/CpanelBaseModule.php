<?php

namespace Naif\CpanelMail;

use GuzzleHttp\Client;

abstract class CpanelBaseModule
{
    
    /**
     * @var Cpanel
     */
    protected $cpanel;
    protected $config = [];
    protected $mock;
    
    function __construct()
    {
        $this->cpanel = app()->make(Cpanel::class);
        $this->config['base_uri'] = $this->cpanel->url;
    }
    
    /**
     * @return mixed
     * @throws \Exception
     */
    protected function getApiData()
    {
        $client = new Client($this->config);
        $response = $client->post('/json-api/cpanel', [
            'auth'        => [config('Config.username'), config('Config.password')],
            'form_params' => $this->cpanel->fields,
        ]);
        $apiData = json_decode($response->getBody()->getContents());
        $this->cpanel->cleanConfig();
        $this->errorHandler($apiData->cpanelresult);
        return $apiData->cpanelresult;
    }
    
    /**
     * throws an Exception if there is any error
     *
     * @param $cpanelresult
     *
     * @throws \Exception
     */
    protected function errorHandler($cpanelresult)
    {
        if (isset($cpanelresult->data->status) || isset($cpanelresult->error)) {
            
            if (isset($cpanelresult->data->status) && $cpanelresult->data[0]->status == 0) {
                if (preg_match('/permission to read the zone/', $cpanelresult->data[0]->statusmsg)) {
                    throw new \Exception("You don't have permissions to read data from this domain");
                }
                
                throw new \Exception($cpanelresult->data[0]->statusmsg);
            }
            
            if (isset($cpanelresult->error)) {
                if (preg_match('/Permission denied/', $cpanelresult->error)) {
                    throw new \Exception("You don't have permissions to execute this action.");
                }
                if (preg_match('/You do not have an email account named/', $cpanelresult->error)) {
                    throw new \Exception("You do not own this email account.");
                }
                
                throw new \Exception($cpanelresult->error);
            }
        }
    }
    
}