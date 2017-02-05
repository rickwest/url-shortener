<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UrlShortenerType extends AbstractType {
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('url', TextType::class, [
                'attr' => [
                    'placeholder' => 'Paste your link to shorten...',
                    'autofocus' => 'autofocus',
                    'title' => 'Please enter the link that you want to shorten'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Shorten',
                'attr' => [
                    'class' => 'btn btn-primary btn-fill',
                ]
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\UrlShortener'
        ]);
    }
}
