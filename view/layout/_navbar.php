<nav class="navbar navbar-default">
  <div class="container-fluid">

    <div class="navbar-header">
      <button 
      type="button" 
      class="navbar-toggle collapsed" 
      data-toggle="collapse" 
      data-target="#bs-example-navbar-collapse-1"
      aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#menu-toggle" id="menu-toggle">
          <i class="fa fa-shopping-cart" aria-hidden="true"></i>
          <div class="cart-quantity" title="Show Cart Items">
              <span class="badge qnt"></span>
              <input type="hidden" value="0">
          </div>

          <i class="fa fa-arrow-left invisible-i" aria-hidden="true" title="Hide Cart Items"></i>
      </a>

        <?php
        $userData = (new ShoppingCartSession())->GetUserData();
        $deposit = 0;
        if (!empty($userData['deposit'])) {
            $deposit = $userData['deposit'];
        }
        ?>
        <div class="user-line pull-right">Your Deposit: $<span class="user-deposit-amount"><?=$deposit ?></span></div>
    </div>
  </div>

</nav>