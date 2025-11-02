import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        // Caminhos otimizados e mais específicos para projetos Laravel/Blade:
        './resources/views/**/*.blade.php',
        './app/View/Components/**/*.php',
        './app/Livewire/**/*.php',

        // Mantendo o caminho genérico (se você tiver outros arquivos no resources)
        './resources/**/*.{html,js,php}',

        // Caminho para vendors (mantido, mas raramente necessário para classes Tailwind)
        // Você pode remover esta linha se não estiver escaneando vendors.
        './vendor/**/*.php',
    ],
    theme: {
        extend: {
            // Mantendo a fonte personalizada 'Instrument Sans'
            fontFamily: {
                sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
        },
    },

    // Módulos e Plugins
    plugins: [
        forms,             // Importado acima
        require('daisyui'),
    ],

    // Configuração DaisyUI
    daisyui: {
        themes: ['light', 'dark'], // Mantendo seus temas
        // outras opções do daisyui, se necessário
    },
}
