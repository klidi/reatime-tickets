@extends('layouts.app')

@section('content')
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="box box-primary">
        <div class="box-body">
            @include('table')
        </div>
    </div>
    <div class="text-center">

    </div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
<script type="text/javascript">
    var socket = io.connect('ws://127.0.0.1:1215', {transports: ['websocket']});

    socket.on("connected", function(data) {
        console.log('connected');
    });

    socket.on('levelChanges', function(data) {
        // this is here for testing purpose so you can notice the change in realtime
        alert('there is a change to clearance levels, dont refresh lines will be added in real time');
        //let uniqueData = data.filter(value => !clearances.includes(value));
        let tableBody = document.getElementsByTagName('tbody')[0];
        deleteTableRows(tableBody);
        appendToTable(data, tableBody);
    });

    socket.on('reservationCompleted', function (data) {
        alert('Reservation completed');
        alert('there is a change to clearance levels, dont refresh lines will be added in real time');
        let tableBody = document.getElementsByTagName('tbody')[0];
        deleteTableRows(tableBody);
        appendToTable(data, tableBody);
    });

    function appendToTable(data, tableBody) {
        data.forEach(function(item) {
            const row = document.createElement('tr');

            let td = document.createElement('td');
            let text = document.createTextNode(item);
            td.appendChild(text);
            row.appendChild(td);

            let tdAction = document.createElement('td');
            let div = document.createElement('div');
            div.classList.add('btn-group');
            div.innerHTML = '<span onclick="reserveClearance(' + item + ')" class="btn btn-default btn-xs reserve-btn"><i class="glyphicon glyphicon-ok"></i></span>';
            tdAction.appendChild(div);

            row.appendChild(tdAction);

            tableBody.appendChild(row);
        });
    }

    function deleteTableRows(tableBody)
    {
        tableBody.innerHTML = '';
    }

    function reserveClearance(clearanceValue) {
        socket.emit('makeReservation', clearanceValue);
    }
</script>
@endsection
