<html>

<head>
    <title>DevOps Board 2.0</title>
    <link rel="icon" href="/public/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/assets/css/fontAwesome.min.css">
    <link rel="stylesheet" href="/assets/css/neyolabUI.css?v=<?= $cacheClear; ?>">
    <link rel="stylesheet" href="/assets/css/neyolabUI.Components.css?v=<?= $cacheClear; ?>">
    <link rel="stylesheet" href="/assets/css/neyolabUI.Board.css?v=<?= $cacheClear; ?>">
    <link rel="stylesheet" href="/assets/css/quill.snow.css?v=<?= $cacheClear; ?>">
    <link rel="stylesheet" href="/assets/css/newDatatables.css">
    <link rel="stylesheet" href="/assets/css/highlight.min.css">
</head>

<body>
    <div class="containerScroller">
        <div class="contentContainer" style="min-height: 0vh; height: 100vh !important">
            <div class="container">
                <div class="containerTopbar clearBorder">
                    <div class="containerButtons">
                        
                    </div>
                </div>
                <div class="content">
                    <div class="flexCenter">
                        <div class="col" id="loginBox">
                            <h2 class="contentTitle">Zaloguj się</h2>
                            <div class="formGroup">
                                <?= formBegin(); ?>
                                <?= formTextBoxTitled("Email", "email", "loginEmail"); ?>
                                <?= formPasswordBoxTitled("Hasło", "password", "loginPassword"); ?>
                                <div style="display: flex; flex-direction: row">
                                    <?= formButtonLink("Zaloguj się", "*loginSubmit()", "baseButton"); ?>
                                    <?= formButtonLink('Zaloguj z&nbsp;<i class="fab fa-facebook"></i>', base_url() . "/login/facebook", "baseButton"); ?>
                                    <?= formButtonLink('Nie masz konta? Utwórz je!', '*loginShow(false)', 'transparent baseLink', "Załóż konto"); ?>
                                </div>
                                <?= formEnd(); ?>
                            </div>
                        </div>
                        <div class="col" id="registerBox" style="display: none">
                            <h2 class="contentTitle">Utwórz konto</h2>
                            <div class="formGroup">
                                <?= formBegin(); ?>
                                <?= formTextBoxTitled("Email", "email", "loginNewEmail"); ?>
                                <?= formPasswordBoxTitled("Hasło", "password", "loginNewPassword"); ?>
                                <div style="display: flex; flex-direction: row">
                                    <?= formButtonLink("Utwórz konto", "*loginNewSubmit()", 'baseButton'); ?>
                                    <?= formButtonLink('Utwórz z&nbsp;<i class="fab fa-facebook"></i>', base_url() . "/login/facebook", "baseButton"); ?>
                                    <?= formButtonLink('Masz już konto? Zaloguj się!', '*loginShow(true)', 'transparent baseLink', "Zaloguj się"); ?>
                                </div>
                                <?= formEnd(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="notificationContainer" id="notificationContainer"></div>
    <div id="fullScreenInfo" style="display: none">
        <div class="fullScreenInfo">
            <h1 class="fullScreenInfoText" id="fullScreenInfoText"></h1>
        </div>
    </div>

    <script>
        const baseUrl = "<?= base_url(); ?>";
    </script>
    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/jquery-ui.js"></script>
    <script src="/assets/js/tilt.js"></script>
    <script src="/assets/js/highlight.min.js"></script>
    <script src="/assets/js/quill.min.js"></script>
    <script src="/assets/js/neyolabUI.Components.js?v=<?= $cacheClear; ?>"></script>
    <script src="/assets/js/moment.js"></script>
    <script src="/assets/js/base.js?v=<?= $cacheClear; ?>"></script>
    <script src="/assets/js/utils.js"></script>
    <script src="/assets/js/login.js?v=<?= $cacheClear; ?>"></script>
</body>

</html>