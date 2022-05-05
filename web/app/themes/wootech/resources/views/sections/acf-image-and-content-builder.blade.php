@php
use Packages\Wordpress\Plugins\ACF\elements\BasicString;
use Packages\Wordpress\Theme\Functions as ThemeFunctions;
@endphp
@if (ThemeFunctions::hasValidArrayContents($layout['section_configuration']['section_rows']))
	@foreach ($layout['section_configuration']['section_rows'] as $key => $sectionRow)
		@php
		// Init some variables.
		$isSectionRowOdd = ($key % 2 != 0);
		@endphp
		<div class="relative flex flex-col pt-14 {{ $isSectionRowOdd ? 'pb-14 bg-white' : 'pb-7' }} lg:py-0 lg:flex-col">
			<div class="inset-y-0 top-0 {{ $isSectionRowOdd ? 'right-0 lg:pl-4' : 'left-0 lg:pr-4' }} w-full mb-8 lg:mb-0 lg:w-1/2 lg:absolute" data-aos="fade-up" data-aos-duration="1000">
				<img class="object-cover w-full h-full" src="{{ BasicString::getPreparedElement($sectionRow['section_image'], 'url') }}" width="960" height="400" alt="{{ BasicString::getPreparedElement($sectionRow, 'section_heading') }}">
			</div>
			<div class="container flex flex-wrap justify-{{ $isSectionRowOdd ? 'start' : 'end' }}">
				<div class="lg:w-1/2 {{ $isSectionRowOdd ? 'lg:pr-8' : 'lg:pl-16 lg:pr-3' }} lg:py-12" data-aos="fade-up" data-aos-duration="500">
					<div class="flex flex-wrap items-baseline text-blue-100">
						<h2>{{ BasicString::getPreparedElement($sectionRow, 'section_heading') }}</h2>
						{!! @file_get_contents(BasicString::getPreparedElement($sectionRow['section_icon'], 'url')) !!}
					</div>
					<h3 class="text-blue-200 text-[22px] mb-7">{{ BasicString::getPreparedElement($sectionRow, 'section_sub_heading') }}</h3>
					<p class="text-lg font-light mb-8">{{ BasicString::getPreparedElement($sectionRow, 'section_description') }}</p>

					@if (ThemeFunctions::hasValidArrayContents($sectionRow['section_links']))
						@include('components.link-group', [
							'links' => $sectionRow['section_links']
						])
					@endif
				</div>
			</div>
		</div>
	@endforeach
@endif
