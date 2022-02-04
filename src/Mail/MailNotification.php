<?php

namespace App\Mail;

class MailNotification {
    public const CLIENT_ADDED = 'client.added';
    public const USER_REGISTRATION = 'client.registration';
    public const USER_RESET_PASSWORD = 'client.resetPassword';

    public function __construct(
        private int $id,
        private string $type,
        private ?string $verificationUrl = null,
        private ?string $resetToken = null,
    )
    {
    }
    public function getId(){
        return $this->id;
    }

    public function getType(){
        return $this->type;
    }

    public function getVerificationUrl(){
        return $this->verificationUrl;
    }
    public function getResetToker(){
        return $this->resetToken;
    }
}