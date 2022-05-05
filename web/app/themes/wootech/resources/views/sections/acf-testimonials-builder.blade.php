@php
use Packages\Wordpress\Plugins\ACF\elements\BasicString;
use Packages\Wordpress\Plugins\ACF\Functions as AcfFunctions;
use Packages\Wordpress\Theme\DatabaseQueries as ThemeDatabaseQueries;
use Packages\Wordpress\Theme\Functions as ThemeFunctions;

// Get testimonials.
$sectionPosts = ThemeDatabaseQueries::getPostTestimonials(
	$layout['section_configuration']
);
@endphp

@if (ThemeFunctions::hasValidArrayContents($sectionPosts))
	<div class="container pb-8 lg:pb-14">
		<h1 class="mb-9" data-aos="fade-up">{{ BasicString::getPreparedElementWithDefaultValue($layout['section_configuration'], 'section_heading', 'Testimonials') }}</h1>
		<h2 class="text-blue-200 text-[32px] mb-14" data-aos="fade-up" data-aos-delay="100">{{ BasicString::getPreparedElementWithDefaultValue($layout['section_configuration'], 'section_sub_heading', 'Patients') }}</h2>
		<div class="js-carousel flex-carousel slick-arrows-mt-[-45px]" data-slick='{
			"slidesToShow": 2, 
			"slidesToScroll": 2, 
			"arrows": true, 
			"dots": true,
			"infinite": true,
			"responsive": [
				{
					"breakpoint": 575,
					"settings": {
					"slidesToShow": 1,
					"slidesToScroll": 1
					}
				}
				]
			}' data-aos="fade-up">
			@foreach ($sectionPosts as $sectionPost)
				@php
				$sectionPostMeta = AcfFunctions::getPostTypeMeta(
					$sectionPost->post_type,
					$sectionPost->ID
				);
				@endphp
				<div class="js-slide relative flex flex-col bg-white px-6 py-8 sm:px-8 md:p-4 pb-2 lg:pt-16 lg:px-12 lg:pb-1 transition duration-300 hover:shadow-xs mb-5 lg:mb-8">
					<p class="font-light mb-8">“{{ $sectionPostMeta['section_content'] }}”</p>
					<div class="flex items-center mt-auto mb-6">
						<img class="rounded-full flex-shrink-0 mr-4" src="{{ $sectionPostMeta['section_icon']['sizes']['thumbnail'] }}" width="60" height="60" alt="{{ $sectionPost->post_title }}">
						<span class="text-gray-300 font-light text-[13px]">{{ $sectionPostMeta['section_location'] }}</span>
					</div>
					<div class="flex items-center justify-between border-t border-gray-400 py-5 min-h-[80px]">
						@if (BasicString::hasPreparedElement($sectionPostMeta, 'section_video'))
							<a class="text-red-50 text-[13px] font-bold flex flex-shrink-0 items-center hover:text-red-500" href="{{ BasicString::getPreparedElement($sectionPostMeta, 'section_video') }}">
								<svg class="inline-block mr-3" aria-hidden="true" focusable="false" width="55" height="39" viewBox="0 0 55 39" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M21.634 26.375L36.37 18.704L21.634 10.98V26.375Z" fill="#ffffff"/>
									<path opacity="0.12" d="M21.634 10.98L34.555 19.648L36.37 18.704L21.634 10.98Z" fill="#420000"/>
									<path d="M53.985 8.31598C53.985 8.31598 53.451 4.54001 51.817 2.87701C50.3747 1.4115 48.411 0.576348 46.355 0.554016C38.72 0.00201613 27.273 0.00201416 27.273 0.00201416H27.252C27.252 0.00201416 15.805 0.00201613 8.16998 0.554016C6.1139 0.576239 4.15022 1.4114 2.70801 2.87701C1.07401 4.54001 0.539978 8.31598 0.539978 8.31598C0.200695 11.2598 0.0187865 14.2197 -0.00500488 17.183V21.34C0.0187884 24.3033 0.200697 27.2632 0.539978 30.207C0.539978 30.207 1.07401 33.983 2.70801 35.646C4.78501 37.829 7.50797 37.759 8.71997 37.99C13.082 38.408 27.263 38.543 27.263 38.543C27.263 38.543 38.721 38.527 46.356 37.969C48.4123 37.9475 50.3762 37.1123 51.818 35.646C53.452 33.983 53.986 30.207 53.986 30.207C54.3251 27.2631 54.507 24.3033 54.531 21.34V17.183C54.5069 14.2197 54.3246 11.2598 53.985 8.31598ZM21.63 26.377V10.977L36.366 18.701L21.63 26.377Z" fill="url(#yt_linear)"/>
									<defs>
									<linearGradient id="yt_linear" x1="27.263" y1="2.50718" x2="27.263" y2="41.0482" gradientUnits="userSpaceOnUse">
									<stop stop-color="#e52d27"/>
									<stop offset="1" stop-color="#bf171d"/>
									</linearGradient>
									</defs>
								</svg>                                
								PLAY VIDEO
							</a>
						@endif

						<span class="absolute bottom-0 right-0 px-3 py-4 bg-red-50 text-white flex-shrink-0">
							<svg aria-hidden="true" focusable="false" width="26" height="17" viewBox="0 0 26 17" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M6.039 0C4.4249 0 2.8769 0.641202 1.73555 1.78255C0.594205 2.92389 -0.0469971 4.47189 -0.0469971 6.086C-0.0469971 7.70011 0.594205 9.24811 1.73555 10.3895C2.8769 11.5308 4.4249 12.172 6.039 12.172C6.50023 12.1722 6.95994 12.1192 7.409 12.014C5.9813 13.293 4.13182 14.0002 2.215 14C1.94607 14 1.68816 14.1068 1.498 14.297C1.30783 14.4872 1.201 14.7451 1.201 15.014C1.201 15.2829 1.30783 15.5408 1.498 15.731C1.68816 15.9212 1.94607 16.028 2.215 16.028C4.81296 16.0148 7.3019 14.9822 9.14614 13.1524C10.9904 11.3225 12.0425 8.84177 12.076 6.244C12.076 6.192 12.076 6.144 12.076 6.087C12.0811 4.47956 11.4481 2.9358 10.3161 1.79458C9.18403 0.653357 7.64543 0.00793922 6.038 0L6.039 0Z" fill="#fff"/>
								<path d="M19.524 0C17.9099 0 16.3619 0.641202 15.2206 1.78255C14.0792 2.92389 13.438 4.47189 13.438 6.086C13.438 7.70011 14.0792 9.24811 15.2206 10.3895C16.3619 11.5308 17.9099 12.172 19.524 12.172C19.9859 12.172 20.4463 12.1186 20.896 12.013C19.4665 13.2937 17.6143 14.0014 15.695 14C15.4261 14 15.1682 14.1068 14.978 14.297C14.7878 14.4872 14.681 14.7451 14.681 15.014C14.681 15.2829 14.7878 15.5408 14.978 15.731C15.1682 15.9212 15.4261 16.028 15.695 16.028C18.2929 16.0151 20.7819 14.9829 22.6265 13.1535C24.471 11.3241 25.5237 8.84369 25.558 6.246C25.558 6.194 25.558 6.146 25.558 6.089C25.5631 4.48189 24.9306 2.93837 23.7993 1.79692C22.6679 0.655469 21.1301 0.00925877 19.523 0L19.524 0Z" fill="#fff"/>
							</svg>
						</span>
					</div>
				</div>                
			@endforeach
		</div>
	</div>
@endif