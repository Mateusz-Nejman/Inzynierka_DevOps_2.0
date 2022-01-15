<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Facebook\Facebook;
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
        return showPage("login", ["logged" => false], [], ["login.js"]);
    }

    public function login()
    {
        if (!$this->checkValidRequest($this->request)) {
            return $this->getInvalidResponse($this->response);
        }

        $email = $this->request->getVar("email");
        $password = $this->request->getVar("password");

        if ($this->loginBase($email, $password)) {
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

        if (!$this->registerBase($email, $password)) {
            return $this->response->setJSON(["state" => 2, "message" => "User with that email exists"]);
        }

        return $this->response->setJSON(["state" => 0, "message" => "successfully logged"]);
    }

    public function logout()
    {
        delete_cookie("devops20");
    }

    public function facebook()
    {
        $fb = new Facebook([
            'app_id' => '592038942179611',
            'app_secret' => 'cc1a87e5defa2c9ed0522d969078c38f',
            'default_graph_version' => 'v3.2'
        ]);

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email'];
        // For more permissions like user location etc you need to send your application for review

        $loginUrl = $helper->getLoginUrl('https://apsl.mateusz-nejman.pl/login/facebookCallback', $permissions);
        header("Location:{$loginUrl}");
        exit();
    }

    public function facebookCallback()
    {
        $fb = new Facebook([
            'app_id' => '592038942179611',
            'app_secret' => 'cc1a87e5defa2c9ed0522d969078c38f',
            'default_graph_version' => 'v3.2'
        ]);

        $helper = $fb->getRedirectLoginHelper();
        $helper->getPersistentDataHandler()->set('state', $this->request->getVar("state"));
        $accessToken = $helper->getAccessToken();
        $response = $fb->get('/me?fields=email', $accessToken);
        $me = $response->getGraphUser();
        $email = $me->getField("email");

        file_put_contents('email.txt', $email);
        $user = $this->db->table("users")->where("email", $email)->get()->getRow();

        if ($user == null) {
            $result = $this->registerBase($email, rand(1000000, 9999999));
            if ($result) {
                header("Location:" . base_url() . "/boards");
                exit();
            } else {
                header("Location:" . base_url());
                exit();
            }
        } else {
            $result = $this->loginBase($user->email, $user->password, false);
            if ($result) {
                header("Location:" . base_url() . "/boards");
                exit();
            } else {
                header("Location:" . base_url());
                exit();
            }
        }
    }

    private function loginBase($email, $password, $verify = true)
    {
        $userData = $this->db->table("users")->where("email", $email)->limit(1)->get()->getRow();

        if ($userData == null) {
            return false;
        }

        $matchPassword = password_verify($password, $userData->password);

        if (!$verify) {
            $matchPassword = true;
        }

        if (!$matchPassword) {
            return false;
        }


        setcookie("devops20", $userData->id . "[DEV]" . password_hash($userData->email . "[DEV]" . $userData->password, PASSWORD_DEFAULT), time() + 2678400, "/");
        return true;
    }

    private function registerBase($email, $password)
    {
        $userData = $this->db->table("users")->where("email", $email)->limit(1)->get()->getRow();

        if ($userData != null) {
            return false;
        }

        $this->db->table("users")->insert([
            "email" => $email,
            "password" => password_hash($password, PASSWORD_BCRYPT)
        ]);

        $userData = $this->db->table("users")->where("email", $email)->limit(1)->get()->getRow();

        setcookie("devops20", $userData->id . "[DEV]" . password_hash($userData->email . "[DEV]" . $userData->password, PASSWORD_DEFAULT), time() + 2678400, "/");

        return true;
    }
}
