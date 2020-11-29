@extends('layout')
@section('main')

    <table class="table">
        <thead>
        <tr>
            <th>Map</th>
            <th>Name</th>
            <th>Status</th>
            <th>Players</th>
            <th>Created</th>
            <th>Last Update</th>
            <th>Details</th>
        </tr>
        </thead>
        @foreach( $maps as $session)
        <tr class="border-bottom">
            <td class="p-0 text-center bg-dark">
                <img width="64" src="https://www.realitymod.com/mapgallery/images/maps/{{ str_replace(' ','',strtolower($session->mapname)) }}/mapoverview_{{ $session->gametype }}_{{ $session->mapsize }}.jpg">
            </td>
            <td>
                <h4 class="p-0 font-weight-bold">{{ $session->mapname }}</h4>
                <code>{{ $session->gametype }}</code>
            </td>
            <td>
                @include('blocks.mapstatus')
            </td>
            <td>
                {{ $session->numplayers }} /
                {{ $session->maxplayers }}
            </td>
            <td>{{ $session->created_at->format(env('DATE_FORMAT')) }} <br><small> {{ $session->created_at->diffForHumans() }}</small></td>
            <td>{{ $session->updated_at->format(env('DATE_FORMAT')) }} <br><small> {{ $session->updated_at->diffForHumans() }}</small></td>
            <td>
                <a class="btn btn-primary" href="/session/{{ $session->id }}">View</a>
            </td>
        </tr>
        @endforeach
    </table>

@endsection
