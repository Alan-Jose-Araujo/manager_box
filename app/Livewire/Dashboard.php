<?php

namespace App\Livewire;

use App\Services\DashboardDataService;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class Dashboard extends Component
{
    public function getItemsCountByCategory()
    {
        $result = (new DashboardDataService())->getItemsCountByCategoryData();
        $labels = $result->pluck('category_name')->toArray();
        $values = $result->pluck('items_count')->toArray();
        $colors = $result->pluck('color_code')->toArray();
        return [
            'labels' => $labels,
            'values' => $values,
            'colors' => $colors,
        ];
    }

    public function getAveragePriceByCategory()
    {
        $result = (new DashboardDataService())->getAveragePriceByCategoryData();
        $labels = $result->pluck('category_name')->toArray();
        $values = $result->pluck('average_sale_price')->toArray();
        $colors = $result->pluck('color_code')->toArray();
        return [
            'labels' => $labels,
            'values' => $values,
            'colors' => $colors,
        ];
    }

    public function render()
    {
        $dbProdutos = [
            ['nome' => 'Gabinete Gamer DarkFlash', 'janeiro' => 30, 'fevereiro' => 25, 'marco' => 30, 'abril' => 20],
            ['nome' => 'Placa de Vídeo RTX 4090', 'janeiro' => 20, 'fevereiro' => 18, 'marco' => 24, 'abril' => 15],
            ['nome' => 'Processador Intel Core i3-13100F', 'janeiro' => 5, 'fevereiro' => 10, 'marco' => 12, 'abril' => 10],
            ['nome' => 'Placa Mãe Pichau Danuri B550M-PX', 'janeiro' => 2, 'fevereiro' => 5, 'marco' => 8, 'abril' => 10],
        ];

        $dbItensPorCategoria = [
            'Gabinetes' => 150,
            'Placas de vídeo' => 162,
            'Processadores' => 300,
            'Placas mãe' => 74,
        ];

        $dbPrecoMedio = [
            'Gabinetes' => 4000,
            'Placas de vídeo' => 10000,
            'Processadores' => 6000,
            'Placas mãe' => 5000,
        ];

        $dbMetricas = [
            'rotatividade' => '70 itens esta semana',
            'total_itens' => 527,
            'total_categorias' => 35,
            'valor_estoque' => 'R$597.6K',
            'saidas_mes' => 62,
        ];

        $dbProdutosParados = [
            ['nome' => 'Combo Gamer', 'dias' => 7],
            ['nome' => 'Cadeira Gamer', 'dias' => 5],
            ['nome' => 'TGT Heron TC2', 'dias' => 3],
        ];


        $labelsProdutos = collect($dbProdutos)->pluck('nome')->toArray();
        $meses = ['janeiro', 'fevereiro', 'marco', 'abril'];
        $cores = ['#EC4899', '#F59E0B', '#6366F1', '#34D399'];

        $entradasSaidasData = [
            'labels' => $labelsProdutos,
            'datasets' => array_map(function ($mes, $index) use ($dbProdutos, $cores) {
                return [
                    'label' => ucfirst($mes),
                    'data' => collect($dbProdutos)->pluck($mes)->toArray(),
                    'borderColor' => $cores[$index % count($cores)],
                ];
            }, $meses, array_keys($meses)),
        ];

        $itensCategoriaData = [
            'labels' => array_keys($dbItensPorCategoria),
            'data' => array_values($dbItensPorCategoria),
        ];

        $precoMedioData = [
            'labels' => array_keys($dbPrecoMedio),
            'data' => array_values($dbPrecoMedio),
        ];

        $produtosParadosData = [
            'labels' => collect($dbProdutosParados)->pluck('nome')->toArray(),
            'data' => collect($dbProdutosParados)->pluck('dias')->toArray(),
        ];

        $metricas = array_merge($dbMetricas, [
            'produtos_parados' => $produtosParadosData,
        ]);

        return view('livewire.dashboard', [
            'entradasSaidasData' => $entradasSaidasData,
            'itensCategoriaData' => $itensCategoriaData,
            'precoMedioData' => $precoMedioData,
            'metricas' => $metricas,
        ]);
    }
}
