<?php

if(!function_exists('showPage')) {
    function showPage($templateName, $data = [], $modals = [], $additionalScripts = [])
    {
        echo view("template", [
            "content" => view($templateName, $data),
            "modals" => $modals,
            "scripts" => $additionalScripts,
            "menu" => [],
            "buttons" => [],
            "cacheClear" => rand(0,100) //TODO
        ]);
    }
}

if (!function_exists("createModal")) {
    function createModal($title, $name, $contentName, $contentData = [])
    {
        return ["title" => $title, "name" => $name, "content" => view($contentName, $contentData)];
    }
}