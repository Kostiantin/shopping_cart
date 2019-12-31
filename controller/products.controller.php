<?php
class ProductsController extends BaseController {
    
    public function __construct (){}

    public function index () {
        $model = (new Product())->GetAllProducts();
        parent::RenderPage(
            'Products',
            'view/layout/layout.php', 
            'view/products/products.php',
            $model
        );
    }

    // possible usage later
    public function details () {
        $id = (int)$_REQUEST['id'];
        $model = (new Product())->GetProductById($id);
        parent::RenderPage(
            'Products',
            'view/layout/layout.php', 
            'view/products/details.php',
            $model
        );
    }

    public function giveRating ()
    {
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!empty($_POST['product_id']) && !empty($_POST['rating']) && !empty($_POST['email']) && !empty(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) {

                $oUser = new User();
                $user = $oUser->GetUserByEmail($_POST['email']);

                if (!empty($user)) {
                    $oProduct = new Product();
                    $new_rating_id = $oProduct->giveRatingToProduct($_POST['product_id'], $user->getId(), str_replace(',', '.', $_POST['rating']));

                    if (!empty($new_rating_id)) {
                        $success = true;
                    }
                }

            }
        }

        echo json_encode(['success' => $success]);
        exit;
    }
}