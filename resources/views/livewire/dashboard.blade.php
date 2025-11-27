<div>
    <div class="p-4 bg-white h-full">
        <nav class="flex text-gray-500 text-sm mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    {{-- Icon adjusted for preview --}}
                    <a href="#" class="inline-flex items-center text-gray-700 hover:text-gray-900">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                        <a href="#" class="ml-1 text-gray-700 hover:text-gray-900 md:ml-2">Relatórios</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 font-medium text-gray-500 md:ml-2">Visão geral</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- The main grid is the key, with 3 columns. --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="md:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-lg p-6 h-96 border border-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Entradas e saídas</h2>
                        <span
                            class="text-sm font-medium text-green-600 bg-green-50 px-3 py-1 rounded-full">Entradas</span>
                    </div>
                    <div class="h-[calc(100%-2.5rem)] rounded-lg p-2">
                        <canvas id="entradasSaidasChart"></canvas>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl shadow-lg p-6 h-36 border border-gray-900">
                        <h2 class="text-md font-semibold text-gray-800 mb-2">Produtos sem rotatividade</h2>
                        <div class="h-20 p-1">
                            <canvas id="produtosSemRotatividadeChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 h-36 relative border border-gray-900">
                        <h2 class="text-md font-semibold text-gray-800 mb-2">Saídas neste mês</h2>
                        <div class="h-20 flex items-center justify-start relative">
                            <div class="w-1/2 h-full">
                                <canvas id="saidasMesChart"></canvas>
                            </div>
                            <div class="text-xs ml-4 space-y-1">
                                <div class="flex items-center"><span
                                        class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span>Placas de vídeo</div>
                                <div class="flex items-center"><span
                                        class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>Processadores</div>
                                <div class="flex items-center"><span
                                        class="w-2 h-2 rounded-full bg-yellow-500 mr-2"></span>Placas mãe</div>
                            </div>
                            <div
                                class="absolute top-1/2 left-[18%] transform -translate-x-1/2 -translate-y-1/2 font-bold text-2xl text-gray-800">
                                {{ $metricas['saidas_mes'] }}</div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-xl shadow-lg p-6 h-36 flex flex-col justify-center border border-gray-900">
                        <h2 class="text-md font-semibold text-gray-800 mb-2">Rotatividade de estoque</h2>
                        {{-- BACKEND DATA: metrics['turnover'] --}}
                        <p class="text-2xl font-bold text-gray-800">{{ $metricas['rotatividade'] }}</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 h-36 border border-gray-900">
                        <h2 class="text-md font-semibold text-gray-800 mb-2">Indicadores-chave de desempenho</h2>
                        <div class="h-20 flex flex-col justify-center items-start text-sm">
                            {{-- BACKEND DATA: Detailed Metrics --}}
                            <p class="text-gray-600">Total de itens: <span
                                    class="font-bold text-gray-800">{{ $metricas['total_itens'] }}</span></p>
                            <p class="text-gray-600">Total de categorias: <span
                                    class="font-bold text-gray-800">{{ $metricas['total_categorias'] }}</span></p>
                            <p class="text-gray-600">Valor do estoque: <span
                                    class="font-bold text-green-600">{{ $metricas['valor_estoque'] }}</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-lg p-6 h-96 border border-gray-900">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Itens por categoria</h2>
                    <div class="h-[calc(100%-2.5rem)] rounded-lg p-2 flex items-center justify-center">
                        <canvas id="itensCategoriaChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 h-96 border border-gray-900">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Preço médio por categoria</h2>
                    <div class="h-[calc(100%-2.5rem)] rounded-lg p-2">
                        <canvas id="precoMedioChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Backend Data Injection (Using Js::from() to avoid editor parsing errors)) --}}
    <script type="module">
        window.entradasSaidasData = @json($entradasSaidasData);
        window.itensCategoriaData = @json($itensCategoriaData);
        window.precoMedioData = @json($precoMedioData);
        window.metricasData = @json($metricas);

        document.addEventListener("DOMContentLoaded", function () {

            const entradasSaidasData = window.entradasSaidasData;
            const itensCategoriaData = window.itensCategoriaData;
            const precoMedioData = window.precoMedioData;
            const metricasData = window.metricasData;

            const COLORS = ['#8B5CF6', '#EF4444', '#10B981', '#3B82F6', '#F59E0B', '#EC4899'];


            new Chart(document.getElementById('entradasSaidasChart'), {
                type: 'line',
                data: {
                    labels: entradasSaidasData.labels,
                    datasets: entradasSaidasData.datasets.map(dataset => ({
                        ...dataset,
                        tension: 0.3,
                        fill: false,
                        pointRadius: 4,
                    }))
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                            }
                        },
                    },
                    scales: {
                        x: {
                            ticks: { maxRotation: 45, minRotation: 45, autoSkip: false },
                        },
                        y: { beginAtZero: true }
                    }
                }
            });

            new Chart(document.getElementById('itensCategoriaChart'), {
                type: 'doughnut',
                data: {
                    labels: itensCategoriaData.labels,
                    datasets: [{
                        data: itensCategoriaData.data,
                        backgroundColor: [COLORS[0], COLORS[1], COLORS[2], COLORS[3]],
                        hoverOffset: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                generateLabels: (chart) => {
                                    const data = chart.data;
                                    const total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                                    return data.labels.map((label, i) => {
                                        const value = data.datasets[0].data[i];
                                        const percentage = Math.round((value / total) * 100);
                                        return {
                                            text: `${label}\n${value} ${percentage}%`,
                                            fillStyle: data.datasets[0].backgroundColor[i],
                                            strokeStyle: data.datasets[0].backgroundColor[i],
                                            lineWidth: 0,
                                            index: i
                                        };
                                    });
                                }
                            }
                        },
                        datalabels: {
                            display: false
                        }
                    }
                },
            });

            new Chart(document.getElementById('produtosSemRotatividadeChart'), {
                type: 'bar',
                data: {
                    labels: metricasData.produtos_parados.labels,
                    datasets: [{
                        label: 'Dias parados',
                        data: metricasData.produtos_parados.data,
                        backgroundColor: COLORS[5],
                        barThickness: 10,
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' },
                        datalabels: { display: false }
                    },
                    scales: {
                        x: { beginAtZero: true, grid: { display: false } },
                        y: { grid: { display: false } }
                    }
                }
            });

            new Chart(document.getElementById('saidasMesChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Saídas', 'Meta Restante'],
                    // USANDO DADOS DO BACKEND
                    datasets: [{
                        data: [metricasData.saidas_mes, 100 - metricasData.saidas_mes],
                        backgroundColor: [COLORS[3], '#E5E7EB'],
                        borderWidth: 0,
                        circumference: 180,
                        rotation: 270,
                        cutout: '80%',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false },
                        datalabels: { display: false }
                    },
                }
            });


            new Chart(document.getElementById('precoMedioChart'), {
                type: 'bar',
                data: {
                    labels: precoMedioData.labels,
                    datasets: [{
                        label: 'Preço médio (R$)',
                        data: precoMedioData.data,
                        backgroundColor: COLORS[0],
                        borderRadius: 5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        datalabels: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value, index, values) {
                                    return 'R$' + value.toLocaleString('pt-BR');
                                }
                            }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });

        });
    </script>
</div>
