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
     * @var string
     */
    protected $entityType;

    /**
     * Constructor
     *
     * @param string $entityType
     */
    public function __construct($entityType)
    {
        $this->entityType = $entityType;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('fields', 'jb_simple_page_root', array(
                'label' => false
            ))
            ->add('submit', 'submit');
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->entityType
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'jb_simple_page_default_form';
    }
}
