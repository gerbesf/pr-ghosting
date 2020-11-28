@extends('layout')
@section('main')

    <table class="table">
        <thead>
        <tr>
            <th>Map Name</th>
            <th>Game Type</th>
            <th>Status</th>
            <th>Created</th>
            <th>Last Update</th>
            <th></th>
        </tr>
        </thead>
        @foreach( $maps as $session)
        <tr>
            <td>{{ $session->mapname }}</td>
            <td>{{ $session->gametype }}</td>
            <td>
                @if($session->status == 'running')
                    <span class="badge badge-success">Running</span>
                @endif
                @if($session->status == 'terminated')
                    <span class="badge badge-danger">Finished</span>
                @endif
                @if($session->status == 'invalid')
                    <span class="badge badge-light">Empty</span>
                @endif
                @if($session->status == 'offline')
                    <span class="badge badge-danger">Offline</span>
                @endif
            </td>
            <td>{{ $session->created_at->format(env('DATE_FORMAT')) }}  - {{ $session->created_at->diffForHumans() }}</td>
            <td>{{ $session->updated_at->format(env('DATE_FORMAT')) }}  - {{ $session->updated_at->diffForHumans() }}</td>
            <td>
                <a href="/session/{{ $session->id }}">View</a>
            </td>
        </tr>
        @endforeach
    </table>

@endsection
