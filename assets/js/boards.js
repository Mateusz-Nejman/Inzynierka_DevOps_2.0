let currentBoard = -1;
let canAddUsers = true;
let canInteract = true;
let tilt;

$(document).ready(() => {
    boardsRefreshBoardsGrid();

    boardsNewTaskEditor = createEditor("boardsNewTaskDescription");

    boardsEditTaskEditor = createEditor("boardsEditTaskDescription");

    boardsNewCommentEditor = createEditor("boardsEditTaskNewComment");
});

const boardsChangeTasksOrder = (columnId, ids) => {
    ajaxPost(baseUrl + '/boards/changeTasksOrder', {
        columnId: columnId,
        ids: ids
    }, result => {

    });
}

const boardsMoveTaskTo = (columnId, taskId, ids) => {
    ajaxPost(baseUrl + '/boards/moveTaskTo', {
        columnId: columnId,
        taskId: taskId,
        ids: ids
    }, result => {

    });
}

const boardsFillBoard = (boardId, onCompleted) => {
    ajaxPost(baseUrl + '/boards/getData', { boardId: boardId }, result => {
        $("#boardName").val(result.name);
        $("#board").empty();
        canAddUsers = result.role == 1;
        canInteract = result.role == 1 || result.role == 2;

        console.log(canAddUsers);
        console.log(canInteract);

        boardsNewTaskEditor.enable(canInteract);
        boardsEditTaskEditor.enable(canInteract);
        $("#boardsNewTaskName").prop("disabled", !canInteract);
        $("#boardsEditTaskName").prop("disabled", !canInteract);
        $("#boardsNewTaskButton").prop("disabled", !canInteract);
        $("#boardsEditTaskButton").prop("disabled", !canInteract);
        $("#boardsEditTaskArchive").prop("disabled", !canInteract);
        $("#boardName").prop("disabled", !canAddUsers);
        $("#boardsUsersButton").prop("disabled", !canAddUsers);

        result.columns.forEach(item => {
            const column = boardsCreateColumnItem(item);
            $("#board").append(column);

            item.tasks.forEach(taskItem => {
                const task = boardsCreateTaskItem(taskItem);
                $("#container" + item.id).append(task);
            });
        });

        console.log(result.users);

        onCompleted();
    });
}

const boardsCreateColumnItem = data => {
    const column = $('<div>', { id: "column" + data.id, "class": "taskColumn" });
    column.append('<div class="taskColumnName"><input type="text" value="' + data.name + '" onblur="boardsChangeColumnName(this)" ' + (canInteract ? "" : "disabled") + '/>' + formButtonLink('<i class="fas fa-times"></i>', "*boardsArchiveColumn(" + data.id + ")", 'transparentButtonLink mlAuto') + '</div>');

    column.append($('<div>', { id: "container" + data.id, "class": "taskColumnContainer" }));
    column.append(formButtonLink("Dodaj zadanie", "*boardsOpenNewTask(" + data.id + ")", "baseButton"));

    return column;
}

const boardsCreateTaskItem = data => {
    let priority = "taskItemPriorityVLow";

    if (data.priority == 1) {
        priority = "taskItemPriorityLow";
    }
    else if (data.priority == 2) {
        priority = "taskItemPriorityNormal";
    }
    else if (data.priority == 3) {
        priority = "taskItemPriorityHigh";
    }
    else if (data.priority == 4) {
        priority = "taskItemPriorityVHigh";
    }
    const task = $('<div>', { id: "task" + data.id, "class": "taskItem " + priority });
    task.append('<div class="taskItemName">' + data.name + '</div>');
    task.append('<div class="taskItemContent">' + formButtonLink('<i class="fas fa-edit"></i>', "*boardsOpenEditTask(" + data.id + ")", "transparentButtonLink") + generateAvatarFromEmail(data.email) + '</div>');

    return task;
}

const boardsChangeColumnsOrder = (boardId, ids) => {
    ajaxPost(baseUrl + '/boards/changeColumnsOrder', {
        boardId: boardId,
        ids: ids
    }, result => {

    });
}

const boardsCreateColumnSubmit = () => {
    const boardId = $("#boardNewColumnBoardId").val();
    const name = $("#boardNewColumnName").val();

    ajaxPost(baseUrl + '/boards/createColumn', {
        boardId: boardId,
        name: name
    }, result => {
        const column = boardsCreateColumnItem(result.data);
        $("#board").append(column);
        boardsInitializeColumns();
        $(".taskContainerBase").sortable('refresh');
    });
    boardsShowNewColumn(false);
}

const boardsOpenNewTask = columnId => {
    boardsNewTaskEditor.deleteText(0, boardsNewTaskEditor.getLength());
    openModal("newTask", [["boardsNewTaskColumnId", columnId], "boardsNewTaskName", ["boardsNewTaskPriority", 1]]);
}

const boardsCreateTaskSubmit = () => {
    const columnId = $("#boardsNewTaskColumnId").val();
    const name = $("#boardsNewTaskName").val();
    const assignedTo = $("#boardsNewTaskAssignedTo").val();
    const priority = $("#boardsNewTaskPriority").val();
    const description = JSON.stringify(boardsNewTaskEditor.getContents());

    ajaxPost(baseUrl + '/boards/createTask', {
        columnId: columnId,
        name: name,
        description: description,
        priority: priority,
        assignedTo: assignedTo
    }, result => {
        const task = boardsCreateTaskItem(result.data);
        $("#container" + columnId).append(task);
        $("#container" + columnId).sortable('refresh');
        closeModal("newTask")
    });
}

const boardsEditTaskSubmit = () => {
    const id = $("#boardsEditTaskId").val();
    const name = $("#boardsEditTaskName").val();
    const assignedTo = $("#boardsEditTaskAssignedTo").val();
    const priority = $("#boardsEditTaskPriority").val();
    const description = JSON.stringify(boardsEditTaskEditor.getContents());

    ajaxPost(baseUrl + '/boards/editTask', { id: id, name: name, description: description, assignedTo: assignedTo, priority: priority }, result => {
        boardsInitialize(currentBoard);
        closeModal("editTask");

    });
}

const boardsOpenEditTask = id => {
    boardsEditTaskEditor.deleteText(0, boardsEditTaskEditor.getLength());
    openModal("editTask", [["boardsEditTaskId", id], "boardsEditTaskName"]);
    $("#taskCommentList").empty();

    ajaxPost(baseUrl + '/boards/getTask', { id: id }, result => {
        $("#boardsEditTaskId").val(id);
        $("#boardsEditTaskName").val(result.data.name);
        $("#boardsEditTaskAssignedTo").val(result.data.assignedTo);
        $("#boardsEditTaskPriority").val(result.data.priority);
        boardsEditTaskEditor.setContents(JSON.parse(result.data.description));

        result.comments.forEach(item => {
            $("#taskCommentList").append(boardsCreateCommentItem(item));
        })
    });
}

const boardsEditTaskArchiveSubmit = () => {
    const id = $("#boardsEditTaskId").val();

    ajaxPost(baseUrl + "/boards/archiveTask", { id: id }, result => {
        $("#task" + id).remove();
        closeModal("editTask");
    });
}

const boardsArchiveColumn = id => {
    ajaxPost(baseUrl + "/boards/archiveColumn", { id: id }, result => {
        $("#column" + id).remove();
    });
}

const boardsChangeColumnName = handler => {
    const newName = $(handler).val();
    const columnHandler = $(handler).parent().parent();
    const columnIdRaw = columnHandler.attr('id');
    const columnId = +columnIdRaw.replace("column", "");

    ajaxPost(baseUrl + "/boards/changeColumnName", { id: columnId, name: newName }, result => {

    });
}

const boardsNewBoardSubmit = () => {
    const boardName = $("#boardNewBoardName").val();
    $("#loading").show();

    ajaxPost(baseUrl + "/boards/createBoard", { name: boardName }, result => {
        boardsRefreshBoardsGrid();
    });
}

const boardsInitialize = id => {
    boardsShowNewColumn(false);
    currentBoard = id;
    $("#boardNewColumnBoardId").val(id);
    boardsFillBoard(id, () => {
        if (canInteract) {
            $(".taskContainerBase").sortable({
                revert: true,
                placeholder: "taskColumnPlaceholder",
                stop: (event, ui) => {
                    const idsArrayRaw = $(event.target).sortable('toArray');

                    if (idsArrayRaw.length > 0) {
                        let idsArray = [];

                        idsArrayRaw.forEach(element => {
                            idsArray.push(parseInt(element.replace("column", "")));
                        });

                        boardsChangeColumnsOrder(id, idsArray);

                        console.log(idsArray);
                    }
                }
            });

            boardsInitializeColumns();
            $(".taskColumnContainer").disableSelection();
        }
        boardsRefreshBoardUsers();
        $("#loading").hide();
    });
}

const boardsShowNewColumn = show => {
    if (!canInteract) {
        return;
    }

    if (show) {
        $("#boardNewColumnInactive").hide();
        $("#boardNewColumnActive").show();
    }
    else {
        $("#boardNewColumnName").val("");
        $("#boardNewColumnInactive").show();
        $("#boardNewColumnActive").hide();
    }
}

const boardsChangeBoardName = () => {
    ajaxPost(baseUrl + "/boards/changeBoardName", { id: currentBoard, name: $("#boardName").val() }, result => {
        boardsRefreshBoardsGrid();
    })
}

const boardsRefreshBoardsGrid = () => {
    ajaxPost(baseUrl + "/boards/getUserBoards", { empty: true }, result => {
        $("#boardGrid").empty();
        result.data.forEach(item => {
            $("#boardGrid").append(formButtonLink(item.name, "*boardsGotoBoard(" + item.id + ")", "boardItem jsTilt"));
        });

        $("#boardGrid").append(boardsCreateNewBoardItem());
        boardsShowNewBoard(false);
        tilt = $(".jsTilt").tilt();
    });
}

const boardsCreateNewBoardItem = () => {
    return '<div class="boardItemNew jsTilt">' +
        formButtonLink('<i class="fas fa-plus"></i> Nowa tablica', "*boardsShowNewBoard(true)", 'transparentButtonLink newBoardInactive" id="boardsNewBoardInactive') +
        '<div class="newBoardActive" id="boardsNewBoardActive">' +
        formTextBox("Nazwa tablicy", "boardName", "boardNewBoardName") +
        '<div class="row">' +
        formButtonLink("Nowa tablica", "*boardsNewBoardSubmit()", "baseButton") +
        formButtonLink('<i class="fas fa-times"></i>', '*boardsShowNewBoard(false)', 'transparentButtonLink') +
        '</div></div></div>';
}

const boardsGotoBoard = id => {
    $("#loading").show();
    $("#boardGridContainer").hide();
    $("#boardContainer").show();
    boardsInitialize(id);
}

const boardsGotoHome = () => {
    $("#boardGridContainer").show();
    $("#boardContainer").hide();
}

const boardsShowNewBoard = show => {
    if (show) {
        $("#boardsNewBoardInactive").hide();
        $("#boardsNewBoardActive").show();
    }
    else {
        $("#boardsNewBoardName").val("");
        $("#boardsNewBoardInactive").show();
        $("#boardsNewBoardActive").hide();
    }
}

const boardsOpenUsers = () => {
    console.log("boardsOpenUsers");
    boardsShowUserSection(true);
    openModal("boardUsers");
}

const boardsShowUserSection = isAddSection => {
    if (isAddSection) {
        $("#boardsUserAddSection").show();
        $("#boardsUserEditSection").hide();
    }
    else {
        $("#boardsUserAddSection").hide();
        $("#boardsUserEditSection").show();
    }
}

const boardsEditUser = handler => {
    const row = $(handler).parent().parent();
    const userId = row.children().eq(0).text();
    const role = row.children().eq(1).text();

    $("#boardsUserEdit").val(userId);
    $("#boardsUserEditRole").val(role);
    boardsShowUserSection(false);
}

const boardsEditUserSubmit = () => {
    const userId = $("#boardsUserEdit").val();
    const role = $("#boardsUserEditRole").val();

    ajaxPost(baseUrl + "/boards/changeUserBoard", { id: currentBoard, userId: userId, role: role }, result => {
        $("#boardsUserUser").val(-1);
        $("#boardsUserRole").val(1);
        boardsShowUserSection(true);
        boardsRefreshBoardUsers();
    })
}

const boardsAddUserSubmit = () => {
    const userId = $("#boardsUserUser").val();
    const role = $("#boardsUserRole").val();

    ajaxPost(baseUrl + "/boards/addUserToBoard", { id: currentBoard, userId: userId, role: role }, result => {
        $("#boardsUserUser").val(-1);
        $("#boardsUserRole").val(1);
        boardsShowUserSection(true);
        boardsRefreshBoardUsers();
    })
}

const boardsRemoveUserSubmit = id => {
    const userId = id;

    ajaxPost(baseUrl + "/boards/removeUserFromBoard", { id: currentBoard, userId: userId }, result => {
        if(result.selfRemove)
        {
            window.location.reload();
        }

        $("#boardsUserUser").val(-1);
        $("#boardsUserRole").val(1);
        boardsShowUserSection(true);
        boardsRefreshBoardUsers();
    })
}

const boardsRefreshBoardUsers = () => {
    $("#boardsUserUser").val(-1);
    $("#boardsUserRole").val(1);

    $("#boardsUserUser").empty();
    $("#boardsUserEdit").empty();

    $("#boardsUserRoleTable").empty();

    $("#boardsNewTaskAssignedTo").empty();
    $("#boardsEditTaskAssignedTo").empty();

    ajaxPost(baseUrl + "/boards/getUsers", { empty: true }, result => {
        result.data.forEach(user => {
            $("#boardsUserUser").append('<option value="' + user.id + '">' + user.email + '</option>');
            $("#boardsUserEdit").append('<option value="' + user.id + '">' + user.email + '</option>');
            $("#boardsEditTaskAssignedTo").append('<option value="' + user.id + '">' + user.email + '</option>');
            $("#boardsNewTaskAssignedTo").append('<option value="' + user.id + '">' + user.email + '</option>');
        });
    });

    ajaxPost(baseUrl + "/boards/getBoardUsers", { id: currentBoard }, result => {
        console.log(result);
        result.data.forEach(user => {
            $("#boardsUserRoleTable").append(
                '<tr>' +
                '<td style="display: none">' + user.id + '</td><td style="display: none">' + user.role + '</td>' +
                '<td>' + user.email + '</td>' +
                '<td>' + formButtonLink('<i class="fas fa-edit"></i>', '*boardsEditUser(this)', 'transparentButtonLink') + '</td>' +
                '<td>' + formButtonLink('<i class="fas fa-trash"></i>', '*boardsRemoveUserSubmit(' + user.id + ')', 'transparentButtonLink') + '</td>' +
                '</tr>'
            );
        })
    })
}

const boardsInitializeColumns = () => {
    $(".taskColumnContainer").sortable({
        connectWith: ".taskColumnContainer",
        placeholder: "taskItemPlaceholder",
        receive: function (event, ui) {
            const idsArrayRaw = $(event.target).sortable('toArray');

            if (idsArrayRaw.length > 0) {
                const taskId = parseInt(ui.item[0].id.replace("task", ""));
                const columnId = parseInt(event.target.id.replace("container", ""));
                console.log(columnId);
                let idsArray = [];

                idsArrayRaw.forEach(element => {
                    idsArray.push(parseInt(element.replace("task", "")));
                });

                boardsMoveTaskTo(columnId, taskId, idsArray);

                console.log(idsArray);
            }
        },
        stop: function (event, ui) {
            const idsArrayRaw = $(event.target).sortable('toArray');

            if (idsArrayRaw.length > 0) {
                const taskId = parseInt(ui.item[0].id.replace("task", ""));
                const columnId = parseInt(event.target.id.replace("container", ""));
                console.log(columnId);
                let idsArray = [];

                idsArrayRaw.forEach(element => {
                    idsArray.push(parseInt(element.replace("task", "")));
                });

                boardsChangeTasksOrder(columnId, idsArray);

                console.log(idsArray);
            }
        },
    });
}

const boardsCreateCommentItem = data => {
    const item = $("<div>", { "class": "taskCommentContainer mt20" });
    item.append(generateAvatarFromEmail(data.email));

    const content = $("<div>", { "class": "taskCommentContent" });
    content.append('<h3 class="taskCommentTitle">' + data.email + '<span class="taskCommentDate">' + data.date + '</span></h3>');
    content.append('<div class="taskCommentContentInner">' + quillGetHTML(data.content) + '</div>');

    item.append(content);

    return item;
}

const boardsEditTaskAddCommentSubmit = () => {
    const content = JSON.stringify(boardsNewCommentEditor.getContents());
    const date = moment().format('YYYY/MM/DD HH:mm');
    const id = $("#boardsEditTaskId").val();

    ajaxPost(baseUrl + "/boards/createComment", { content: content, date: date, id: id }, result => {
        $("#taskCommentList").append(boardsCreateCommentItem(result.data));
        boardsNewCommentEditor.deleteText(0, boardsNewCommentEditor.getLength());
    })
}