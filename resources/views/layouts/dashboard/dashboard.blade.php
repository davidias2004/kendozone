<?php
$tournamentsCreated = Auth::user()->tournaments;
$tournamentsParticipated = Auth::user()->getMyTournaments();
?>
<div class="row">
    <div class="col-md-6">
        <div class="row ml-5 mr-10">
            <div class="panel panel-body">
                <fieldset title="{{Lang::get('crud.venue')}}">
                    <legend class="text-semibold">TORNEOS CREADOS</legend>
                </fieldset>

                    <table width="100%">
                        @foreach($tournamentsCreated->sortByDesc('created_at')->take(3) as $tournament)
                            <tr class="dashboard-table">
                                <td width="80%">{{$tournament->name}}</td>
                                <td width="20%" align="right"><a
                                            class="btn text-success border-success border-4 pl-20 pr-20 "
                                            href="{!! URL::action('TournamentController@edit', $tournament->slug) !!}">EDIT</a>
                                </td>
                            </tr>
                        @endforeach

                    </table>
                    <div align="right" class="mt-20 pt-20">
                        <a class="btn text-primary border-primary border-4 text-uppercase "
                           href="{!! URL::to('tournaments')!!}">{{trans('core.see_all')}}</a>
                    </div>



            </div>
        </div>
        <div class="row ml-5 mr-10">
            <div class="panel panel-body">
                <fieldset title="MIS TORNEOS">
                    <legend class="text-semibold">REGISTROS EN TORNEOS</legend>
                </fieldset>
                @if (sizeof($tournamentsParticipated) == 0)
                    <div class="mt-20 mb-20 pt-20 pb-20 text-center">{{ trans('crud.no_tournament_registered_yet') }}</div>
                    <div class="text-center pb-20">
                        <a href="{!! URL::action('TournamentController@create') !!}" type="button"
                           class="btn border-primary btn-flat text-primary disabled text-uppercase p-10 ">{{ trans('core.see_open_tournaments') }}
                            {{--( {{trans('core.soon')}} )--}}
                        </a>
                    </div>

                @else
                    <table width="100%">


                        @foreach($tournamentsParticipated as $tournament)

                            <tr class="dashboard-table" height="100px" valign="middle">
                                <td width="80%">{{$tournament->name}}</td>
                                <td width="20%" align="right"><a
                                            class="btn text-success border-success border-4 pl-20 pr-20 "
                                            @if(Auth::user()->isSuperAdmin() || Auth::user()->owns($tournament))
                                            href="{!! URL::action('TournamentController@edit', $tournament->slug) !!}">EDIT</a>
                                    @else
                                        {{--TODO Permission problems--}}
                                        href="{!! URL::action('TournamentController@show', $tournament->slug) !!}
                                        ">VER</a>
                                    @endif
                                </td>
                            </tr>

                        @endforeach
                    </table>

                    <div align="right" class="mt-20 pt-20">
                        <a class="btn text-primary border-primary border-4 text-uppercase "
                           href="#">{{trans('core.see_all')}}</a>
                    </div>
                @endif


            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="panel panel-body">
                <fieldset title="NUMEROS">
                    <legend class="text-semibold">NUMEROS</legend>
                </fieldset>
                <div class="row">
                    <div class="col-lg-6">

                        <div class="square bg-nav">{{ $tournamentsCreated->count() }}
                            <div class="text-size-large text-uppercase">creados</div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="square bg-secondary">{{ $tournamentsParticipated->count()  }}
                            <div class="text-size-large text-uppercase">Participaciones</div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="square bg-primary">{{ $tournamentsCreated->where('dateFin','<', new \DateTime('today'))->count() }}
                            <div class="text-size-large text-uppercase">Pasados</div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="square bg-success">{{ $tournamentsCreated->where('dateFin','>=', new \DateTime('today'))->count() }}
                            <div class="text-size-large text-uppercase">Próximos</div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="row">
            <div class="panel panel-body">

                <fieldset title="ULTIMOS MENSAJES">
                    <legend class="text-semibold">ULTIMAS NOTIFICACIONES</legend>
                </fieldset>


                <ul class="media-list">
                    <li class="media">
                        <div class="media-left">
                            <img src="/images/demo/users/face10.jpg" class="img-circle img-xs" alt="">
                            {{--<span class="badge bg-danger-400 media-badge">8</span>--}}
                        </div>

                        <div class="media-body">
                            <a href="index.html#">
                                Jesus Maya
                                <span class="media-annotation pull-right">14:58</span>
                            </a>

                            <span class="display-block text-muted">Practica en Amecameca mañana... 4 horas de geiko para que se les quite lo p...</span>
                        </div>
                    </li>

                    <li class="media">
                        <div class="media-left">
                            <img src="/images/demo/users/face3.jpg" class="img-circle img-xs" alt="">
                        </div>

                        <div class="media-body">
                            <a href="index.html#">
                                FMK
                                <span class="media-annotation pull-right">12:16</span>
                            </a>

                            <span class="display-block text-muted">¡Examen de Iaido! No se apendejen!!!</span>
                        </div>
                    </li>


                </ul>

                <div align="right" class="pt-20">
                    <a class="btn text-primary border-primary border-4 text-uppercase "
                       href="#">{{trans('core.see_all')}}</a>
                </div>

            </div>
        </div>
    </div>

</div>