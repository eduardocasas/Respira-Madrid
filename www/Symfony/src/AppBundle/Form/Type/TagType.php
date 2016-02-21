<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TagType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['autofocus' => 'autofocus'],
                'label' => 'backoffice.article.form.name',
                'required' => true
            ])
            ->add('slug', TextType::class, [
                'label' => 'backoffice.article.form.slug',
                'required' => true
            ]);
    }

    public function getName()
    {
        return 'tag_form';
    }

}
