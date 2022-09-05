<?php
namespace vendor\ZEmail;
class Email{
    public static function send(string $to, string $subject, string $message,array $headers = []) {
        mail($to, $subject, $message, $headers);
    }
}