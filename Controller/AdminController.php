<?php

namespace Jb\Bundle\SimplePageBundle\Controller;

use Jb\Bundle\SimplePageBundle\Provider\PageProviderInterface;
use Jb\Bundle\SimplePageBundle\Provider\Exception\PageException;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * AdminController
 *
 * @author jobou
 */
class AdminController
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
     * @var array
     */
    protected $templateArray;

    /**
     * Constructor
     *
     * @param \Jb\Bundle\SimplePageBundle\Provider\PageProviderInterface $pageProvider
     * @param \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface $templating
     * @param array $templateArray
     */
    public function __construct(
        PageProviderInterface $pageProvider,
        EngineInterface $templating,
        $templateArray
    ) {
        $this->pageProvider = $pageProvider;
        $this->templating = $templating;
        $this->templateArray = $templateArray;
    }

    public function indexAction()
    {
        $pages = $this->pageProvider->findAll();

        return $this->templating->renderResponse($this->templateArray['index_template'], array(
            'pages' => $pages,
            'templates' => $this->templateArray
        ));
    }

    /**
     * Check if admin interface is supported
     *
     * @throws \Jb\Bundle\SimplePageBundle\Provider\Exception\PageException
     */
    public function supportAdminInterface()
    {
        if (!$this->pageProvider->isAdminSupported()) {
            throw new PageException('Provider '.get_class($this->pageProvider).' does not support admin interface');
        }
    }
}
