// resources/js/forgot-password.js

window.ForgotPassword = (function () {
    function checkEmail() {
        let email = document.getElementById("forgot_email").value.trim();
        document.getElementById("email_error").innerText = "";
        if (!email) {
            document.getElementById("email_error").innerText = "請輸入Email";
            return;
        }
        fetch("/api/forgot-password/check-email", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
            body: JSON.stringify({ email }),
        })
            .then((r) => r.json())
            .then((res) => {
                if (res.status === "success") {
                    document.getElementById("show_email").innerText = res.email;
                    document.getElementById("forgot-step1").style.display =
                        "none";
                    document.getElementById("forgot-step2").style.display = "";
                    document
                        .getElementById("reset_password_btn")
                        .setAttribute("data-email", res.email);
                } else {
                    document.getElementById("email_error").innerText =
                        res.message || "查無此信箱";
                }
            })
            .catch(() => {
                document.getElementById("email_error").innerText = "查無此信箱";
            });
    }

    function resetPassword() {
        let password = document.getElementById("reset_password").value;
        let password_confirm = document.getElementById(
            "reset_password_confirm"
        ).value;
        let email =
            document
                .getElementById("reset_password_btn")
                .getAttribute("data-email") || "";
        document.getElementById("password_error").innerText = "";
        if (!password || !password_confirm) {
            document.getElementById("password_error").innerText =
                "請輸入密碼與確認密碼";
            return;
        }
        if (password.length < 6) {
            document.getElementById("password_error").innerText =
                "密碼長度至少6碼";
            return;
        }
        if (password !== password_confirm) {
            document.getElementById("password_error").innerText =
                "兩次密碼不一致";
            return;
        }
        fetch("/api/forgot-password/reset", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
            body: JSON.stringify({
                email: email,
                password: password,
                password_confirmation: password_confirm,
            }),
        })
            .then((r) => r.json())
            .then((res) => {
                if (res.status === "success") {
                    document.getElementById("forgot-step2").style.display =
                        "none";
                    document.getElementById("reset-success").innerText =
                        res.message;
                    document.getElementById("reset-success").style.display = "";
                    setTimeout(() => {
                        window.location.href = "/login";
                    }, 1800);
                } else {
                    console.log(res);
                    document.getElementById("password_error").innerText =
                        res.message || "重設失敗";
                }
            })
            .catch((res) => {
                    console.log(res);
                document.getElementById("password_error").innerText =
                    "重設失敗";
            });
    }

    function bind() {
        document
            .getElementById("check_email_btn")
            ?.addEventListener("click", checkEmail);
        document
            .getElementById("reset_password_btn")
            ?.addEventListener("click", resetPassword);
    }

    return { checkEmail, resetPassword, bind };
})();
