@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 list">
                <a href="{{route('device.create')}}" role="button" class="btn btn-primary mb-4">Add device</a>
                <ul class="list-group">
                    @foreach($devices as $device)
                        <li class="list-group-item ">{{$device->name}}</li>
                    @endforeach
                </ul>
                <br>
                <div>
                    <P><b>Max distance: </b>{{$range['distance']}}Km. From {{$range['from_name']}} to {{$range['to_name']}} </P>
                </div>
            </div>
            <div class="col map">
                <div id="map"></div>
            </div>
        </div>
    </div>
    <script>
         var app = @json($devices);
         var address = @json($address);
         var lat = app[0].latitude;
         var lng = app[0].longitude;

         var map = new google.maps.Map(document.getElementById('map'), {
             zoom: 11,
             center: {lat: lat, lng: lng}
         });

         var marker = new google.maps.Marker({
            position: {
                lat: lat,
                lng: lng
            },
            map: map
        });

         var contentString = '<div id="content" style="height: 100px"><div id="siteNotice"></div>'+
             '<h5>Device ID: '+app[0].name+'</h5>'+
             '<h5>Place: '+app[0].place+'</h5>'+
             '<p><b>Address: </b>'+address+'</p>'+
             '</div>';

         var infowindow = new google.maps.InfoWindow({
             content: contentString
         });

         marker.addListener('click', function() {
             infowindow.open(map, marker);
         });

    </script>

@endsection