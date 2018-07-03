<?php

namespace Base\Controller;

class Admin extends \Windward\Mvc\Controller
{
    public function afterHandle(&$response)
    {
        $route = $this->router->getActiveRoute();
        $this->view->assign('controllerName', $route->getControllerName());
        $this->view->assign('actionName', $route->getActionName());
    }
    
    use \Base\Traits\Base;
}
