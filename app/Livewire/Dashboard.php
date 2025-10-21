<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    // Propriedades para dados simples
    public string $rotatividadeEstoque = '70 itens esta semana';
    public int $totalItens = 527;
    public int $totalCategorias = 35;
    public string $valorEstoque = 'R$597.6K';

    // Propriedade obrigatória para o Chart.js no Mary UI
    public array $chartEntradasSaidas = [];
    public array $chartItensCategoria = [];
    public array $chartPrecoMedio = [];

    // Propriedades para dados do dashboard
    public array $produtosSemRotatividade = [
        ['nome' => 'Combo Gamer Pichau Netuno', 'dias' => 7],
        ['nome' => 'Cadeira Gamer TGT Heron TC2', 'dias' => 5],
    ];

    public function mount()
    {
        // 1. Configuração do Gráfico de Linhas (Entradas e Saídas)
        $this->chartEntradasSaidas = [
            'type' => 'line',
            'data' => [
                'labels' => ['Janeiro', 'Fevereiro', 'Março', 'Abril'],
                'datasets' => [
                    ['label' => 'Entradas', 'data' => [28, 20, 29, 25], 'borderColor' => '#8b5cf6', 'tension' => 0.3], // Roxo
                    ['label' => 'Saídas', 'data' => [30, 24, 27, 15], 'borderColor' => '#f87171', 'tension' => 0.3], // Vermelho
                    ['label' => 'Devoluções', 'data' => [5, 9, 4, 11], 'borderColor' => '#06b6d4', 'tension' => 0.3], // Ciano
                ],
            ],
            'options' => [
                'plugins' => ['legend' => ['display' => false]], // Oculta a legenda do topo do gráfico
            ]
        ];

        // 2. Configuração do Gráfico de Pizza (Itens por Categoria)
        $this->chartItensCategoria = [
            'type' => 'pie',
            'data' => [
                'labels' => ['Gabinetes', 'Placas de vídeo', 'Processadores', 'Placas mãe'],
                'datasets' => [
                    ['data' => [150, 182, 300, 74], 'backgroundColor' => ['#8b5cf6', '#f87171', '#06b6d4', '#fb923c']],
                ],
            ],
        ];

        // 3. Configuração do Gráfico de Barras (Preço Médio)
        $this->chartPrecoMedio = [
            'type' => 'bar',
            'data' => [
                'labels' => ['Gabinetes', 'Placas de vídeo', 'Processadores', 'Placas mãe'],
                'datasets' => [
                    ['label' => 'Preço Médio (R$)', 'data' => [4000, 10000, 8000, 6000], 'backgroundColor' => '#8b5cf6'],
                ],
            ],
            'options' => [
                'scales' => [
                    'y' => ['beginAtZero' => true],
                ],
            ],
        ];
    }

    public function render()
    {
        // Certifique-se de que o arquivo Blade está em resources/views/livewire/dashboard.blade.php
        return view('livewire.dashboard');
    }
}
