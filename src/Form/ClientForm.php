<?php
namespace App\Form;

use App\Entity\Address;
use App\Entity\Client;
use App\Form\DataTransformer\TagsTransformer;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientForm extends AbstractType {

    public function __construct(private TagsTransformer $transformer)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email', EmailType::class)
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'male' => Client::GENDER_MALE,
                    'female' => Client::GENDER_FEMALE,
                    'hz' => Client::GENDER_HZ
                ],
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => 'Is active?',
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
            ->add('avatar', FileType::class, [
                'mapped' => false,
                'required' => false
            ])
            ->add('tags', TextType::class, [
                'required' => false,
            ])
            ->add('save',SubmitType::class);

        $builder->get('tags')
            ->addModelTransformer($this->transformer);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
            'cascade_validation' => true,
        ]);
    }
}