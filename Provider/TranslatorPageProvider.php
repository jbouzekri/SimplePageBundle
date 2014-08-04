<?php

namespace Jb\Bundle\SimplePageBundle\Provider;

use Symfony\Component\Translation\TranslatorInterface;
use Jb\Bundle\SimplePageBundle\Model\Page;

/**
 * TranslatorPageProvider
 *
 * @author jobou
 */
class TranslatorPageProvider implements PageProviderInterface
{
    /**
     * @var \Symfony\Component\Translation\TranslatorInterface
     */
    protected $translator;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var array
     */
    protected $pages;

    /**
     * @var string
     */
    protected $translationDomain;

    /**
     * Constructor
     *
     * @param \Symfony\Component\Translation\TranslatorInterface $translator
     * @param string $entityClass
     * @param array $pages
     * @param string $translationDomain
     */
    public function __construct(
        TranslatorInterface $translator,
        $entityClass,
        $pages = array(),
        $translationDomain = "jb_simple_page"
    ) {
        $this->translator = $translator;
        $this->entityClass = $entityClass;
        $this->pages = $pages;
        $this->translationDomain = $translationDomain;
    }

    /**
     * {@inheritDoc}
     */
    public function findAll()
    {
        $results = array();
        foreach ($this->pages as $transKey) {
            $results[] = $this->createPage($transKey);
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
                return $this->createPage($slug);
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

    /**
     * Builder for page entity
     *
     * @param string $slug
     *
     * @return \Jb\Bundle\SimplePageBundle\Model\Page
     */
    protected function createPage($slug)
    {
        $page = new $this->entityClass();
        if (!$page instanceof Page) {
            throw new Exception\PageException('Page entity must be of type Jb\Bundle\SimplePageBundle\Model\Page');
        }

        $page->setTitle($this->trans($slug.'.title'));
        $page->setContent($this->trans($slug.'.content'));

        $metaTitle =
            ($this->trans($slug.'.meta_title') != $slug.'.meta_title') ? $this->trans($slug.'.meta_title') : null;
        $page->setMetaTitle($metaTitle);

        $metaDescription =
            ($this->trans($slug.'.meta_description') != $slug.'.meta_description')
            ? $this->trans($slug.'.meta_description') : null;
        $page->setMetaDescription($metaDescription);

        $page->setSlug($slug);

        return $page;
    }

    /**
     * Translate a key
     *
     * @param string $key
     *
     * @return string
     */
    protected function trans($key)
    {
        return $this->translator->trans($key, array(), $this->translationDomain);
    }
}
