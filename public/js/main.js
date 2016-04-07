$(document).ready(function(){

    $('.datetimepicker').datetimepicker({
        format: 'yyyy-mm-dd',
        weekStart: 1,
        autoclose: true,
        minView: 2,
        language: 'zh-CN'
    });

    $('.selectpicker').selectpicker();

    var options={
        animation:true,
        trigger:'hover'
    }
    $('.tip').tooltip(options);

    $('.myswitch').bootstrapSwitch();

    $(".tbcloth").tablecloth({
          theme: "default",
          striped: true,
          sortable: true,
          condensed: true
    });

    $("a[data-toggle=popover]").popover().click(function(e) {
        e.preventDefault()
    });

	$('.combobox').combobox();

    $('.metisMenu').metisMenu();

    $('.metisFolder').metisMenu({
        toggle: false
    });

});

var typ=["marginTop","marginLeft"],rangeN=10,timeout=20;
function shake(o,end){
    var range=Math.floor(Math.random()*rangeN);
    var typN=Math.floor(Math.random()*typ.length);
    o["style"][typ[typN]]=""+range+"px";
    var shakeTimer=setTimeout(function(){shake(o,end)},timeout);
    o[end]=function(){clearTimeout(shakeTimer)};
}