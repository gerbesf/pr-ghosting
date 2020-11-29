@extends('layout')
@section('main')
    <meta http-equiv="refresh" content="20; URL='{{ env('APP_URL') }}session/{{ $session->id }}'"/>

    <div class="p-3">

        <a href="/">Back</a>

    </div>
    <div class="card card-body">

        <div class="row">
            <div class="col-md-6">
                <h3>{{ $session->mapname }}</h3>

                <h5>
                    {{ $session->numplayers }} /
                    {{ $session->maxplayers }}
                </h5>
            </div>
            <div class="col-md-6">
                @include('blocks.mapstatus')
                <div>
                    Started: {{ $session->created_at->format(env('DATE_FORMAT')) }}
                </div>
                <div>
                    Updated: {{ $session->updated_at->format(env('DATE_FORMAT')) }}  - {{ $session->updated_at->diffForHumans() }}
                </div>
            </div>
        </div>



        {{--  <div>
              Rendered: {{ \Carbon\Carbon::now()->format(env('DATE_FORMAT')) }} - {{ \Carbon\Carbon::now()->diffForHumans() }}
          </div>--}}

    </div>
    <br>

    <div class="card card-body">

        @if(count($playersd)==0)
            <div>Server is empty</div>
        @endif

        <div class="row">

            @foreach($playersd as $team => $players)

                <div class="col-md-6">

                    <h4>Team: #{{ $team }}</h4>
                    <p>Players: {{ count($players) }}</p>
                    <table class="table table-sm table-hover small">
                        <thead>
                        <tr>
                            <td>Clan</td>
                            <td>Nick</td>
                            <td>Tags</td>
                            <td>Online</td>
                            <td>Change</td>
                        </tr>
                        </thead>
                        @foreach($players as $player)
                            <tr @if($player->changed) class="table-danger" @endif>
                                <td class="font-weight-normal text-center px-0">{{ $player->clan }}</td>
                                <td class="font-weight-normal px-0">
                                    {{ $player->nickname }}

                                    @if($player->profile['steam_level']==0)
                                        <span class="badge badge-danger float-right">  High </span>
                                    @endif
                                    @if($player->profile['steam_level']==1)
                                        <span class="badge badge-info float-right"> Medium </span>
                                    @endif
                                    @if($player->profile['steam_level']==2)
                                        <span class="badge badge-info float-right">Low</span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        @if( is_array($player->profile['steam_tags']))
                                            @foreach($player->profile['steam_tags'] as $tag)

                                                @if($tag=="vac banned")

                                                    <small class="badge badge-danger" title="VAC Bannes">VAC</small>

                                                @elseif($tag=="legacy")

                                                    <small class="badge badge-success" title="Legacy Account"> LG</small>
                                                @elseif($tag=="whitelisted")

                                                    <small class="badge badge-light" title="Whitelisted">WL</small>
                                                @else
                                                    <small class="badge badge-light"> {{ $tag }}</small>

                                                @endif

                                            @endforeach
                                        @endif
                                    </div>
                                </td>
                                @if($player->online)
                                    <td>{{ $player->created_at->diffInMinutes() }}min</td>
                                @else
                                    <td><span class="badge badge-danger">OFFLINE</span> </td>
                                @endif
                                <td class="p-0 text-center">
                                    <div>
                                        @if($player->changed)
                                            <a href="/session/{{ $player->id_session }}/trust/{{ $player->profile_index }}" class="btn btn-sm py-0 btn-dark"> Cancel Alarm</a>
                                        @endif
                                    </div>
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
