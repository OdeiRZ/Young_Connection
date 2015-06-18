$('label:contains("Idioma/s"), label:contains("Alojamiento/s"), label:contains("Miembro/s")').eq(1).remove(); //borramos segundo label idiomas/miembros/alojamientos
var $addTagLink = $('<a href="#" class="agregar_link">Agregar</a>');
var $newLinkLi = $('<li></li>').append($addTagLink);
var sw = true;

$(document).ready(function() {
    $(document).mousemove(function(event) {
        TweenLite.to($("body"), .5, {
            css: {
                backgroundPosition: "" + parseInt(event.pageX / 8) + "px " + parseInt(event.pageY / '12') + "px, " + parseInt(event.pageX / '15') + "px " + parseInt(event.pageY / '15') + "px, " + parseInt(event.pageX / '30') + "px " + parseInt(event.pageY / '30') + "px",
                "background-position": parseInt(event.pageX / 8) + "px " + parseInt(event.pageY / 12) + "px, " + parseInt(event.pageX / 15) + "px " + parseInt(event.pageY / 15) + "px, " + parseInt(event.pageX / 30) + "px " + parseInt(event.pageY / 30) + "px"
            }
        })
    });
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
            });
            TweenMax.set([container], {
                position: 'absolute',
                top: '50%',
                left: '50%',
                xPercent: -50,
                yPercent: -50
            });
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
            }).to(drop2, 4, {
                    attr: {
                        cx: 250
                    }, ease: Power1.easeInOut
                }, '-=4').to(drop, 4, {
                    attr: {
                        cx: 125,
                        rx: '-=10',
                        ry: '-=10'
                    }, ease: Back.easeInOut.config(3)
                }).to(drop2, 4, {
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
(function() {
    console.log("a");
    function mobilecheck() {
        var check = false;
        (function(a){if(/(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
        return check;
    }
    var support = { animations : Modernizr.cssanimations },
        animEndEventNames = { 'WebkitAnimation' : 'webkitAnimationEnd', 'OAnimation' : 'oAnimationEnd', 'msAnimation' : 'MSAnimationEnd', 'animation' : 'animationend' },
        animEndEventName = animEndEventNames[ Modernizr.prefixed( 'animation' ) ], onEndAnimation = function( el, callback ) {
            var onEndCallbackFn = function( ev ) {
                if( support.animations ) {
                    if( ev.target != this ) return;
                    this.removeEventListener( animEndEventName, onEndCallbackFn );
                } if( callback && typeof callback === 'function' ) { callback.call(); }
            };
            if( support.animations ) {
                el.addEventListener( animEndEventName, onEndCallbackFn );
            } else {
                onEndCallbackFn();
            }
        }, eventtype = mobilecheck() ? 'touchstart' : 'click';
    [].slice.call( document.querySelectorAll( '.cbutton' ) ).forEach( function( el ) {
        el.addEventListener( eventtype, function( ev ) {
            classie.add( el, 'cbutton--click' );
            onEndAnimation( classie.has( el, 'cbutton--complex' ) ? el.querySelector( '.cbutton__helper' ) : el, function() {
                classie.remove( el, 'cbutton--click' );
            } );
        } );
    } );
})();