<?php
namespace App\Form;

use App\Entity\City;
use App\Entity\Client;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchForm extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'male' => Client::GENDER_MALE,
                    'female' => Client::GENDER_FEMALE,
                    'hz' => Client::GENDER_HZ
                ],
//                'multiple' => true
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name'
            ])
            ->add('save',SubmitType::class);
    }
}
