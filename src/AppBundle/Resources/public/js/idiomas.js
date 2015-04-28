var $addTagLink = $('<a href="#" class="agregar_link_idioma">Agregar Idioma</a>');
var $newLinkLi = $('<li></li>').append($addTagLink);

jQuery(document).ready(function() {
    $collectionHolder = $('ul.idiomas');
    if(!$(location).attr('href').contains('/nuevo')) {
        addTagFormDeleteLink($collectionHolder);//$('a.eliminar-idioma:first').remove();
    } else {
        $('div.form-group').eq(-2).remove();    //eliminamos penultima etiqueta con el label idioma
    }
    $collectionHolder.append($newLinkLi);
    $collectionHolder.data('index', $collectionHolder.find(':input').length);
    $addTagLink.on('click', function(e) {
        e.preventDefault();
        addTagForm($collectionHolder, $newLinkLi);
    });
});

function addTagForm($collectionHolder, $newLinkLi) {
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');
    var newForm = prototype.replace(/__name__/g, index);
    $collectionHolder.data('index', index + 1);
    var $newFormLi = $('<li></li>').append(newForm);
    $newFormLi.append('<a href="#" class="eliminar-idioma" style="position: absolute; margin-top: -195px; margin-left: 0px;" >' +
        '<i class="glyphicon glyphicon-minus"></a><hr />');
    $newLinkLi.before($newFormLi);
    $('.eliminar-idioma').click(function(e) {
        e.preventDefault();
        $(this).parent().remove();
        return false;
    });
    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<a href="#" class="eliminar-idioma" style="position: absolute; top: 10px; margin-left: -35px;">' +
        '<i class="glyphicon glyphicon-trash"></i></a>');
    $tagFormLi.append($removeFormA);
    $removeFormA.on('click', function(e) {
        e.preventDefault();
        $('ul.idiomas').empty();

        $collectionHolder = $('ul.idiomas');
        $collectionHolder.each(function() {
            addTagFormDeleteLink($(this));
        });
        $collectionHolder.append($newLinkLi);
        $collectionHolder.data('index', $collectionHolder.find(':input').length);
        $addTagLink.on('click', function(e) {
            e.preventDefault();
            addTagForm($collectionHolder, $newLinkLi);
        });
        $('a.eliminar-idioma').empty();
    });
}
