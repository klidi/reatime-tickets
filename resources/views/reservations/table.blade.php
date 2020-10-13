<div class="table-responsive">
    <table class="table" id="clearance-table">
        <thead>
        <tr>
            <th>Reservation id</th>
            <th>Clearance Level</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($reservations as $reservation)
        <tr>
            <td>{{ $reservation->id }}</td>
            <td>{{ $reservation->clearance }}</td>
            <td>
                <div class='btn-group'>
                    <a href="" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
