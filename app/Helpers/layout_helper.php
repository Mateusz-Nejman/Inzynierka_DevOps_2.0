<?php

if(!function_exists('showPage')) {
    function showPage($templateName, $data = [], $modals = [], $additionalScripts = [])
    {
        echo view("header");
        echo view($templateName,$data);
        echo view("footer", ["modals" => $modals, "scripts" => $additionalScripts, "cacheClear" => 100]);
    }
}

if (!function_exists("createModal")) {
    function createModal($title, $name, $contentName, $contentData = [])
    {
        return ["title" => $title, "name" => $name, "content" => view($contentName, $contentData)];
    }
}