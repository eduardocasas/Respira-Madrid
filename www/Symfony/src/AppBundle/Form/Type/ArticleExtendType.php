<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleExtendType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('html', 'textarea', ['label' => 'Contenido:', 'required' => false])
            ->add('markdown', 'textarea', ['label' => 'Contenido:', 'required' => false]);
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AppBundle\Entity\ArticleExtend']);
    }

    public function getName()
    {
        return 'article_extend_form';
    }

}
