<?php
class OrderController extends BaseController {

    public $aDeliveries = [
        1 => 0,
        2 => 5
    ];

    public function __construct (){}
    
    public function index () {
        $model = [];
        parent::RenderPage(
            'Sales', 
            'view/layout/layout.php', 
            'view/order/form.php',
            $model
        );
    }

    public function getOrderForm () {
        $model = [];
        parent::RenderView(
            'view/order/form.php',
            $model
        );
    }

    public function makeOrder () {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $deliveryCost = 0;

            if (!empty($_POST['delivery']) && in_array($_POST['delivery'], array_keys($this->aDeliveries))) {

                $deliveryCost = $this->aDeliveries[$_POST['delivery']];
            }

            $userDataValid = $this->validateUserData($_POST);

            $ShoppingCartSession = new ShoppingCartSession();

            if ($ShoppingCartSession->ShoppingCartExists()) {

                $cart = $ShoppingCartSession->GetShoppingCart();
                $user_id = 0;

                $oUser = new User();

                // get user
                $user = $oUser->GetUserByEmail($_POST['email']);
                if (!empty($user)) {
                    $user_id = $user->getId();
                }
                else { //or create user
                    $user = (new User($_POST['first_name'], $_POST['last_name'], $_POST['phone'], $_POST['email']))->Create();
                    $user_id = $user->getId();
                }

                if (!empty($cart->products) && $userDataValid == true && !empty($user_id)) {

                    $total_amount = 0;
                    $orderProducts = [];

                    foreach ($cart->products as $product_id => $quantity) {
                        $oProduct = new Product();
                        $product = $oProduct->getProductById($product_id);

                        $current_price = number_format($product->getPrice()*$quantity, 2);

                        $total_amount += $current_price;

                        $orderProducts[] = [
                            'product_id' => $product_id,
                            'quantity' => $quantity,
                            'current_price' => $current_price,
                        ];

                    }

                    $total_amount = number_format($total_amount,2);

                    $order = (new Order($user_id, $total_amount, date("Y-m-d H:i:s"), $_POST['delivery']))->Create();

                    // add products to order products

                    $order->CreateOrderProducts($orderProducts);

                    // clear cart
                    $shoppingCart = new ShoppingCartSession();
                    $shoppingCart->RemoveShoppingCartFromSession();

                    // change user deposit
                    $userShopSession = new ShoppingCartSession();
                    $userData = $userShopSession->GetUserData();

                    if ($userData['deposit'] > ($total_amount + $deliveryCost)) {
                        $deposit = number_format($userData['deposit'] - $total_amount - $deliveryCost,2);
                        $userShopSession->StoreUserDepositAmountInSession($deposit);
                    }

                    // later can add email sending here

                    // return order to js
                    echo json_encode(['success' => true,'total_amount'=>number_format($total_amount+$deliveryCost, 2), 'first_name' => $_POST['first_name'], 'last_name' => $_POST['last_name'], 'deposit' => $deposit]);
                    exit;

                }
            }

        }
    }

    private function validateUserData($post)
    {
        $isValid = false;
        $countErrors = 0;

        if (empty($post['first_name'])) {
            $countErrors++;
        }
        if (empty($post['last_name'])) {
            $countErrors++;
        }

        if (empty($post['email']) || empty(filter_var($post['email'], FILTER_VALIDATE_EMAIL))) {
            $countErrors++;
        }

        if (empty($post['phone'])) {
            $countErrors++;
        }

        if (empty($post['delivery'])) {
            $countErrors++;
        }

        if ($countErrors == 0) {
            $isValid = true;
        }

        return $isValid;
    }

}

