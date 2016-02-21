<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleExtendType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('html', TextareaType::class, [
                'label' => 'backoffice.article.form.content',
                'required' => false,
            ])
            ->add('markdown', TextareaType::class, [
                'label' => 'backoffice.article.form.content',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AppBundle\Entity\ArticleExtend']);
    }

    public function getName()
    {
        return 'article_extend_form';
    }
}
