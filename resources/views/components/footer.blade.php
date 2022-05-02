@php unset($data->menu[2]); @endphp
<div class="container">
    <div class="row">
        <div class="col-6 col-md-3 col-footer">
            <div class="border-menu-footer"></div>
            <div class="row">
                <h1>@lang('messages.onlinebible')</h1>
                <ul class="list-group list-group-flush">
                @foreach($data->menu as $menu)
                    <li class="list-group-item menu-list-footer">
                    @if ($menu == 'bibles')
                        <a class="nav-link cursor-pointer menu-link-footer" data-bs-toggle="modal" data-bs-target="#modal_bibles">@lang('messages.' . $menu)</a>
                    @elseif ($menu == 'home')
                        <a class="nav-link menu-link-footer" href="{{ url('') }}">@lang('messages.' . $menu)</a>
                    @else
                        <a class="nav-link menu-link-footer" href="{{ url(__('messages.href_' . $menu)) }}">@lang('messages.' . $menu)</a>
                    @endif
                    </li>
                @endforeach
                </ul>
            </div> 
            <div class="row">
                
            </div>  
        </div>
        <div class="col-sm-6 col-md-9">
            <div class="row">
                <div class="col col-footer">
                    <div class="border-menu-footer"></div>
                    <h1>@lang('messages.oldtestament')</h1>
                    <ul class="list-group list-group-flush unsigned-list-menu">
                    @for ($countb = 0; $countb < 20; $countb++)
                    @php
                        $book = $data->books_data[config('data.language_default')][$countb];
                        $url = url($data->version . "/$book->abbreviation_url")
                    @endphp
                        <li class="list-group-item menu-list-footer">
                            <a class="nav-link menu-link-footer" href="{{ $url }}">
                                {{ $book->book }}
                            </a>
                        </li>
                    @endfor
                    </ul>
                    <ul class="list-group list-group-flush unsigned-list-menu">
                        @for ($countb = 20; $countb < 39; $countb++)
                        @php
                            $book = $data->books_data[config('data.language_default')][$countb];
                            $url = url($data->version . "/$book->abbreviation_url")
                        @endphp
                            <li class="list-group-item menu-list-footer">
                                <a class="nav-link menu-link-footer" href="{{ $url }}">
                                    {{ $book->book }}
                                </a>
                            </li>
                        @endfor
                    </ul>
                </div>
                <div class="col col-footer">
                    <div class="border-menu-footer"></div>
                    <h1>@lang('messages.newtestament')</h1>
                    <ul class="list-group list-group-flush unsigned-list-menu">
                        @for ($countb = 39; $countb < 52; $countb++)
                        @php
                            $book = $data->books_data[config('data.language_default')][$countb];
                            $url = url($data->version . "/$book->abbreviation_url")
                        @endphp
                            <li class="list-group-item menu-list-footer">
                                <a class="nav-link menu-link-footer" href="{{ $url }}">
                                    {{ $book->book }}
                                </a>
                            </li>
                        @endfor
                    </ul>
                    <ul class="list-group list-group-flush unsigned-list-menu">
                        @for ($countb = 52; $countb <= 65; $countb++)
                        @php
                            $book = $data->books_data[config('data.language_default')][$countb];
                            $url = url($data->version . "/$book->abbreviation_url")
                        @endphp
                            <li class="list-group-item menu-list-footer">
                                <a class="nav-link menu-link-footer" href="{{ $url }}">
                                    {{ $book->book }}
                                </a>
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>