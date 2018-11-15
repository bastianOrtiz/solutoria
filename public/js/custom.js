$(document).ready(function(){
    
    function pad(n){return n<10 ? '0'+n : n}
    if( $('#menu_calendar').length > 0 ){            
        $('#menu_calendar').datepicker({
            format: "yyyy-mm-dd",
            language: "es",    
            beforeShowDay: function (date){
                var this_day = date.getDate();
                var this_day = pad(this_day);
                var this_month = (date.getMonth() + 1);
                var this_month = pad(this_month);            
                var this_year = date.getFullYear();
                myDate =  this_year+'-'+this_month+'-'+this_day ;
                $.each(array_feriados, function( index, value ) {                                
                    if ( myDate == '2015-09-18' ){
                        return {
                            tooltip: 'Example tooltip',
                            classes: 'active css-class-to-highlight'
                        };                        
                    }
                });            
            }
        }); 
    }

    
     
    $('.dropdown-menu.drop-calendar > *').click(function(e) {
        e.stopPropagation();
    });
    
    if( $(".wys_editor").length > 0 ){
        var editor = $(".wys_editor").Editor();    
    }    
    
    $("#menuBarDiv").append('<div class="btn-group"><a href="javascript:void(0)" class="btn btn-default" id="comodin_trabajador_nombre" title="Toggle Screen" style="cursor: pointer;"><i class="fa fa-help"></i></a></div>')
    
    $('#comodin_trabajador_nombre').on('click', function(){
        $(".Editor-editor").append('[trabajador.nombre]');
    })
    
    mouse_inside_side_search = false;
    $(document).on('mouseover','#overlay_search_trabajador', function(){
        mouse_inside_side_search=true;
    })
    $(document).on('mouseout','#overlay_search_trabajador', function(){
        mouse_inside_side_search=false;
    })
        
    $('body').click(function(){
        if( !mouse_inside_side_search ){
            $("#overlay_search_trabajador").fadeOut().remove();
        }
    })
    
    
    //setup before functions
    var typingTimer;                //timer identifier
    var doneTypingInterval = 300;  //time in ms, 5 second for example
    var $input = $("#buscarTrabajadorSidebar");
    
    //on keyup, start the countdown
    $input.on('keyup', function () {
        $("#overlay_search_trabajador").html('<i class="fa fa-refresh fa-spin fa-1x fa-fw margin-bottom"></i>');        
        if( $(this).val().length >= 3 ){
            clearTimeout(typingTimer);
            typingTimer = setTimeout(callAjaxSidebar, doneTypingInterval);
        } else {
            $("#overlay_search_trabajador").remove();  
        }
    });
    
    //on keydown, clear the countdown 
    $input.on('keydown', function () {
      clearTimeout(typingTimer);
    });
        
    
    
    
            
    setTimeout(function(){ 
        $(".alert").fadeOut(250, function(){
            $(".alert").remove();
        })
    }, 3000);
        
})

function callAjaxSidebar(){    
    $.ajax({
		type: "POST",
		url: BASE_URL + '/controllers/ajax/trabajador.ajax.php',
		data: 's=' + $("#buscarTrabajadorSidebar").val() + '&action=buscarlive',
        dataType: 'json',
        beforeSend: function(){                    
        },
		success: function (json) {				    
		    html = '<div id="overlay_search_trabajador">';
		    if(json.status == 'success'){				                                
                $.each(json.registros, function(k,v) {
                    html += '<a href="' + BASE_URL + '/trabajador/editar/' + v.id + '"><i class="fa fa-caret-right"></i> ';
                    html += v.nombre
                    html += '</a>';
                });                                                
		    } else {				        
		        html += "No hay registros";                        
		    }
            html += '</div>';
            $("#overlay_search_trabajador").remove();    
            $(".sidebar-form .input-group").append(html);
        }
	})
}


function formateaRut(formElement){    
    if( formElement.val() != "" ){
        arr_rut = formElement.val().split("-");
        
        var the_rut = arr_rut[0];
        the_rut = the_rut.replace(/\./g,'');
        
        if( arr_rut.length == 1 ){
            the_dv = the_rut.substring((the_rut.length - 1), (the_rut.length));
            the_rut = the_rut.substring(0, (the_rut.length - 1));
        } else {
            the_dv = arr_rut[1];
            the_rut = the_rut;
        }
        
        formElement.val(the_rut+"-"+the_dv);
        
        if( validarut(the_rut,the_dv) ){
            return true;
        } else {
            return false;
        }
    }    
}


function format_rut(rut){
    arr_rut = rut.split("-");
    
    var the_rut = arr_rut[0];
    the_rut = the_rut.replace(/\./g,'');
    
    if( arr_rut.length == 1 ){
        the_dv = the_rut.substring((the_rut.length - 1), (the_rut.length));
        the_rut = the_rut.substring(0, (the_rut.length - 1));
    } else {
        the_dv = arr_rut[1];
        the_rut = the_rut;
    }
    
    return_rut = the_rut+"-"+the_dv;
    
    return return_rut;
}

function validarut(ruti,dvi){
 var rut = ruti+"-"+dvi;
 if (rut.length<9)
     return(false)
  i1=rut.indexOf("-");
  dv=rut.substr(i1+1);
  dv=dv.toUpperCase();
  nu=rut.substr(0,i1);

  cnt=0;
  suma=0;
  for (i=nu.length-1; i>=0; i--)
  {
    dig=nu.substr(i,1);
    fc=cnt+2;
    suma += parseInt(dig)*fc;
    cnt=(cnt+1) % 6;
   }
  dvok=11-(suma%11);
  if (dvok==11) dvokstr="0";
  if (dvok==10) dvokstr="K";
  if ((dvok!=11) && (dvok!=10)) dvokstr=""+dvok;

  if (dvokstr==dv)
     return(true);
  else
     return(false);
}



function base64_encode(data) {
  //   example 1: base64_encode('Kevin van Zonneveld');
  //   returns 1: 'S2V2aW4gdmFuIFpvbm5ldmVsZA=='
  //   example 2: base64_encode('a');
  //   returns 2: 'YQ=='

  var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
  var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
    ac = 0,
    enc = '',
    tmp_arr = [];

  if (!data) {
    return data;
  }

  do { // pack three octets into four hexets
    o1 = data.charCodeAt(i++);
    o2 = data.charCodeAt(i++);
    o3 = data.charCodeAt(i++);

    bits = o1 << 16 | o2 << 8 | o3;

    h1 = bits >> 18 & 0x3f;
    h2 = bits >> 12 & 0x3f;
    h3 = bits >> 6 & 0x3f;
    h4 = bits & 0x3f;

    // use hexets to index into b64, and append result to encoded string
    tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
  } while (i < data.length);

  enc = tmp_arr.join('');

  var r = data.length % 3;

  return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
}



function base64_decode(data) {
  //   example 1: base64_decode('S2V2aW4gdmFuIFpvbm5ldmVsZA==');
  //   returns 1: 'Kevin van Zonneveld'
  //   example 2: base64_decode('YQ===');
  //   returns 2: 'a'

  var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
  var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
    ac = 0,
    dec = '',
    tmp_arr = [];

  if (!data) {
    return data;
  }

  data += '';

  do { // unpack four hexets into three octets using index points in b64
    h1 = b64.indexOf(data.charAt(i++));
    h2 = b64.indexOf(data.charAt(i++));
    h3 = b64.indexOf(data.charAt(i++));
    h4 = b64.indexOf(data.charAt(i++));

    bits = h1 << 18 | h2 << 12 | h3 << 6 | h4;

    o1 = bits >> 16 & 0xff;
    o2 = bits >> 8 & 0xff;
    o3 = bits & 0xff;

    if (h3 == 64) {
      tmp_arr[ac++] = String.fromCharCode(o1);
    } else if (h4 == 64) {
      tmp_arr[ac++] = String.fromCharCode(o1, o2);
    } else {
      tmp_arr[ac++] = String.fromCharCode(o1, o2, o3);
    }
  } while (i < data.length);

  dec = tmp_arr.join('');

  return dec.replace(/\0+$/, '');
}





function getCaretCharOffsetInDiv(element) {
    var caretOffset = 0;
    if (typeof window.getSelection != "undefined") {
        var range = window.getSelection().getRangeAt(0);
        var preCaretRange = range.cloneRange();
        preCaretRange.selectNodeContents(element);
        preCaretRange.setEnd(range.endContainer, range.endOffset);
        caretOffset = preCaretRange.toString().length;
    }
    else if (typeof document.selection != "undefined" && document.selection.type != "Control")
    {
        var textRange = document.selection.createRange();
        var preCaretTextRange = document.body.createTextRange();
        preCaretTextRange.moveToElementText(element);
        preCaretTextRange.setEndPoint("EndToEnd", textRange);
        caretOffset = preCaretTextRange.text.length;
    }
    return caretOffset;
}

       
        
function hideFieldValue(field_id, button_id){
    field = $(field_id);
    control = $(button_id);
    if( field.attr('type') != 'password' ){
        field.attr('type', 'password');
    }

    $( control ).bind( "click", function(e) {
        e.preventDefault();
        $(control).toggleClass('fa-eye fa-eye-slash');
        $(field).toggleClass('hidding');
        if( $(field).hasClass('hidding') ){
            $(field).attr('type','text')            
        } else {
            $(field).attr('type','password')
        }                        
    })
}




function IsRut(rut){
    var rexp = new RegExp(/^([0-9])+\-([kK0-9])+$/);
    if(rut.match(rexp)){
        var RUT		= rut.split("-");
        var elRut	= RUT[0];
        var factor	= 2;
        var suma	= 0;
        var dv;
        for(i=(elRut.length-1); i>=0; i--){
            factor = factor > 7 ? 2 : factor;
            suma += parseInt(elRut[i])*parseInt(factor++);
        }
        dv = 11 -(suma % 11);
        if(dv == 11){
            dv = 0;
        }else if (dv == 10){
            dv = "k";
        }

        if(dv == RUT[1].toLowerCase()){
            return true;
        }else{            
            return false;
        }
    }else{
        return false;
    }
}

function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}



$.fn.extend({
    insertAtCaret: function(myValue) {
        if (document.selection) {
                this.focus();
                sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
        }
        else if (this.selectionStart || this.selectionStart == '0') {
            var startPos = this.selectionStart;
            var endPos = this.selectionEnd;
            var scrollTop = this.scrollTop;
            this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
            this.focus();
            this.selectionStart = startPos + myValue.length;
            this.selectionEnd = startPos + myValue.length;
            this.scrollTop = scrollTop;
        } else {
            this.value += myValue;
            this.focus();
        }
    }
})

