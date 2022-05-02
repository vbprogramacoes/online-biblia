<div class="container">
        <h1 class="h1">@lang('messages.bibles') <small class="text-muted">@lang('messages.descriptionhome', ['amount' => ($data->countallversions - 1)])</small></h1>
        <div class="row">
            <div class="col">
                <ul class="list-group list-group-flush">
                    @for ($cv = 0; $cv < 5; $cv++)
                        <li class="list-group-item version-bible">
                        @php
                                $url = $data->lang_bibles[config('data.language_default')][$cv]['abb'];
                                $url .= '/';
                                $acontent = $data->lang_bibles[config('data.language_default')][$cv]['version'];
                            @endphp
                            <a class="nav-link version-bible-link" href="{{ url($url) }}">
                                {{ $data->lang_bibles[config('data.language_default')][$cv]['version'] }}
                            </a>
                        </li>
                    @endfor
                </ul>
            </div>
            <div class="col">
                <ul class="list-group list-group-flush">
                    @for ($cv = 5; $cv < 10; $cv++)
                        <li class="list-group-item version-bible">
                            <a class="nav-link version-bible-link" href="{{ url($data->lang_bibles[config('data.language_default')][$cv]['abb']) }}">
                                {{ $data->lang_bibles[config('data.language_default')][$cv]['version'] }}
                            </a>
                        </li>
                    @endfor
                    <li class="list-group-item version-bible">
                        <a class="nav-link cursor-pointer version-bible-link" data-bs-toggle="modal" data-bs-target="#modal_bibles">
                            @lang('messages.other_bibles')
                        </a>
                    </li>                  
                </ul>
            </div>
        </div>
    </div>