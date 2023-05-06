<div id="widget_post_toroflix-3" class="Wdgt widget_postlist">
    <div class="Title">{{$top['label']}}</div>
    <ul class="MovieList MovieList Rows AF A04">
        @foreach($top['data'] as $movie)
            <li>
                <div class="TPost B">
                    <a href="{{$movie->getUrl()}}">
                        <div class="Image">
                            <figure class="Objf TpMvPlay AAIco-play_arrow">
                                <img loading="lazy"
                                     src="{{$movie->getThumbUrl()}}"
                                     alt="{{$movie->name}}">
                            </figure>
                            <span class="TpTv BgA">{{$movie->quality}}</span></div>
                        <div class="Title">{{$movie->name}}</div>
                    </a>
                </div>
            </li>
        @endforeach
    </ul>
</div>
