<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppFunction extends AbstractExtension{
    public function getFunctions()
    {
        return [
            new TwigFunction('mail', [$this, 'passEmail']),
        ];
    }

    public function passEmail(string $email){
        return substr_replace($email, "***", 0, strrpos($email, "@"));
    }
}