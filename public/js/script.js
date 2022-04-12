$(function(){
    'use strict'
    $('form').submit(function(){
        $(".btn-submit").attr("disabled", true);
        $(".btn-submit").html("<span class='spinner-grow spinner-grow-sm' role='status' aria-hidden='true'></span>&nbsp;Loading...");
    });
    
    $('#dataTbl').dataTable({
        responsive: true
    });

    $('.select2').select2();

    $(".search-select").select2({
        allowClear: true
    });

    $(".dtpicker").pickadate({
        format: "dd/mmm/yyyy",
        selectYears: 100,
        selectMonths: true,
        //max: true
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".addPurchaseRow").click(function(){
        $(".tblPurchase tbody").append("<tr><td><select class='form-control form-control-md select2 selProduct' name='product[]' required='required'><option value=''>Select</option></select></td><td><input type='number' class='form-control text-right' placeholder='0' name='qty[]' required='required'></td><td><input type='number' class='form-control text-right' placeholder='0.00' name='price[]' required='required'></td><td><input type='number' class='form-control text-right' placeholder='0.00' name='total[]' required='required'></td><td class='text-center'><a href='javascript:void(0)' onClick='$(this).parent().parent().remove()'><i class='fa fa-trash text-danger'></i></a></td></tr>");
        $('.selProduct').select2();
        bindDDL('product', 'selProduct');
    })
});

function bindDDL(type, ddl){
    $.ajax({
        type: 'GET',
        url: '/helper/product/'
    }).then(function (data){
        xdata = $.map(data, function(obj){
            obj.text = obj.name || obj.id;  
            return obj;
        });
        $('.'+ddl).select2({data:xdata});
    });
}