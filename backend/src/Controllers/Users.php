<?php

use App\Core\Controller;

class Users extends Controller
{
  public function findAll()
  {
    $userModel = $this->model("User");

    $users = $userModel->findAll();

    echo json_encode($users, JSON_UNESCAPED_UNICODE);
  }

  public function findOne($id)
  {
    $userModel = $this->model("User");
    $result = $userModel->findById($id);

    if (!$result) {
      http_response_code(404);
      echo json_encode(["erro" => "user not found"]);
      exit;
    }

    echo json_encode($result, JSON_UNESCAPED_UNICODE);
  }


  public function create()
  {
    $body = $this->getRequestBody();
    $errors = [];

    if (!isset($body->name) || empty(trim($body->name))) {
      $errors[] = "name is required";
    } elseif (strlen($body->name) < 3 || strlen($body->name) > 50) {
      $errors[] = "The 'name' field must be between 3 and 50 characters long";
    }

    if (!isset($body->age)) {
      $errors[] = "age is required";
    } elseif (!filter_var($body->age, FILTER_VALIDATE_INT)) {
      $errors[] = "The 'age' field must be an integer";
    }

    if (!empty($errors)) {
      http_response_code(400);
      echo json_encode(["erros" => $errors]);
      return;
    }

    $userModel = $this->model("User");

    $userModel->name = $body->name;
    $userModel->age = $body->age;

    $userModel = $userModel->create();

    if ($userModel) {
      http_response_code(201);
      echo json_encode($userModel);
    } else {
      http_response_code(500);
      echo json_encode(["erro" => "Erro"]);
    }
  }

  public function delete($id)
  {
    $userModel = $this->model("User");

    $result = $userModel->findById($id);

    if (!$result) {
      http_response_code(404);
      echo json_encode(["erro" => "user not found"]);
      exit;
    }

    $userModel->delete();


    echo "";
  }

  public function update($id)
  {
    $userModel = $this->model("User");
    $result = $userModel->findById($id);

    if (!$result) {
      http_response_code(404);
      echo json_encode(["erro" => "user not found"]);
      exit;
    }

    $body = $this->getRequestBody();
    $errors = [];

    if (!isset($body->name) || empty(trim($body->name))) {
      $errors[] = "name is required";
    } elseif (strlen($body->name) < 3 || strlen($body->name) > 50) {
      $errors[] = "The 'name' field must be between 3 and 50 characters long";
    }

    if (!isset($body->age)) {
      $errors[] = "age is required";
    } elseif (!filter_var($body->age, FILTER_VALIDATE_INT)) {
      $errors[] = "The 'age' field must be an integer";
    }

    if (!empty($errors)) {
      http_response_code(400);
      echo json_encode(["erros" => $errors]);
      return;
    }

    $userModel->name = $body->name;
    $userModel->age = $body->age;

    $result = $userModel->put();


    echo json_encode($result, JSON_UNESCAPED_UNICODE);
  }
}
