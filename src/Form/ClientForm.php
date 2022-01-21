<?php
namespace App\Form;

use App\Entity\Address;
use App\Entity\Client;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
            ->add('phones', CollectionType::class, [
                'entry_type' => PhoneForm::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                "allow_delete" => true,
                'by_reference' => false
            ])
            ->add('save',SubmitType::class);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
            'cascade_validation' => true,
        ]);
    }
}