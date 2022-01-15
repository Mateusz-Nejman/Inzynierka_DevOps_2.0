<div class="baseControl baseControlModal">
    <div class="row">
        <div class="col2">
            <div class="formGroup">
                <input type="hidden" id="boardsEditTaskId" />
                <?= formTextBoxTitled("Nazwa", "name", "boardsEditTaskName"); ?>
                <?= formListBoxTitled("Zadanie użytkownika", "assignedTo", "boardsEditTaskAssignedTo", -1, []); ?>
                <?= formListBoxTitled("Priorytet", "priority", "boardsEditTaskPriority", 1, ["Bardzo niski", "Niski", "Średni", "Wysoki", "Krytyczny"]); ?>
                <?= formListBoxTitled("Kolumna", "column", "boardsEditTaskColumn"); ?>
                <div id="boardsEditTaskDescription" class="formTextBox"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <?= formButtonLink("Zapisz", "*boardsEditTaskSubmit()", 'baseButton" id="boardsEditTaskButton'); ?>
        <?= formButtonLink("Archiwizuj", "*boardsEditTaskArchiveSubmit()", 'baseButton" id="boardsEditTaskArchive'); ?>
    </div>
    <div class="row mt20">
        <div class="col2">
            <h2 class="contentTitle">Nowy komentarz</h2>
            <div class="formGroup">
                <div class="formTextBox" id="boardsEditTaskNewComment"></div>
            </div>
            <?= formButtonLink("Dodaj komentarz", "*boardsEditTaskAddCommentSubmit()", "baseButton"); ?>
            <h2 class="contentTitle mt20">Komentarze</h2>
            <div class="taskCommentList" id="taskCommentList">

            </div>
        </div>
    </div>
</div>