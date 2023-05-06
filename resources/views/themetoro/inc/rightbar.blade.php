<aside>
    @foreach($tops as $top)
        @include("themes::themetoro.inc.rightbar." . $top['template'])
    @endforeach
</aside>
