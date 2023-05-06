<section>
    <div class="Top AAIco-star_border">
        <h1 class="Title">{{$home_page_slider_thumb['label']}}</h1>
    </div>
    <div class="MovieListTop owl-carousel">
        @foreach($home_page_slider_thumb['data'] as $movie)
            <div class="TPostMv">
                <div class="TPost B">
                    <a href="{{$movie->getUrl()}}">
                        <div class="Image">
                            <figure class="Objf TpMvPlay AAIco-play_arrow">
                                <img loading="lazy" class="owl-lazy"
                                     data-src="{{$movie->getThumbUrl()}}"
                                     alt="{{$movie->name}}">
                            </figure>
                            <span class="Qlty">{{$movie->episode_current}}</span>
                        </div>
                        <h2 class="Title">{{$movie->name}}</h2>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</section>
