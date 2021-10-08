<?php foreach ($modals as $modal) : ?>
    <div class="modalBackground" id="<?= $modal["name"]; ?>">
        <div class="modalSmallerContent">
            <div class="modalWindowHeader">
                <div class="modalWindowTitle mrAuto"></div>
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
<script src="/assets/js/components.js"></script>
<script src="/assets/js/moment.js"></script>
<script src="/assets/js/base.js?v=4"></script>
<?php foreach ($scripts as $scriptPath) : ?>
        <?php if (strpos($scriptPath, "http") === 0) : ?>
            <script src="<?= $scriptPath; ?>"></script>
        <?php else : ?>
            <script src="/assets/js/<?= $scriptPath; ?>?v=<?= $cacheClear; ?>"></script>
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
</body>

</html>