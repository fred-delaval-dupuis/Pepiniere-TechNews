<?php

namespace App\Form;

use App\Entity\User;
use App\User\UserRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, ['label' => 'form.user.firstname', 'attr' => ['placeholder' => 'form.user.placeholder.firstname']])
            ->add('lastName', TextType::class, ['label' => 'form.user.lastname', 'attr' => ['placeholder' => 'form.user.placeholder.lastname']])
            ->add('email', EmailType::class, ['attr' => ['placeholder' => 'form.user.placeholder.email']])
            ->add('password', PasswordType::class, ['label' => 'form.user.password', 'attr' => ['placeholder' => 'form.user.placeholder.password']])
            ->add('cgu', CheckboxType::class, [
                'mapped'        => false,
                'constraints'   => [ new IsTrue() ],
                'label'         => 'form.user.cgu.label',
            ])
            ->add('submit', SubmitType::class, ['label' => 'form.user.submit'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserRequest::class,
            'translation_domain' => 'forms',
        ]);
    }
}
