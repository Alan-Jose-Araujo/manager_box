<div>
    <div class="p-4 bg-white h-full">

        @livewire('navigation.breadcrumps', [
            'links' => [
                'Relatórios' => '#',
                'Visão Geral' => '#'
            ]
        ])

        @livewire('navigation.section-head-info', [
            'title' => 'Visão Geral',
            'subtitle' => 'Acompanhe as métricas de seu estoque'
        ])

        @php
            $weeklyTurnover = $this->getWeeklyStockTurnover();
            $kpiReports = $this->getKPIReports();
        @endphp

        {{-- The main grid is the key, with 3 columns. --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="md:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-lg p-6 h-96 border border-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Entradas e saídas este ano</h2>
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
                        <p class="text-2xl font-bold text-gray-800">{{ $weeklyTurnover['checkin'] }} itens deram entrada esta semana</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $weeklyTurnover['checkout'] }} itens sairam esta semana</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 h-36 border border-gray-900">
                        <h2 class="text-md font-semibold text-gray-800 mb-2">Indicadores-chave de desempenho</h2>
                        <div class="h-20 flex flex-col justify-center items-start text-sm">
                            {{-- BACKEND DATA: Detailed Metrics --}}
                            <p class="text-gray-600">Total de itens: <span
                                    class="font-bold text-gray-800">{{ $kpiReports['total_of_items'] }}</span></p>
                            <p class="text-gray-600">Total de categorias: <span
                                    class="font-bold text-gray-800">{{ $kpiReports['total_of_categories'] }}</span></p>
                            <p class="text-gray-600">Valor do estoque: <span
                                    class="font-bold text-green-600">R$ {{ $kpiReports['total_stock_value'] }}</span></p>
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
        window.entradasSaidasData = @json($this->getStockMovementsGroupedByMonth(\App\Enums\StockMovementType::CHECKIN));
        window.itensCategoriaData = @json($this->getItemsCountByCategory());
        window.precoMedioData = @json($this->getAveragePriceByCategory());
        window.metricasData = @json($metricas);

        document.addEventListener("DOMContentLoaded", function () {

            const entradasSaidasData = window.entradasSaidasData;
            const itensCategoriaData = window.itensCategoriaData;
            const precoMedioData = window.precoMedioData;
            const metricasData = window.metricasData;
            const COLORS = ['#8B5CF6', '#EF4444', '#10B981', '#3B82F6', '#F59E0B', '#EC4899'];

            new Chart(document.getElementById('entradasSaidasChart'), {
                type: 'bar',
                data: {
                    labels: entradasSaidasData.labels,
                    datasets: [{
                        label: '',
                        data: entradasSaidasData.values,
                        backgroundColor: [...entradasSaidasData.colors],
                        borderColor: '#000',
                        borderWidth: 1,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                        }
                    },
                    padding: true,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    }
                }
            });

            new Chart(document.getElementById('itensCategoriaChart'), {
                type: 'doughnut',
                data: {
                    labels: itensCategoriaData.labels,
                    datasets: [{
                        data: itensCategoriaData.values,
                        backgroundColor: [...itensCategoriaData.colors],
                        hoverOffset: 8,
                        borderColor: 'black',
                        borderWidth: 1,
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
                        data: precoMedioData.values,
                        backgroundColor: [...precoMedioData.colors],
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
