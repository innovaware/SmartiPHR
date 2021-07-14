/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * author Francesco Misiti
 * mail: misitifrancesco@gmail.com
 *   
 *
 */

$(".modal_div").keydown(function (e) {

    
    switch (e.which) {
        case 38: // up
            var position = $('.ac_selected').data('position');
            if ($("#select" + (position - 1)).length != 0) {
                seleziona("#select" + (position - 1), "#select" + position);
            }
            break;

        case 40: // down
            var position = $('.ac_selected').data('position');
            if ($("#select" + (position + 1)).length != 0) {
                seleziona("#select" + (position + 1), "#select" + position);
            }
            break;
        case 13:
            if ($('.ac_selected').is(":visible")) {
                var id_search = $('.ac_selected').data('id_is');
                $("#" + id_search).val($('.ac_selected').data('desc_search'));
                $("#" + id_search).attr('data-input_search', $('.ac_selected').data('valore'));
                
                $("#" + id_search).attr( 'valselezionato', $('.ac_selected').data('valore') );
               
                
                
                $('#div_' + id_search + '_desc').html($('.ac_selected').data('desc_search'));
                $('#div_' + id_search + '_result').html('');
                $('#div_' + id_search + '_result').hide();
            } else {
                return;
            }
            break;
        default:
            return; // exit this handler for other keys
    }
    e.preventDefault(); // prevent the default action (scroll / move caret)
});


function seleziona(nuovo, vecchio) {
    $(vecchio).removeClass("ac_selected");
    $(nuovo).addClass("ac_selected");
    
    $(vecchio).css('background-color', 'white');
    $(nuovo).css('background-color', '#b3e0ff');
}


$('body').on('click', '.ac_item_select', function () {
    $('.ac_item_select ').removeClass("ac_selected");
    $(this).addClass("ac_selected");
    
    var id_search = $(this).data('id_is');
    
    $("#" + id_search).val($('.ac_selected').data('desc_search'));
    $("#" + id_search).attr('data-input_search', $('.ac_selected').data('valore'));
    $("#" + id_search).attr( 'valselezionato', $('.ac_selected').data('valore') );
    
        
    $('#div_' + id_search + '_desc').html($(this).data('desc_search'));
    $('#div_' + id_search + '_result').html('');
    $('#div_' + id_search + '_result').hide();
})

function selectItem(id) {
    $("#" + id).addClass("ac_selected");
}


$('.input_search').on('input', function (e) {
    var id_search = $(this).attr('id');

    if ($(this).val() == '') {

        $('#div_' + id_search + '_desc').html('');
        $('#div_' + id_search + '_result').html('');
        $('#div_' + id_search + '_result').hide();
    } else {
        $.ajax({
            type: "POST",
            url: $(this).data('url'),
            data: {operation: $(this).data('metodo'), search_text: $('#' + id_search).val(), id_is: id_search},
            success: function (res) {
                //alert(res);	
                $('#div_' + id_search + '_result').show();
                $('#div_' + id_search + '_result').html(res);
            }
        });
    }
});











