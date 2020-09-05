    
    addressData =  $('#address').val();

            function initialize() {
            var input = document.getElementById('address');
                    new google.maps.places.Autocomplete(input);
            }

             google.maps.event.addDomListener(window, 'load', initialize);
          
    $( document ).ready(function() {
        if ("geolocation" in navigator){
            navigator.geolocation.getCurrentPosition(function(position){
              //console.log(position);
              var currentLatitude = position.coords.latitude;
              var currentLongitude = position.coords.longitude;
              //position[0].address_components[0]
                 if(addressData == ''){
                   initializeCurrent(currentLatitude,currentLongitude)
                 }
            });
        }else{
            console.log("i am not acivate");
        }
    });

    $('#address').on('change',function(e){
        var geocoder = new google.maps.Geocoder();
        var address = $(this).val();
        geocoder.geocode( { 'address': address}, function(results, status) {

          if (status == google.maps.GeocoderStatus.OK) {
            $('#latitude').val(results[0].geometry.location.lat());
            $('#longitude').val(results[0].geometry.location.lng());
          }

        }); 

    });

    if(addressData){
        var geocoder = new google.maps.Geocoder();
        var address = addressData;
        geocoder.geocode( { 'address': address}, function(results, status) {

          if (status == google.maps.GeocoderStatus.OK) {
            $('#latitude').val(results[0].geometry.location.lat());
            $('#longitude').val(results[0].geometry.location.lng());
          }

        }); 
    }

      function initializeCurrent(latcurr, longcurr) {
        currgeocoder = new google.maps.Geocoder();
        if (latcurr != '' && longcurr != '') {
          var myLatlng = new google.maps.LatLng(latcurr, longcurr);
          $('#latitude').val(latcurr);
          $('#longitude').val(longcurr);
          return getCurrentAddress(myLatlng);
        }
      }

function getCurrentAddress(location) {
  currgeocoder.geocode({
  'location': location
  }, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      console.log(results[0].formatted_address);
      if($('#address').val() == ''){
        $('#address').val(results[0].formatted_address)
      }
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}
