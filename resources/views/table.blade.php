<div class="table-responsive">
    <table class="table" id="clearance-table">
        <thead>
            <tr>
                <th>Clearance level</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($clearances as $clearance)
            <tr>
                <td>{{ $clearance }}</td>
                <td>
                    <div class='btn-group'>
                        <span onclick="reserveClearance({{$clearance}})" class='btn btn-default btn-xs reserve-btn'><i class="glyphicon glyphicon-ok"></i></span>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
