import Chart from "chart.js/auto";

document.addEventListener("DOMContentLoaded", function () {
    const dataEl = document.getElementById("chart-data");
    if (!dataEl) return;

    const data = JSON.parse(dataEl.textContent);

    const barCanvas = document.getElementById("activeUsersChart");
    if (barCanvas) {
        const dates = data.dates.map((d) => {
            const parts = d.split("-");
            return parts[2] + "/" + parts[1];
        });

        new Chart(barCanvas, {
            type: "bar",
            data: {
                labels: dates,
                datasets: [
                    {
                        label: "Mahasiswa Aktif",
                        data: data.counts,
                        backgroundColor: "#10b981",
                        borderRadius: 4,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 },
                    },
                },
            },
        });
    }

    const doughnutCanvas = document.getElementById("activityRatioChart");
    if (doughnutCanvas) {
        new Chart(doughnutCanvas, {
            type: "doughnut",
            data: {
                labels: [
                    "Aktif Hari Ini (" + data.activeToday + ")",
                    "Aktif Minggu Ini (" + data.activeWeek + ")",
                    "Aktif Bulan Ini (" + data.activeMonth + ")",
                    "Tidak Aktif (" + data.inactive + ")",
                ],
                datasets: [
                    {
                        data: [
                            data.activeToday,
                            data.activeWeek - data.activeToday,
                            data.activeMonth - data.activeWeek,
                            data.inactive,
                        ],
                        backgroundColor: [
                            "#059669",
                            "#10b981",
                            "#6ee7b7",
                            "#d1d5db",
                        ],
                        borderWidth: 0,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "bottom",
                    },
                },
            },
        });
    }
});
