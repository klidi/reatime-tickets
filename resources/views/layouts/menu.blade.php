<li class="{{ Request::is('tickets*') ? 'active' : '' }}">
    @role('admin')
    <a href="{{ route('tickets.index') }}"><i class="fa fa-edit"></i><span>Tickets</span></a>
    @endrole
</li>
<li class="{{ Request::is('reservations*') ? 'active' : '' }}">
    @role('user')
    <a href="{{ route('reservations.index') }}"><i class="fa fa-edit"></i><span>Reservations</span></a>
    @endrole
</li>

