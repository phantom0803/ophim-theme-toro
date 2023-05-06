@extends('themes::layout')

@php
    $menu = \Ophim\Core\Models\Menu::getTree();
    $tops = Cache::remember('site.movies.tops', setting('site_cache_ttl', 5 * 60), function () {
        $lists = preg_split('/[\n\r]+/', get_theme_option('hotest'));
        $data = [];
        foreach ($lists as $list) {
            if (trim($list)) {
                $list = explode('|', $list);
                [$label, $relation, $field, $val, $sortKey, $alg, $limit, $template] = array_merge($list, ['Phim hot', '', 'type', 'series', 'view_total', 'desc', 4, 'top_thumb']);
                try {
                    $data[] = [
                        'label' => $label,
                        'template' => $template,
                        'data' => \Ophim\Core\Models\Movie::when($relation, function ($query) use ($relation, $field, $val) {
                            $query->whereHas($relation, function ($rel) use ($field, $val) {
                                $rel->where($field, $val);
                            });
                        })
                            ->when(!$relation, function ($query) use ($field, $val) {
                                $query->where($field, $val);
                            })
                            ->orderBy($sortKey, $alg)
                            ->limit($limit)
                            ->get(),
                    ];
                } catch (\Exception $e) {
                    # code
                }
            }
        }
        return $data;
    });

@endphp

@push('header')
    <link rel='stylesheet' id='global-styles-inline-css' href='{{asset('themes/toro/css/global-styles.css')}}?ver=1.0.0' type='text/css'/>
    <link rel='stylesheet' id='TOROFLIX_Theme-css' href='{{asset('themes/toro/css/toroflix-public.css')}}?ver=1.0.0' type='text/css' media='all'/>
    <link rel='stylesheet' id='tp_style_css' href='{{asset('themes/toro/css/tp_style.css')}}?ver=1.0.0' type='text/css' media='all'/>
@endpush

@section('body')
    <div class="Tf-Wp">
        @include("themes::themetoro.inc.header")
        <div class="Body">
            @if (get_theme_option('ads_header'))
                <div class="Main Container">
                    {!! get_theme_option('ads_header') !!}
                </div>
            @endif
            @yield('home_page_slider_poster')
            @yield('single_top')
            <div class="Main Container">
                @yield('home_page_slider_thumb')
                <div class="TpRwCont ">
                    <main>
                        @yield('content')
                    </main>
                    @include('themes::themetoro.inc.rightbar')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush

@section('footer')
    {!! get_theme_option('footer') !!}
    @if (get_theme_option('ads_catfish'))
        {!! get_theme_option('ads_catfish') !!}
    @endif

    <link rel='stylesheet' id='font-awesome-public_css-css'
          href='{{asset('themes/toro/css/font-awesome.css')}}?ver=1.0.0'
          type='text/css' media='all'/>
    <link rel='stylesheet' id='material-public-css-css'
          href='{{asset('themes/toro/css/material.css')}}?ver=1.0.0'
          type='text/css' media='all'/>
    <link rel='stylesheet' id='font-source-sans-pro-public-css-css'
          href='https://fonts.googleapis.com/css?family=Source+Sans+Pro%3A300%2C400%2C600%2C700&#038;ver=1.0.0'
          type='text/css' media='all'/>
    <script type="text/javascript"
            src='{{asset('themes/toro/js/jquery.js')}}?ver=3.0.0'
            id='funciones_public_jquery-js'></script>
    <script type="text/javascript"
            src='{{asset('themes/toro/js/owl.carousel.min.js')}}?ver=1.0.0'
            id='funciones_public_carousel-js'></script>

    <script type="text/javascript" id='funciones_public_sol-js-extra'>
        var toroflixPublic = {"url":"/","nonce":"7a0fde296e","trailer":"","noItemsAvailable":"No entries found","selectAll":"Select all","selectNone":"Select none","searchplaceholder":"Click here to search","loadingData":"Still loading data...","viewmore":"View more","id":"","type":"","report_text_reportForm":"Report Form","report_text_message":"Message","report_text_send":"SEND","report_text_has_send":"the report has been sent","playerAutomaticSlider":"1"};
    </script>

    <script type="text/javascript"
            src='{{asset('themes/toro/js/sol.js')}}?ver=1.0.0'
            id='funciones_public_sol-js'></script>
    <script type="text/javascript"
            src='{{asset('themes/toro/js/functions.js')}}?ver=1.0.0'
            id='funciones_public_functions-js'></script>

    {!! setting('site_scripts_google_analytics') !!}
@endsection
