$(function(){
    'use strict'
    $('form').submit(function(){
        var cls = $(this).attr('class');
        if(cls != 'export'){
            $(".btn-submit").attr("disabled", true);
            $(".btn-submit").html("<span class='spinner-grow spinner-grow-sm' role='status' aria-hidden='true'></span>&nbsp;Loading...");
        }        
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
        $(".tblPurchase tbody").append("<tr><td><select class='form-control form-control-md select2 selProduct' name='product[]' required='required'><option value=''>Select</option></select></td><td><input type='number' class='form-control text-right qty' placeholder='0' name='qty[]' required='required'></td><td><input type='number' class='form-control text-right price' placeholder='0.00' name='price[]' required='required'></td><td><input type='number' class='form-control text-right total' placeholder='0.00' name='total[]' required='required'></td><td class='text-center'><a href='javascript:void(0)' onClick='$(this).parent().parent().remove()'><i class='fa fa-trash text-danger'></i></a></td></tr>");
        $('.selProduct').select2();
        bindDDL('product', 'selProduct');
    })

    $(document).on('change', '.selProduct', function(){
        var pid = $(this).val(); var discount = $(".discount").val();
        var qty = $(this).parent().parent().find('.qty');
        var price = $(this).parent().parent().find('.price');
        var total = $(this).parent().parent().find('.total');
        $.ajax({
            type: 'GET',
            url: '/helper/product/'+pid,
            success: function( response ) {
                qty.val('1');
                price.val(response.selling_price);
                total.val(response.selling_price);
                calculateTotal(discount);
            }
        });
    });

    $(document).on('change', '.qty, .price', function(){
        var qty = $(this).parent().parent().find('.qty').val();
        var price = $(this).parent().parent().find('.price').val();
        var total = $(this).parent().parent().find('.total');
        total.val(qty*price); var discount = $(".discount").val();
        calculateTotal(discount);
    });

    $(document).on('change', '.discount', function(){
        var discount = $(this).val();
        calculateTotal(discount);
    });

    $(document).on('click', '.chkReturn', function(){
        var val = $(this).is(':checked') ? 1 : 0;
        var id = $(this).closest('tr').attr('id');
        var url = $(this).closest('form').attr('action');
        var c = confirm("Are you sure want to update this record?")
        if(c){
            $.ajax({
                type: 'PUT',
                url: url,
                data: {val: val, id: id},
                success: function( response ) {
                    alert(response)
                }
            });
        }else{
            return false;
        }
    });
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

function calculateTotal(discount){
    var tot = 0;
    $("table .total").each(function () {
        tot += Number($(this).val());               
    });
    tot = tot - discount;
    $(".tbt").text(tot.toFixed(2));
}