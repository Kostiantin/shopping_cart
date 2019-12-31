<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <h1>Products</h1>

      </header>
      <div class="panel-body">

            <?
              foreach ($MODEL as $product) {
            ?>
              <div class="col-xs-12 col-md-3">
                  <div class="panel panel-primary product-holder">
                      <div class="panel-heading text-center"><?=$product->getName()?></div>
                      <div class="panel-body">
                          <img class="img-thumbnail product-img text-center" src="<?=$product->getImg()?>" alt=""/>
                          <div class="product-rating">
                              <div class="five-stars-container" id="five-stars-container_<?=$product->getId()?>" >
                                  <span class="five-stars" style="width: <?=$product->rating*20?>%;"></span>
                              </div>
                          </div>
                          <div class="description"><?=stripslashes($product->getDescription())?></div>
                          <div class="row">
                              <div class="col-xs-12 col-md-3 price text-center">$<?=$product->getPrice()?></div>
                              <div class="col-xs-12 col-md-5 quantity-holder">
                                  <div class="input-group">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-number" data-type="minus" data-field="quantity_<?=$product->getId()?>">
                                            <span class="glyphicon glyphicon-minus"></span>
                                        </button>
                                    </span>
                                    <!--<input type="text" name="quant[1]" class="form-control input-number" value="1" min="1" max="10">-->
                                    <input class="quantity form-control input-number" id="quantity_<?=$product->getId()?>" value="1" min="1" type="text" max="1000">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quantity_<?=$product->getId()?>">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </button>
                                    </span>
                                  </div>
                              </div>
                              <div class="col-xs-12 col-md-4 actions-holder text-center">
                                  <a class="btn btn-primary btn-sm addProduct" href="javascript:void(0);" data-product_id="<?=$product->getId()?>"><i class="fa fa-cart-plus"></i> Add to Cart</a>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            <?
              }
            ?>
      </div>
    </section>
  </div>
</div>

<script type="text/javascript">





</script>


<div class="sp-areYouSure-main-popup-texts-container">

    <div class="apch-image-holder"></div>
    <div class="apch-description">

    </div>
    <h3>Give your rating to this product</h3>
    <small>*only users who previously bought our products can give rating, please provide us your email which you used during previous orders.</small>
    <div>
        <div class="form-group">
          <input type="email" name="user_rating_email" class="user_rating_email form-control" placeholder="Email" title="Email"/>
        </div>
        <div class="form-group">
          <input type="number" min="1" max="5" name="user_rating" class="user_rating form-control"  placeholder="Rating from 1 to 5" title="Rating from 1 to 5">
        </div>
    </div>
    <div class="rating-error-message">Unfortunately we did not find provided email</div>
    <div class="rating-error-cant-be-empty">Neither email nor rating can be empty</div>
    <div class="apch-bottom-button-container">
        <a class="apch-button btn btn-primary saveRating">SAVE</a>
    </div>

</div>
