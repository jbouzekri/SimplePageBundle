<?php

namespace Jb\Bundle\SimplePageBundle\Controller;

use Jb\Bundle\SimplePageBundle\Provider\PageProviderInterface;
use Jb\Bundle\SimplePageBundle\Provider\Exception\PageException;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Form\Form;

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
     * @var \Symfony\Bridge\Doctrine\RegistryInterface
     */
    protected $doctrine;

    /**
     * @var \Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    protected $session;

    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    protected $router;

    /**
     * @var \Symfony\Component\Form\Form
     */
    protected $form;

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
     * @param \Symfony\Bridge\Doctrine\RegistryInterface $doctrine
     * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session
     * @param \Symfony\Component\Routing\RouterInterface $router
     * @param \Symfony\Component\Form\Form $form
     * @param \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface $templating
     * @param array $templateArray
     */
    public function __construct(
        PageProviderInterface $pageProvider,
        RegistryInterface $doctrine,
        SessionInterface $session,
        RouterInterface $router,
        Form $form,
        EngineInterface $templating,
        $templateArray
    ) {
        $this->pageProvider = $pageProvider;
        $this->doctrine = $doctrine;
        $this->session = $session;
        $this->router = $router;
        $this->form = $form;
        $this->templating = $templating;
        $this->templateArray = $templateArray;
    }

    /**
     * Page list
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $pages = $this->pageProvider->findAll();

        return $this->templating->renderResponse($this->templateArray['index_template'], array(
            'pages' => $pages,
            'templates' => $this->templateArray
        ));
    }

    /**
     * Page create
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction()
    {
        return $this->templating->renderResponse($this->templateArray['edit_template'], array(
            'form' => $this->form->createView(),
            'templates' => $this->templateArray
        ));
    }

    /**
     * Page remove
     *
     * @param string $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeAction($slug)
    {
        $page = $this->pageProvider->findOneBySlug($slug);
        if (!$page) {
            throw new NotFoundHttpException('Page '.$slug.' not found');
        }

        $manager = $this->doctrine->getManager();
        $manager->remove($page);
        $manager->flush();

        $this->session->getFlashBag()->add(
            'notice',
            'Page removed successfully'
        );

        return new RedirectResponse($this->router->generate('jb_simple_page_index'));
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
