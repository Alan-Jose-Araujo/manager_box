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
            $monthlyCheckouts = $this->getMonthlyCheckouts();
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
                        <div class="h-full p-1">
                            <canvas id="produtosSemRotatividadeChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 h-36 relative border border-gray-900">
                        @php
                            $monthlyCheckoutsLabels = $monthlyCheckouts->pluck('category_name')->toArray();
                            $monthlyCheckoutsColors = $monthlyCheckouts->pluck('category_color')->toArray();
                            $monthlyCheckoutsValues = $monthlyCheckouts->pluck('total_quantity_moved')->toArray();
                            $monthlyCheckoutsSplittedData = [
                                'labels' => $monthlyCheckoutsLabels,
                                'colors' => $monthlyCheckoutsColors,
                                'values' => $monthlyCheckoutsValues,
                            ];
                            $totalMonthlyCheckoutsValues = array_reduce($monthlyCheckoutsSplittedData['values'], function($carry, $value) {
                                return $carry + $value;
                            }, 0);
                        @endphp
                        <h2 class="text-md font-semibold text-gray-800 mb-2">Saídas neste mês</h2>
                        <div class="h-20 flex items-center justify-start relative">
                            <div class="h-full">
                                <canvas id="saidasMesChart"></canvas>
                            </div>
                            <div class="text-xs ml-[15%] space-y-1">
                               @foreach ($monthlyCheckouts as $monthlyCheckout)
                                    <div class="flex items-center"><span
                                        style="background-color: {{ $monthlyCheckout->category_color }}"
                                        class="w-2 h-2 rounded-full mr-2"></span>{{ $monthlyCheckout->category_name }}</div>
                               @endforeach
                            </div>
                            <div
                                class="absolute top-1/2 left-[22%] transform -translate-x-1/2 -translate-y-1/2 font-bold text-2xl text-gray-800">
                                {{ $totalMonthlyCheckoutsValues }}</div>
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
        window.monthlyCheckoutsData = @json($monthlyCheckoutsSplittedData);
        window.topItemsWithoutTurnover = @json($this->getTopItemsWithoutTurnover());

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
                    labels: topItemsWithoutTurnover.labels,
                    datasets: [{
                        label: 'Dias parados',
                        data: topItemsWithoutTurnover.values,
                        backgroundColor: Array.isArray(topItemsWithoutTurnover.colors) ? topItemsWithoutTurnover.colors : [topItemsWithoutTurnover.colors],
                        maxBarThickness: 14, // Lower thickness for more space
                        minBarLength: 4,
                        borderRadius: 6,
                        barPercentage: 0.35, // More margin between bars
                        categoryPercentage: 0.5 // More margin between groups
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            top: 8,
                            bottom: 8,
                            left: 0,
                            right: 0
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            enabled: true,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) label += ': ';
                                    if (context.parsed.x !== null) label += context.parsed.x + ' dias';
                                    return label;
                                }
                            }
                        },
                        datalabels: { display: false }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: { display: false },
                            title: { display: true, text: 'Dias parados', font: { size: 12 } }
                        },
                        y: {
                            grid: { display: false },
                            ticks: {
                                autoSkip: false,
                                font: { size: 12 },
                                callback: function(value, index, values) {
                                    return topItemsWithoutTurnover.labels && topItemsWithoutTurnover.labels[index] ? topItemsWithoutTurnover.labels[index] : value;
                                }
                            }
                        }
                    }
                }
            });

            new Chart(document.getElementById('saidasMesChart'), {
                type: 'doughnut',
                data: {
                    labels: monthlyCheckoutsData.labels,
                    // USANDO DADOS DO BACKEND
                    datasets: [{
                        data: monthlyCheckoutsData.values,
                        backgroundColor: monthlyCheckoutsData.colors,
                        borderWidth: 0,
                        // circumference: 180,
                        // rotation: 270,
                        // cutout: '80%',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: true },
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
