<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		helper("access");

		$userData = getLoggedUserData();

		if($userData == null)
		{
			header("Location: " . base_url() . "/login");
            exit();
		}
		else
		{
			header("Location: " . base_url() . "/boards");
            exit();
		}
	}
}
