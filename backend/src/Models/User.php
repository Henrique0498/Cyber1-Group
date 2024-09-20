<?php

use App\Core\Model;

class User
{
  public $id;
  public $name;
  public $age;

  public function findAll()
  {
    $sql = " SELECT * FROM users ORDER BY id DESC ";

    $stmt = Model::getConn()->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);

      return $resultado;
    } else {
      return [];
    }
  }

  public function findById($id)
  {
    $sql = " SELECT * FROM users WHERE id = ?";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(1, $id);

    if ($stmt->execute()) {
      $result = $stmt->fetch(PDO::FETCH_OBJ);

      if (!$result) {
        return null;
      }

      $this->id = $result->id;
      $this->name = $result->name;
      $this->age = $result->age;


      return $this;
    } else {
      return null;
    }
  }

  public function create()
  {
    $sql = " INSERT INTO users (name, age) VALUES (?, ?) ";

    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(1, $this->name);
    $stmt->bindValue(2, $this->age);

    if ($stmt->execute()) {
      $this->id = Model::getConn()->lastInsertId();
      return $this;
    } else {
      print_r($stmt->errorInfo());
      return null;
    }
  }

  public function delete()
  {
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(1, $this->id);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function put()
  {
    $sql = " UPDATE users SET name = ?, age = ? WHERE id = ? ";

    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(1, $this->name);
    $stmt->bindValue(2, $this->age);
    $stmt->bindValue(3, $this->id);

    $stmt->execute();

    return $this;
  }
}
