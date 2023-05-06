@extends('themes::themetoro.layout')

@php
    $watch_url = '';
    if (!$currentMovie->is_copyright && count($currentMovie->episodes) && $currentMovie->episodes[0]['link'] != '') {
        $watch_url = $currentMovie->episodes
            ->sortBy([['server', 'asc']])
            ->groupBy('server')
            ->first()
            ->sortByDesc('name', SORT_NATURAL)
            ->groupBy('name')
            ->last()
            ->sortByDesc('type')
            ->first()
            ->getUrl();
    }
@endphp

@section('single_top')
    <div class="MovieListSldCn">
        <article class="TPost A">
            <header class="Container">
                <div class="TPMvCn">
                    <h1 class="Title">{{ $currentMovie->name }}</h1>
                    <p class="SubTitle"><span>{{ $currentMovie->origin_name }}</span></p>
                    <div class="Info">
                        <div class="Vote">
                            <div class="post-ratings">
                                <img src="{{asset('themes/toro/img/cnt/rating_on.gif')}}" alt="img"><span
                                    style="font-size: 12px;">{{$currentMovie->getRatingStar()}}</span>
                            </div>
                        </div>
                        <span class="Date">{{ $currentMovie->publish_year }}</span>
                        <span class="Qlty">
                            @switch($currentMovie->status)
                                @case("ongoing")
                                    Đang chiếu
                                    @break
                                @case("completed")
                                    Trọn bộ
                                    @break
                                @default
                                    Trailer
                            @endswitch
                        </span>
                        <span class="Time">{{$currentMovie->episode_time}}</span>
                        <span class="Views AAIco-remove_red_eye">{{$currentMovie->view_total}}</span>
                        {!! $currentMovie->regions->map(function ($region) {
                               return '<span class="Qlty"><a href="'.$region->getUrl().'">'.$region->name.'</a></span>';
                        })->implode(' ') !!}
                    </div>
                    <div class="Description">
                        <p>{!! strip_tags($currentMovie->content) !!}</p>
                        <p class="Director">
                            <span>Đạo diễn:</span>
                            {!! $currentMovie->directors->map(function ($director) {
                                   return '<span class="tt-at"><a href="'.$director->getUrl().'">'.$director->name.'</a></span>';
                            })->implode(',') !!}
                        </p>
                        <p class="Genre"><span>Thể loại:</span>
                            {!! $currentMovie->categories->map(function ($category) {
                                   return '<a href="'.$category->getUrl().'">'.$category->name.'</a>';
                            })->implode(', ') !!}
                        </p>
                        <p class="Cast">
                            <span>Diễn viên:</span>
                            {!! $currentMovie->actors->map(function ($actor) {
                                   return '<a href="'.$actor->getUrl().'">'.$actor->name.'</a>';
                            })->implode('<span class="dot-sh">,</span> ') !!}
                        </p>
                    </div>
                    @if($watch_url)
                        <a href="{{$watch_url}}" class="Button TPlay AAIco-play_circle_outline"><strong>Xem Phim</strong></a>
                    @endif
                    <ul class="ShareList">
                        @if ($currentMovie->trailer_url && strpos($currentMovie->trailer_url, 'youtube'))
                            <li><a href="javascript:void(0)" id="watch-trailer" class="fa-youtube" title="Xem Trailer"></a></li>
                        @endif
                        <li><a href="javascript:void(0)"
                               title="Chia sẻ lên facebook"
                               onclick="window.open ('http://www.facebook.com/sharer.php?u={{$currentMovie->getUrl()}}', 'Facebook', 'toolbar=0, status=0, width=650, height=450');"
                               class="fa-facebook"></a></li>
                        <li><a href="javascript:void(0)"
                               title="Chia sẻ lên twitter"
                               onclick="javascript:window.open('https://twitter.com/intent/tweet?original_referer={{$currentMovie->getUrl()}}&amp;text={{$currentMovie->name}}&amp;tw_p=tweetbutton&amp;url={{$currentMovie->getUrl()}}', 'Twitter', 'toolbar=0, status=0, width=650, height=450');"
                               class="fa-twitter"></a></li>
                    </ul>

                    <div class="rating-content">
                        <div id="movies-rating-star" style="height: 18px;"></div>
                        <div>
                            ({{ $currentMovie->getRatingStar() }}
                            sao
                            /
                            {{$currentMovie->getRatingCount()}} đánh giá)
                        </div>
                        <div id="movies-rating-msg"></div>
                    </div>

                </div>
                <div class="Image">
                    <figure class="Objf">
                        <img loading="lazy" class="TPostBg"
                             src="{{$currentMovie->getPosterUrl()}}" alt="Background">
                    </figure>
                </div>
            </header>
        </article>
    </div>
@endsection

@section('content')

    @if ($currentMovie->showtimes && $currentMovie->showtimes != '')
        <p class="comment-notes">
            <span id="email-notes">Lịch chiếu</span>
            <span class="required-field-message">{!! $currentMovie->showtimes !!}</span>
        </p>
    @endif

    @if ($currentMovie->notify && $currentMovie->notify != '')
        <p class="comment-notes">
            <span id="email-notes">Thông báo</span>
            <span class="required-field-message">{!! $currentMovie->notify !!}</span>
        </p>
    @endif

    @foreach ($currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server') as $server => $data)
        <section class="SeasonBx AACrdn">
            <div class="Top AAIco-playlist_play AALink episodes-view episodes-load">
                <div class="Title"><a href="#">Danh sách tập <span>{{ $server }}</span></a></div>
            </div>
            <ul class="AZList">
                @foreach ($data->sortByDesc('name', SORT_NATURAL)->groupBy('name') as $name => $item)
                    <li><a href="{{ $item->sortByDesc('type')->first()->getUrl() }}" title="{{ $name }}">{{ $name }}</a></li>
                @endforeach
            </ul>
        </section>
    @endforeach
    <section>
        <div class="Top AAIco-chat">
            <div class="Title">Bình luận</div>
        </div>
        <ul class="CommentsList">
            <div style="width: 100%; background-color: #fff">
                <div style="width: 100%; background-color: #fff" class="fb-comments" data-href="{{ $currentMovie->getUrl() }}" data-width="100%"
                     data-colorscheme="light" data-numposts="5" data-order-by="reverse_time" data-lazy="true"></div>
            </div>
        </ul>
    </section>

    <section>
        <div class="Top AAIco-star_border">
            <h3 class="Title">Có thể bạn muốn xem?</h3>
        </div>
        <div class="MovieListTop owl-carousel">
            @foreach($movie_related as $movie)
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
@endsection

@push('scripts')
    @if ($currentMovie->trailer_url && strpos($currentMovie->trailer_url, 'youtube'))
        @php
            parse_str( parse_url( $currentMovie->trailer_url, PHP_URL_QUERY ), $my_array_of_vars );
            $video_id = $my_array_of_vars['v'];
        @endphp
        <script>
            toroflixPublic.trailer = "<iframe width=\"560\" height=\"315\" src=\"https:\/\/www.youtube.com\/embed\/{{$video_id}}\" frameborder=\"0\" allow=\"autoplay\" allow=\"encrypted-media\" allowfullscreen><\/iframe>"
        </script>
        <div class="Modal-Box Ttrailer">
            <div class="Modal-Content">
                <span class="Modal-Close Button AAIco-clear"></span>
            </div>
            <i class="AAOverlay"></i>
        </div>
    @endif

    <script src="/themes/toro/plugins/jquery-raty/jquery.raty.js"></script>
    <link href="/themes/toro/plugins/jquery-raty/jquery.raty.css" rel="stylesheet" type="text/css" />

    <script>
        var rated = false;
        $('#movies-rating-star').raty({
            score: {{ $currentMovie->getRatingStar() }},
            number: 10,
            numberMax: 10,
            hints: ['quá tệ', 'tệ', 'không hay', 'không hay lắm', 'bình thường', 'xem được', 'có vẻ hay', 'hay',
                'rất hay', 'siêu phẩm'
            ],
            starOff: '/themes/toro/plugins/jquery-raty/images/star-off.png',
            starOn: '/themes/toro/plugins/jquery-raty/images/star-on.png',
            starHalf: '/themes/toro/plugins/jquery-raty/images/star-half.png',
            click: function(score, evt) {
                if (rated) return
                fetch("{{ route('movie.rating', ['movie' => $currentMovie->slug]) }}", {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        'X-CSRF-TOKEN': document.querySelector(
                            'meta[name="csrf-token"]')
                            .getAttribute(
                                'content')
                    },
                    body: JSON.stringify({
                        rating: score
                    })
                });
                rated = true;
                $('#movies-rating-star').data('raty').readOnly(true);
                $('#movies-rating-msg').html(`Bạn đã đánh giá ${score} sao cho phim này!`);
            }
        });
    </script>

    {!! setting('site_scripts_facebook_sdk') !!}
@endpush
