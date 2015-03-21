jQuery(document).ready(function($) {
  var initialLocation;
  var browserSupportFlag =  new Boolean();
  var map;
  var infowindow;
  function gmap_initialize() {
    var geocoder;
    var mapOptions = {
      zoom: 9,
      //center: results[0].geometry.location,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
    }
    map = new google.maps.Map(document.getElementById('cust-search-map-result'), mapOptions);
    infowindow = new google.maps.InfoWindow(); 
    // Try W3C Geolocation (Preferred)
    if(navigator.geolocation) {
      browserSupportFlag = true;
      navigator.geolocation.getCurrentPosition(function(position) {
        initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
        map.setCenter(initialLocation);
      }, function() {
        handleNoGeolocation(browserSupportFlag);
      });
    }  
    
    $('.gmap-address').each(function() {
    
      var geocoder;
      var address = this.value;
      var title = $(this).parent().parent().html();
      geocoder = new google.maps.Geocoder();
      geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location,
            animation: google.maps.Animation.DROP
          });
          google.maps.event.addListener(marker, 'click', function() {
          		infowindow.setContent(title);
          		infowindow.open(map, marker);
      	  });  
        } 
      });
     
    });
  }

	
		$('body').on('click','.searchbtn', function(e) {
			passing_data($(this));
			return false;
		});
	
		$('body').on('click','.pagievent', function(e) {
			var pagenumber =  $(this).attr('id');
			var formid = $('#curform').val();
			pagination_ajax(pagenumber, formid);
			return false;
		});

		$('body').on('keypress','.awpqsftext',function(e) {
		
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
				        
				        //$('#cust-search-map').html('');
				        $('#cust-search-map').show();
				        $('#cust-search-text').hide();
				        $(''+ajxdiv+'').html(html);
				        gmap_initialize(); 
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
				  
				  //$('#cust-search-map').html('');
				  $('#cust-search-map').show();
				  $('#cust-search-text').hide();
				  $(''+ajxdiv+'').html(html);
				  gmap_initialize();
				
				//res.container.find(res.loader).remove();
				 }
				 });
		}
		
	 $('body').on('click', '.awpsfcheckall',function () {
	
	    $(this).closest('.togglecheck').find('input:checkbox').prop('checked', this.checked);
		
         });



});//end of script
