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
        @foreach( $maps as $map)
        <tr>
            <td>{{ $map->mapname }}</td>
            <td>{{ $map->gametype }}</td>
            <td>{{ $map->status }}</td>
            <td>{{ $map->created_at->format(env('DATE_FORMAT')) }}  - {{ $map->created_at->diffForHumans() }}</td>
            <td>{{ $map->updated_at->format(env('DATE_FORMAT')) }}  - {{ $map->updated_at->diffForHumans() }}</td>
            <td>
                <a href="/session/{{ $map->id }}">View</a>
            </td>
        </tr>
        @endforeach
    </table>

@endsection
