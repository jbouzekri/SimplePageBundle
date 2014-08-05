<?php

namespace Jb\Bundle\SimplePageBundle\Provider;

/**
 * TranslatorPageProvider
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
class TranslatorPageProvider implements PageProviderInterface
{
    /**
     * @var \Jb\Bundle\SimplePageBundle\Provider\TranslatorPageBuilderInterface
     */
    protected $builder;

    /**
     * @var array
     */
    protected $pages;

    /**
     * Constructor
     *
     * @param \Jb\Bundle\SimplePageBundle\Provider\TranslatorPageBuilderInterface $builder
     * @param array $pages
     */
    public function __construct(
        TranslatorPageBuilderInterface $builder,
        $pages = array()
    ) {
        $this->builder = $builder;
        $this->pages = $pages;
    }

    /**
     * {@inheritDoc}
     */
    public function findAll()
    {
        $results = array();
        foreach ($this->pages as $transKey) {
            $results[] = $this->builder->createPage($transKey);
        }

        return $results;
    }

    /**
     * {@inheritDoc}
     */
    public function findOneBySlug($slug)
    {
        foreach ($this->pages as $page) {
            if ($page == $slug) {
                return $this->builder->createPage($slug);
            }
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function isAdminSupported()
    {
        return false;
    }
}
