<?php
class ShoppingCartSession {

    public function __construct()
    {
        if (!isset($_SESSION)) { session_start(); }
    }

    private $shoppingCartSessionKey = 'myshoppingcart';
    private $shoppingCartUserKey = 'user_data';
    private $defaultUserDeposit = 100;

    public function StoreShoppingCartInSession ($shoppingCart) {

        $_SESSION[$this->shoppingCartSessionKey] = $shoppingCart;
    }

    public function ShoppingCartExists () {

        return isset($_SESSION[$this->shoppingCartSessionKey]);
    }

    public function GetShoppingCart () {
        if ($this->ShoppingCartExists()) {

          return $_SESSION[$this->shoppingCartSessionKey];
        } else {
          return null;
        }
    }

    public function RemoveShoppingCartFromSession () {
        if ($this->ShoppingCartExists()) {

          if (isset($_SESSION[$this->shoppingCartSessionKey])) {
            unset($_SESSION[$this->shoppingCartSessionKey]);
          }
        }
    }

    public function StoreUserDepositAmountInSession ($amount = null) {
        if (empty($amount)) {
            $amount = $this->defaultUserDeposit;
        }
        if (isset($_SESSION)) {
            $_SESSION[$this->shoppingCartUserKey]['deposit'] = $amount;
        }

    }

    public function UserExists () {

        return isset($_SESSION) && isset($_SESSION[$this->shoppingCartUserKey]);
    }

    public function GetUserData () {
        if ($this->UserExists()) {
            return $_SESSION[$this->shoppingCartUserKey];
        } else {
            return null;
        }
    }

    public function RemoveUserFromSession () {
        if ($this->ShoppingCartExists()) {

            if (isset($_SESSION[$this->shoppingCartUserKey])) {
                unset($_SESSION[$this->shoppingCartUserKey]);
            }
        }
    }

}
