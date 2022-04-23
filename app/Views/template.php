<html>

<head>
    <title>Evaluation Board</title>
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

<body style="overflow-x: hidden">
    <div class="containerScroller">
        <div class="contentContainer">
            <div class="container">
                <div class="containerTopbar clearBorder">
                    <div class="containerButtons">
                        <?php if ($logged) : ?>
                            <?= formBegin(); ?>
                            <div class="boardName">
                                <input type="text" id="boardName" value="Title" onblur="boardsChangeBoardName()" style="display: none; width:auto" />
                            </div>
                            <?= formEnd(); ?>
                            <div class="rowStatic mlAutoDesktop mrCenterMobile">
                                <div class="rowStatic" id="boardButtons" style="display: none">
                                    <?= formButtonLink('<i class="fas fa-trash"></i>', '*boardsArchiveBoard()', 'baseButton" id="boardsArchiveButton', "Tablice"); ?>
                                    <?= formButtonLink('<i class="fas fa-users"></i>', '*boardsOpenUsers()', 'baseButton" id="boardsUsersButton', "Użytkownicy"); ?>
                                    <?= formButtonLink('<i class="fas fa-table"></i>', '*boardsGotoHome()', 'baseButton', "Tablice"); ?>
                                </div>
                                <?= formButtonLink('<i class="fas fa-archive"></i>', '*archiveOpen()', 'baseButton mlAuto', "Archiwum"); ?>
                                <?= formButtonLink('<i class="fas fa-key"></i>', '*passwordChangeOpen()', 'baseButton', "Zmiana hasła"); ?>
                                <?= formButtonLink('<i class="fas fa-door-open"></i>', '*logout()', 'baseButton mlAuto', "Wyloguj się"); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="content"><?= $content; ?></div>
            </div>
        </div>
    </div>
    <?php foreach ($modals as $modal) : ?>
        <div class="modalBackground modalBottomRight" id="<?= $modal["name"]; ?>">
            <div class="modalSmallerContent" id="<?= $modal["name"]; ?>SmallerContent">
                <div class="modalWindowHeader">
                    <div class="modalWindowTitle mrAuto"><h5><?= $modal["title"]; ?></h5></div>
                    <div class="mlAuto"><button type="button" class="baseButton" id="modalClose<?= $modal["name"]; ?>"><i class="fas fa-times"></i></button></div>
                </div>
                <?= $modal["content"]; ?>
            </div>
        </div>
    <?php endforeach; ?>
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
    <?php foreach ($scripts as $scriptPath) : ?>
        <?php if (strpos($scriptPath, "http") === 0) : ?>
            <script src="<?= $scriptPath; ?>"></script>
        <?php else : ?>
            <script src="/assets/js/<?= $scriptPath; ?>?v=<?= $cacheClear; ?>1001"></script>
        <?php endif; ?>
    <?php endforeach; ?>
    <script>
        $(document).ready(() => {
            //<div class="[fullscreen] modal[direction]" id="[name]"><div class="modalBlurBackground"></div><div class="[fullscreen1]"><div class="modalWindowHeader"><div class="mrAuto modalWindowTitle"><h5>[title]</h5></div><div class="mlAuto modalHeaderButtons">[buttons]<button type="button" class="modalWindowButton" id="modalClose[name]"><i class="fas fa-times"></i></button></div></div></div></div>
            <?php foreach ($modals as $value) : ?>
                $("#modalClose<?= $value["name"]; ?>").click(() => {
                    var validationFunction = "<?= $value["validate"]; ?>";
                    var canClose = true;

                    if (validationFunction.length > 0) {
                        var fn = window[validationFunction];

                        if (typeof fn === 'function') {
                            canClose = fn();
                        }
                    }

                    if (canClose) {
                        closeModal("<?= $value["name"]; ?>");
                    }
                });
            <?php endforeach; ?>
        });
    </script>
    <script>
        $(document).ready(() => {
            <?= $script; ?>
        });
    </script>
</body>

</html>