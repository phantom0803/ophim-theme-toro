<div id="toroflix_genres_widget-3" class="Wdgt widget_categories">
    <div class="Title">{{$top['label']}}</div>
    <ul>
        @foreach($top['data'] as $movie)
            <li><a href="{{$movie->getUrl()}}">{{$movie->name}}</a> {{$movie->publish_year}}</li>
        @endforeach
    </ul>
</div>
