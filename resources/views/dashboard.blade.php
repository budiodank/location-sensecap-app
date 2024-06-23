@extends('layouts.app')
@section('title', 'Mapbox Dashboard')
@push('style')
<link rel="stylesheet" type="text/css" href="/assets/src/plugins/mapbox/mapbox.css" />
<script src="/assets/src/plugins/mapbox/mapbox.js"></script>
<!-- <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script> -->
<script src="/assets/src/scripts/stomp.min.js"></script>
<style>
    #map {
        width: 100%;
        height: 400px;
    }

    .marker {
        background-image: url('/assets/src/images/icon-marker.png');
        background-size: cover;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
    }

    .mapboxgl-popup {
        max-width: 200px;
    }

    .mapboxgl-popup-content {
        text-align: center;
    }
</style>
@endpush
@section('content')
<div class="xs-pd-20-10 pd-ltr-20">
    <div class="title pb-20">
        <h2 class="h3 mb-0">Location Overview</h2>
    </div>

    <!-- <div class="row pb-10">
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">Sunday</div>
                        <div class="font-14 text-secondary weight-500">
                            12 May 2024
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#00eccf">
                            <i class="icon-copy dw dw-calendar1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">1</div>
                        <div class="font-14 text-secondary weight-500">
                            Device
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#ff5b5b">
                            <span class="icon-copy ti-heart"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">1h ago</div>
                        <div class="font-14 text-secondary weight-500">
                            Last Update
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon">
                            <i class="icon-copy fa fa-stethoscope" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">31000</div>
                        <div class="font-14 text-secondary weight-500">Data Receive</div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#09cc06">
                            <i class="icon-copy fa fa-money" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="card-box pb-10">
        <div class="h5 pd-20 mb-0">Recent Location</div>
        <div id="map"></div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        // getDataLocation()
        // Running Pusher
        // Pusher.logToConsole = true;

        // var pusher = new Pusher('YOUR_PUSHER_ACCESS', {
        //     cluster: 'ap1'
        // });

        // var channel = pusher.subscribe('locations');
        // channel.bind('location-event', function(data) {
        //     console.log("data : " + JSON.stringify(data));
        // });

        // Running Web Stomp
        connect()
        // var ws = new WebSocket('ws://127.0.0.1:15674/ws');
        // var client = Stomp.over(ws);

        // // Melakukan koneksi ke RabbitMQ
        // client.connect('YOUR_RABBITMQ_USERNAME', 'YOUR_RABBITMQ_PASSWORD', function(frame) {
        //     console.log('Connected: ' + frame);

        //     // Melakukan subscribe ke topik
        //     client.subscribe('/topic/location.notifications.4197', function(message) {
        //         console.log('message : ' + message.body);
        //         let messageBody = message.body;
        //         // create a HTML element for each feature
        //         const el = document.createElement('div');
        //         el.className = 'marker';

        //         // make a marker for each feature and add it to the map
        //         new mapboxgl.Marker(el)
        //             .setLngLat([messageBody.longitude, messageBody.latitude])
        //             .setPopup(
        //                 new mapboxgl.Popup({
        //                     offset: 25
        //                 }) // add popups
        //                 .setHTML(
        //                     `<h5>${messageBody.device.device_name}</h5><p>${messageBody.device.online_status}</p><p>${feature.create_time}</p>`
        //                 )
        //             )
        //             .addTo(map);
        //     });
        // }, function(error) {
        //     console.error('Error: ' + error);
        // });
    });
    mapboxgl.accessToken = 'YOUR_MAPBOX_ACCESS';

    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [106.95, -5.76], // Starting position [lng, lat]
        zoom: 6 // Starting zoom level
    });

    let geoJSON = [];

    function getDataLocation() {
        const data = {
            device_eui: '2CF7F1C0530003E4'
        }
        $.ajax({
            type: 'POST',
            url: `/apis/transaction/location/show-device`,
            data: JSON.stringify(data),
            dataType: 'JSON',
            contentType: "application/json; charset=utf-8",
            success: function(res) {
                $.each(res.result, function(index, item) {
                    let location = {
                        device_name: item.device.device_name,
                        coordinates: [item.longitude, item.latitude],
                        create_time: item.created_tm,
                        online_status: item.device.online_status
                    }
                    geoJSON.push(location)
                })
                setMarkerMap()
            },
            error: function(xhr, status, error) {
                errorMessage(xhr, status, error)
            }
        });
    }

    function setMarkerMap() {
        // add markers to map
        for (const feature of geoJSON) {
            // create a HTML element for each feature
            const el = document.createElement('div');
            el.className = 'marker';

            // make a marker for each feature and add it to the map
            new mapboxgl.Marker(el)
                .setLngLat(feature.coordinates)
                .setPopup(
                    new mapboxgl.Popup({
                        offset: 25
                    }) // add popups
                    .setHTML(
                        `<h5>${feature.device_name}</h5><p>${feature.online_status}</p><p>${feature.create_time}</p>`
                    )
                )
                .addTo(map);
        }
    }

    let stompClient = null;

    function connect() {
        var ws = new WebSocket('ws://127.0.0.1:15674/ws');
        stompClient = Stomp.over(ws);

        stompClient.connect('YOUR_RABBITMQ_USERNAME', 'YOUR_RABBITMQ_PASSWORD', function(frame) {
            // Melakukan subscribe ke topik
            stompClient.subscribe('/topic/location.notifications.4197', function(message) {
                let messageBody = message.body;
                // create a HTML element for each feature
                const el = document.createElement('div');
                el.className = 'marker';

                // make a marker for each feature and add it to the map
                new mapboxgl.Marker(el)
                    .setLngLat([messageBody.longitude, messageBody.latitude])
                    .setPopup(
                        new mapboxgl.Popup({
                            offset: 25
                        }) // add popups
                        .setHTML(
                            `<h5>${messageBody.device.device_name}</h5><p>${messageBody.device.online_status}</p><p>${feature.create_time}</p>`
                        )
                    )
                    .addTo(map);
            });
        }, function(error) {
            console.error('STOMP error: ' + error);
            setTimeout(connect, 5000); // Try to reconnect every 5 seconds
        });

        ws.onclose = function() {
            console.warn('Socket closed. Reconnecting in 5 seconds...');
            setTimeout(connect, 5000); // Try to reconnect every 5 seconds
        };
    }

    window.onbeforeunload = function() {
        if (stompClient !== null) {
            stompClient.disconnect();
        }
    };
</script>
@endpush