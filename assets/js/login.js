const loginSubmit = () => {
    console.log("loginSubmit");
    const email = $("#loginEmail").val();
    const password = $("#loginPassword").val();

    ajaxPost(baseUrl + "/login/login", { email: email, password: password }, result => {
        console.log(result);
        openUrl(baseUrl + "/boards");
    });
}

const loginNewSubmit = () => {
    const email = $("#loginNewEmail").val();
    const password = $("#loginNewPassword").val();
    const passwordRepeat = $("#loginNewPasswordRepeat").val();

    if (password != passwordRepeat) {
        showNotification(2, "Passwords don't match");
        return;
    }

    if (!validateEmail(email)) {
        showNotification(2, "Invalid email");
        return;
    }

    ajaxPost(baseUrl + "/login/register", { email: email, password: password }, result => {
        openUrl(baseUrl + "/boards");
    });
}

const validateEmail = email => {
    const res = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return res.test(String(email).toLowerCase());
}