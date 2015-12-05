<?php

namespace AppBundle\Form\Providers;

use AppBundle\Entity\Providers\Query;
use AppBundle\Entity\Providers\RedditProvider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RedditProviderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('weight', IntegerType::class)
            ->add('subreddit')
            ->add('queries', CollectionType::class, [
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'prototype_data' => new Query(),
                'entry_type' => QueryType::class,
                'by_reference' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', RedditProvider::class);
    }
}
