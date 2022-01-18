<?php
namespace App\Form;

use App\Entity\Address;
use App\Entity\Client;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientForm extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'male' => Client::GENDER_MALE,
                    'female' => Client::GENDER_FEMALE,
                    'hz' => Client::GENDER_HZ
                ],
            ])
            ->add('isActive', CheckboxType::class, [
                'required' => false
            ])
            ->add('address', AddressForm::class)
            ->add('save',SubmitType::class);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
            'cascade_validation' => true
        ]);
    }
}