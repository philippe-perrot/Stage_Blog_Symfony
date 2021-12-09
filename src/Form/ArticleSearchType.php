<?php

namespace App\Form;

use App\Entity\ArticleSearch;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('article', TextType::class, [
                'required' => false,
                'label' => "Nom de l'article",
            ])
            ->add('category', EntityType::class, [
                'required' => false,
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => 'true',
            ])
            ->add('date', DateType::class, [
                'required' => false,
                'label' => 'Date',
                'attr' => [
                    'placeholder' => 'Date'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ArticleSearch::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

}
