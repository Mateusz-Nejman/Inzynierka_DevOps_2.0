<div class="baseControl baseControlModal">
    <div class="row">
        <div class="col">
            <div class="formGroup" id="boardsUserAddSection">
                <?= formListBoxTitled("Użytkownik", "user", "boardsUserUser"); ?>
                <?= formListBoxTitled("Rola", "role", "boardsUserRole", 1, [1 => "Administrator", 2 => "Użytkownik", 3 => "Tylko podgląd"]); ?>
                <?= formButtonLink("Dodaj użytkownika", "*boardsAddUserSubmit()", "baseButton"); ?>
            </div>
            <div class="formGroup" id="boardsUserEditSection" style="display: none">
                <?= formListBoxTitled("Użytkownik", "user", "boardsUserEdit", -1, [], false, "", true); ?>
                <?= formListBoxTitled("Rola", "role", "boardsUserEditRole", 1, [1 => "Administrator", 2 => "Użytkownik", 3 => "Tylko podgląd"]); ?>
                <?= formButtonLink("Zmień", "*boardsEditUserSubmit()", "baseButton"); ?>
            </div>
        </div>
        <div class="col">
            <table class="table dataTable">
                <thead>
                    <tr>
                        <th>Użytkownik</th>
                        <th>Edytuj</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody id="boardsUserRoleTable"></tbody>
            </table>
        </div>
    </div>
</div>