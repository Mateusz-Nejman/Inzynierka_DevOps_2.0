$(document).ready(() => {
  $(".inputFile").change((handler) => {
    $(handler.target)
      .parent()
      .children()
      .eq(1)
      .val($(handler.target).prop("files")[0].name);
  });

  const passwordInputs = document.querySelectorAll("input[type=password]");

  passwordInputs.forEach((passwordInput) => {
    const id = passwordInput.id;

    console.log(id);
    const eyeElement = document.getElementById(id+"eye");

    if(eyeElement == null)
    {
        return;
    }

    document.getElementById(id + "eye").addEventListener("click", (e) => {
      const type =
        passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);
      // toggle the eye slash icon
      passwordInput.classList.toggle("fa-eye-slash");
    });
  });
});

function addToFLBV(id, name = "", value = "") {
  const selectedValue = $("#flbvs" + id).val();
  let selectedText = $("#flbvs" + id + " option:selected").text();

  if (name.length > 0) selectedText = name;

  const newValue =
    '<div class="row" style="padding: 10px"><div class="col40"><input type="text" class="formTextBox" placeholder="Nazwa" value="' +
    selectedText +
    '"/></div><div class="col40"><input type="text" class="formTextBox" placeholder="Wartość" value="' +
    value +
    '"/></div><div class="col20"><button type="button"  class="baseButton margin0 height100" onclick="removeFromFLBV(this)"><i class="fas fa-times"></i></button></div></div>';
  //console.log(selectedValue + " => " + selectedText);
  $("#flbvc" + id).prepend(newValue);
}

function removeFromFLBV(handler) {
  $(handler).parent().parent().remove();
}

function clearFLBV(id) {
  console.log("clearFLBV " + id);
  $("#flbvc" + id).empty();
}

function refreshFLBV(id, values) {
  $("#flbvs" + id).empty();
  $("#flbvs" + id).append('<option value="-1">Nowy atrybut</option>');

  items.forEach((item, index) => {
    $("#flbvs" + id).append(
      '<option value="' + index + '">' + item + "</option>"
    );
  });

  Object.keys(values).forEach((itemName, index) => {
    addToFLBV(id, itemName, values[itemName]);
  });
}

function getDataFromFLBV(id) {
  const children = $("#flbvc" + id).children();

  let data = [];

  for (let a = 0; a < children.length; a++) {
    console.log(children.eq(a));
    const id = children
      .eq(a)
      .children()
      .eq(0)
      .children()
      .eq(0)
      .children()
      .eq(1)
      .attr("id")
      .replace("attribute", "");
    const value = children
      .eq(a)
      .children()
      .eq(0)
      .children()
      .eq(0)
      .children()
      .eq(1)
      .val();
    console.log(id, value);

    data.push({ id: id, value: value });
  }
  return data;
}

function getTreeViewChecked(id) {
  let returnData = [];
  $("#" + id + " input[type=checkbox]").each((index, item) => {
    if ($(item).prop("checked")) {
      returnData.push(parseInt($(item).attr("id").split("_")[1]));
    }
  });

  return returnData;
}

function clearTreeViewChecked(id) {
  $("#" + id + " input[type=checkbox]").each((index, item) => {
    $(item).prop("checked", false);
  });
}

function setTreeViewChecked(id, checked = []) {
  checked.forEach((value) => {
    $("#" + id + "_" + value).prop("checked", true);
  });
}

function openLogin() {
  $("#registerBox").hide();
  $("#loginBox").show();
}

function openRegister() {
  $("#loginBox").hide();
  $("#registerBox").show();
}

function addToListBox(id, value, text) {
  $("#" + id).append('<option value="' + value + '">' + text + "</option>");
}

function disableDataTableAutocomplete() {}

function formTextBox(
  title,
  name,
  id,
  value = "",
  onChanging = "",
  type = "text",
  disabled = false
) {
  const onChangingText =
    onChanging == "" ? "" : 'oninput = "' + onChanging + '"';
  const disabledText = disabled ? "disabled" : "";

  return (
    '<input type="' +
    type +
    '" class="formTextBox" id="' +
    id +
    '" name="' +
    name +
    '" placeholder="' +
    title +
    '" value="' +
    value +
    '" ' +
    onChangingText +
    " " +
    disabledText +
    "/>"
  );
}

function formTextBoxTitled(
  title,
  name,
  id,
  value = "",
  onChanging = "",
  type = "text",
  disabled = false
) {
  return (
    '<div class="formTextBoxTitled" id="' +
    id +
    'div"><span>' +
    title +
    "</span>" +
    formTextBox(title, name, id, value, onChanging, type, disabled) +
    "</div>"
  );
}

function formDatePicker(title, name, id, value = "") {
  return formTextBox(title, name, id, value);
}

function formDatePickerTitled(title, name, id, value = "") {
  return formTextBoxTitled(title, name, id, value);
}

function formListBox(
  title,
  name,
  id,
  value = -1,
  items = [],
  canBeNull = false,
  onChanged = "",
  disabled = false
) {
  const onChangedText = onChanged == "" ? "" : 'onchange="' + onChanged + '"';
  const disabledText = disabled ? "disabled" : "";
  let control =
    '<label class="formListBox"><select name="' +
    name +
    '" id="' +
    id +
    '" ' +
    onChangedText +
    " " +
    disabledText +
    ">";
  if (canBeNull) {
    control +=
      '<option value="-1" ' +
      (value == -1 ? "selected" : "") +
      ">" +
      title +
      "</option>";
  }

  items.forEach((item, index) => {
    control +=
      '<option value="' +
      index +
      '" ' +
      (index == value ? "selected" : "") +
      ">" +
      item +
      "</option>";
  });

  control +=
    '</select><svg viewbox="0 0 10 6"><polyline points="1 1 5 5 9 1"></polyline></svg></label>';

  return control;
}

function formListBoxTitled(
  title,
  name,
  id,
  value = -1,
  items = [],
  canBeNull = false,
  onChanged = "",
  disabled = false
) {
  return (
    '<div class="formTextBoxTitled" id="' +
    id +
    'div"><span>' +
    title +
    "</span>" +
    formListBox(title, name, id, value, items, canBeNull, onChanged, disabled) +
    "</div>"
  );
}

function formDropdownButton(icon, id, menuItems = [], additionalContent = "") {
  let control = '<div class="dropdown">';
  control +=
    '<button type="button" class="topbarButtonSmaller dropdownButton" onclick="openDropdown(\'' +
    id +
    '\')"><i class="' +
    icon +
    '"></i></button>';
  control += '<div id="' + id + '" class="dropdownContent">';
  control += additionalContent;

  menuItems.forEach((menuItem) => {
    control += formButtonLink(
      menuItem.title,
      menuItem.link,
      "baseButtonLink width100"
    );
  });

  control += "</div></div>";

  return control;
}

function formButtonLink(title, link, className = "") {
  const isButton = link.startsWith("*");
  const linkSource = isButton
    ? 'onclick="' + link.substring(1) + '"'
    : 'href="' + link + '"';

  if (isButton) {
    return (
      '<button type="button" class="' +
      className +
      '" ' +
      linkSource +
      ">" +
      title +
      "</button>"
    );
  } else {
    return '<a class="' + className + '" ' + linkSource + ">" + title + "</a>";
  }
}

function formCheckBox(title, name, id, value, onChanged = "") {
  const checkedText = value ? "checked" : "";
  const onChangedText = onChanged == "" ? "" : 'onclick="' + onChanged + '"';

  let control = '<div class="formTextBoxTitled"><span>' + title + "</span>";
  control +=
    '<div class="formCheckboxFrame"><input class="formCheckbox" type="checkbox" name="' +
    name +
    '" id="' +
    id +
    '" ' +
    checkedText +
    " " +
    onChangedText +
    '><label for="' +
    id +
    '"></label></div>';
  control += "</div>";

  return control;
}

function formListBoxValuable(
  title,
  name,
  id,
  items,
  defaultText = "",
  jsMethod = "addToFLBV"
) {
  let container = '<div class="formGroup">';

  let listBox =
    '<select class="formListBox" name="' + name + '" id="flbvs' + id + '">';
  listBox += '<option value="-1" selected>' + defaultText + "</option>";

  items.forEach((item, index) => {
    listBox += '<option value="' + index + '">' + item + "</option>";
  });

  listBox += "</select>";

  const firstLayer =
    '<div class="row"><div class="col75">' +
    listBox +
    '</div><div class="col25">' +
    formButtonLink(
      '<i class="fas fa-plus"></i>',
      "*" + jsMethod + "('" + id + "')",
      "baseButtonM0 height100"
    ) +
    "</div></div>";
  const secondLayer = '<div id="flbvc' + id + '"></div>';

  container += firstLayer;
  container += secondLayer;
  container += "</div>";

  return container;
}

function formTreeListBox(title, name, id, value, items = []) {
  let control =
    '<select class="formListBox" name="' + name + '" id="' + id + '">';
  control +=
    '<option value="-1" ' +
    (value == -1 ? "selected" : "") +
    ">" +
    title +
    "</option>";
  control += getTreeOption(items, 0);
  control += "</select>";

  return control;
}

function getTreeOption(items, startTab = 0) {
  let control = "";

  items.forEach((value, index) => {
    control +=
      '<option value="' +
      index +
      '">' +
      value.name.padStart(value.name.length + startTab, ";") +
      "</option>";

    if (typeof value.children !== "undefined" && value.children.length > 0) {
      control += getTreeOption(value.children, startTab + 10);
    }
  });

  return control;
}

function formCheckTreeView(title, name, id, items = []) {
  const control = getTreeNode(id, items);

  return '<div id="' + id + '">' + control + "</div>";
}

function getTreeNode(id, items = []) {
  if (items.count == 0) {
    return "";
  }

  let control = '<ul class="formTreeViewUL">';

  items.forEach((item, index) => {
    let li =
      '<li class="formTreeViewLi"><input type="checkbox" id="' +
      id +
      "_" +
      index +
      '"><label for="' +
      id +
      "_" +
      index +
      '">' +
      item.name +
      "</label>";

    if (typeof item.children !== "undefined" && item.children.length > 0) {
      li += getTreeNode(id, item.children);
    }

    li += "</li>";

    control += li;
  });

  control += "</ul>";

  return control;
}

function formBegin() {
  return '<form autocomplete="off">';
}

function formEnd() {
  return "</form>";
}
