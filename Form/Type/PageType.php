<?php

namespace Jb\Bundle\SimplePageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of PageType
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
class PageType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('title', 'text')
            ->add('content', 'textarea')
            ->add('metaTitle', 'text')
            ->add('metaDescription', 'text');
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'inherit_data' => true,
            'translation_domain' => 'jb_simple_page_admin'
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'jb_simple_page_root';
    }
}
