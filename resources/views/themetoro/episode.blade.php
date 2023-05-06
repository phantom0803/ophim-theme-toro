@extends('themes::themetoro.layout')

@push('header')
    <style>
        .jwplayer {
            position: unset !important;
        }
    </style>
@endpush

@section('single_top')
    <div class="TPost A D">
        <div class="Container">
            <div class="optns-bx">
                <div class="drpdn">
                    <button class="bstd Button">
                        <span>Đổi server khi lỗi<span>2 server</span></span>
                        <i class="fa-chevron-down"></i>
                    </button>
                    <ul class="optnslst trsrcbx">
                        @foreach ($currentMovie->episodes->where('slug', $episode->slug)->where('server', $episode->server) as $server)
                            <li>
                                <a onclick="chooseStreamingServer(this)" data-type="{{ $server->type }}" data-id="{{ $server->id }}" data-link="{{ $server->link }}" class="streaming-server Button sgty">
                                    <span class="nmopt">0{{ $loop->index + 1 }}</span>
                                    <span>Nguồn Phát <span>#0{{ $loop->index + 1 }}</span></span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="VideoPlayer">
                <div id="VideoOption01" class="Video on">

                </div>
                <span class="BtnLight AAIco-lightbulb_outline lgtbx-lnk"></span>
                <span class="lgtbx"></span>
                <div class="navepi tagcloud">
                </div>
            </div>
            <div class="Image">
                <figure class="Objf"><img src="{{$currentMovie->getPosterUrl()}}" alt="{{$currentMovie->name}}"></figure>
            </div>
        </div>
    </div>
    <div class="Main Container">
        @foreach ($currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server') as $server => $data)
            <section class="SeasonBx AACrdn">
                <div class="Top AAIco-playlist_play AALink episodes-view episodes-load">
                    <div class="Title"><a href="#">Danh sách tập <span>{{ $server }}</span></a></div>
                </div>
                <ul class="AZList">
                    @foreach ($data->sortByDesc('name', SORT_NATURAL)->groupBy('name') as $name => $item)
                        <li class="@if ($item->contains($episode)) Current @endif"><a href="{{ $item->sortByDesc('type')->first()->getUrl() }}" title="{{ $name }}">{{ $name }}</a></li>
                    @endforeach
                </ul>
            </section>
        @endforeach
    </div>
@endsection

@section('content')
    <article class="TPost A">
        <header class="Container">
            <div class="TPMvCn">
                <a href="javascript:void(0)"><h1 class="Title">{{$currentMovie->name}}</h1></a>
                <ul class="ShareList">
                    <li><a href="javascript:void(0)"
                           title="Chia sẻ lên facebook"
                           onclick="window.open ('http://www.facebook.com/sharer.php?u={{$currentMovie->getUrl()}}', 'Facebook', 'toolbar=0, status=0, width=650, height=450');"
                           class="fa-facebook"></a></li>
                    <li><a href="javascript:void(0)"
                           title="Chia sẻ lên twitter"
                           onclick="javascript:window.open('https://twitter.com/intent/tweet?original_referer={{$currentMovie->getUrl()}}&amp;text={{$currentMovie->name}}&amp;tw_p=tweetbutton&amp;url={{$currentMovie->getUrl()}}', 'Twitter', 'toolbar=0, status=0, width=650, height=450');"
                           class="fa-twitter"></a></li>
                </ul>
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
                @if ($currentMovie->trailer_url && strpos($currentMovie->trailer_url, 'youtube'))
                    <a href="javascript:void(0)" id="watch-trailer" class="Button TPlay AAIco-play_circle_outline"><strong>Xem Trailer</strong></a>
                @endif

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
        </header>
    </article>

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
    <script src="/themes/toro/player/js/p2p-media-loader-core.min.js"></script>
    <script src="/themes/toro/player/js/p2p-media-loader-hlsjs.min.js"></script>

    <script src="/js/jwplayer-8.9.3.js"></script>
    <script src="/js/hls.min.js"></script>
    <script src="/js/jwplayer.hlsjs.min.js"></script>

    <script>
        var episode_id = {{$episode->id}};
        const wrapper = document.getElementById('VideoOption01');
        const vastAds = "{{ Setting::get('jwplayer_advertising_file') }}";

        function chooseStreamingServer(el) {
            const type = el.dataset.type;
            const link = el.dataset.link.replace(/^http:\/\//i, 'https://');
            const id = el.dataset.id;

            const newUrl =
                location.protocol +
                "//" +
                location.host +
                location.pathname.replace(`-${episode_id}`, `-${id}`);

            history.pushState({
                path: newUrl
            }, "", newUrl);
            episode_id = id;

            Array.from(document.getElementsByClassName('streaming-server')).forEach(server => {
                server.classList.remove('on');
            })
            el.classList.add('on');
            renderPlayer(type, link, id);
        }

        function renderPlayer(type, link, id) {
            if (type == 'embed') {
                if (vastAds) {
                    wrapper.innerHTML = `<div id="fake_jwplayer"></div>`;
                    const fake_player = jwplayer("fake_jwplayer");
                    const objSetupFake = {
                        key: "{{ Setting::get('jwplayer_license') }}",
                        aspectratio: "16:9",
                        width: "100%",
                        file: "/themes/toro/player/1s_blank.mp4",
                        volume: 100,
                        mute: false,
                        autostart: true,
                        advertising: {
                            tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                            client: "vast",
                            vpaidmode: "insecure",
                            skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                            skipmessage: "Bỏ qua sau xx giây",
                            skiptext: "Bỏ qua"
                        }
                    };
                    fake_player.setup(objSetupFake);
                    fake_player.on('complete', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                        allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adSkipped', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                        allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adComplete', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                        allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });
                } else {
                    if (wrapper) {
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                        allowfullscreen="" allow='autoplay'></iframe>`
                    }
                }
                return;
            }

            if (type == 'm3u8' || type == 'mp4') {
                wrapper.innerHTML = `<div id="jwplayer"></div>`;
                const player = jwplayer("jwplayer");
                const objSetup = {
                    key: "{{ Setting::get('jwplayer_license') }}",
                    aspectratio: "16:9",
                    width: "100%",
                    file: link,
                    playbackRateControls: true,
                    playbackRates: [0.25, 0.75, 1, 1.25],
                    sharing: {
                        sites: [
                            "reddit",
                            "facebook",
                            "twitter",
                            "googleplus",
                            "email",
                            "linkedin",
                        ],
                    },
                    volume: 100,
                    mute: false,
                    autostart: true,
                    logo: {
                        file: "{{ Setting::get('jwplayer_logo_file') }}",
                        link: "{{ Setting::get('jwplayer_logo_link') }}",
                        position: "{{ Setting::get('jwplayer_logo_position') }}",
                    },
                    advertising: {
                        tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                        client: "vast",
                        vpaidmode: "insecure",
                        skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                        skipmessage: "Bỏ qua sau xx giây",
                        skiptext: "Bỏ qua"
                    }
                };

                if (type == 'm3u8') {
                    const segments_in_queue = 50;

                    var engine_config = {
                        debug: !1,
                        segments: {
                            forwardSegmentCount: 50,
                        },
                        loader: {
                            cachedSegmentExpiration: 864e5,
                            cachedSegmentsCount: 1e3,
                            requiredSegmentsPriority: segments_in_queue,
                            httpDownloadMaxPriority: 9,
                            httpDownloadProbability: 0.06,
                            httpDownloadProbabilityInterval: 1e3,
                            httpDownloadProbabilitySkipIfNoPeers: !0,
                            p2pDownloadMaxPriority: 50,
                            httpFailedSegmentTimeout: 500,
                            simultaneousP2PDownloads: 20,
                            simultaneousHttpDownloads: 2,
                            // httpDownloadInitialTimeout: 12e4,
                            // httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpDownloadInitialTimeout: 0,
                            httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpUseRanges: !0,
                            maxBufferLength: 300,
                            // useP2P: false,
                        },
                    };
                    if (Hls.isSupported() && p2pml.hlsjs.Engine.isSupported()) {
                        var engine = new p2pml.hlsjs.Engine(engine_config);
                        player.setup(objSetup);
                        jwplayer_hls_provider.attach();
                        p2pml.hlsjs.initJwPlayer(player, {
                            liveSyncDurationCount: segments_in_queue, // To have at least 7 segments in queue
                            maxBufferLength: 300,
                            loader: engine.createLoaderClass(),
                        });
                    } else {
                        player.setup(objSetup);
                    }
                } else {
                    player.setup(objSetup);
                }

                const resumeData = 'OPCMS-PlayerPosition-' + id;

                player.on('ready', function() {
                    if (typeof(Storage) !== 'undefined') {
                        if (localStorage[resumeData] == '' || localStorage[resumeData] == 'undefined') {
                            console.log("No cookie for position found");
                            var currentPosition = 0;
                        } else {
                            if (localStorage[resumeData] == "null") {
                                localStorage[resumeData] = 0;
                            } else {
                                var currentPosition = localStorage[resumeData];
                            }
                            console.log("Position cookie found: " + localStorage[resumeData]);
                        }
                        player.once('play', function() {
                            console.log('Checking position cookie!');
                            console.log(Math.abs(player.getDuration() - currentPosition));
                            if (currentPosition > 180 && Math.abs(player.getDuration() - currentPosition) >
                                5) {
                                player.seek(currentPosition);
                            }
                        });
                        window.onunload = function() {
                            localStorage[resumeData] = player.getPosition();
                        }
                    } else {
                        console.log('Your browser is too old!');
                    }
                });

                player.on('complete', function() {
                    if (typeof(Storage) !== 'undefined') {
                        localStorage.removeItem(resumeData);
                    } else {
                        console.log('Your browser is too old!');
                    }
                })

                function formatSeconds(seconds) {
                    var date = new Date(1970, 0, 1);
                    date.setSeconds(seconds);
                    return date.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
                }
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const episode = '{{$episode->id}}';
            let playing = document.querySelector(`[data-id="${episode}"]`);
            if (playing) {
                playing.click();
                return;
            }

            const servers = document.getElementsByClassName('streaming-server');
            if (servers[0]) {
                servers[0].click();
            }
        });
    </script>

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
