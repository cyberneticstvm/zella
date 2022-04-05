$(function(){
    'use strict'
    $('form').submit(function(){
        $(".btn-submit").attr("disabled", true);
        $(".btn-submit").html("<span class='spinner-grow spinner-grow-sm' role='status' aria-hidden='true'></span>&nbsp;Loading...");
    });
    
    $('#dataTbl').dataTable({
        responsive: true
    });
})