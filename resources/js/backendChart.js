import Chart from "chart.js/auto";
document.addEventListener("DOMContentLoaded", function () {
    const parseData = (el) => {
        return {
            labels: JSON.parse(el.dataset.labels),
            data: JSON.parse(el.dataset.data),
        };
    };

    // 狀態圖表
    const statusEl = document.getElementById("statusChart");
    if (statusEl) {
        const { labels, data } = parseData(statusEl);

        new Chart(statusEl, {
            type: "pie",
            data: {
                labels: labels,
                datasets: [
                    {
                        data: data,
                        backgroundColor: [
                            "#28a745",
                            "#ffc107",
                            "#dc3545",
                            "#17a2b8",
                            "#d622d6ff",
                        ],
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: "top" },
                    title: { display: true, text: "訂單狀態分佈" },
                },
            },
        });
    }

    // 每日圖表
    const dailyEl = document.getElementById("dailyChart");
    if (dailyEl) {
        const { labels, data } = parseData(dailyEl);

        new Chart(dailyEl, {
            type: "line",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "每日訂單金額",
                        data: data,
                        fill: false,
                        borderColor: "#007bff",
                        tension: 0.3,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    title: { display: true, text: "每日訂單金額趨勢" },
                },
                scales: {
                    y: { beginAtZero: true },
                },
            },
        });
    }
});
