<?php

namespace Jb\Bundle\SimplePageBundle\Controller;

use Jb\Bundle\SimplePageBundle\Provider\PageProviderInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * FrontController
 *
 * @author jobou
 */
class FrontController
{
    /**
     * @var \Jb\Bundle\SimplePageBundle\Provider\PageProviderInterface
     */
    protected $pageProvider;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface
     */
    protected $templating;

    /**
     * @var string
     */
    protected $viewTemplate;

    /**
     * Constructor
     *
     * @param \Jb\Bundle\SimplePageBundle\Provider\PageProviderInterface $pageProvider
     * @param \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface $templating
     * @param string $viewTemplate
     */
    public function __construct(
        PageProviderInterface $pageProvider,
        EngineInterface $templating,
        $viewTemplate
    ) {
        $this->pageProvider = $pageProvider;
        $this->templating = $templating;
        $this->viewTemplate = $viewTemplate;
    }

    /**
     * View the detail of a page
     *
     * @param string $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($slug)
    {
        $page = $this->pageProvider->findOneBySlug($slug);
        if (!$page) {
            throw new NotFoundHttpException('Page '.$slug.' not found');
        }

        return $this->templating->renderResponse($this->viewTemplate, array(
            'page' => $page
        ));
    }
}
