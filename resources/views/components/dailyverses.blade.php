<style src="{{ asset('js/modal_bibles.js') }}"></style>
<div class="container">
    <h1 class="h1"> @lang('messages.dailyverses')</h1>
    @foreach ($dailyverses as $dvs)
    <div class="card">
        <div class="card-body">
            <blockquote class="blockquote mb-0">
                @foreach ($dvs as $verse)
                    @php
                        $version            = $verse['version'];
                        $book               = $verse['book'];
                        $chapter            = $verse['chapter'];
                        $first_num_verse    = $verse['num'];
                        $url = "$version/$book/$chapter/$first_num_verse";
                    @endphp
                    <p class="content-verse"><sup class="num-verse"><a href="{{ url($url) }}" class="text-muted">{{ $verse['num'] }}</a></sup>{{ $verse['content'] }}</p>
                @endforeach
                @php
                    $version            = $dvs[0]['version'];
                    $book               = $dvs[0]['book'];
                    $book_name          = $dvs[0]['book_name'];
                    $chapter            = $dvs[0]['chapter'];
                    $first_num_verse    = $dvs[0]['num'];
                    if (count($dvs) > 1) {

                        $last_verse = $dvs[array_key_last($dvs)]['num'];
                        $acontent = "$book_name $chapter, $first_num_verse-$last_verse";
                        $url = "$version/$book/$chapter/$first_num_verse/$last_verse";
                    } else {

                        $acontent = "$book_name $chapter, $first_num_verse";
                        $url = "$version/$book/$chapter/$first_num_verse";
                    }
                @endphp
                <footer class="blockquote-footer text-end footer-card-font"><cite title="{{ $acontent }}"><a href="{{ url($url) }}" class="text-muted">{{ $acontent }}</a></cite></footer>
            </blockquote>
        </div>
    </div>
    @endforeach
</div>