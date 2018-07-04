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
            ->add('firstName',  TextType::class,        ['label' => 'Prénom', 'attr' => ['placeholder' => 'Saisissez votre prénom']])
            ->add('lastName',   TextType::class,        ['label' => 'Nom', 'attr' => ['placeholder' => 'Saisissez votre nom']])
//            ->add('username',   TextType::class,        ['label' => 'Nom d\'utilisateur', 'attr' => ['placeholder' => 'Saisissez votre nom d\'utilisateur']])
            ->add('email',      EmailType::class,       ['attr' => ['placeholder' => 'Saisissez votre e-mail']])
            ->add('password',   PasswordType::class,    ['label' => 'Mot de passe', 'attr' => ['placeholder' => '********']])
            ->add('cgu',        CheckboxType::class,    [
                'mapped'        => false,
                'constraints'   => [ new IsTrue() ],
                'label'         => 'J\'accepte les conditions générales d\'utilisation',
            ])
            ->add('submit',     SubmitType::class,      ['label' => 'S\'inscrire'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserRequest::class,
        ]);
    }
}
