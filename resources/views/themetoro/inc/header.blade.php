@php
    $logo = setting('site_logo', '');
    $brand = setting('site_brand', '');
    $title = isset($title) ? $title : setting('site_homepage_title', '');
@endphp

<header id="Hd" class="Header">
    <div class="Container">
        <div id="HdTop" class="Top">
            <span class="MenuBtn AATggl CXHd" data-tggl="Tf-Wp"><i></i><i></i><i></i></span>
            <div class="Search">
                <form method="get" action="/">
                    <input type="text" placeholder="Tìm kiếm phim..." name="search" value="{{ request('search') }}">
                    <label for="Tf-Search" class="SearchBtn fa-search AATggl" data-tggl="HdTop">
                        <i class="AAIco-clear"></i>
                    </label>
                </form>
            </div>
            <figure class="Logo">
                <a href="/" title="{{ $title }}" rel="home">
                    @if ($logo)
                        {!! $logo !!}
                    @else
                        {!! $brand !!}
                    @endif
                </a>
            </figure>
            <nav class="Menu">
                <ul>
                    @foreach ($menu as $item)
                        @if (count($item['children']))
                            <li id="menu-item-{{ $item['id'] }}"
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-134">
                                <a href="{{ $item['link'] }}">{{ $item['name'] }}</a>
                                <ul class="sub-menu">
                                    @foreach ($item['children'] as $children)
                                        <li id="menu-item-{{ $children['id'] }}" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-135">
                                            <a href="{{ $children['link'] }}">{{ $children['name'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li id="menu-item-{{ $item['id'] }}"
                                class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-131">
                                <a href="{{ $item['link'] }}" aria-current="page">{{ $item['name'] }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>
</header>
