@extends('layout')
@section('main')

    <a href="/">Back</a>

    <h3>{{ $session->mapname }}</h3>
    <div>
        Mapname: {{ $session->mapname }}
    </div>
    <div>
        Gametype: {{ $session->gametype }}
    </div>
    <div>
        Status: {{ $session->status }}
        @if($session->status == 'running')
            <span class="badge badge-success">Running</span>
        @endif
        @if($session->status == 'terminated')
            <span class="badge badge-danger">Finished</span>
        @endif
        @if($session->status == 'invalid')
            <span class="badge badge-light">Empty</span>
        @endif
    </div>
    <div>
        Created: {{ $session->created_at->format(env('DATE_FORMAT')) }}  - {{ $session->created_at->diffForHumans() }}
    </div>
    <div>
        Updated: {{ $session->updated_at->format(env('DATE_FORMAT')) }}  - {{ $session->updated_at->diffForHumans() }}
    </div>

    <br>

    <div class="card card-body">
        <div class="row">

        @foreach($playersd as $team => $players)

            <div class="col-6">

                <h4>Team: #{{ $team }}</h4>
                <p>Players: {{ count($players) }}</p>
                <table class="table table-sm table-hover ">
                    @foreach($players as $player)
                    <tr @if($player->changed) class="table-danger" @endif>
                        <td class="font-weight-bold">{{ $player->nickname }}</td>
                        <td>
                            @if($player->changed)
                                <span class="badge badge-warning">has change</span>
                            @endif
                        </td>
                        <td class="text-right">
                            @if($player->changed)
                            <a href="#" class="btn btn-sm btn-light"> Fake Alarm </a>
                            @else
                                <span class="text-success">Trustworthy</span>
                            @endif
                        </td>
                        <td>
                            @if($player->online)
                                <span class="badge badge-success">ONLINE</span>
                            @else
                                <span class="badge badge-danger">OFFLINE</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        {{--
          --}}
        @endforeach
        </div>
    </div>

@endsection
