<?php

namespace Naif\cPanelMail;

class Email
{
    public $user;
    public $domain;
    public $email;
    public $_diskused = 0;
    public $_diskquota = 52428800;
    public $humandiskused;
    public $humandiskquota;
    public $suspended_incoming;
    public $suspended_login;
    public $mtime;
    
    public function __construct($item = null)
    {
        $this->setProperties($item);
    }
    
    public function destroy()
    {
        $cpanel = app()->make(cPanel::class);
        
        return $cpanel
            ->email()
            ->destroy($this);
    }
    
    /**
     * @param $item
     */
    private function setProperties($item)
    {
        if ($item != null) {
            foreach ($item as $key => $value) {
                if (property_exists($this, $key)) {
                    if ($key == '_diskquota' && $value <= 1000){
                        $value = $value * 1024 * 1024;
                    }
                    $this->{$key} = $value;
                }
            }
        }
        if ( ! $this->email && ($this->user && $this->domain)) {
            $this->email = $this->user . "@" . $this->domain;
        }
    }
    
}