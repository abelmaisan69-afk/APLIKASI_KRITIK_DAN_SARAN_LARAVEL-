import Chart from 'chart.js/auto';

const holder = document.getElementById('dash-data');

if (holder) {
    const d = JSON.parse(holder.dataset.chart);

    // Ambil warna dari branding (variabel CSS "r g b")
    const warna = (nama, alpha = 1) => {
        const [r, g, b] = getComputedStyle(document.documentElement)
            .getPropertyValue(nama).trim().split(/\s+/);
        return `rgba(${r}, ${g}, ${b}, ${alpha})`;
    };

    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.color = '#64748b';

    const grid = { color: '#f1f5f9' };
    const dasar = { responsive: true, maintainAspectRatio: false };

    // Jumlah ulasan
    new Chart(document.getElementById('chart-jumlah'), {
        type: 'bar',
        data: {
            labels: d.labels,
            datasets: [{
                label: 'Ulasan',
                data: d.jumlah,
                backgroundColor: warna('--c-primary'),
                borderRadius: 6,
                maxBarThickness: 36,
            }],
        },
        options: {
            ...dasar,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 }, grid },
                x: { grid: { display: false } },
            },
        },
    });

    // Rata-rata rating
    new Chart(document.getElementById('chart-rata'), {
        type: 'line',
        data: {
            labels: d.labels,
            datasets: [{
                label: 'Rata-rata rating',
                data: d.rata,
                borderColor: warna('--c-accent'),
                backgroundColor: warna('--c-accent', 0.18),
                pointBackgroundColor: warna('--c-accent'),
                pointRadius: 4,
                tension: 0.35,
                fill: true,
                spanGaps: true,
            }],
        },
        options: {
            ...dasar,
            plugins: { legend: { display: false } },
            scales: {
                y: { min: 0, max: 5, ticks: { stepSize: 1 }, grid },
                x: { grid: { display: false } },
            },
        },
    });

    // Distribusi bintang
    new Chart(document.getElementById('chart-dist'), {
        type: 'doughnut',
        data: {
            labels: ['5 ★', '4 ★', '3 ★', '2 ★', '1 ★'],
            datasets: [{
                data: d.dist,
                backgroundColor: [1, 0.8, 0.6, 0.4, 0.2].map(a => warna('--c-primary', a)),
                borderWidth: 2,
                borderColor: '#ffffff',
            }],
        },
        options: {
            ...dasar,
            cutout: '62%',
            plugins: { legend: { position: 'bottom' } },
        },
    });
}