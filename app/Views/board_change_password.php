<div class="baseControl baseControlModal">
    <div class="row">
        <div class="col2">
            <div class="formGroup">
                <?= formPasswordBoxTitled("Nowe hasło", "password", "passwordChangePassword"); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <?= formButtonLink("Zapisz", "*passwordChangeSubmit()", 'baseButton'); ?>
    </div>
</div>