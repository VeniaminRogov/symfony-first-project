<?php
namespace App\Form;

use App\Entity\City;
use App\Entity\Client;
use App\Entity\Phone;
use App\Object\ObjectSearchForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false
            ])
            ->add('email', TextType::class, [
                'required' => false
            ])
            ->add('phone', TextType::class, [
                'required' => false,
//                'class' => Phone::class,
//                'choice_label' => 'number'
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'male' => Client::GENDER_MALE,
                    'female' => Client::GENDER_FEMALE,
                    'hz' => Client::GENDER_HZ
                ],
                'required' => false
//                'multiple' => true
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
                'required' => false

            ])
            ->add('sortField', ChoiceType::class, [
                'choices' => [
                    'First name' => 'c.firstName',
                    'Last name' => 'c.lastName',
                    'City' => 'ci.name',
                    'Phone' => 'cp.number'
                ]
            ])
            ->add('orderBy', ChoiceType::class, [
                'choices' => [
                    'ASC' => 'asc',
                    'DESC' => 'desc',
                ]
            ])
            ->add('sort',SubmitType::class);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ObjectSearchForm::class,
        ]);
    }
}