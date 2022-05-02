<script type="text/javascript">
    var lang_bibles = '<?php echo json_encode($lang_bibles); ?>';
    var lang_default = 'portuguese';
</script>
<script src="{{ asset('js/modal_bibles.js') }}"></script>

<div class="modal fade modal_bibles" id="modal_bibles" tabindex="-1" aria-labelledby="ModalBibles" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-primary btn-lg menu-modal-button active" id="languages-modal-button">Idioma</button>
                <button type="button" class="btn btn-primary btn-lg menu-modal-button" id="bibles-modal-button">Bíblias</button>
            </div>
            <div class="container-fluid modal-bibles-container-idiomas" id="languages-modal-container">
                <ul class="list-group list-group-flush">
                    @foreach ($lang_bibles as $lang => $bibles)
                        <li class="list-group-item link-menu-modal">
                            <button type="button" class="btn btn-link btn-modal-button" data-type="language-modal-button" data-language="{{ $lang }}">
                                @lang('messages.' . $lang)
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="container-fluid modal-bibles-container-languages visually-hidden" id="bibles-modal-container">
                <ul class="list-group list-group-flush" id="bibles-modal-container-list">
                    
                </ul>
            </div>
        </div>
    </div>
</div>