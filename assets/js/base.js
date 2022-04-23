let notificationId = 0;

function openModal(modalName, elementsToClear = [], opened = "") {
  console.log("Open modal " + modalName);
  $("#" + modalName).addClass("opened", 500, "swing", () => {
    elementsToClear.forEach((item) => {
      if (Array.isArray(item)) {
        if ($("#" + item[0]).is(":checkbox")) {
          $("#" + item[0]).prop("checked", item[1]);
        } else {
          $("#" + item[0]).val(item[1]);
        }
      } else {
        if ($("#" + item).is(":checkbox")) {
          $("#" + item).prop("checked", false);
        } else {
          $("#" + item).val("");
        }
      }
    });

    $("#" + modalName).scrollTop(0);
    console.log("Opened function " + opened + " " + modalName);
    if (opened.length > 0) {
      var fn = window[opened];

      console.log(window);
      console.log(typeof fn);
      if (typeof fn === "function") {
        fn();
      }
    }
    $("#" + modalName + " .modalContent").css("display", "block");
    $("#" + modalName + " .modalContent").scrollTop(0);
    $('#' + modalName + ' .modalSmallerContent').css('display', 'block');
    $("#" + modalName + " .modalSmallerContent").scrollTop(0);
    $("body").css("overflow-y", "hidden");
  });
}

function openAndFillModal(modalName, elementsToClear = [], opened = "", id) {
  //console.log("openAndFillModal " + opened + " " + id);
  $("#" + modalName).addClass("opened", 500, "swing", () => {
    elementsToClear.forEach((item) => {
      if (Array.isArray(item)) {
        if ($("#" + item[0]).is(":checkbox")) {
          $("#" + item[0]).prop("checked", item[1]);
        } else {
          $("#" + item[0]).val(item[1]);
        }
      } else {
        if ($("#" + item).is("select")) {
          $("#" + item).val(listBoxContainsNull(item) ? -1 : 0);
        } else if ($("#" + item).is(":checkbox")) {
          $("#" + item).prop("checked", false);
        } else {
          $("#" + item).val("");
        }
      }
    });

    if (opened.length > 0) {
      var fn = window[opened];

      if (typeof fn === "function") {
        fn(id);
      }
    }
    $("#" + modalName + " .modalContent").css("display", "block");
    $("#" + modalName + " .modalContent").css("display", "block");
    $("body").css("overflow-y", "hidden");
  });
}

function closeModal(name) {
  $("#" + name).removeClass("opened");
  $("body").css("overflow-y", "auto");
}

function hasClass(element, classNames) {
  let _hasClass = false;
  classNames.forEach((item) => {
    if ($(element).hasClass(item)) {
      _hasClass = true;
      return;
    }
  });

  return _hasClass;
}

function showNotification(state = 0, text = "") {
  let stateClass = "";
  let icon = "check";
  let title = "Sukces";

  if (state == 1) {
    stateClass = "niWarning";
    icon = "exclamation-triangle";
    title = "Ostrzeżenie";
  } else if (state == 2) {
    stateClass = "niError";
    icon = "exclamation-circle";
    title = "Błąd";
  }

  const template =
    '<div class="notification" id="notification' +
    notificationId +
    '"><i class="fas fa-' +
    icon +
    " notificationIcon " +
    stateClass +
    '"></i><div class="notificationText">' +
    text +
    "</div></div>";
  $("#notificationContainer").append(template);

  const notification = $("#notification" + notificationId);
  notification.delay(5000).hide(0, "linear", () => {
    notification.remove();
  });

  notificationId++;
}

function setInvalid(id) {
  $("#" + id).addClass("formBoxInvalid");
}

function unsetInvalid(id) {
  $("#" + id).removeClass("formBoxInvalid");
}

function ajaxPost(url, data, onSuccess) {
  $.ajax({
    url: url,
    type: "POST",
    data: data,
    success: (result) => {
      console.log(result);
      let canExecute = true;
      if (result.state !== undefined && result.message !== undefined) {
        if (result.state == 2) {
          canExecute = false;
        }
        showNotification(result.state, result.message);
      }

      if (canExecute) {
        onSuccess(result);
      }

      $("#fullScreenInfo").hide();
    },
    error: (xhr, status, error) => {
      console.log(xhr);
      console.log(status);
      console.log(error);
      showNotification(2, error);
    },
  });
}

function generateAvatarFromEmail(email) {
  const isUnassigned = email == "nieprzypisany@nieprzypisany.com";
  let avatarLetters = "";
  const emailPart = email.split("@")[0];
  const emailFormatted = emailPart
    .replaceAll(".", "[SEP]")
    .replaceAll("_", "[SEP]");
  const emailItems = emailFormatted.split("[SEP]");

  if (emailItems.length == 1) {
    avatarLetters = emailItems[0].charAt(0).toUpperCase();
  } else {
    avatarLetters =
      emailItems[0].charAt(0).toUpperCase() +
      emailItems[1].charAt(0).toUpperCase();
  }

  return (
    '<div class="taskItemAvatar ' +
    (isUnassigned ? "unassigned" : "") +
    '">' +
    avatarLetters +
    "</div>"
  );
}

function createEditor(id) {
  return new Quill("#" + id, {
    modules: {
      syntax: true,
      toolbar: [
        [{ size: [] }],
        ["bold", "italic", "underline", "strike"],
        [{ color: [] }, { background: [] }],
        [{ script: "super" }, { script: "sub" }],
        [{ header: "1" }, { header: "2" }, "blockquote", "code-block"],
        [
          { list: "ordered" },
          { list: "bullet" },
          { indent: "-1" },
          { indent: "+1" },
        ],
        [{ direction: "rtl" }, { align: [] }],
        ["link", "image", "formula"],
        ["clean"],
      ],
    },
    theme: "snow",
  });
}

function quillGetHTML(inputDelta) {
  console.log(inputDelta);
  var tempQuill = new Quill(document.createElement("div"));
  tempQuill.setContents(JSON.parse(inputDelta));

  console.log(tempQuill.root.innerHTML);
  return tempQuill.root.innerHTML;
}
