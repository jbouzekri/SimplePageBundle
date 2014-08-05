<?php

namespace Jb\Bundle\SimplePageBundle\Provider;

/**
 * TranslatorPageBuilder
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
interface TranslatorPageBuilderInterface
{
    /**
     * Builder for page entity
     *
     * @param string $slug
     *
     * @return \Jb\Bundle\SimplePageBundle\Model\Page
     */
    public function createPage($slug);
}
