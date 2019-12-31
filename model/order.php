<?php
class Order {

    private $id;
    private $user_id;
    private $total_amount;
    private $date_added;
    private $delivery_id;

    public function getId () { return $this->id; }
    private function setId ($id) { $this->id = $id; }

    public function getUserId () { return $this->user_id; }
    public function setUserId ($user_id) { $this->user_id = $user_id; }

    public function getTotalAmount () { return $this->total_amount; }
    public function setTotalAmount ($total_amount) { $this->total_amount = $total_amount; }

    public function getDateAdded () { return $this->date_added; }
    public function setDateAdded ($date_added) { $this->date_added = $date_added; }

    public function getDeliveryId () { return $this->delivery_id; }
    public function setDeliveryId ($delivery_id) { $this->delivery_id = $delivery_id; }

    public function __construct($user_id = null, $total_amount = null, $date_added = null, $delivery_id = null, $id = null){
        $this->user_id = $user_id;
        $this->total_amount = $total_amount;
        $this->date_added = $date_added;
        $this->id = $id;
        $this->delivery_id = $delivery_id;
    }

    public function GetOrderById ($id)
    {
        $model = null;
        $db = (new DB())->CreateConnection();
        $statement = $db->prepare('SELECT `user_id`, `total_amount`, `date_added`, `id`, `delivery_id` FROM `orders` WHERE `id` = ?');
        $statement->bind_param('i', $id);
        $statement->bind_result($user_id, $total_amount, $date_added, $delivery_id, $id);
        if ($statement->execute()) {
          while ($row = $statement->fetch()) {
            $model = new Product($user_id, $total_amount, $date_added, $delivery_id, $id);
          }
        }

        $db->close();

        return $model;
    }

    public function Create () {

        $model = null;
        $db = (new DB())->CreateConnection();

        $statement = $db->prepare(
            'INSERT INTO `orders` (`user_id`, `total_amount`, `date_added`, `delivery_id`) 
      VALUES (?, ?, ?, ?)'
        );

        $statement->bind_param('sdss',
            $this->user_id,
            $this->total_amount,
            $this->date_added,
            $this->delivery_id
        );

        $statement->execute();

        if (!empty($db->insert_id)) {
            $model = new Order($this->user_id, $this->total_amount, $this->date_added, $this->delivery_id, $db->insert_id);
        }

        $db->close();

        return $model;
    }

    public function CreateOrderProducts ($products) {

        $db = (new DB())->CreateConnection();

        foreach ($products as $product) {
            $statement = $db->prepare(
                'INSERT INTO `order_products` (`order_id`, `product_id`, `quantity`, `current_price`) 
      VALUES (?, ?, ?, ?)'
            );

            $statement->bind_param('iiid',
                $this->id,
                $product['product_id'],
                $product['quantity'],
                $product['current_price']
            );

            $statement->execute();
        }


        $db->close();

    }

}