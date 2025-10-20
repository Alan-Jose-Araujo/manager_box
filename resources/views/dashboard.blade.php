<x-layouts.app>
    <div class="space-y-6">
        <h1 class="text-2xl font-bold text-gray-800">Visão Geral</h1>

        <!-- Main charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- GLine Chart --}}
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-4">Entradas e Saídas</h2>
                <canvas id="chart-line" class="w-full h-64"></canvas>
            </div>

            {{-- Pie Chart --}}
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-4">Itens por Categoria</h2>
                <canvas id="chart-pie" class="w-full h-64"></canvas>
            </div>
        </div>

        <!-- indicators -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Turnover indicator --}}
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-sm font-medium text-gray-500">Rotatividade de estoque</h3>
                <p class="text-3xl font-bold mt-2">70 itens</p>
            </div>

            {{-- Output indicator --}}
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-sm font-medium text-gray-500">Saídas neste mês</h3>
                <p class="text-3xl font-bold mt-2">62</p>
            </div>

            {{-- Category total indicator --}}
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-sm font-medium text-gray-500">Total de Categorias</h3>
                <p class="text-3xl font-bold mt-2">35</p>
            </div>
        </div>

        <!-- New indicator-->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-sm font-medium text-gray-500">Preço Médio por Categoria</h3>
                <canvas id="chart-price" class="w-full h-64"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctxLine = document.getElementById('chart-line');
            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fev', 'Mar', 'Abr'],
                    datasets: [
                        { label: 'Processadores', data: [10, 20, 30, 25], borderColor: '#3b82f6', fill: false },
                        { label: 'Placas de Vídeo', data: [15, 10, 25, 30], borderColor: '#f43f5e', fill: false },
                        { label: 'Gabinetes', data: [5, 8, 10, 7], borderColor: '#8b5cf6', fill: false },
                        { label: 'Placas Mãe', data: [7, 6, 9, 8], borderColor: '#34d399', fill: false }
                    ]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            const ctxPie = document.getElementById('chart-pie');
            new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: ['Processadores', 'Placas-mãe', 'Gabinetes', 'Placas de vídeo'],
                    datasets: [{
                        data: [43, 11, 22, 24],
                        backgroundColor: ['#60a5fa', '#facc15', '#fb7185', '#34d399'],
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            const ctxPrice = document.getElementById('chart-price');
            new Chart(ctxPrice, {
                type: 'bar',
                data: {
                    labels: ['Gabinetes', 'Placas de vídeo', 'Processadores', 'Placas-mãe'],
                    datasets: [{
                        data: [6000, 8000, 5500, 4500],
                        backgroundColor: '#6D28D9',
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        </script>
    @endpush
</x-layouts.app>
