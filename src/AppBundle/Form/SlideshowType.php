<?php

namespace AppBundle\Form;

use AppBundle\Entity\Providers\GiphyProvider;
use AppBundle\Entity\Providers\RedditProvider;
use AppBundle\Form\Providers\GiphyProviderType;
use AppBundle\Form\Providers\RedditProviderType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SlideshowType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('delay', null, ['label' => "Delay (seconds)"])
            /*->add('giphyProviders', CollectionType::class, [
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'prototype_data' => new GiphyProvider(),
                'entry_type' => GiphyProviderType::class,
                'by_reference' => false
            ])
            ->add('redditProviders', CollectionType::class, [
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'prototype_data' => new RedditProvider(),
                'entry_type' => RedditProviderType::class,
                'by_reference' => false
            ])*/
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Slideshow'
        ));
    }
}
