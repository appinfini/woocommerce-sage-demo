{{--
  Template Name: Home Page
--}}

@extends('layouts.app')

@section('content')
    @while(have_posts()) @php(the_post())
        @include('partials.content-page')
    @endwhile
    @include('sections.acf-section-parser')
@endsection