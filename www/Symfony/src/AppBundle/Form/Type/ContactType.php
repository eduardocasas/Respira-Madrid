<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', [
                'label' => 'contact.form.email.label',
                'attr' => [
                    'placeholder' => 'contact.form.email.placeholder',
                    'required' => true
                ]
            ])
            ->add('subject', 'text', [
                'label' => 'contact.form.subject.label',
                'attr' => [
                    'placeholder' => 'contact.form.subject.placeholder',
                    'required' => true
                ]
            ])
            ->add('message', 'textarea', [
                'label' => 'contact.form.message.label',
                'attr' => [
                    'placeholder' => 'contact.form.message.placeholder',
                    'required'    => true
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $collectionConstraint = new Collection([
            'email' => [new NotBlank(['message' => 'Email should not be blank.'])],
            'subject' => [new NotBlank(['message' => 'Subject should not be blank.'])],
            'message' => [new NotBlank(['message' => 'Message should not be blank.'])]
        ]);

        $resolver->setDefaults(['constraints' => $collectionConstraint]);
    }

    public function getName()
    {
        return 'contact';
    }

}
