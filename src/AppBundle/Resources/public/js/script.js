$('label:contains("Idioma/s"), label:contains("Alojamiento/s"), label:contains("Miembro/s")').eq(1).remove(); //borramos segundo label idiomas/miembros/alojamientos
var $addTagLink = $('<a href="#" class="agregar_link">Agregar</a>');
var $newLinkLi = $('<li></li>').append($addTagLink);
var sw = true;

jQuery(document).ready(function() {
    $('#tabla').DataTable();
    $('#multiple').unbind('click').removeAttr('class').click(function() {
        $("input[type='checkbox']").prop("checked", sw);
        $("#multiple i").attr("class", (sw) ? 'glyphicon glyphicon-unchecked' : 'glyphicon glyphicon-check');
        sw = !sw;
    });
    $('form').submit(function() {
        $("body").append(
            '<svg width="400" height="200" viewBox="0 0 400 200">'+
            '<defs>'+
            '<filter id="goo">'+
            '<feGaussianBlur in="SourceGraphic" stdDeviation="7" result="blur" />'+
            '<feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 17 -7" result="cm" />'+
            '<feComposite in="SourceGraphic" in2="cm" />'+
            '</filter>'+
            '<filter id="f2" x="-200%" y="-40%" width="400%" height="200%">'+
            '<feOffset in="SourceAlpha" dx="9" dy="3" />'+
            '<feGaussianBlur result="blurOut" in="offOut" stdDeviation="0.51" />'+
            '<feComponentTransfer>'+
            '<feFuncA type="linear" slope="0.05" />'+
            '</feComponentTransfer>'+
            '<feMerge>'+
            '<feMergeNode/>'+
            '<feMergeNode in="SourceGraphic" />'+
            '</feMerge>'+
            '</filter>'+
            '</defs>'+
            '<g filter="url(#goo)" style="fill:#FFFFFF">'+
            '<ellipse id="drop"  cx="125" cy="90" rx="20" ry="20" fill-opacity="0.6" fill="gray" />'+
            '<ellipse id="drop2" cx="125" cy="90" rx="20" ry="20" fill-opacity="0.6" fill="gray" />'+
            '</g>'+
            '</svg>'
        );
        (function() {
            var container = document.getElementById('container');
            var drop = document.getElementById('drop');
            var drop2 = document.getElementById('drop2');
            var outline = document.getElementById('outline');
            TweenMax.set(['svg'], {
                position: 'absolute',
                top: '50%',
                left: '50%',
                xPercent: -50,
                yPercent: -50
            })
            TweenMax.set([container], {
                position: 'absolute',
                top: '50%',
                left: '50%',
                xPercent: -50,
                yPercent: -50
            })
            TweenMax.set(drop, {
                transformOrigin: '50% 50%'
            })
            var tl = new TimelineMax({
                repeat: -1,
                paused: false,
                repeatDelay: 0,
                immediateRender: false
            });
            tl.timeScale(3);
            tl.to(drop, 4, {
                attr: {
                    cx: 250,
                    rx: '+=10',
                    ry: '+=10'
                }, ease: Back.easeInOut.config(3)
            })
                .to(drop2, 4, {
                    attr: {
                        cx: 250
                    }, ease: Power1.easeInOut
                }, '-=4')
                .to(drop, 4, {
                    attr: {
                        cx: 125,
                        rx: '-=10',
                        ry: '-=10'
                    }, ease: Back.easeInOut.config(3)
                })
                .to(drop2, 4, {
                    attr: {
                        cx: 125,
                        rx: '-=10',
                        ry: '-=10'
                    }, ease: Power1.easeInOut
                }, '-=4')
        })();
        return true;
    });
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: '',
        yearRange: "-100:+0"
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);
    asignarCalendario();
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
    asignarCalendario();
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

function asignarCalendario() {
    $('.date').datepicker({
        language: 'es',
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true
    });
}