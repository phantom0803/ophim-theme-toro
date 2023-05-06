<div id="widget_post_toroflix-2" class="Wdgt widget_postlist">
    <div class="Title">{{$top['label']}}</div>
    <ul class="MovieList ">
        @foreach($top['data'] as $key => $movie)
            <li>
                <div class="TPost C">
                    <a href="{{$movie->getUrl()}}">
                        <span class="Top">{{$key + 1}}</span>
                        <div class="Image">
                            <figure class="Objf TpMvPlay AAIco-play_arrow">
                                <img loading="lazy"
                                     src="{{$movie->getThumbUrl()}}"
                                     alt="{{$movie->name}}">
                            </figure>
                        </div>
                        <div class="Title">
                            {{$movie->name}}
                        </div>
                    </a>
                    <div class="Info">
                        <div>
                            <span class="TpTv BgA">
                                {{$movie->language}}
                            </span>
                            <span class="TpTv BgA">
                                {{$movie->quality}}
                            </span>
                        </div>
                        <div class="Vote">
                            <div class="post-ratings">
                                <img loading="lazy"
                                     src="{{asset('themes/toro/img/cnt/rating_on.gif')}}"
                                     alt="img"><span style="font-size: 12px;">{{$movie->getRatingStar()}}</span>
                            </div>
                        </div>
                        <span class="Date">{{$movie->publish_year}}</span> <span class="Time">{{$movie->episode_time}}</span> <span
                            class="Views AAIco-remove_red_eye">{{$movie->view_week}}</span></div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
