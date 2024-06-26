$(document).ready(function(){

    // Select 2
    $(".select2_demo_1").select2();
    $(".select2_demo_2").select2({
        placeholder: "Select a state",
        allowClear: true
    });

    // Bootstrap datepicker
    $('#date_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: true,
        calendarWeeks: true,
        autoclose: true,
        format: 'yyyy-mm-dd', // Format default yang akan digunakan oleh datetimepicker
        formatDate: 'yyyy-mm-dd', // Format yang akan digunakan dalam input (tahun, bulan, hari)
    });
    $('#date_2 .input-group.date').datepicker({
        startView: 1,
        todayBtn: "linked",
        keyboardNavigation: false,
        autoclose: true,
        format: "yyyy-mm-dd"
    });
    $('#date_3 .input-group.date').datepicker({
        startView: 2,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true
    });
    $('#date_4 .input-group.date').datepicker({
        minViewMode: 1,
        keyboardNavigation: false,
        forceParse: false,
        forceParse: false,
        autoclose: true,
        todayHighlight: true
    });
    $('#date_5 .input-daterange').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true
    });
    $('#date_6').datepicker({
        
    });

    // Timepicker
    $('.timepicker').timepicker();

    // Jquery minicolors
    $('.minicolors').each(function(){
        $(this).minicolors({
            theme:"bootstrap",
            control:$(this).attr("data-control")||"hue",
            format: $(this).attr('data-format') || 'hex',
            opacity:$(this).attr("data-opacity"),
            swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
            position: $(this).attr('data-position') || 'bottom left',
        });
    });
    
    // jQuery Knob
    $(".dial").knob();

});
