<?php

namespace App\Core;

class Router
{

	private $controller;

	private $method;

	private $controllerMethod;

	private $params = [];

	function __construct()
	{

		$url = $this->parseURL();

		if (file_exists("../src/Controllers/" . ucfirst($url[1]) . ".php")) {

			$this->controller = $url[1];
			unset($url[1]);
		} elseif (empty($url[1])) {

			echo "";

			exit;
		} else {
			http_response_code(404);
			echo json_encode(["erro" => "Not found"]);

			exit;
		}

		require_once "../src/Controllers/" . ucfirst($this->controller) . ".php";

		$this->controller = new $this->controller;

		$this->method = $_SERVER["REQUEST_METHOD"];

		switch ($this->method) {
			case "GET":

				if (isset($url[2])) {
					$this->controllerMethod = "finOne";
					$this->params = [$url[2]];
				} else {
					$this->controllerMethod = "findAll";
				}

				break;

			case "POST":
				$this->controllerMethod = "create";
				break;

			case "PUT":
				$this->controllerMethod = "update";
				if (isset($url[2]) && is_numeric($url[2])) {
					$this->params = [$url[2]];
				} else {
					http_response_code(400);
					echo json_encode(["erro" => "Id is required"]);
					exit;
				}
				break;

			case "DELETE":
				$this->controllerMethod = "delete";
				if (isset($url[2]) && is_numeric($url[2])) {
					$this->params = [$url[2]];
				} else {
					http_response_code(400);
					echo json_encode(["erro" => "Id is required"]);
					exit;
				}
				break;

			default:
				echo "Method is not supported";
				exit;
				break;
		}

		call_user_func_array([$this->controller, $this->controllerMethod], $this->params);
	}

	private function parseURL()
	{
		return explode("/", $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
	}
}
