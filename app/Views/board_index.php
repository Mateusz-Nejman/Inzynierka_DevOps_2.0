<div class="boardContainer" id="boardGridContainer">
    <div class="boardGrid" id="boardGrid">
    </div>
</div>
<div style="display: none" id="boardContainer">
    <div class="boardContainer">
        <div class="taskContainerBase" id="board">

        </div>
        <div class="formGroup boardContainerSidebar">
            <div class="newColumn">
                <?= formButtonLink('<i class="fas fa-plus"></i> Nowa kolumna', '*boardsShowNewColumn(true)', 'transparentButtonLink newColumnInactive" id="boardNewColumnInactive'); ?>
                <div class="newColumnActive" id="boardNewColumnActive">
                    <input type="hidden" id="boardNewColumnBoardId" />
                    <?= formTextBox("Nazwa kolumny", "columnName", "boardNewColumnName", "", "", "text", false, "boardsCreateColumnSubmit"); ?>
                    <div class="row" style="justify-content: center">
                        <?= formButtonLink('<i class="fas fa-check"></i>', "*boardsCreateColumnSubmit()", "transparentButtonLink greenColor"); ?>
                        <?= formButtonLink('<i class="fas fa-times"></i>', '*boardsShowNewColumn(false)', 'transparentButtonLink'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fullScreenInfo loadingScreen" id="loading">
        <div class="circle-border"><div class="circle-core"></div></div>
    </div>
</div>