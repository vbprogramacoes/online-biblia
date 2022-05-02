/*
    1- Desativar o botão da biblía
    2- Ativar o botão das linguas
    3- Adcionar a classe visually-hidden em versions-modal-container
    4- Remover a classe visually-hidden languages-modal-container
*/
function trataLanguageButton() {

    $('#bibles-modal-button').removeClass("active");
    $('#languages-modal-button').addClass("active");
    $('#bibles-modal-container').addClass("visually-hidden");
    $('#languages-modal-container').removeClass("visually-hidden");
}

/*
    1- Desativar o botão das linguas
    2- Ativar o botão das versões
    3- Adcionar a classe visually-hidden em languages-modal-container
    4- Remover a classe visually-hidden bibles-modal-container
*/
function trataVersionsButton() {

    $('#languages-modal-button').removeClass("active");
    $('#bibles-modal-button').addClass("active");
    $('#languages-modal-container').addClass("visually-hidden");
    $('#bibles-modal-container').removeClass("visually-hidden");

    var children = $("#bibles-modal-container-list").children('li');
    if (children.length == 0) {
        var json_lang_bibles = JSON.parse(lang_bibles);
        json_lang_bibles[lang_default].forEach(function(value, index) {

            $("#bibles-modal-container-list").append('<li class="list-group-item link-menu-modal"><a class="btn btn-link btn-modal-button" href="' + url +'/' + value.abb + '">' + value.version + '</a></li>');
        });
    }
}

function trataLanguageSelect(language) {

    language.addClass("active");
    var lang = language.attr('data-language');
    var json_lang_bibles = JSON.parse(lang_bibles);

    $("#bibles-modal-container-list").html('');
    json_lang_bibles[lang].forEach(function(value, index) {

        $("#bibles-modal-container-list").append('<li class="list-group-item link-menu-modal"><a class="btn btn-link btn-modal-button" href="' + url +'/' + value.abb + '">' + value.version + '</a></li>');
    });

    trataVersionsButton();
    return false;
}

$(document).ready(function(){

    $("#languages-modal-button").off("click")
    $("#languages-modal-button").on("click", function(){
        
        trataLanguageButton();
    });

    $("#bibles-modal-button").off("click")
    $("#bibles-modal-button").on("click", function(){
        trataVersionsButton();
    });

    $('[data-type="language-modal-button"]').off("click");
    $('[data-type="language-modal-button"]').on("click", function() {
        
        trataLanguageSelect($(this));
    });
});