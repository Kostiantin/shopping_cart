<?php

include_once('./session/shoppingcart.session.php');
include_once('./model/user.php');
include_once('./model/product.php');
include_once('./model/order.php');
include_once('./model/shoppingcart.php');
include_once('./db/db.class.php');
include_once('./controller/base.controller.php');

// if user does not exist in the session we add it and give deposit 100$
$userShopSession = new ShoppingCartSession();
if (!$userShopSession->UserExists()) {
    $userShopSession->StoreUserDepositAmountInSession();
}

// this class determines where to redirect and what controllers are allowed
class Router {

    private $defaultController = 'products';
    private $publicControllers = ['cart', 'products', 'order'];

    public function IsControllerExists () {
        $controller = isset($_REQUEST['c']) ? strtolower($_REQUEST['c']) : $this->defaultController;
        return in_array($controller, $this->publicControllers);
    }

    public function RenderController () {
        if (!isset($_REQUEST['c'])) $this->Render($this->defaultController); else $this->getFromQueryString();
    }

    private static function Render ($controller) {
        require_once "controller/$controller.controller.php";
        $controller = ucwords($controller) . 'Controller';
        $controller = new $controller;
        $controller->index();
    }

    public function getFromQueryString () {

        $controller = strtolower($_REQUEST['c']);
        $accion = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'Index';

        require_once "controller/$controller.controller.php";
        $controller = ucwords($controller).'Controller';
        $controller = new $controller;

        call_user_func(array($controller, $accion));
    }

    public function ProcessRequest () {
        if ($this->IsControllerExists()) {  $this->RenderController(); return; }
        header('Location: ?c=' . $this->defaultController);
    }

}

(new Router())->ProcessRequest();



