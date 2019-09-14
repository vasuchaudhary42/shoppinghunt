<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GroupSequence;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',        TextType::class)
            ->add('email',       TextType::class)
            ->add('companyName', TextType::class)
            ->add('domain',      TextType::class)
            ->add('password',    RepeatedType::class,[
                'type' =>                   PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'first_options' => ['label' => false],
                'second_options'=> ['label' => false]
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'allow_extra_fields' => true,
            'validation_groups' => new GroupSequence(['Registration']),
            'csrf_protection' => false
        ]);
    }
}