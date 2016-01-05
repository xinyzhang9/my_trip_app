
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Index</title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<style type ="text/css">
  body{
    margin: 20px
  }
	input{
		display: inline-block;
		margin: 0 10px 10px 0;
	}
  #map {
        width: 300px;
        height: 200px;
        margin: 10px 10px 10px 0;
        vertical-align: top;
        display: inline-block;
        border: 1px solid silver;
        border-radius: 20px;
        padding: 20px;
      }

	.block{
		width: 350px;
		margin: 10px 10px 10px 0;
		vertical-align: top;
		display: inline-block;
		border: 1px solid silver;
		border-radius: 20px;
		padding: 20px;
		
	}
  .block_small{
    width: 350px;
    height: 385px;
    margin: 10px 10px 10px 0;
    vertical-align: top;
    display: inline-block;
    border: 1px solid silver;
    border-radius: 20px;
    padding: 20px;
    
  }
  h4{
    color: green;
  }
	</style>
	<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>

   	<script>
      $(document).ready(function(){
        //direction
        $('form.direction').submit(function() {
          // load up any gif you want, this will be shown while user is waiting for response
          $('#results_direction').html("<img src='assets/loading.gif'>");
          $.post($(this).attr('action'), $(this).serialize(), function(res) {
            var html_str = "";
            for (var i = 0; i < res.routes[0].legs[0].steps.length; i++) {
              html_str+="<p>"+(i+1)+": "+ res.routes[0].legs[0].steps[i].html_instructions +"</p>";
            };
              
            $('#results_direction').html(html_str);
          }, 'json');
          // don't forget, without it the page will refresh
          return false;
        });


        //geocode
        $('#get_direction').click(function(){
          $.post("/main/geocode_start", $('form.direction').serialize(), function(res) {
            
              $('#start_latitude').val(res.results[0].geometry.location.lat);
              $('#start_longitude').val(res.results[0].geometry.location.lng);
          }, 'json');

          $.post("/main/geocode_end", $('form.direction').serialize(), function(res) {
            
              $('#end_latitude').val(res.results[0].geometry.location.lat);
              $('#end_longitude').val(res.results[0].geometry.location.lng);
          }, 'json');
          // if I don't remove the following line, it will not display direction()
          // return false;
          
        });

        //google is not defined???
        // $('#add_marker').click(add_marker($('#start_latitude').val(),$('#start_longitude').val()));

        $('#get_price').click(function() {
          // load up any gif you want, this will be shown while user is waiting for response
          $('#results_price').html("<img src='assets/loading.gif'>");
          $.post("/main/get_price", $('form.geo').serialize(), function(res) {
            var html_str = "<h2>Price Estimates</h2><hr>";
              if(res.message){
                html_str+="<p><b>Message:</b> "+res.message+"</p>";
              }
              else{
                for (var i = 0; i < res.prices.length; i++) {
                  html_str+="<h4>Option "+(i+1)+"</h4>"
                  html_str+="<p><b>currency_code</b>: "+res.prices[i].currency_code+"</p>";
                  html_str+="<p><b>display_name</b>: "+res.prices[i].display_name+"</p>";
                  html_str+="<p><b>estimate</b>: "+res.prices[i].estimate+"</p>";
                  html_str+="<p><b>minimum</b>: "+res.prices[i].minimum+"</p>";
                  html_str+="<p><b>product_id</b>: "+res.prices[i].product_id+"</p>";
                  html_str+="<hr>";
                  
                };
              }
              
            $('#results_price').html(html_str);
          }, 'json');
          // don't forget, without it the page will refresh
          return false;
        });

        $('#get_time').click(function() {
          // load up any gif you want, this will be shown while user is waiting for response
          $('#results_time').html("<img src='assets/loading.gif'>");
          $.post("/main/get_time", $('form.geo').serialize(), function(res) {
            var html_str = "<h2>Time Estimates</h2><hr>";
              if(res.message){
                html_str+="<p><b>Message:</b> "+res.message+"</p>";
              }
              else{
                for (var i = 0; i < res.times.length; i++) {
                  html_str+="<h4>Option "+(i+1)+"</h4>"
                  html_str+="<p><b>display_name</b>: "+res.times[i].display_name+"</p>";
                  html_str+="<p><b>estimate</b>: "+Math.round((res.times[i].estimate)/60)+ " minutes</p>";
                  html_str+="<p><b>product_id</b>: "+res.times[i].product_id+"</p>";
                  html_str+="<hr>";
                  
                };
              }
              
            $('#results_time').html(html_str);
          }, 'json');
          // don't forget, without it the page will refresh
          return false;
        });

      $('#get_product').click(function() {
          // load up any gif you want, this will be shown while user is waiting for response
          $('#results_product').html("<img src='assets/loading.gif'>");
          $.post("/main/get_product", $('form.geo').serialize(), function(res) {

            var html_str = "<h2>Available Products</h2><hr>";
              if(res.message){
                html_str+="<p><b>Message:</b> "+res.message+"</p>";
              }
              else{
                for (var i = 0; i < res.products.length; i++) {
                  html_str+="<h4>Option "+(i+1)+"</h4>"
                  html_str+="<p><b>capacity</b>: "+res.products[i].capacity+"</p>";
                  html_str+="<p><b>product_id</b>: "+res.products[i].product_id+"</p>";
                  html_str+="<p><b>description</b>: "+res.products[i].description+"</p>";
                  html_str+="<p><b>cost_per_minute</b>: "+res.products[i].price_details.cost_per_minute+"</p>";
                  html_str+="<p><b>cost_per_distance</b>: "+res.products[i].price_details.cost_per_distance+"</p>";
                  html_str+="<p><b>base</b>: "+res.products[i].price_details.base+"</p>";
                  html_str+="<p><b>cancellation_fee</b>: "+res.products[i].price_details.cancellation_fee+"</p>";
                  html_str+="<hr>";
                  
                };
              }
            $('#results_product').html(html_str);
          }, 'json');
          // don't forget, without it the page will refresh
          return false;
        });

        $('#get_weather').click(function(){
            // load up any gif you want, this will be shown while user is waiting for response
            $('#results_weather').html("<img src='assets/loading.gif'>");
            $.post("/main/get_weather", $('form.direction').serialize(), function(res) {
              var html_str = "<h4>Weather Information</h4>";
              if(res.message){
                html_str+="<p><b>Message:</b> "+res.message+"</p>";
              }else{
                html_str+="<p> <b>Name:</b> "+res.name+"</p>";
                html_str+="<p> <b>Description:</b> "+res.weather[0].description+"</p>";
                html_str+="<p> <b>Temperature:</b> "+res.main.temp+"</p>";
                html_str+="<p> <b>Humidity:</b> "+res.main.humidity+"</p>";
              }
              $('#results_weather').html(html_str);
            }, 'json');
            // don't forget, without it the page will refresh
            return false;
        })

      });//document ready
    </script>
</head>
<body>
  
  <script>
  function initMap() {
  var myLatLng = {lat: 37.34, lng: -122};

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 4,
    center: myLatLng
  });

  var marker = new google.maps.Marker({
    position: myLatLng,
    map: map,
    title: 'Hello World!'
  });
}

function add_marker(lat,lng){
   var myLatlng = new google.maps.LatLng(lat,lng);
    var mapOptions = {
       zoom: 4,
       center: myLatlng
    }
    var map = new google.maps.Map(document.getElementById("map"), mapOptions);

    var marker = new google.maps.Marker({
          position: myLatlng,
          title:"start point"
        });
        // To add the marker to the map, call setMap();
        marker.setMap(map);
}

  </script>
  
    

    <div id = "search">
      <form class = 'direction' action="/main/direction" method = "post">
        <fieldset>
        <legend>Direction:</legend>
        <label for="origin">From: </label>
        <input type="text" name = "origin" id = "origin">
        <label for="destination">To: </label>
        <input type="text" name = "destination" id = "destination">
        <input type="submit" id = "get_direction" class = 'btn btn-success' value = "Get direction"> 
      </fieldset>
      </form>
    </div>

    <div id = "results_geo">
      <form class = "geo">
        <label for="start_latitude">start latitude: </label>
        <input type="text" name = "start_latitude" id = "start_latitude">
        <label for="start_longitude">start longitude: </label>
        <input type="text" name = "start_longitude" id = "start_longitude">

        <label for="end_latitude">end latitude: </label>
        <input type="text" name = "end_latitude" id = "end_latitude">
        <label for="end_longitude">end longitude: </label>
        <input type="text" name = "end_longitude" id = "end_longitude">
        <br>
        <input type="button" id = "get_price" class = "btn btn-info" value = "get price from uber">
<!--         <input type="button" id = "add_marker" class = "btn btn-warning" value = "add marker">
 -->
        <input type="button" id = "get_time" class = "btn btn-success" value = "get time from uber">
        <input type="button" id = "get_product" class = "btn btn-warning" value = "get product from uber">
        <input type="button" id = "get_weather" class = "btn btn-danger" value = "get weather of destination">

      </form>
    </div>
    <div id = "map">
    </div>
    <div id = "results_weather" class = "block"></div>

    <div id = "results_direction"></div>
    <div id = "results_price" class = "block"></div> 
    <div id = "results_time" class = "block"></div>   
    <div id = "results_product" class = "block"></div>  

    <script src="https://maps.googleapis.com/maps/api/js?signed_in=true&callback=initMap&sensor=false&key=AIzaSyBtg6vAefdIUTyG4qbysXi31a1tf6jIXQQ"
        async defer>
  </script>
    
  </body>
</html>