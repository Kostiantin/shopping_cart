<?php
class CartController extends BaseController {
    
    public function __construct (){}
    
    public function index ()
    {
        $cart = (new ShoppingCartSession())->GetShoppingCart();
        $model = $cart->products;
        parent::RenderPage(
            'Cart', 
            'view/layout/layout.php', 
            'view/cart/cart.php',
            $model
        );
    }

    public function _Empty () {
        (new ShoppingCartSession())->RemoveShoppingCartFromSession();
        parent::RedirectToController('products');
    }

    public function removeProduct ()
    {
        $id = $_REQUEST['id'];

        $ShoppingCartSession = new ShoppingCartSession();

        if ($ShoppingCartSession->ShoppingCartExists()) {

            $cart = $ShoppingCartSession->GetShoppingCart();

            if (!empty($cart->products[$id])) {
                unset($cart->products[$id]);
            }
        }

        $ShoppingCartSession->StoreShoppingCartInSession($cart);

        parent::RedirectToController('products');

    }
    
    public function checkout ()
    {
        $cart = (new ShoppingCartSession())->GetShoppingCart();
        $model = $cart->products;
        parent::RenderPage(
            'Cart', 
            'view/layout/layout.php', 
            'view/cart/checkout.php',
            $model
        );
    }

    public function addProductToCart()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = (int)$_POST['id'];
            $quantity = (int)$_POST['quantity'];
            $product = (new Product())->GetProductById($id);
            $cart = null;
            $success = false;
            if (!empty($product) && !empty($quantity)) {

                $ShoppingCartSession = new ShoppingCartSession();

                if ($ShoppingCartSession->ShoppingCartExists()) {

                    $cart = $ShoppingCartSession->GetShoppingCart();

                    if (!empty($cart->products[$id])) {
                        $cart->products[$id] += $quantity;
                    }
                    else {
                        $cart->products[$id] = $quantity;
                    }

                } else {
                    $cart = new ShoppingCart();
                    $cart->products[$id] = $quantity;
                }

                $ShoppingCartSession->StoreShoppingCartInSession($cart);

                if (!empty($cart->products[$id])) {
                    $success = true;
                }

                echo json_encode(['success' => $success]);
                exit;
            }
        }
   }

   public function getCartData()
   {
       $ShoppingCartSession = new ShoppingCartSession();
       $productsInCart['products'] = [];
       $totalProducts = 0;
       $totalAmount = 0;
       if ($ShoppingCartSession->ShoppingCartExists()) {

           $cart = $ShoppingCartSession->GetShoppingCart();
           if (!empty($cart) && !empty($cart->products)) {

               foreach ($cart->products as $id => $quantity) {

                   $product = (new Product())->GetProductById($id);
                   if (!empty($product)) {
                       $totalProducts += $quantity;
                       $productsInCart['products'][$id]['quantity'] = $quantity;
                       $productsInCart['products'][$id]['price'] = $product->getPrice();
                       $productsInCart['products'][$id]['img'] = $product->getImg();
                       $productsInCart['products'][$id]['name'] = $product->getName();
                       $productsInCart['products'][$id]['amount'] = number_format($product->getPrice() * $quantity, 2);

                       $totalAmount += $productsInCart['products'][$id]['amount'];
                   }
               }

               $productsInCart['totalProducts'] = $totalProducts;
               $productsInCart['totalAmount'] = number_format($totalAmount, 2);
           }
       }

       echo json_encode($productsInCart);
       exit;
   }
}
