<?php

namespace Jb\Bundle\SimplePageBundle\Provider;

/**
 * PageProviderInterface
 *
 * @author jobou
 */
interface PageProviderInterface
{
    /**
     * Find a page by slug
     *
     * @param string $slug
     */
    public function findOneBySlug($slug);
}
