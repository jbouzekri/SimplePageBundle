<?php

namespace Jb\Bundle\SimplePageBundle\Controller;

use Jb\Bundle\SimplePageBundle\Provider\PageProviderInterface;
use Jb\Bundle\SimplePageBundle\Provider\Exception\PageException;
use Jb\Bundle\SimplePageBundle\Model\Page;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * AdminController
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
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
     * @var \Symfony\Component\Form\FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var string
     */
    protected $formType;

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
     * @param \Symfony\Component\Form\FormFactoryInterface $formFactory
     * @param string $formType
     * @param \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface $templating
     * @param array $templateArray
     */
    public function __construct(
        PageProviderInterface $pageProvider,
        RegistryInterface $doctrine,
        SessionInterface $session,
        RouterInterface $router,
        FormFactoryInterface $formFactory,
        $formType,
        EngineInterface $templating,
        $templateArray
    ) {
        $this->pageProvider = $pageProvider;
        $this->doctrine = $doctrine;
        $this->session = $session;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->formType = $formType;
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
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        return $this->handleForm($request);
    }

    /**
     * Page edit
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $slug)
    {
        $page = $this->pageProvider->findOneBySlug($slug);
        if (!$page) {
            throw new NotFoundHttpException('Page '.$slug.' not found');
        }

        return $this->handleForm($request, $page);
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

    /**
     * Hanlde form creation and submission
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Jb\Bundle\SimplePageBundle\Model\Page $page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleForm(Request $request, Page $page = null)
    {
        $form = $this->formFactory->create($this->formType, $page);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->doctrine->getManager();
            $manager->persist($form->getData());
            $manager->flush();

            $this->session->getFlashBag()->add(
                'notice',
                'Saved successfully'
            );

            return new RedirectResponse($this->router->generate('jb_simple_page_index'));
        }

        return $this->templating->renderResponse($this->templateArray['edit_template'], array(
            'form' => $form->createView(),
            'templates' => $this->templateArray
        ));
    }
}
