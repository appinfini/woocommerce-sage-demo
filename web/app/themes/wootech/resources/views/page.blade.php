@php
// Basics.
use Packages\Wordpress\Plugins\ACF\Functions as AcfFunctions;

// Get ACF fields.
$layoutConfigurations = AcfFunctions::getAllLayouts();
@endphp

@extends('layouts.app')
<main class="main {{ is_front_page() ? 'bg-main-home md:pt-24 lg:pt-48' : '' }}">
    @section('content')
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
    @endsection
</main><!-- /.main -->
