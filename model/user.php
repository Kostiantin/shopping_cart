<?php
class User {

    private $id;
    private $email;
    private $first_name;
    private $last_name;
    private $phone;

    public function __construct($first_name = '', $last_name = '', $phone = '', $email = '', $id = null) {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->phone = $phone;
        $this->email = $email;
        $this->id = $id;
    }

    public function getId () { return $this->id; }
    private function setId ($id) { $this->id = $id; }


    public function getFirstName () { return $this->first_name; }
    public function setFirstName ($first_name) { $this->first_name = $first_name; }


    public function getLastName () { return $this->last_name; }
    public function setLastName ($last_name) { $this->last_name = $last_name; }


    public function getPhone () { return $this->phone; }
    public function setPhone ($phone) { $this->phone = $phone; }


    public function getEmail () { return $this->email; }
    public function setEmail ($email) { $this->email = $email; }

    public function GetUserById ($id) {
        $model = null;
        $db = (new DB())->CreateConnection();
        $statement = $db->prepare('SELECT `id`, `first_name`, `last_name`, `phone`, `email` FROM `users` WHERE `id` = ?');
        $statement->bind_param('i', $id);
        $statement->bind_result($id, $first_name, $last_name, $phone, $email);
        if ($statement->execute()) {
          while ($row = $statement->fetch()) {
            $model = new User($id, $first_name, $last_name, $phone, $email);
          }
        }
        $db->close();
        return $model;
    }

    public function GetUserByEmail ($email) {
        $model = null;
        $db = (new DB())->CreateConnection();
        $statement = $db->prepare('SELECT `id`, `first_name`, `last_name`, `phone`, `email` FROM `users` WHERE `email` = ?');
        $statement->bind_param('i', $email);
        $statement->bind_result($id, $first_name, $last_name, $phone, $email);
        if ($statement->execute()) {
            while ($row = $statement->fetch()) {
                $model = new User($first_name, $last_name, $phone, $email, $id);
            }
        }
        $db->close();
        return $model;
    }

    public function Create () {
        $model = null;
        $db = (new DB())->CreateConnection();

        $statement = $db->prepare(
            'INSERT INTO `users` (`first_name`, `last_name`, `phone`, `email`) VALUES (?, ?, ?, ?)'
        );

        $statement->bind_param('ssss',$this->first_name, $this->last_name, $this->phone, $this->email);
        $statement->execute();

        if (!empty($db->insert_id)) {
            $model = new User($this->first_name, $this->last_name, $this->phone, $this->email, $db->insert_id);
        }

        $db->close();
        return $model;
    }

    public function GetAllUsers () {
        $models = [];
        $db = (new DB())->CreateConnection();
        $statement = $db->prepare('SELECT `id`, `first_name`, `last_name`, `phone`, `email` FROM `users`');
        $statement->bind_result($id, $first_name, $last_name, $phone, $email);
        if ($statement->execute()) {
          while ($row = $statement->fetch()) {
            $model = new User($id, $first_name, $last_name, $phone, $email);
            array_push($models, $model);
          }
        }
        $db->close();
        return $models;
    }

    public function ToAssociativeArray () {
        return array(
          'id' => $this->id,
          'first_name' => $this->first_name,
          'last_name' => $this->last_name,
          'phone' => $this->phone,
          'email' => $this->email,
        );
    }
}
