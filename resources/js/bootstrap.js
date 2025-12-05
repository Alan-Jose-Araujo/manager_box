import axios from 'axios';
import { Chart } from 'chart.js/auto';
import ChartDataLabels from 'chartjs-plugin-datalabels';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const CHARTJS_NO_DATA_PLUGIN = {
    id: 'noDataPlugin',
    beforeDraw: (chart, args, options) => {
        if (chart.data.datasets.every(ds => ds.data.length === 0)) {
            const { ctx, chartArea: { top, bottom, left, right }, scales: { x, y } } = chart;
            ctx.save();
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.font = '16px Arial';
            ctx.fillStyle = 'grey';
            ctx.fillText('Dados insuficientes para gerar relatórios.', (left + right) / 2, (top + bottom) / 2);
            ctx.restore();
        }
    }
};

Chart.register(ChartDataLabels);
Chart.register(CHARTJS_NO_DATA_PLUGIN);
window.Chart = Chart;
