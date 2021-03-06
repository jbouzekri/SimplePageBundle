<?php

namespace Jb\Bundle\SimplePageBundle\Provider;

/**
 * PageProviderInterface
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
interface PageProviderInterface
{
    /**
     * Find a page by slug
     *
     * @param string $slug
     */
    public function findOneBySlug($slug);

    /**
     * Return true if this provider supports admin interface
     *
     * @return bool
     */
    public function isAdminSupported();

    /**
     * Find all pages
     *
     * @return array
     */
    public function findAll();
}
