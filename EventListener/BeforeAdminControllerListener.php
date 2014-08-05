<?php

namespace Jb\Bundle\SimplePageBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Jb\Bundle\SimplePageBundle\Controller\AdminController;

/**
 * BeforeAdminControllerListener
 *
 * @author jobou
 */
class BeforeAdminControllerListener
{
    /**
     * Check if provider provides admin interface
     *
     * @param \Symfony\Component\HttpKernel\Event\FilterControllerEvent $event
     *
     * @return void
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        if (!$controller[0] instanceof AdminController) {
            return;
        }

        $controller[0]->supportAdminInterface();
    }
}
