<?php

namespace Jb\Bundle\SimplePageBundle\Provider;

use Doctrine\Common\Persistence\ObjectRepository;

/**
 * DoctrinePageProvider
 *
 * @author jobou
 */
class DoctrinePageProvider implements PageProviderInterface
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $repository;

    /**
     * Constructor
     *
     * @param \Doctrine\Common\Persistence\ObjectRepository $repository
     */
    public function __construct(ObjectRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritDoc}
     */
    public function findOneBySlug($slug)
    {
        return $this->repository->findOneBySlug($slug);
    }
}
