<?php
class Product {

    private $id;
    private $name;
    private $description;
    private $price;
    private $img;
    public $rating;

    public function getId () { return $this->id; }
    private function setId ($id) { $this->id = $id; }


    public function getName () { return $this->name; }
    public function setName ($name) { $this->name = $name; }


    public function getDescription () { return $this->description; }
    public function setDescription ($description) { $this->description = $description; }


    public function getPrice () { return $this->price; }
    public function setPrice ($price) { $this->price = $price; }


    public function getImg () { return $this->img; }
    public function setImg ($img) { $this->img = $img; }


  public function __construct($name = '', $description = '', $price = 0.0, $img = '', $id = null, $rating = null)
  {

    $this->name = $name;
    $this->description = $description;
    $this->price = $price;
    $this->img = $img;
    $this->id = $id;
    $this->rating = $rating;

  }

  public function GetProductById ($id)
  {
    $model = null;
    $db = (new DB())->CreateConnection();
    $statement = $db->prepare('SELECT `name`, `description`, `price`, `img`, `id` FROM `products` WHERE `id` = ?');
    $statement->bind_param('i', $id);
    $statement->bind_result($name, $description, $price, $img, $id);
    if ($statement->execute()) {
      while ($row = $statement->fetch()) {
        $model = new Product($name, $description, $price, $img, $id);
      }
    }

    $db->close();

    return $model;
  }

  public function GetAllProducts ()
  {
    $models = [];
    $db = (new DB())->CreateConnection();
    $statement = $db->prepare('SELECT `name`, `description`, `price`, `img`, `id` FROM `products`');
    $statement->bind_result($name, $description, $price, $img, $id);
    if ($statement->execute()) {
      while ($row = $statement->fetch()) {

        $aRatings = $this->GetProductRatings($id);
        $totalRating = 0;
        if (!empty($aRatings)) {
            foreach ($aRatings as $productRating) {
                $totalRating += $productRating['rating'];
            }
            $totalRating = $totalRating / count($aRatings);
        }


        $model = new Product($name, $description, $price, $img, $id, $totalRating);

        array_push($models, $model);
      }
    }

    $db->close();
    return $models;
  }

  public function giveRatingToProduct($product_id, $user_id, $rating) {

      $new_rating_id = null;

      $db = (new DB())->CreateConnection();

      $statement = $db->prepare(
          'INSERT INTO `product_rating` (`product_id`, `user_id`, `rating`) 
      VALUES (?, ?, ?)'
      );

      $statement->bind_param('iid',
          $product_id,
          $user_id,
          $rating
      );

      $statement->execute();

      if (!empty($db->insert_id)) {
          $new_rating_id =  $db->insert_id;
      }

      $db->close();

      return $new_rating_id;
  }

    public function GetProductRatings ($product_id)
    {
        $productRatings = [];
        $db = (new DB())->CreateConnection();
        //$statement = $db->prepare('SELECT `product_id`, `user_id`, `rating` FROM `product_rating`');
        $statement = $db->prepare('SELECT `product_id`, `user_id`, `rating`, `id` FROM `product_rating` WHERE `product_id` = ?');
        $statement->bind_param('i', $product_id);
        $statement->bind_result($product_id, $user_id, $rating, $id);
        if ($statement->execute()) {
            while ($row = $statement->fetch()) {
                $productRatings[] = [
                    'product_id' => $product_id,
                    'user_id' => $user_id,
                    'rating' => $rating,
                    'id' => $id,
                ];
            }
        }

        $db->close();
        return $productRatings;
    }
}