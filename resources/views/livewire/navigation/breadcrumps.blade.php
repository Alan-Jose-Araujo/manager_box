<div>
    <nav class="flex text-gray-500 text-sm mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                {{-- Icon adjusted for preview --}}
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-gray-700 hover:text-gray-900">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Início
                </a>
            </li>
            @foreach ($links as $label => $url)
                <li>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                        @if($loop->last)
                            <span class="ml-1 font-medium text-gray-500 md:ml-2" aria-current="page">
                                {{ $label }}
                            </span>
                        @else
                            <a href="{{ url($url) }}" class="ml-1 text-gray-700 hover:text-gray-900 md:ml-2">{{ $label }}</a>
                        @endif
                    </div>
                </li>
            @endforeach
            </li>
        </ol>
    </nav>
</div>
