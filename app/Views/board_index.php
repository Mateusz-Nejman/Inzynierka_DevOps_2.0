<div class="boardContainer" id="boardGridContainer">
    <div class="boardGrid" id="boardGrid">
    </div>
</div>
<div style="display: none" id="boardContainer">
    <div class="boardTopbar">
        <?= formButtonLink('<i class="fas fa-home"></i>', '*boardsGotoHome()', 'baseButton'); ?>
        <?= formBegin(); ?>
        <div class="boardName">
            <input type="text" id="boardName" value="Title" onblur="boardsChangeBoardName()" />
        </div>
        <?= formEnd(); ?>
        <?= formButtonLink('<i class="fas fa-users"></i>', '*boardsOpenUsers()', 'baseButton" id="boardsUsersButton'); ?>
    </div>

    <div class="boardContainer">
        <div class="taskContainerBase" id="board">

        </div>
        <div class="formGroup boardContainerSidebar">
            <div class="newColumn">
                <?= formButtonLink('<i class="fas fa-plus"></i> Nowa kolumna', '*boardsShowNewColumn(true)', 'transparentButtonLink newColumnInactive" id="boardNewColumnInactive'); ?>
                <div class="newColumnActive" id="boardNewColumnActive">
                    <input type="hidden" id="boardNewColumnBoardId" />
                    <?= formTextBox("Nazwa kolumny", "columnName", "boardNewColumnName"); ?>
                    <div class="row">
                        <?= formButtonLink("Nowa kolumna", "*boardsCreateColumnSubmit()", "baseButton"); ?>
                        <?= formButtonLink('<i class="fas fa-times"></i>', '*boardsShowNewColumn(false)', 'transparentButtonLink'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fullScreenInfo loadingScreen" id="loading">
        <div class="spin"></div>
    </div>
</div>