<div class="MovieListSldCn" style="height: 589px;">
    <div class="MovieListSld owl-carousel">
        @foreach($home_page_slider_poster['data'] as $movie)
            <div class="TPostMv">
                <article class="TPost A">
                    <header class="Container">
                        <div class="TPMvCn">
                            <a href="{{$movie->getUrl()}}">
                                <div class="Title">{{$movie->name}}</div>
                            </a>
                            <div class="Info">
                                <div class="Vote">
                                    <div class="post-ratings">
                                        <img src="{{asset('themes/toro/img/cnt/rating_on.gif')}}">
                                        <span class="st-vote">{{$movie->getRatingStar()}}</span>
                                    </div>
                                </div>
                                <span class="Date">{{$movie->publish_year}}</span>
                                <span class="Qlty">
                                    @if($movie->type == 'single')
                                        Phim lẻ
                                    @else
                                        Phim bộ
                                    @endif
                                </span>
                                <span class="Time">{{$movie->episode_time}}</span> <span
                                    class="Views AAIco-remove_red_eye">{{$movie->view_total}}</span>
                            </div>
                            <div class="Description">
                                <p>
                                    {!! mb_substr(strip_tags($movie->content),0,160, "utf-8") !!}...
                                </p>
                                <p class="Director"><span>Đạo diễn:</span>
                                    @if(count($movie->directors))
                                        {!! $movie->directors->map(function ($director) {
                                                   return '<a href="' .
                                                       $director->getUrl() .
                                                       '" tite="Đạo diễn ' .
                                                       $director->name .
                                                       '">' .
                                                       $director->name .
                                                       '</a>';
                                               })->implode(', ') !!}
                                    @endif
                                </p>
                                <p class="Genre"><span>Thể loại:</span>
                                    @if(count($movie->categories))
                                        {!! $movie->categories->map(function ($category) {
                                                   return '<a href="' .
                                                       $category->getUrl() .
                                                       '" tite="Thể loại ' .
                                                       $category->name .
                                                       '">' .
                                                       $category->name .
                                                       '</a>';
                                               })->implode(', ') !!}
                                    @endif
                                </p>
                                <p class="Cast"><span>Diễn viên:</span>
                                    @if(count($movie->actors))
                                        {!! $movie->actors->take(3)->map(function ($actor) {
                                                   return '<a href="' .
                                                       $actor->getUrl() .
                                                       '" tite="Diễn viên ' .
                                                       $actor->name .
                                                       '">' .
                                                       $actor->name .
                                                       '</a>';
                                               })->implode(', ') !!}
                                        ...
                                    @endif
                                </p>
                            </div>
                            <a href="{{$movie->getUrl()}}"
                               class="Button TPlay AAIco-play_circle_outline"><strong>Xem phim</strong></a>
                        </div>
                        <div class="Image">
                            <figure class="Objf">
                                <img loading="lazy" class="TPostBg" src="{{$movie->getPosterUrl()}}" alt="Background">
                            </figure>
                        </div>
                    </header>
                </article>
            </div>
        @endforeach
    </div>
</div>
