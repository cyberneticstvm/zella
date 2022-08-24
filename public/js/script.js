$(function(){
    'use strict'
    $('form').submit(function(){
        var fid = $(this).attr('id');
        if(fid == 'frm-sales'){
            var c = confirm("Are you sure want to proceed?");
            if(c){
                var cls = $(this).attr('class');
                if(cls != 'export'){
                    $(".btn-submit").attr("disabled", true);
                    $(".btn-submit").html("<span class='spinner-grow spinner-grow-sm' role='status' aria-hidden='true'></span>&nbsp;Loading...");
                }  
            }else{
                return false;
            }
        }else{
            var cls = $(this).attr('class');
            if(cls != 'export'){
                $(".btn-submit").attr("disabled", true);
                $(".btn-submit").html("<span class='spinner-grow spinner-grow-sm' role='status' aria-hidden='true'></span>&nbsp;Loading...");
            }  
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

    $(document).on("blur", ".tblPurchase tbody .qty", function(e){
        var dis = $(this);
        var pid = dis.parent().parent().find(".selProduct").val();
        var qty = dis.val();
        var dval = $("#is_dead_stock").val();
        $.ajax({
            type: 'GET',
            url: '/helper/product/'+pid+'/'+qty+'/'+dval,
            success: function(response) {
                if(!response){
                    alert("Insufficient Qty");
                    dis.val('0');
                    dis.focus();
                }
            }
        });
    });

    $(document).on("keypress", ".tblPurchase tbody .total", function(e){
        if(e.keyCode == 13){
            $(".tblPurchase tbody").append("<tr><td><select class='form-control form-control-md select2 selProduct' name='product[]' required='required'><option value=''>Select</option></select></td><td><input type='number' class='form-control text-right qty' placeholder='0' step='any' name='qty[]' required='required'></td><td><input type='number' step='any' class='form-control text-right price' placeholder='0.00' name='price[]' required='required'></td><td><input type='number' step='any' class='form-control text-right total' placeholder='0.00' name='total[]' required='required'></td><td class='text-center'><a href='javascript:void(0)' onClick='$(this).parent().parent().remove()'><i class='fa fa-trash text-danger'></i></a></td></tr>");
            $('.selProduct').select2();
            bindDDL('product', 'selProduct');
            return false;
        }
    });

    $(".addPurchaseRow").click(function(){        
        $(".tblPurchase tbody").append("<tr><td><select class='form-control form-control-md select2 selProduct' name='product[]' required='required'><option value=''>Select</option></select></td><td><input type='number' class='form-control text-right qty' placeholder='0' step='any' name='qty[]' required='required'></td><td><input type='number' step='any' class='form-control text-right price' placeholder='0.00' name='price[]' required='required'></td><td><input type='number' step='any' class='form-control text-right total' placeholder='0.00' name='total[]' required='required'></td><td class='text-center'><a href='javascript:void(0)'><i class='fa fa-trash text-danger'></i></a></td></tr>");
        $('.selProduct').select2();
        bindDDL('product', 'selProduct');
    });

    $(document).on("click", ".fa-trash", function(){
        var pmode = $(".payment_mode").val();
        $(this).parent().parent().remove();
        calculateTotal(pmode);
    });

    $(document).on('change', '.selProduct', function(){
        var pid = $(this).val();
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
                var pmode = $(".payment_mode").val();
                calculateTotal(pmode);
            }
        });
    });

    $(document).on('change', '.qty, .price', function(){
        var qty = $(this).parent().parent().find('.qty').val();
        var price = $(this).parent().parent().find('.price').val();
        var total = $(this).parent().parent().find('.total');
        total.val(qty*price);
        var pmode = $(".payment_mode").val();
        calculateTotal(pmode);
    });

    $(document).on('change', '.discount', function(){
        var pmode = $(".payment_mode").val();
        calculateTotal(pmode);
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
                    window.location.href = response;
                }
            });
        }else{
            return false;
        }
    });

    $(".payment_mode").change(function(){
        var pmode = $(this).val();
        var discount = $(".discount").val();
        calculateTotal(pmode);
    });

    $(document).on("change", ".selStatus", function(){
        if($(this).val() == 1){
            var pmode = $(".payment_mode").val();
            $(this).closest('tr').find(".qty, .price, .total").val('0');
            calculateTotal(pmode);
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

function calculateTotal(pmode){
    var tot = 0;
    var card_fee = (pmode == 'card') ? $("#card_fee").val() : 0.00;
    var vat = $("#vat").val();
    var discount = $(".discount").val();
    $("table .total").each(function () {
        tot += Number($(this).val());               
    });
    $(".stot").val(tot);
    $(".card_fee").val(card_fee);
    tot = tot - discount;
    tot = (vat > 0 ) ? tot+(tot*vat)/100 : tot;
    tot = tot - (tot*card_fee)/100;    
    $(".gtot").val(tot.toFixed(2));
}