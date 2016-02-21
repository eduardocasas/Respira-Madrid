<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Article;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('active', CheckboxType::class, [
                'label' => 'backoffice.article.form.active', 'required' => false,
            ])
            ->add('language', ChoiceType::class, [
                'choices' => [
                     Article::SPANISH_LANGUAGE => 'Español',
                     Article::ENGLISH_LANGUAGE => 'Inglés',
                     Article::BOTH_LANGUAGE => 'Ambos',
                ],
                'choice_translation_domain' => false,
                'label' => 'backoffice.article.form.language',
                'required' => true,
            ])
            ->add('title', TextType::class, [
                'attr' => ['autofocus' => 'autofocus'],
                'label' => 'backoffice.article.form.name',
                'required' => true,
            ])
            ->add('slug', TextType::class, [
                'label' => 'backoffice.article.form.slug',
                'required' => true,
            ])
            ->add('thumbnail', TextType::class, [
                'label' => 'backoffice.article.form.picture',
                'required' => false,
            ])
            ->add('thumbnail_alt', TextType::class, [
                'label' => 'backoffice.article.form.alt',
                'required' => false,
            ])
            ->add('summary', TextareaType::class, [
                'label' => 'backoffice.article.form.summary',
                'required' => true,
            ])
            ->add('tags', EntityType::class, [
                'translation_domain' => false,
                'label' => 'Tags:',
                'class' => 'AppBundle:Tag',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('article_extend', ArticleExtendType::class, [
                'label' => 'hy',
            ]);
    }

    public function getName()
    {
        return 'article_form';
    }
}
