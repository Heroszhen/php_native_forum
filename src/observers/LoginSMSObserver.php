<?php
namespace src\observers;

class LoginSMSObserver implements \SplObserver{
    private $sms;

    public function __construct(object $sms = null){
        $this->sms = $sms;
    }

    public function update(\SplSubject $subject){
       
    }
}