<div id="content" class="home">
    <div class="row">
        @if (count($menuTopCol1) > 0)
            <div class="col-sm-6">
                @foreach ($menuTopCol1 as $menuSpace)
                    @if (sizeof($menuSpace["item"]) > 0)
                        <div class="title">
                            {{ $menuSpace["info"]["name"] }}
                        </div>
                        <ul class="nav">
                            @foreach ($menuSpace["item"] as $menuItem)
                                <li>
                                    <a href="{{ $menuItem["url"] }}">{{ $menuItem["label"] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                @endforeach
            </div>
        @endif
        @if (count($menuTopCol2) > 0)
            <div class="col-sm-6">
                @foreach ($menuTopCol2 as $menuSpace)
                    @if (sizeof($menuSpace["item"]) > 0)
                        <div class="title">{{ $menuSpace["info"]["name"] }}</div>
                        <ul class="nav">
                            @foreach ($menuSpace["item"] as $menuItem)
                                <li>
                                    <a href="{{ $menuItem["url"] }}">{{ $menuItem["label"] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>