<?php

namespace App\Form;

use App\Article\ArticleRequest;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ArticleType extends AbstractType
{
    /**
     * @var string
     */
    private $assetsDir;

    public function __construct($assetsDir)
    {
        $this->assetsDir = $assetsDir;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('content', CKEditorType::class, ['label' => 'Contenu'])
            ->add('category', EntityType::class, ['label' => 'Categorie', 'class' => Category::class, 'choice_label' => 'title'])
            ->add('featuredImage', FileType::class, ['label' => 'Image', 'data_class' => null, 'attr' => ['class' => 'dropify', 'data-default-file' => $options['image_url']]])
            ->add('special', CheckboxType::class, ['label' => 'Mis en avant ?', 'required' => false, 'attr' => ['data-toggle' => 'toggle', 'data-on' => 'Oui', 'data-off' => 'Non']])
            ->add('spotlight', CheckboxType::class, ['label' => 'Spotlight ?', 'required' => false, 'attr' => ['data-toggle' => 'toggle', 'data-on' => 'Oui', 'data-off' => 'Non']])
            ->add('submit', SubmitType::class, ['label' => 'Publier'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'    => ArticleRequest::class,
            'image_url'     => null,
        ]);
    }
}
