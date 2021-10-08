<div class="row">
    <div class="col">
        <h2 class="contentTitle">Zaloguj się</h2>
        <div class="formGroup">
        <?=formBegin();?>
            <?=formTextBoxTitled("Email","email","loginEmail");?>
            <?=formTextBoxTitled("Hasło","password","loginPassword","","","password");?>
            <?=formButtonLink("Zaloguj się","*loginSubmit()","baseButton");?>
            <?=formEnd();?>
        </div>
    </div>
    <div class="col">
        <h2 class="contentTitle">Utwórz konto</h2>
        <div class="formGroup">
            <?=formBegin();?>
            <?=formTextBoxTitled("Email","email","loginNewEmail");?>
            <?=formTextBoxTitled("Hasło","password","loginNewPassword","","","password");?>
            <?=formTextBoxTitled("Powtórz hasło","passwordRepeat","loginNewPasswordRepeat","","","password");?>
            <?=formButtonLink("Utwórz konto","*loginNewSubmit()","baseButton");?>
            <?=formEnd();?>
        </div>
    </div>
</div>