@php
// Basics.
use Packages\Wordpress\Plugins\ACF\Functions as AcfFunctions;
use Packages\Wordpress\Theme\Functions as ThemeFunctions;

// Get ACF fields.
$layoutConfigurations = AcfFunctions::getAllLayouts();
@endphp

<main class="main {{ is_front_page() ? 'bg-main-home' . (ThemeFunctions::hasSpecifiedBlockInContent() ? '' : 'md:pt-24 lg:pt-48') : '' }}">
    @if (is_cart() || is_checkout())
        <div class="container pb-8 lg:pb-14">
            @while(have_posts()) @php(the_post())
                @include('partials.page-header')
                @includeFirst(['partials.content-page', 'partials.content'])
            @endwhile
        </div>
    @endif

    @foreach($layoutConfigurations['layouts'] as $key => $layout)
        @include(
            'sections.acf-' . $layout["acf_fc_template"],
            [
                'layout' => $layout,
                'meta' => $layoutConfigurations['meta'],
                'order' => $key
            ]
        )
    @endforeach
</main><!-- /.main -->
