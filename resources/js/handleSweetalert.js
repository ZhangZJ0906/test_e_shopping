/**
 * SweetAlert Helper - Laravel 專用
 * 張董專屬的 SweetAlert 工具包
 */
class SweetAlertHelper {
    constructor() {
        this.init();
    }

    // 初始化設定
    init() {
        // 設置全域變數
        if (typeof window.Swal !== "undefined") {
            window.Swal = Swal;
        }

        // 建立 Toast 配置
        this.Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
        });

        // 綁定全域函數
        this.bindGlobalFunctions();
    }

    // 綁定全域函數
    bindGlobalFunctions() {
        window.showAlert = this.showAlert.bind(this);
        window.showToast = this.showToast.bind(this);
        window.confirmDelete = this.confirmDelete.bind(this);
        window.showLoading = this.showLoading.bind(this);
        window.hideLoading = this.hideLoading.bind(this);
        window.showInput = this.showInput.bind(this);
        window.showConfirm = this.showConfirm.bind(this);
        
    }

    // 取得 CSRF Token
    getCsrfToken() {
        const token = document.querySelector('meta[name="csrf-token"]');
        return token ? token.getAttribute("content") : "";
    }

    // 顯示警告框
    showAlert(type, title, text = "") {
        return Swal.fire({
            icon: type,
            title: title,
            text: text,
            confirmButtonText: "確定",
            customClass: {
                confirmButton: "btn btn-primary",
            },
        });
    }

    // 顯示 Toast 通知
    showToast(type, message) {
        return this.Toast.fire({
            icon: type,
            title: message,
        });
    }

    // 確認刪除
    confirmDelete(url, title = "確定要刪除嗎？", text = "刪除後將無法復原！") {
        return Swal.fire({
            title: title,
            text: text,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "確定刪除",
            cancelButtonText: "取消",
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                this.submitDeleteForm(url);
            }
            return result;
        });
    }

    // 提交刪除表單
    submitDeleteForm(url) {
        const form = document.createElement("form");
        form.method = "POST";
        form.action = url;
        form.style.display = "none";

        // CSRF Token
        const csrfToken = document.createElement("input");
        csrfToken.type = "hidden";
        csrfToken.name = "_token";
        csrfToken.value = this.getCsrfToken();

        // DELETE Method
        const methodField = document.createElement("input");
        methodField.type = "hidden";
        methodField.name = "_method";
        methodField.value = "DELETE";

        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }

    // 顯示載入中
    showLoading(title = "處理中...") {
        return Swal.fire({
            title: title,
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });
    }

    // 隱藏載入中
    hideLoading() {
        Swal.close();
    }

    // 輸入對話框
    showInput(title, options = {}) {
        const defaultOptions = {
            placeholder: "請輸入內容",
            inputType: "text",
            confirmButtonText: "確定",
            cancelButtonText: "取消",
            showCancelButton: true,
        };

        const config = Object.assign(defaultOptions, options);

        return Swal.fire({
            title: title,
            input: config.inputType,
            inputPlaceholder: config.placeholder,
            showCancelButton: config.showCancelButton,
            confirmButtonText: config.confirmButtonText,
            cancelButtonText: config.cancelButtonText,
            inputValidator: (value) => {
                if (!value && config.required !== false) {
                    return "請輸入內容！";
                }
            },
        });
    }

    // 一般確認對話框
    showConfirm(title, text = "", options = {}) {
        const defaultOptions = {
            icon: "question",
            confirmButtonText: "確定",
            cancelButtonText: "取消",
            showCancelButton: true,
        };

        const config = Object.assign(defaultOptions, options);

        return Swal.fire({
            title: title,
            text: text,
            icon: config.icon,
            showCancelButton: config.showCancelButton,
            confirmButtonText: config.confirmButtonText,
            cancelButtonText: config.cancelButtonText,
            confirmButtonColor: config.confirmButtonColor,
            cancelButtonColor: config.cancelButtonColor,
        });
    }

    // 處理 Laravel Session 訊息
    handleSessionMessages() {
        const messages = window.LaravelSessionMessages || {};

        if (messages.success) {
            this.showToast("success", messages.success);
        }
        if (messages.error) {
            this.showToast("error", messages.error);
        }
        if (messages.warning) {
            this.showToast("warning", messages.warning);
        }
        if (messages.info) {
            this.showToast("info", messages.info);
        }
    }
}

// 初始化
const sweetAlertHelper = new SweetAlertHelper();
window.SweetAlertHelper = sweetAlertHelper;

// 頁面載入完成後處理 Session 訊息
document.addEventListener("DOMContentLoaded", function () {
    if (window.SweetAlertHelper) {
        window.SweetAlertHelper.handleSessionMessages();
    }
});
