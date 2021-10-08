<div class="baseControl">
    <div class="row">
        <div class="col2">
            <div class="formGroup">
                <input type="hidden" id="boardsNewTaskColumnId" />
                <?= formTextBoxTitled("Nazwa", "name", "boardsNewTaskName"); ?>
                <?= formListBoxTitled("Zadanie użytkownika", "assignedTo", "boardsNewTaskAssignedTo", -1, []); ?>
                <?= formListBoxTitled("Priorytet", "priority", "boardsNewTaskPriority", 1, ["Bardzo niski", "Niski", "Średni", "Wysoki", "Krytyczny"]); ?>
                <div id="boardsNewTaskDescription" class="formTextBox"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <?= formButtonLink("Nowe zadanie", "*boardsCreateTaskSubmit()", 'baseButton" id="boardsNewTaskButton'); ?>
    </div>
</div>