<div class="row">
    <div class="col">
        <h2 class="contentTitle">Zaloguj się</h2>
        <div class="formGroup">
            <?= formBegin(); ?>
            <?= formTextBoxTitled("Email", "email", "loginEmail"); ?>
            <?= formPasswordBoxTitled("Hasło", "password", "loginPassword"); ?>
            <div style="display: flex; flex-direction: row">
                <?= formButtonLink("Zaloguj się", "*loginSubmit()", "baseButton"); ?>
                <?= formButtonLink('Zaloguj z&nbsp;<i class="fab fa-facebook"></i>', base_url() . "/login/facebook", "baseButton"); ?>
            </div>
            <?= formEnd(); ?>
        </div>
    </div>
    <div class="col">
        <h2 class="contentTitle">Utwórz konto</h2>
        <div class="formGroup">
            <?= formBegin(); ?>
            <?= formTextBoxTitled("Email", "email", "loginNewEmail"); ?>
            <?= formPasswordBoxTitled("Hasło", "password", "loginNewPassword"); ?>
            <div style="display: flex; flex-direction: row">
                <?= formButtonLink("Utwórz konto", "*loginNewSubmit()", 'baseButton'); ?>
                <?= formButtonLink('Utwórz z&nbsp;<i class="fab fa-facebook"></i>', base_url() . "/login/facebook", "baseButton"); ?></div>
            <?= formEnd(); ?>
        </div>
    </div>
</div>