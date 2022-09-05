<?php
namespace src\observers;

class LoginEmailObserver implements \SplObserver{
    private $email;

    public function __construct(object $email){
        $this->email = $email;
    }

    public function update(\SplSubject $subject){
        $user = $subject->getUser();
        $to = $user->getEmail();
        $subject = "Connexion sur Forum";
        $message = "Bonjour ".$user->getName()."\r\n";
        $message .= "Une personne s'est connectée sur votre compte avec IP : ".$_SERVER['REMOTE_ADDR'];
        $this->email::send($to,$subject,$message);
    }
}