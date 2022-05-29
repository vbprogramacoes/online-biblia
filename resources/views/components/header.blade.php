@php unset($data->menu[2]);@endphp
<div class="container header-nav">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid nav-logo">
            <a class="navbar-brand mb-0 logo" href="{{ url($data->version) }}">@lang('messages.onlinebible')</a>
        </div>
        <div class="container-fluid d-none"></div>
        <?php
        /*
        <form class="container-fluid d-none">
            
            @csrf
            <div class="col-12">
                <label class="visually-hidden" for="specificSizeInputGroupUsername">@lang('messages.search')</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-label="Pesquisa conteúdo na bíblia" placeholder="Pesquisar" disabled="disabled">
                    <button type="submit" class="btn btn-outline-secondary" disabled="disabled"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </form>
        */?>
        <div class="dropdown container-fluid justify-content-end nav-menu">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </button>
            <ul class="dropdown-menu menu-header" aria-labelledby="dropdownMenuButton1">
            @foreach($data->menu as $menu)
                <li>
                @if ($menu == 'bibles')
                    <a class="nav-link cursor-pointer menu-header-link" data-bs-toggle="modal" data-bs-target="#modal_bibles">@lang('messages.' . $menu)</a>
                @elseif ($menu == 'home')
                    <a class="nav-link menu-header-link" href="{{ url('') }}">@lang('messages.' . $menu)</a>
                @else
                    <a class="nav-link menu-header-link" href="{{ url(__('messages.href_' . $menu)) }}">@lang('messages.' . $menu)</a>
                @endif
                </li>
            @endforeach
            </ul>
        </div>
    </nav>
</div>
@component('components.modal_bibles', ['lang_bibles' => $data->lang_bibles])
@endcomponent