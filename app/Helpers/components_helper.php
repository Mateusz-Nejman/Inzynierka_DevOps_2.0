<?php
//Dashboard module

if (!function_exists('getCountries')) {
    function getCountries()
    {
        $country = [];
        $country["616"] = "Polska";
        $country["4"] = "Afghanistan";
        $country["248"] = "Åland Islands";
        $country["8"] = "Albania";
        $country["12"] = "Algeria";
        $country["16"] = "American Samoa";
        $country["20"] = "Andorra";
        $country["24"] = "Angola";
        $country["660"] = "Anguilla";
        $country["10"] = "Antarctica";
        $country["28"] = "Antigua and Barbuda";
        $country["32"] = "Argentina";
        $country["51"] = "Armenia";
        $country["533"] = "Aruba";
        $country["36"] = "Australia";
        $country["40"] = "Austria";
        $country["31"] = "Azerbaijan";
        $country["44"] = "Bahamas";
        $country["48"] = "Bahrain";
        $country["50"] = "Bangladesh";
        $country["52"] = "Barbados";
        $country["112"] = "Belarus";
        $country["56"] = "Belgium";
        $country["84"] = "Belize";
        $country["204"] = "Benin";
        $country["60"] = "Bermuda";
        $country["64"] = "Bhutan";
        $country["68"] = "Bolivia, Plurinational State of";
        $country["535"] = "Bonaire, Sint Eustatius and Saba";
        $country["70"] = "Bosnia and Herzegovina";
        $country["72"] = "Botswana";
        $country["74"] = "Bouvet Island";
        $country["76"] = "Brazil";
        $country["86"] = "British Indian Ocean Territory";
        $country["96"] = "Brunei Darussalam";
        $country["100"] = "Bulgaria";
        $country["854"] = "Burkina Faso";
        $country["108"] = "Burundi";
        $country["116"] = "Cambodia";
        $country["120"] = "Cameroon";
        $country["124"] = "Canada";
        $country["132"] = "Cape Verde";
        $country["136"] = "Cayman Islands";
        $country["140"] = "Central African Republic";
        $country["148"] = "Chad";
        $country["152"] = "Chile";
        $country["156"] = "China";
        $country["162"] = "Christmas Island";
        $country["166"] = "Cocos (Keeling) Islands";
        $country["170"] = "Colombia";
        $country["174"] = "Comoros";
        $country["178"] = "Congo";
        $country["180"] = "Congo, the Democratic Republic of the";
        $country["184"] = "Cook Islands";
        $country["188"] = "Costa Rica";
        $country["384"] = "Côte d'Ivoire";
        $country["191"] = "Croatia";
        $country["192"] = "Cuba";
        $country["531"] = "Curaçao";
        $country["196"] = "Cyprus";
        $country["203"] = "Czech Republic";
        $country["208"] = "Denmark";
        $country["262"] = "Djibouti";
        $country["212"] = "Dominica";
        $country["214"] = "Dominican Republic";
        $country["218"] = "Ecuador";
        $country["818"] = "Egypt";
        $country["222"] = "El Salvador";
        $country["226"] = "Equatorial Guinea";
        $country["232"] = "Eritrea";
        $country["233"] = "Estonia";
        $country["231"] = "Ethiopia";
        $country["238"] = "Falkland Islands (Malvinas)";
        $country["234"] = "Faroe Islands";
        $country["242"] = "Fiji";
        $country["246"] = "Finland";
        $country["250"] = "France";
        $country["254"] = "French Guiana";
        $country["258"] = "French Polynesia";
        $country["260"] = "French Southern Territories";
        $country["266"] = "Gabon";
        $country["270"] = "Gambia";
        $country["268"] = "Georgia";
        $country["276"] = "Germany";
        $country["288"] = "Ghana";
        $country["292"] = "Gibraltar";
        $country["300"] = "Greece";
        $country["304"] = "Greenland";
        $country["308"] = "Grenada";
        $country["312"] = "Guadeloupe";
        $country["316"] = "Guam";
        $country["320"] = "Guatemala";
        $country["831"] = "Guernsey";
        $country["324"] = "Guinea";
        $country["624"] = "Guinea-Bissau";
        $country["328"] = "Guyana";
        $country["332"] = "Haiti";
        $country["334"] = "Heard Island and McDonald Islands";
        $country["336"] = "Holy See (Vatican City State)";
        $country["340"] = "Honduras";
        $country["344"] = "Hong Kong";
        $country["348"] = "Hungary";
        $country["352"] = "Iceland";
        $country["356"] = "India";
        $country["360"] = "Indonesia";
        $country["364"] = "Iran, Islamic Republic of";
        $country["368"] = "Iraq";
        $country["372"] = "Ireland";
        $country["833"] = "Isle of Man";
        $country["376"] = "Israel";
        $country["380"] = "Italy";
        $country["388"] = "Jamaica";
        $country["392"] = "Japan";
        $country["832"] = "Jersey";
        $country["400"] = "Jordan";
        $country["398"] = "Kazakhstan";
        $country["404"] = "Kenya";
        $country["296"] = "Kiribati";
        $country["408"] = "Korea, Democratic People's Republic of";
        $country["410"] = "Korea, Republic of";
        $country["414"] = "Kuwait";
        $country["417"] = "Kyrgyzstan";
        $country["418"] = "Lao People's Democratic Republic";
        $country["428"] = "Latvia";
        $country["422"] = "Lebanon";
        $country["426"] = "Lesotho";
        $country["430"] = "Liberia";
        $country["434"] = "Libya";
        $country["438"] = "Liechtenstein";
        $country["440"] = "Lithuania";
        $country["442"] = "Luxembourg";
        $country["446"] = "Macao";
        $country["807"] = "Macedonia, the former Yugoslav Republic of";
        $country["450"] = "Madagascar";
        $country["454"] = "Malawi";
        $country["458"] = "Malaysia";
        $country["462"] = "Maldives";
        $country["466"] = "Mali";
        $country["470"] = "Malta";
        $country["584"] = "Marshall Islands";
        $country["474"] = "Martinique";
        $country["478"] = "Mauritania";
        $country["480"] = "Mauritius";
        $country["175"] = "Mayotte";
        $country["484"] = "Mexico";
        $country["583"] = "Micronesia, Federated States of";
        $country["498"] = "Moldova, Republic of";
        $country["492"] = "Monaco";
        $country["496"] = "Mongolia";
        $country["499"] = "Montenegro";
        $country["500"] = "Montserrat";
        $country["504"] = "Morocco";
        $country["508"] = "Mozambique";
        $country["104"] = "Myanmar";
        $country["516"] = "Namibia";
        $country["520"] = "Nauru";
        $country["524"] = "Nepal";
        $country["528"] = "Netherlands";
        $country["540"] = "New Caledonia";
        $country["554"] = "New Zealand";
        $country["558"] = "Nicaragua";
        $country["562"] = "Niger";
        $country["566"] = "Nigeria";
        $country["570"] = "Niue";
        $country["574"] = "Norfolk Island";
        $country["580"] = "Northern Mariana Islands";
        $country["578"] = "Norway";
        $country["512"] = "Oman";
        $country["586"] = "Pakistan";
        $country["585"] = "Palau";
        $country["275"] = "Palestinian Territory, Occupied";
        $country["591"] = "Panama";
        $country["598"] = "Papua New Guinea";
        $country["600"] = "Paraguay";
        $country["604"] = "Peru";
        $country["608"] = "Philippines";
        $country["612"] = "Pitcairn";
        $country["620"] = "Portugal";
        $country["630"] = "Puerto Rico";
        $country["634"] = "Qatar";
        $country["638"] = "Réunion";
        $country["642"] = "Romania";
        $country["643"] = "Russian Federation";
        $country["646"] = "Rwanda";
        $country["652"] = "Saint Barthélemy";
        $country["654"] = "Saint Helena, Ascension and Tristan da Cunha";
        $country["659"] = "Saint Kitts and Nevis";
        $country["662"] = "Saint Lucia";
        $country["663"] = "Saint Martin (French part)";
        $country["666"] = "Saint Pierre and Miquelon";
        $country["670"] = "Saint Vincent and the Grenadines";
        $country["882"] = "Samoa";
        $country["674"] = "San Marino";
        $country["678"] = "Sao Tome and Principe";
        $country["682"] = "Saudi Arabia";
        $country["686"] = "Senegal";
        $country["688"] = "Serbia";
        $country["690"] = "Seychelles";
        $country["694"] = "Sierra Leone";
        $country["702"] = "Singapore";
        $country["534"] = "Sint Maarten (Dutch part)";
        $country["703"] = "Slovakia";
        $country["705"] = "Slovenia";
        $country["90"] = "Solomon Islands";
        $country["706"] = "Somalia";
        $country["710"] = "South Africa";
        $country["239"] = "South Georgia and the South Sandwich Islands";
        $country["728"] = "South Sudan";
        $country["724"] = "Spain";
        $country["144"] = "Sri Lanka";
        $country["729"] = "Sudan";
        $country["740"] = "Suriname";
        $country["744"] = "Svalbard and Jan Mayen";
        $country["748"] = "Swaziland";
        $country["752"] = "Sweden";
        $country["756"] = "Switzerland";
        $country["760"] = "Syrian Arab Republic";
        $country["158"] = "Taiwan, Province of China";
        $country["762"] = "Tajikistan";
        $country["834"] = "Tanzania, United Republic of";
        $country["764"] = "Thailand";
        $country["626"] = "Timor-Leste";
        $country["768"] = "Togo";
        $country["772"] = "Tokelau";
        $country["776"] = "Tonga";
        $country["780"] = "Trinidad and Tobago";
        $country["788"] = "Tunisia";
        $country["792"] = "Turkey";
        $country["795"] = "Turkmenistan";
        $country["796"] = "Turks and Caicos Islands";
        $country["798"] = "Tuvalu";
        $country["800"] = "Uganda";
        $country["804"] = "Ukraine";
        $country["784"] = "United Arab Emirates";
        $country["826"] = "United Kingdom";
        $country["840"] = "United States";
        $country["581"] = "United States Minor Outlying Islands";
        $country["858"] = "Uruguay";
        $country["860"] = "Uzbekistan";
        $country["548"] = "Vanuatu";
        $country["862"] = "Venezuela, Bolivarian Republic of";
        $country["704"] = "Viet Nam";
        $country["92"] = "Virgin Islands, British";
        $country["850"] = "Virgin Islands, U.S.";
        $country["876"] = "Wallis and Futuna";
        $country["732"] = "Western Sahara";
        $country["887"] = "Yemen";
        $country["894"] = "Zambia";
        $country["716"] = "Zimbabwe";
        return $country;
    }
}

if (!function_exists('formPasswordBox')) {
    function formPasswordBox($title, $name, $id, $value = "", bool $disabled = false)
    {
        $control = '<input type="password" class="formTextBox" name="' . $name . '" autocomplete="current-password" required="" id="' . $id . '" placeholder="' . $title . '" value="' . $value . '">';
        $control .= '<i class="far fa-eye" id="' . $id . 'eye" style="margin-left: -30px; cursor: pointer;"></i>';

        return $control;
    }
}

if (!function_exists('formPasswordBoxTitled')) {
    function formPasswordBoxTitled($title, $name, $id, $value = "", bool $disabled = false)
    {
        return '<div class="formTextBoxTitled" id="' . $id . 'div"><span>' . $title . '</span>' . formPasswordBox($title, $name, $id, $value, $disabled) . '</div>';
    }
}
if (!function_exists('formTextBox')) {
    function formTextBox($title, $name, $id, $value = "", $onChanging = "", $type = "text", bool $disabled = false, $onEnter = "")
    {
        $onChangingText = $onChanging == "" ? "" : 'oninput = "' . $onChanging . '"';
        $disabledText = $disabled ? "disabled" : "";
        return '<input type="' . $type . '" class="formTextBox" id="' . $id . '" name="' . $name . '" placeholder="' . $title . '" value="' . $value . '" onkeypress="componentsOnEnter(event,\'' . $onEnter . '\')" ' . $onChangingText . " " . $disabledText . '/>';
    }
}

if (!function_exists('formTextBoxTitled')) {
    function formTextBoxTitled($title, $name, $id, $value = "", $onChanging = "", $type = "text", bool $disabled = false, $onEnter = "")
    {
        return '<div class="formTextBoxTitled" id="' . $id . 'div"><span>' . $title . '</span>' . formTextBox($title, $name, $id, $value, $onChanging, $type, $disabled, $onEnter) . '</div>';
    }
}

if (!function_exists('formDatePicker')) {
    function formDatePicker($title, $name, $id, $value = "")
    {
        return '<input type="text" class="formTextBox" id="' . $id . '" name="' . $name . '" placeholder="' . $title . '" value="' . $value . '"/>';
    }
}

if (!function_exists('formDatePickerTitled')) {
    function formDatePickerTitled($title, $name, $id, $value = "")
    {
        return '<div class="formTextBoxTitled" id="' . $id . 'div"><span>' . $title . '</span>' . formDatePicker($title, $name, $id, $value) . '</div>';
    }
}

if (!function_exists('formCountriesBox')) {
    function formCountriesBox($title, $name, $id, $value = 616)
    {
        return formListBox($title, $name, $id, $value, getCountries());
    }
}

if (!function_exists('formCountriesBoxTitled')) {
    function formCountriesBoxTitled($title, $name, $id, $value = -1)
    {
        return '<div class="formTextBoxTitled"><span>' . $title . '</span>' . formCountriesBox($title, $name, $id, $value) . '</div>';
    }
}

if (!function_exists('formListBox')) {
    function formListBox($title, $name, $id, $value = -1, $items = [], $canBeNull = false, $onChanged = "", bool $disabled = false)
    { //items -> ["value" => "title"]
        $onChanged = $onChanged == "" ? "" : "onchange='{$onChanged}'";
        $disabledText = $disabled ? "disabled" : "";
        $control = '<label class="formListBox"><select name="' . $name . '" id="' . $id . '" ' . $onChanged . ' ' . $disabledText . '>';
        if ($canBeNull)
            $control .= '<option value="-1" ' . ($value == -1 ? "selected" : "") . '>' . $title . '</option>';

        foreach ($items as $index => $item) {
            $control .= '<option value="' . $index . '" ' . ($index == $value ? "selected" : "") . '>' . $item . '</option>';
        }

        $control .= '</select><svg viewbox="0 0 10 6"><polyline points="1 1 5 5 9 1"></polyline></svg></label>';

        return $control;
    }
}

if (!function_exists('formListBoxTitled')) {
    function formListBoxTitled($title, $name, $id, $value = -1, $items = [], $canBeNull = false, $onChanged = "", bool $disabled = false)
    {
        return '<div class="formTextBoxTitled" id="' . $id . 'div"><span>' . $title . '</span>' . formListBox($title, $name, $id, $value, $items, $canBeNull, $onChanged, $disabled) . '</div>';
    }
}

if (!function_exists('formDropdownButton')) {
    function formDropdownButton($icon, $id, $menuItems = [], $additionalContent = "", bool $middle = false, $smallerIcon = false, $bottom = false, $notIcon = false)
    { //[["title" => "", "link" => ""]]
        $control = '<div class="dropdown">';
        $control .= '<button type="button" class="' . ($smallerIcon ? 'transparent baseLink' : 'topbarButtonSmaller dropdownButton') . '" onclick="openDropdown(\'' . $id . '\')">' . ($notIcon ? $icon : '<i class="' . $icon . '"></i>') . '</button>';
        $control .= '<div id="' . $id . '" class="dropdownContent' . ($middle ? "Middle" : ($bottom ? "Bottom" : "")) . '">';
        $control .= $additionalContent;

        foreach ($menuItems as $menuItem) {
            $control .= formButtonLink($menuItem["title"], $menuItem["link"], "baseButtonLink width100" . (isset($menuItem["newTab"]) && $menuItem["newTab"] ? '" target="_blank"' : ''));
        }

        $control .= '</div></div>';

        return $control;
    }
}

if (!function_exists('formButtonLink')) {
    function formButtonLink($text, $link, $className = "", $title = "")
    {
        $isButton = substr($link, 0, 1) == "*";
        $linkSource = $isButton ? 'onclick="' . substr($link, 1) . '"' : 'href="' . $link . '"';

        if ($isButton)
            return '<button type="button" class="' . $className . '" ' . $linkSource . ' title="' . $title . '">' . $text . '</button>';
        else
            return '<a class="' . $className . '" ' . $linkSource . ' title="' . $title . '">' . $text . '</a>';
    }
}


if (!function_exists('formCheckBox')) {
    function formCheckBox(string $title, string $name, string $id, bool $value, string $onChanged = "", bool $titled = true): string
    {
        $checkedText = $value ? "checked" : "";
        $onChangedText = $onChanged == "" ? "" : 'onclick="' . $onChanged . '"';

        $control = "";

        if ($titled) {
            $control = '<div class="formTextBoxTitled"><span>' . $title . '</span>';

            $control .= '<div class="formCheckboxFrame"><input class="formCheckbox" type="checkbox" name="' . $name . '" id="' . $id . '" ' . $checkedText . ' ' . $onChangedText . '><label for="' . $id . '"></label></div>';
            $control .= '</div>';
        } else {
            $control = '<div class="formCheckboxFrame"><input class="formCheckbox" type="checkbox" name="' . $name . '" id="' . $id . '" ' . $checkedText . ' ' . $onChangedText . '><label for="' . $id . '"></label></div>';
        }

        return $control;
    }
}

if (!function_exists('formRadioBox')) {
    function formRadioBox(string $title, string $name, string $id, $value, string $onChanged = ""): string
    {
        $onChangedText = $onChanged == "" ? "" : 'onclick="' . $onChanged . '"';

        $control = '<div class="formCheckboxFrame"><input class="formCheckbox" type="radio" name="' . $name . '" id="' . $id . '" ' . $onChangedText . ' value="' . $value . '"><label for="' . $id . '"></label></div>';

        return $control;
    }
}

if (!function_exists('formListBoxValuable')) {
    function formListBoxValuable(string $title, string $name, string $id, array $items, string $defaultText = "", string $jsMethod = "addToFLBV"): string //array should be contains only attribute id as index and name as value
    {
        $container = '<div class="formGroup">';

        $listBox = '<label class="formListBox"><select class="formListBox" name="' . $name . '" id="flbvs' . $id . '">';

        $listBox .= '<option value="-1" selected>' . $defaultText . '</option>';

        foreach ($items as $index => $item) {
            $listBox .= '<option value="' . $index . '">' . $item . '</option>';
        }

        $listBox .= '</select><svg viewbox="0 0 10 6"><polyline points="1 1 5 5 9 1"></polyline></svg></label>';

        $firstLayer = '<div class="row"><div class="col75">' . $listBox . '</div><div class="col25">' . formButtonLink('<i class="fas fa-plus"></i>', "*" . $jsMethod . "('" . $id . "')", "baseButton margin0 height100") . '</div></div>';
        $secondLayer = '<div id="flbvc' . $id . '"></div>';

        $container .= $firstLayer;
        $container .= $secondLayer;
        $container .= '</div>';
        return $container;
    }
}

if (!function_exists('formTreeListBox')) {
    function formTreeListBox($title, $name, $id, $value, $items = []) //id => name;children
    {
        $control = '<select class="formListBox" name="' . $name . '" id="' . $id . '">';
        $control .= '<option value="-1" ' . ($value == -1 ? "selected" : "") . '>' . $title . '</option>';

        $control .= getTreeOption($items, 0);

        $control .= '</select>';

        return $control;
    }

    function getTreeOption($items, $startTab = 0)
    {
        $control = "";

        foreach ($items as $index => $value) {
            $control .= '<option value="' . $index . '">' . str_pad($value->name, strlen($value->name) + $startTab, html_entity_decode("&nbsp;"), STR_PAD_LEFT) . '</option>';

            if (isset($value->children) && count($value->children) > 0) {
                $control .= getTreeOption($value->children, $startTab + 10);
            }
        }

        return $control;
    }
}

if (!function_exists('formCheckTreeView')) {
    function formCheckTreeView($title, $name, $id, $items = [])
    {
        $control = getTreeNode($id, $items);

        return '<div id="' . $id . '">' . $control . '</div>';
    }

    function getTreeNode($id, $items = [])
    {
        if (count($items) == 0)
            return "";

        $control = '<ul class="formTreeViewUl">';

        foreach ($items as $index => $item) {
            $li = '<li class="formTreeViewLi"><input type="checkbox" id="' . $id . '_' . $item->id . '"><label for="' . $id . '_' . $item->id . '">' . $item->name . '</label>';

            if (isset($item->children) && count($item->children) > 0) {
                $li .= getTreeNode($id, $item->children);
            }

            $li .= "</li>";

            $control .= $li;
        }

        $control .= "</ul>";

        return $control;
    }
}

if (!function_exists('formLoginBox')) {
    function formLoginBox(bool $canRegister = true)
    {
        $control = '<div class="formLoginBorder" id="loginBox"><div class="formGroup">';

        $control .= '<h6>Zaloguj się</h6>';
        $control .= formTextBoxTitled("Email", "email", "loginEmail", "", "", "email");
        $control .= formTextBoxTitled("Hasło", "password", "loginPassword", "", "", "password");
        $control .= formButtonLink("Zaloguj", "*login()", "baseButton");
        if ($canRegister) {
            $control .= formButtonLink("Nie masz konta? Utwórz je!", "*openRegister()", "transparent baseLink");
        }

        $control .= '</div></div>';

        if ($canRegister) {
            $control .= '<div class="formLoginBorder" id="registerBox" style="display: none"><div class="formGroup">';

            $control .= '<h6>Zarejestruj się</h6>';
            $control .= formTextBoxTitled("Email", "email", "registerEmail", "", "", "email");
            $control .= formTextBoxTitled("Hasło", "password", "registerPassword", "", "", "password");
            $control .= formTextBoxTitled("Powtórz hasło", "passwordRepeat", "registerPasswordRepeat", "", "", "password");
            $control .= formButtonLink("Zarejestruj", "*register()", "baseButton");
            $control .= formButtonLink("Masz już konto? Zaloguj się!", "*openLogin()", "transparent baseLink");

            $control .= '</div></div>';
        }
        return $control;
    }
}

if (!function_exists('formBegin')) {
    function formBegin()
    {
        return '<form autocomplete="off">';
    }
}

if (!function_exists('formEnd')) {
    function formEnd()
    {
        return '</form>';
    }
}

if (!function_exists('formFilePicker')) {
    function formFilePicker($title, $name, $id, $buttonText = "Wybierz", $multiple = false, $accept = "")
    {
        $content = '<div class="formTextBoxTitled">';
        $content .= '<span>' . $title . '</span>';
        $content .= '<div class="rowStatic">';
        $content .= '<label for="' . $id . '" class="baseButton">' . $buttonText . '</label>';
        $content .= '<input type="text" class="formTextBox" id="' . $id . 'Text" disabled value="Nie wybrano pliku"/>';
        $content .= '<input type="file" style="display: none" id="' . $id . '" class="inputFile" ' . ($multiple ? "multiple" : "") . ($accept != "" ? ' accept="' . $accept . '"' : '') . '/>';
        $content .= '</div></div>';

        return $content;
    }
}
