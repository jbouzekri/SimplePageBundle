<?php

namespace Jb\Bundle\SimplePageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * DefaultPageType
 *
 * @author jobou
 */
class DefaultPageType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('fields', 'jb_simple_page_root')
            ->add('submit', 'submit');
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'jb_simple_page_default_form';
    }
}
