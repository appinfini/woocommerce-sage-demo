@php
// Basics.
use Packages\Wordpress\Plugins\ACF\Functions as AcfFunctions;

// Get ACF fields.
$layoutConfigurations = AcfFunctions::getAllLayouts();
@endphp

@extends('layouts.app')

@section('content')
    @foreach($layoutConfigurations['layouts'] as $key => $layout)
        @include(
            'partials.layouts.layout-' . $layout["acf_fc_layout"],
            [
                'layout' => $layout,
                'meta' => $layoutConfigurations['meta'],
                'order' => $key
            ]
        )
    @endforeach
@endsection