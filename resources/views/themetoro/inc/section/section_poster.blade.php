<section>
    <div class="Top">
        <div class="Title">{{$item['label']}}</div>
    </div>
    <ul class="MovieList Rows BX B06 C04 E03 Episodes">
        @foreach($item['data'] as $movie)
            <li class="TPostMv">
                <article class="TPost B">
                    <a href="{{$movie->getUrl()}}">
                        <div class="Image">
                            <figure class="Objf TpMvPlay AAIco-play_arrow">
                                <img class="TPostBg"
                                     src="{{$movie->getPosterUrl()}}"
                                     alt="Background">
                            </figure>
                            <span class="Qlty">{{$movie->episode_current}} {{$movie->language}}</span>
                        </div>
                        <h2 class="Title" data-subtitle="{{$movie->origin_name}}">{{$movie->name}}</h2>
                    </a>
                </article>
            </li>
        @endforeach
    </ul>
</section>
