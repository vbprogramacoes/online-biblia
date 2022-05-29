<div class="container">
        <h1 class="h1" style="display:none">{{ $data->h1 }}</h1>
        <div class="row">
            <div class="col">
                <h2>@lang('messages.oldtestament')</h2>
                <ul class="list-group list-group-flush menu-books">
                @for ($countb = 0; $countb < 20; $countb++)
                @php
                
                    $book = $data->footer->books_data[config('data.language_default')][$countb];
                    $url = url($data->version . "/$book->abbreviation_url");
                @endphp
                    <li class="list-group-item menu-books-list">
                        <a class="nav-link menu-books-list-link" href="{{ $url }}">
                            {{ $book->book }}
                        </a>
                    </li>
                @endfor
                </ul>
                <ul class="list-group list-group-flush menu-books">
                @for ($countb = 20; $countb < 39; $countb++)
                @php
                    $book = $data->books_data[config('data.language_default')][$countb];
                    $url = url($data->version . "/$book->abbreviation_url");
                @endphp
                    <li class="list-group-item menu-books-list">
                        <a class="nav-link menu-books-list-link" href="{{ $url }}">
                            {{ $book->book }}
                        </a>
                    </li>
                @endfor
                </ul>
            </div>
            <div class="col">
                <h2>@lang('messages.newtestament')</h2>
                <ul class="list-group list-group-flush menu-books">
                @for ($countb = 39; $countb < 52; $countb++)
                @php
                    $book = $data->books_data[config('data.language_default')][$countb];
                    $url = url($data->version . "/$book->abbreviation_url");
                @endphp
                    <li class="list-group-item menu-books-list">
                        <a class="nav-link menu-books-list-link" href="{{ $url }}">
                            {{ $book->book }}
                        </a>
                    </li>
                @endfor
                </ul>
                <ul class="list-group list-group-flush menu-books">
                @for ($countb = 52; $countb < 65; $countb++)
                @php
                    $book = $data->books_data[config('data.language_default')][$countb];
                    $url = url($data->version . "/$book->abbreviation_url");
                @endphp
                    <li class="list-group-item menu-books-list">
                        <a class="nav-link menu-books-list-link" href="{{ $url }}">
                            {{ $book->book }}
                        </a>
                    </li>
                @endfor
                </ul>
            </div>
        </div>
    </div>