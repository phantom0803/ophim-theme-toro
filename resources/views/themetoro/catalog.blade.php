@extends('themes::themetoro.layout')
@section('content')
    <section>
        <div class="Top AAIco-movie_filter"><h2 class="Title">{{$section_name}}</h2></div>
        @if(!count($data))
            <p class="comment-notes">
                <span id="email-notes">Thông báo!</span>
                <span class="required-field-message">Không có nội dung cho mục này. </span>
            </p>
        @endif
        <ul class="MovieList Rows AX A04 B03 C20 D03 E20 Alt">
            @foreach($data as $movie)
                @include("themes::themetoro.inc.section.section_thumb_item")
            @endforeach
        </ul>
        {{ $data->appends(request()->all())->links('themes::themetoro.inc.pagination') }}
    </section>
@endsection
