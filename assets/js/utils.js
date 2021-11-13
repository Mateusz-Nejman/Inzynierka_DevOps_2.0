const Base64 = {
    _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
    encode: function (e) {
        var t = "";
        var n, r, i, s, o, u, a;
        var f = 0;
        e = Base64._utf8_encode(e);
        while (f < e.length) {
            n = e.charCodeAt(f++);
            r = e.charCodeAt(f++);
            i = e.charCodeAt(f++);
            s = n >> 2;
            o = (n & 3) << 4 | r >> 4;
            u = (r & 15) << 2 | i >> 6;
            a = i & 63;
            if (isNaN(r)) { u = a = 64 } else if (isNaN(i)) { a = 64 }
            t = t + this._keyStr.charAt(s) + this._keyStr.charAt(o) + this._keyStr.charAt(u) + this._keyStr.charAt(a)
        }
        return t
    },
    decode: function (e) {
        var t = "";
        var n, r, i;
        var s, o, u, a;
        var f = 0;
        e = e.replace(/[^A-Za-z0-9\+\/\=]/g, "");
        while (f < e.length) {
            s = this._keyStr.indexOf(e.charAt(f++));
            o = this._keyStr.indexOf(e.charAt(f++));
            u = this._keyStr.indexOf(e.charAt(f++));
            a = this._keyStr.indexOf(e.charAt(f++));
            n = s << 2 | o >> 4;
            r = (o & 15) << 4 | u >> 2;
            i = (u & 3) << 6 | a;
            t = t + String.fromCharCode(n);
            if (u != 64) { t = t + String.fromCharCode(r) }
            if (a != 64) { t = t + String.fromCharCode(i) }
        }
        t = Base64._utf8_decode(t);
        return t
    },
    _utf8_encode: function (e) {
        e = e.replace(/\r\n/g, "\n");
        var t = "";
        for (var n = 0; n < e.length; n++) {
            var r = e.charCodeAt(n);
            if (r < 128) { t += String.fromCharCode(r) } else if (r > 127 && r < 2048) {
                t += String.fromCharCode(r >> 6 | 192);
                t += String.fromCharCode(r & 63 | 128)
            } else {
                t += String.fromCharCode(r >> 12 | 224);
                t += String.fromCharCode(r >> 6 & 63 | 128);
                t += String.fromCharCode(r & 63 | 128)
            }
        }
        return t
    },
    _utf8_decode: function (e) {
        var t = "";
        var n = 0;
        var r = c1 = c2 = 0;
        while (n < e.length) {
            r = e.charCodeAt(n);
            if (r < 128) {
                t += String.fromCharCode(r);
                n++
            } else if (r > 191 && r < 224) {
                c2 = e.charCodeAt(n + 1);
                t += String.fromCharCode((r & 31) << 6 | c2 & 63);
                n += 2
            } else {
                c2 = e.charCodeAt(n + 1);
                c3 = e.charCodeAt(n + 2);
                t += String.fromCharCode((r & 15) << 12 | (c2 & 63) << 6 | c3 & 63);
                n += 3
            }
        }
        return t
    }
}

function urlencode(str) {
    let newStr = '';
    const len = str.length;

    for (let i = 0; i < len; i++) {
        let c = str.charAt(i);
        let code = str.charCodeAt(i);

        // Spaces
        if (c === ' ') {
            newStr += '+';
        }
        // Non-alphanumeric characters except "-", "_", and "."
        else if ((code < 48 && code !== 45 && code !== 46) ||
            (code < 65 && code > 57) ||
            (code > 90 && code < 97 && code !== 95) ||
            (code > 122)) {
            newStr += '%' + code.toString(16);
        }
        // Alphanumeric characters
        else {
            newStr += c;
        }
    }

    return newStr;
}

function isNumeric(number) {
    const validChars = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];

    for (let a = 0; a < number.toString(); a++) {
        if (!validChars.includes(number.toString().charAt(a)))
            return false;
    }

    return true;
}

function parseCost(value) {
    let newValue = 0;

    if (typeof value == 'number') {
        newValue = parseFloat(value.toFixed(2));
    }
    else {
        newValue = parseFloat(parseFloat(value.replace(",", ".")).toFixed(2));
    }

    return isNaN(newValue) ? 0 : newValue;
}

function ajaxPost(url, data, onSuccess) {
    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        success: result => {
            let canExecute = true;
            if (result.state !== undefined && result.message !== undefined) {
                if (result.state == 2) {
                    canExecute = false;
                }
                showNotification(result.state, result.message);
            }

            if (canExecute)
                onSuccess(result);

            $("#fullScreenInfo").hide();
        },
        error: (xhr, status, error) => {
            console.log(xhr);
            console.log(status);
            console.log(error);
            showNotification(2, error);
        }
    })
}

function ajaxPostWithFile(url, data, onSuccess) {
    $.ajax({
        url: url,
        type: 'POST',
        cache: false,
        data: data,
        processData: false,
        contentType: false,
        beforeSend: function () {
            showFullScreenInfo("Wysyłanie zapytania na serwer");
        },
        success: result => {
            let canExecute = true;
            if (result.state !== undefined && result.message !== undefined) {
                if (result.state == 2) {
                    canExecute = false;
                }
                showNotification(result.state, result.message);
            }

            if (canExecute)
                onSuccess(result);

            $("#fullScreenInfo").hide();
        },
        error: (xhr, status, error) => {
            console.log(xhr);
            console.log(status);
            console.log(error);
            $("#fullScreenInfo").hide();
            showNotification(2, error);
        },
        complete: function () {
            $("#fullScreenInfo").hide();
        }
    })
}

function openNewTab(url) {
    const link = document.createElement('a');
    link.href = url;
    link.target = '_blank';
    document.body.appendChild(link);
    link.click();
    link.remove();
}

function openUrl(url) {
    const link = document.createElement('a');
    link.href = url;
    document.body.appendChild(link);
    link.click();
    link.remove();
}

function listBoxContainsNull(id) {
    let containsNull = false;

    const options = $('#' + id + ' option');
    $.map(options, e => {
        if ($(e).val() == -1) {
            containsNull = true;
        }
        return null;
    })

    return containsNull;
}

function validateBase(ids = []) {
    let validated = true;

    ids.forEach(itemBase => {
        const item = Array.isArray(itemBase) ? itemBase[0] : itemBase;
        const valueSelect = Array.isArray(itemBase) ? itemBase[1] : -1;
        const valueInput = Array.isArray(itemBase) ? itemBase[1] : '';
        if ($('#' + item).is('select')) {
            if ($('#' + item).val() == valueSelect) {
                setInvalid(item);
                validated = false;
            } else {
                unsetInvalid(item);
            }
        } else if ($("#" + item).is(':checkbox')) {
            //Nothing
        } else {
            if ($('#' + item).val() == valueInput) {
                setInvalid(item);
                validated = false;
            } else {
                unsetInvalid(item);
            }
        }
    });

    return validated;
}

function loop(delayMs, action) {

    function delayLoop() {
        action();
    }

    setInterval(delayLoop, delayMs);
}

function objectToFormData(data) {
    let formData = new FormData();

    Object.keys(data).forEach(variableName => {
        const variable = data[variableName];

        if (variable instanceof File || typeof variable === 'bigint' || typeof variable === 'boolean' || typeof variable === 'number' || typeof variable === 'string') {
            formData.append(variableName, variable);
        } else if (variable instanceof FileList) {
            for (var i = 0; i < variable.length; i++) {
                console.log(variable[i]);
                formData.append(variableName + i, variable[i]);
            }
            formData.append(variableName + "Count", variable.length);
        } else {
            formData.append(variableName, "[NERP_UPLOAD_OBJECT]" + JSON.stringify(variable));
        }
    });

    return formData;
}

function getPosition(element) {
    var xPos = 0;
    var yPos = 0;

    let el = element.get(0);

    while (el) {
        if (el.tagName == "BODY") {
            var xScroll = el.scrollLeft || document.documentElement.scrollLeft;
            var yScroll = el.scrollTop || document.documentElement.scrollTop;

            xPos += (el.offsetLeft - xScroll + el.clientLeft);
            yPos += (el.offsetTop - yScroll + el.clientTop);
        }
        else {
            xPos += (el.offsetLeft - el.scrollLeft + el.clientLeft);
            yPos += (el.offsetTop - el.scrollTop + el.clientTop);
        }

        el = el.offsetParent;
    }
    return {
        x: xPos,
        y: yPos
    };
}