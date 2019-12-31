<?php
class UsersController extends BaseController {
    
    public function __construct () {}

    // possible usage later
    public function index () {
        $model = (new User())->GetAllUsers();
        parent::RenderPage(
            'Users', 
            'view/layout/layout.php', 
            'view/users/users.php',
            $model
        );
    }

    // create a new user
    public function Create () {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User(
                $_REQUEST['first_name'],
                $_REQUEST['last_name'],
                $_REQUEST['phone'],
                $_REQUEST['email']
            );
            $user->Create();
        }
    }

    // possible usage later
    public function Details () {
        $id = (int)$_REQUEST['id'];
        $model = (new User())->GetUserById($id);
        parent::RenderPage(
            'Users', 
            'view/layout/layout.php', 
            'view/users/details.php',
            $model
        );
    }
}
