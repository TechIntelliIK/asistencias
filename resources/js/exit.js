$(document).ready(function () {
    //CheckBox Ocultar campos de imagen
    $('#customSwitch1').click(function () {
        $(this).is(':checked') ? $('#file1_block').slideToggle(300) : $('#file1_block').slideToggle(300); 
        $(this).is(':checked') ? $('#file2_block').slideToggle(300) : $('#file2_block').slideToggle(300);
        $(this).is(':checked') ? $('#comentario').slideToggle(300) : $('#comentario').slideToggle(300); 
        $('#file1').prop('required', $(this).is(':checked') ? false : true);
        $('#file2').prop('required', $(this).is(':checked') ? false : true);
        // // $('#label1').css('display', $(this).is(':checked') ? 'none' : 'block');
        // $('#file1_block').css('display', $(this).is(':checked') ? 'none' : 'block');
        // // $('#label2').css('display', $(this).is(':checked') ? 'none' : 'block');
        // $('#file2_block').css('display', $(this).is(':checked') ? 'none' : 'block');
        // // $('#label3').css('display', $(this).is(':checked') ? 'none' : 'block');
        // $('#comentario').css('display', $(this).is(':checked') ? 'none' : 'block');
    });
});