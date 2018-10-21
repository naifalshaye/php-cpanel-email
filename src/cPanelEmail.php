<?php

namespace Naif\cPanelMail;

use Illuminate\Support\Collection;

class cPanelEmail extends cPanelBaseModule
{
    
    function __construct()
    {
        parent::__construct();
        $this->cpanel->mergeFields([
            'cpanel_jsonapi_module' => 'Email',
        ]);
    }
    
    /**
     * returns an emails collection
     *
     * @return Collection
     */
    public function fetch()
    {
        
        $this->cpanel->mergeFields([
            'cpanel_jsonapi_func' => 'listpopswithdisk',
        ]);
        
        $response = $this->getApiData();
        
        return $this->collectEmails($response);
    }
    
    /**
     * Filters the search to the given email address
     *
     * @param $email
     *
     * @return $this
     */
    public function filter($email)
    {
        $this->cpanel->mergeFields([
            'regex' => $email,
        ]);
        return $this;
    }
    
    /**
     * Filters the search to the given domain name
     *
     * @param $domain
     *
     * @return $this
     */
    public function filterDomain($domain)
    {
        
        $this->cpanel->mergeFields([
            'domain' => $domain,
        ]);
        
        return $this;
    }
    
    /**
     * Stores a new email if there isnt any with the specified information
     *
     * @param Email $email
     * @param       $password
     *
     * @return Collection
     * @throws \Exception
     */
    public function store(Email $email, $password)
    {
        if ($this->cpanel->email()->filter($email->email)->fetch()->count()) {
            throw new \Exception("The e-mail \"" . $email->email . "\" already exists.");
        }

        $this->cpanel->mergeFields([
            'cpanel_jsonapi_func' => 'addpop',
            'domain'              => $email->domain,
            'email'               => $email->email,
            'password'            => $password,
            'quota'               => 0, // 50mb = 52428800b
        ]);
        $this->getApiData();

        return $this->cpanel->email()->filter($email->email)->fetch();
    }

    /**
     * Changes the password from the given email
     *
     * @param Email $email
     * @param       $password
     *
     * @return bool
     */
    public function updatePassword(Email $email, $password)
    {
        $this->cpanel->mergeFields([
            'cpanel_jsonapi_func' => 'passwdpop',
            'domain'              => $email->domain,
            'email'               => $email->user,
            'password'            => $password,
        ]);
        $this->getApiData();
        return true;
    }
    
    /**
     * Change the quota from the given email
     *
     * @param Email $email
     *
     * @return bool
     * @throws \Exception
     */
    public function updateQuota(Email $email)
    {
        if (!$email->domain || !$email->user || ! $email->diskquota){
            throw new \Exception("Invalid Email Object, must fill the domain, user and _diskquota properties.");
        }
        $this->cpanel->mergeFields([
            'cpanel_jsonapi_func' => 'editquota',
            'domain'              => $email->domain,
            'email'               => $email->user,
            'quota'               => $email->diskquota, // convert to mb
        ]);
        $this->getApiData();
        return true;
    }
    
    /**
     * Remove the given email
     *
     * @param Email $email
     *
     * @return bool
     */
    public function destroy(Email $email)
    {
        $this->cpanel->mergeFields([
            'cpanel_jsonapi_func' => 'delpop',
            'domain'              => $email->domain,
            'email'               => $email->user,
        ]);
        $this->getApiData();
        return true;
    }
    
    /**
     * @param $response
     *
     * @return Collection
     * @throws \Exception
     */
    private function collectEmails($response)
    {
        $itens = $response->data;
        $emails = new Collection();
        foreach ($itens as $item) {
            $emails->push(
                new Email($item)
            );
        }
        return $emails;
    }
}