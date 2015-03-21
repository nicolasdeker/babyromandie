jQuery(document).ready(function($) {
	
		$('.searchbtn').click('change', function(e) {
			passing_data($(this));
			return false;
		});
	
		$('.pagievent').live('click', function(e) {
			var pagenumber =  $(this).attr('id');
			var formid = $('#curform').val();
			pagination_ajax(pagenumber, formid);
			return false;
		});

		$('.awpqsftext').keypress(function(e) {
		  if($(this).val().length >2){
		  	passing_data( $(this) );
		  }
		  if(e.keyCode == 13){
		    e.preventDefault();
		    passing_data($(this));
		  }
		});
		
		$('.awpqsf_class > select').change(function(e) {
		  	passing_data($("#awpqsf_id_btn") );
		});
		
		
		window.passing_data = function ($obj) {
			
			var ajxdiv = $obj.closest("form").find("#jaxbtn").val();	
			var res = {loader:$('<div />',{'class':'mloading'}),container : $(''+ajxdiv+'')};
		
			var getdata = $obj.closest("form").serialize();
			var pagenum = '1';
			
			jQuery.ajax({
				 type: 'POST',	 
				 url: ajax.url,
				 data: ({action : 'awpqsf_ajax',getdata:getdata, pagenum:pagenum }),
				 beforeSend:function() {$(''+ajxdiv+'').empty();res.container.append(res.loader);},
				 success: function(html) {
					res.container.find(res.loader).remove();
				  $(''+ajxdiv+'').html(html);
				
				
				 }
				 });
			
		}	
		
		window.pagination_ajax = function (pagenum, formid) {
			var ajxdiv = $(''+formid+'').find("#jaxbtn").val();	
			var res = {loader:$('<div />',{'class':'mloading'}),container : $(''+ajxdiv+'')};
			var getdata = $(''+formid+'').serialize();
		
			jQuery.ajax({
				 type: 'POST',	 
				 url: ajax.url,
				 data: ({action : 'awpqsf_ajax',getdata:getdata, pagenum:pagenum }),
				 beforeSend:function() {$(''+ajxdiv+'').empty(); res.container.append(res.loader);},
				 success: function(html) {
				  res.container.find(res.loader).remove();
				  $(''+ajxdiv+'').html(html);
				
				//res.container.find(res.loader).remove();
				 }
				 });
		}
		
	 $('.awpsfcheckall').click(function () {
	
	    $(this).closest('.togglecheck').find('input:checkbox').prop('checked', this.checked);
		
         });



});//end of script
