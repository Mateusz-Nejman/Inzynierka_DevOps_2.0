
<?php

if (!function_exists('checkAccessToPage')) {
    function checkAccessToPage(bool $loginRequired, bool $adminPage = false, bool $maintentance = false): bool
    {
        helper('cookie');

        $currentCookie = get_cookie('devops20', true);

        if ($currentCookie == null && $loginRequired)
            return false;

        if ($loginRequired) {
            if (!validAccessData($currentCookie))
                return false;

            $items = explode("[DEV]", $currentCookie);

            $db = \Config\Database::connect();

            $builder = $db->table("users");

            $userData = $builder->where("id", intval($items[0]))->get()->getRow();

            if ($userData == null)
                return false;
            else {
                if ($adminPage && $userData->role == 0)
                    return false;
                else if ($maintentance && $userData->role == 0)
                    return false;
                else
                    return password_verify($userData->email . "[DEV]" . $userData->password, $items[1]);
            }
        }

        return false;
    }
}

if (!function_exists('redirectIfAccessDenied')) {
    function redirectIfAccessDenied($loginRequired, $adminPage = false, $maintentance = false, $url = "")
    {
        if (!checkAccessToPage($loginRequired, $adminPage, $maintentance, $url)) {
            header("Location: " . base_url() . "/" . $url);
            exit();
        }
    }
}

if (!function_exists('getLoggedUserData')) {
    function getLoggedUserData()
    {
        helper('cookie');

        $currentCookie = get_cookie('devops20', true);

        if ($currentCookie == null) {
            return null;
        }

        if (!validAccessData($currentCookie)) {
            return null;
        }

        $items = explode("[DEV]", $currentCookie);

        $db = \Config\Database::connect();

        $builder = $db->table("users");

        $userData = $builder->where("id", intval($items[0]))->get()->getRow();

        if ($userData == null) {
            return null;
        }

        if (!password_verify($userData->email . "[DEV]" . $userData->password, $items[1])) {
            return null;
        }

        return $userData;
    }
}

if (!function_exists('validAccessData')) {
    function validAccessData($data)
    {
        $items = explode("[DEV]", $data);

        return count($items) == 2 && is_numeric($items[0]);
    }
}
