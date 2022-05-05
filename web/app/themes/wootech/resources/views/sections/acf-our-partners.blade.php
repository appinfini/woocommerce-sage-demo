@php
use Packages\Wordpress\Plugins\ACF\elements\BasicString;
use Packages\Wordpress\Theme\Functions as ThemeFunctions;
@endphp
@if (ThemeFunctions::hasValidArrayContents($layout['section_configuration']['section_rows']))
	<div class="container pt-10 pb-6 md:pt-14 md:pb-8">
		<h2 class="text-center text-gray-100" data-aos="fade-up">{{ BasicString::getPreparedElementWithDefaultValue($layout['section_configuration'], 'section_heading', 'Our Partners') }}</h2>
		<div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-5 py-8">
			@foreach ($layout['section_configuration']['section_rows'] as $key => $sectionRow)
				<div class="flex items-center justify-center p-6 grayscale hover:grayscale-0 {{ $key == 0 ? 'lg:justify-start lg:pl-0' : '' }} {{ $key + 1 == count($layout['section_configuration']['section_rows']) ? 'lg:justify-end lg:pr-0' : '' }}" data-aos="fade-up" data-aos-duration="1000">
					<img src="{{ $sectionRow['section_image']['url'] }}" width="210" height="90" alt="swiss visio">
				</div>
			@endforeach
		</div>
	</div>
@endif
