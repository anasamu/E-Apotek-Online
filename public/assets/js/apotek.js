$(document).ready(function() 
{
    App.init();


    $("#kalender_penjualan").datepicker({
        dateFormat: "dd-mm-yy"
    });

    $("#kalender_start").datepicker({
        dateFormat: "dd-mm-yy"
    });

    $("#kalender_end").datepicker({
        dateFormat: "dd-mm-yy"
    });

    $("#kalender_start_2").datepicker({
        dateFormat: "dd-mm-yy"
    });

    $("#kalender_end_2").datepicker({
        dateFormat: "dd-mm-yy"
    });

    $("#kalender_start_3").datepicker({
        dateFormat: "dd-mm-yy"
    });

    $("#kalender_end_3").datepicker({
        dateFormat: "dd-mm-yy"
    });

    $("#kalender_pembelian").datepicker({
        dateFormat: "dd-mm-yy"
    });

    $("#kalender_expired").datepicker({
        dateFormat: "dd-mm-yy"
    });

    $('.selectpicker').selectpicker();

    $("#jstree-default").jstree();
});
