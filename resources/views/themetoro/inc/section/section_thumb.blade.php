<section data-id="movies">
    <div class="Top AAIco-movie_filter">
        <h2 class="Title">{{$item['label']}}</h2>
        <a href="{{$item['link']}}" class="Button Sm">Xem thêm</a>
    </div>
    <ul class="MovieList Rows AX A04 B03 C20 D03 E20 Alt">
        @foreach($item['data'] as $movie)
            @include("themes::themetoro.inc.section.section_thumb_item")
        @endforeach
    </ul>
</section>
