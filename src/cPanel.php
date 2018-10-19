<?php

namespace Naif\cPanelMail;
include_once('Config.php');

class cPanel
{
    public $url;
    public $fields;
    private $fallbackFields;
    protected $cpanel;

    /**
     * If testing, this will fake the responses
     * @var \GuzzleHttp\Handler\MockHandler
     */
    public $mock;

    function __construct()
    {
        $this->url = config('Config.host') . ':' . config('Config.port');
        $this->cleanConfig();
    }
    
    public function email()
    {
        return new cPanelEmail();
    }

    /**
     * Adiciona campos da array informada nas configurações
     *
     * @param array $fields
     */
    public function mergeFields(array $fields)
    {
        $this->fallbackFields = $this->fields;
        
        if (is_array($fields)) {
            $this->fields = array_merge($this->fields, $fields);
        }
    }
    
    public function cleanConfig()
    {
        $this->fields = [
            'cpanel_jsonapi_user'       => config('Config.username'),
            'cpanel_jsonapi_apiversion' => config('Config.version'),
            'cpanel_jsonapi_module'     => 'Email',
            'cpanel_jsonapi_func'       => '',
        ];
    }

    /**
     * @return array
     */
    public function getEmailAddresses()
    {
        $emails = $this->email()->fetch()->all();
        $list = [];
        foreach ($emails as $email){
            array_push($list,$email);
        }
       return $list;
    }


    /**
     * @param $email_address
     * @param $password
     * @return array
     */
    public function create($email_address, $password)
    {
        if ($email_address) {
            $email = new Email();
            $email->email = $email_address . '@' . config('Config.domain');
            try {
                $response = $this->email()->store($email,$password);

                if ($response->count() > 0) {
                    return ['status'=>'success', 'message'=>'Email address has been added successfully'];
                }
                return ['status'=>'error', 'message'=>'Failed to add email address!'];
            } catch (\Exception $e) {
                return ['status'=>'error', 'message'=>$e->getMessage()];
            }
        }
    }

    /**
     * @param $email_address
     * @return array
     */
    public function delete($email_address)
    {
        if ($email_address) {
            $email = new Email();
            $email->domain = config('Config.domain');
            $email->user = $email_address;
            try {
                $response = $this->email()->destroy($email);
                if ($response) {
                    return ['status'=>'success', 'message'=>'Email address has been deleted successfully'];
                }
                return ['status'=>'error', 'message'=>'Failed to delete email address!'];
            } catch (\Exception $e){
                return ['status'=>'error', 'message'=>$e->getMessage()];
            }
        }
    }
}