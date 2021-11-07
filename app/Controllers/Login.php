<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use stdClass;

class Login extends BaseController
{
	private $db;

	public function __construct()
	{
		$this->db = \Config\Database::connect();
        helper("cookie");
	}

	public function index()
	{
		return showPage("login", ["logged" => false], [],["login.js"]);
	}

    public function login()
    {
        if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

        $email = $this->request->getVar("email");
        $password = $this->request->getVar("password");

        $userData = $this->db->table("users")->where("email",$email)->limit(1)->get()->getRow();

        if($userData == null)
        {
            return $this->response->setJSON(["state" => 2, "message" => "User with that email doesn't exists"]);
        }

        $matchPassword = password_verify($password,$userData->password);

        if($matchPassword)
        {
            set_cookie("devops20", $userData->id . "[DEV]" . password_hash($userData->email . "[DEV]" . $userData->password, PASSWORD_DEFAULT), 2678400);
            
            return $this->response->setJSON(["state" => 0, "message" => "successfully logged"]);
        }

        return $this->response->setJSON(["state" => 2, "message" => "invalid password"]);
    }

    public function register()
    {
        if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

        $email = $this->request->getVar("email");
        $password = $this->request->getVar("password");

        $userData = $this->db->table("users")->where("email",$email)->limit(1)->get()->getRow();

        if($userData != null)
        {
            return $this->response->setJSON(["state" => 2, "message" => "User with that email exists"]);
        }

        $this->db->table("users")->insert([
            "email" => $email,
            "password" => password_hash($password, PASSWORD_BCRYPT)
        ]);

        $userData = $this->db->table("users")->where("email",$email)->limit(1)->get()->getRow();

        set_cookie("devops20", $userData->id . "[DEV]" . password_hash($userData->email . "[DEV]" . $userData->password, PASSWORD_DEFAULT), 2678400);

        return $this->response->setJSON(["state" => 0, "message" => "successfully logged"]);
    }

    public function logout()
    {
        delete_cookie("devops20");
    }
}
