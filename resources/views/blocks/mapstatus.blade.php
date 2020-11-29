
<div>
    @if($session->status == 'running')
        <span class="badge badge-success">Running</span>
    @endif
    @if($session->status == 'terminated')
        <span class="badge badge-danger">Finished</span>
    @endif
    @if($session->status == 'invalid')
        <span class="badge badge-light">Empty</span>
    @endif
    @if($session->status == 'inative')
        <span class="badge badge-light">Inative</span>
    @endif
    @if($session->status == 'offline')
        <span class="badge badge-danger">Offline</span>
    @endif
</div>
