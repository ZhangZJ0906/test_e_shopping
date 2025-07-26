const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
function removeItem(id) {
    fetch(`/cart/delete/${id}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
            Accept: "application/json",
        },
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.status === "success") {
                location.reload();
            }
        });
}

function checkout() {
    const checkboxes = document.querySelectorAll(".cart-checkbox:checked");
    const selectedItems = Array.from(checkboxes).map((cb) => cb.value);

    if (selectedItems.length === 0) {
        alert("請先選擇要結帳的商品");
        return;
    }

    fetch(`/cart/checkout`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            Accept: "application/json",
        },
        body: JSON.stringify({ selected_items: selectedItems }),
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.status === "success") {
                window.location.href = `/orders`;
            } else {
                alert(data.message || "結帳失敗");
            }
        })
        .catch((err) => {
            console.error("錯誤", err);
            alert("發生錯誤，請稍後再試");
        });
}
window.removeItem = removeItem;
window.checkout = checkout;
