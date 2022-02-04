<?php

namespace App\Form\DataTransformer;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TagsTransformer implements DataTransformerInterface{
    public function transform($tagsAsString): string
    {
        if(null == $tagsAsString){
            return '';
        }
        return implode(', ', $tagsAsString);
    }

    public function reverseTransform($tagsAsString):array
    {
        return explode(',', $tagsAsString);
    }
}