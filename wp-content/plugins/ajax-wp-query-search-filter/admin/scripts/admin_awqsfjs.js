jQuery(document).ready(function($) {
	$('#toplevel_page_ajaxwpqsf').removeClass('wp-not-current-submenu').addClass('current');
	$('#menu-dashboard').removeClass('wp-has-current-submenu').addClass('wp-not-current-submenu');
	$('.closex').on('click', function() {
		jQuery.ajax({
				 type: 'POST',	 
				 url: ajaxurl,
				 data: ({action : 'remove_dona' }),
				 success: function(html) {
					$('.donation').remove();
				 }
				 });
		
		
		return false;	
	});
	$('.addTaxo').on('click',function() {
		addTaxoAjax();
		return false;
	});
	
	$('.addCmf').on('click',function() {
		addCmfAjax();
		return false;
	});
	
	$('.genv').on('click',function() {
		generate_value_ajax();
		return false;
	});
	
	$( "#sortable" ).sortable();
   	
	$( "#sortable2" ).sortable();
   	
	$('.remove_row').on('click',function(e) {
	e.preventDefault();
	$(this).parent().parent().css("background-color","#FF3700");
    $(this).parent().parent().fadeOut(400, function(){
            $(this).remove();
        });
    return false;
	});
	
	$("#numberpost").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
	
	function addTaxoAjax(){
				taxo = $('#pretax').val(); 
				label = $('#prelabel').val();
				text = $('#preall').val();
				excl = $('#preexclude').val();
				type = $('input[name=displyatype]:checked').val();
				hide = $('input[name=pre_hide_empty]:checked').val();
				var tbl = $('#taxo_table tbody > tr:last > td');			
				counter = tbl.find('#taxcounter').val();	
				if(!counter) {counter = 0;}else{ counter++;}
				jQuery.ajax({
				 type: 'POST',	 
				 url: ajaxurl,
				 data: ({action : 'awpqsfTaxo_ajax', taxo:taxo,label:label,text:text,hide:hide,type:type,excl:excl,counter:counter }),
				 success: function(html) {
				
				 $('#taxo_table').last().append(html);
				taxo = $('#pretax').val(""); 
				label = $('#prelabel').val("");
				text = $('#preall').val("");
				hide = $('input[name=pre_hide_empty]:checked').val("");
				 }
				 });
		}
		
	function addCmfAjax() {
		key = $('#precmfkey').val(); 
		metalabel = $('#precmflabel').val(); 
		all = $('#precmfall').val();
		compare = $('#precompare').val(); 
		opt = $('#preopt').val(); 
		check = $('input[name=cmfdisplay]:checked').val();
		var tbl = $('#cmf_table tbody > tr:last > td');		
		cmfcounter = tbl.find('#cmfcounter').val();	
		if(!cmfcounter) {cmfcounter = 0;}else{ cmfcounter++;}
		
		jQuery.ajax({
				 type: 'POST',	 
				 url: ajaxurl,
				 data: ({action : 'awpqsfCmf_ajax', key:key,metalabel:metalabel,all:all,compare:compare,opt:opt,check:check,cmfcounter:cmfcounter,type:'form'  }),
				 success: function(html) {
			
				$('#cmf_table').last().append(html);
				$('#precmfkey').val(""); 
				$('#precmflabel').val(""); 
				$('#precmfall').val("");
				$('#precompare').val(""); 
				$('#preopt').val(""); 
				
				 }
				 });
		
	}

	function generate_value_ajax(){

		key = $('#precmfkey').val(); 
		if(!key) {alert("You must select a mete key first"); return;}	
		jQuery.ajax({
				 type: 'POST',	 
				 url: ajaxurl,
				 data: ({action : 'awpqsfCmf_ajax',key:key,type:'meta'  }),
				 success: function(html) {
			
					$('#preopt').val(html);
				
				 }
				 });
	}

	var $content = $(".content").hide();
	 $(".toggle").on("click", function(e){
    		$(this).toggleClass("expanded");
		$(this).find('.plus').toggleClass("minus");
    		$(this).next('.content').slideToggle();
  	});	
	
});  
