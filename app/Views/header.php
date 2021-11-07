<html>

<head>
    <title>DevOps Board 2.0</title>
    <link rel="icon" href="/public/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/assets/css/template/styles.css">
    <link rel="stylesheet" href="/assets/css/fontAwesome.min.css">
    <link rel="stylesheet" href="/assets/css/styles.css?v=3">
    <link rel="stylesheet" href="/assets/css/quill.snow.css?v=5">
    <link rel="stylesheet" href="/assets/css/newDatatables.css">
    <link rel="stylesheet" href="/assets/css/highlight.min.css">
</head>

<body>
    <div class="containerScroller">
        <nav class="navbar fixedTop flexRow">
            <div class="navbarBrand"><img class="navbarLogo" src="/assets/css/dashboard/NeyoLabERPLogo.png" /></div>
            <div class="navbarContent">
                <div class="mlAuto dropdownButtons">
                    <?= $userData->role == 1 ? formDropdownButton("fas fa-cog", "dropdownButtonSettings", [
                        ["title" => "Ogólne", "link" => "*openModal('settingsBasics')"],
                        ["title" => "Użytkownicy", "link" => "*openSettingsUsersPage()"]
                    ]) : ""; ?>
                    <?php
                    echo formDropdownButton("fas fa-user-circle", "dropdownButtonProfile", [
                        ["title" => "Profil", "link" => "*openModal('userProfile')"],
                        ["title" => "Wyloguj", "link" => "*logout()"]
                    ], '<h5 class="pad20">' . $userData->email . '</h5>'); ?>
                </div>
            </div>
        </nav>
        <div class="contentContainer">
            <nav class="sidebar">
                <ul class="nav">
                    <li class="navItem"><span class="navLink" id="profileMenuItem"></span></li>
                    <?php

                    foreach ($menu as $menuIndex => $menuItem) {
                        if (is_string($menuIndex)) {
                            echo '<li class="navItem navCategory">' . $menuIndex . '</li>';

                            foreach ($menuItem as $_menuItem) {
                                echo '<li class="navItem"><a href="' . base_url() . '/' . $_menuItem->link . '" class="navLink ' . ($_menuItem->title == $activeMenu ? "active" : "") . '"><i class="navIcon ' . $_menuItem->icon . '"></i><span class="navTitle">' . $_menuItem->title . '</span></a></li>';
                            }
                        } else {
                            echo '<li class="navItem"><a href="' . base_url() . '/' . $menuItem->link . '" class="navLink ' . ($menuItem->title == $activeMenu ? "active" : "") . '"><i class="navIcon ' . $menuItem->icon . '"></i><span class="navTitle">' . $menuItem->title . '</span></a></li>';
                        }
                    }
                    ?>
                </ul>
            </nav>
            <div class="container">
                <div class="containerTopbar">
                    <h5 class="containerTitle"><?= $title; ?></h5>
                    <div class="containerButtons">
                        <?php if (count($buttons) > 0) : ?>
                            <?php foreach ($buttons as $index => $value) {
                                echo formButtonLink($value["text"], $value["path"], "baseButton");
                            } ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="content"><?= $content; ?></div>
            </div>
        </div>
    </div>