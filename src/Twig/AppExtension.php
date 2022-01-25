<?php

namespace App\Twig;

use App\Entity\Client;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension {
    public function getFilters()
    {
        return [
          new TwigFilter('gender', [$this, 'getGender'])
        ];
    }

    public function getGender(int $choice){
        $client = new Client();
        if($choice == $client::GENDER_MALE){
            return 'Male';
        }
        elseif ($choice == $client::GENDER_FEMALE){
            return 'Female';
        }
        else{
            return 'HZ';
        }
    }
}