@php
use Packages\Wordpress\Theme\Functions as ThemeFunctions;
@endphp

@if (ThemeFunctions::hasValidArrayContents($links))
    @foreach ($links as $link)
        <div class="py-2 mb-4">
            <a class="linline-block px-8 py-4 text-[13px] font-bold transition duration-200 text-white hover:text-white focus:text-white bg-blue-100 hover:bg-blue-100 focus:bg-blue-100 hover:shadow-xs focus:shadow-xs focus:outline-none" href="{{ $link['section_link']['url'] }}">{{ $link['section_link']['title'] }}</a>
        </div>
    @endforeach
@endif
