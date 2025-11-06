<div class="w-full md:w-1/3 lg:w-1/4 bg-[#F8F2EC] flex flex-col justify-center items-center p-8 md:p-10">
    <div class="text-center mt-20 md:mt-0">
        <div class="mb-4 flex justify-center">
            <img src="{{ asset('images/manager_box_logo.svg') }}" alt="Logo" class="w-24 h-24 md:w-28 md:h-28">
        </div>
        <h1 class="text-2xl font-semibold text-gray-800">{{ $title }}</h1>
        <p class="text-gray-600 mt-2">{{ $subtitle }}</p>
    </div>

    <div class="mt-10 md:mt-auto text-center">
        <p class="text-gray-700"> {{ $infoText }}</p>
        <a href="{{ $buttonLink }}" class="text-green-700 font-semibold hover:underline">
            {{ $buttonText }}
        </a>
    </div>
</div>
