$('label:contains("Idioma/s"), label:contains("Miembro/s")').eq(1).remove(); //borramos segundo label idiomas/miembros
var $addTagLink = $('<a href="#" class="agregar_link">Agregar</a>');
var $newLinkLi = $('<li></li>').append($addTagLink);

jQuery(document).ready(function() {
    $collectionHolder = $('ul.coleccion');
    $collectionHolder.append($newLinkLi);
    if ($('ul.coleccion li').length > 1) {  //if(!$(location).attr('href').contains('/nuevo'))
        addTagFormDeleteLink($collectionHolder);//$('a.eliminar-idioma:first').remove();
    }
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
    $newFormLi.append('<a href="#" class="eliminar-coleccion" style="position: absolute; margin-top: -195px; margin-left: 0px;" >' +
        '<i class="glyphicon glyphicon-minus"></i></a><hr />');
    $newLinkLi.before($newFormLi);
    $('.eliminar-coleccion').click(function(e) {
        e.preventDefault();
        $(this).parent().remove();
        return false;
    });
    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<a href="#" class="eliminar-coleccion" style="position: absolute; top: 10px; margin-left: -35px;">' +
        '<i class="glyphicon glyphicon-trash"></i></a>');
    $tagFormLi.append($removeFormA);
    $removeFormA.on('click', function(e) {
        e.preventDefault();
        $('ul.coleccion').empty();
        $collectionHolder = $('ul.coleccion');
        $collectionHolder.append($newLinkLi);
        $collectionHolder.data('index', $collectionHolder.find(':input').length);
        $addTagLink.on('click', function(e) {
            e.preventDefault();
            addTagForm($collectionHolder, $newLinkLi);
        }); //$('a.eliminar-coleccion').empty();
    });
}
