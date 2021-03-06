@extends('layouts.dashboard')
@section('title')
    <title>{{ trans_choice('core.tree',2) }}</title>
@stop

@section('styles')
    {!! Html::style('css/pages/trees.css')!!}
@stop

@section('breadcrumbs')
    {!! Breadcrumbs::render('trees.index', $tournament) !!}
@stop

@section('content')

    <div class="container-detached">

        <div class="content-detached">
            @include('layouts.tree.topTree')
            <ul class="nav nav-tabs nav-tabs-solid nav-justified trees">
                @foreach($tournament->championships as $championship)
                    <li class={{ $loop->first ? "active" : "" }}>
                        <a href="#{{$championship->id}}" data-toggle="tab"
                           id="tab{{$championship->id}}">{{$championship->buildName()}}</a>
                    </li>

                @endforeach
            </ul>

            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="container-fluid">
                        <div class="tab-content">
                            @foreach($tournament->championships as $championship)
                                <div class="tab-pane {{ $loop->first ? "active" : "" }}" id="{{$championship->id}}">
                                    <h1> {{$championship->buildName()}}
                                        <a href="{{URL::action('PDFController@tree', ['championship'=> $championship->id]) }}"
                                           target="_blank"
                                           class="btn bg-teal btn-xs btnPrint pull-right ml-10 mt-5">
                                            <i class="icon-printer"></i>
                                        </a>

                                        @if (Auth::user()->can('store', [App\FightersGroup::class, $tournament]))

                                            {!! Form::close() !!}

                                            {!! Form::open(
                                                ['method' => 'POST', 'id' => 'storeTree', 'class'=> 'pull-right',
                                                 'data-gen' => $championship->fightersGroups->count(),
                                                'action' => ['TreeController@store', $championship->id]]) !!}

                                            <button type="button" class="btn bg-success btn-xs generate">
                                                {{ trans_choice('core.generate_tree',1) }}
                                            </button>
                                            <input type="hidden" id="activeTreeTab" name="activeTreeTab"
                                                   value="{{$championship->id}}"/>
                                            {!! Form::close() !!}
                                        @endif

                                    </h1>

                                    @if ($championship->fightersGroups != null  && $championship->fightersGroups->count() != 0)
                                        @if ($championship->hasPreliminary() && ! $championship->isPlayOffType())
                                            @include('laravel-tournaments::partials.tree.preliminary')
                                        @elseif ($championship->isSingleEliminationType())
                                            @include('laravel-tournaments::partials.tree.singleElimination', ['hasPreliminary' => 0])
                                        @elseif ($championship->isPlayOffType())
                                            @include('laravel-tournaments::partials.tree.playOff')
                                        @endif
                                    @else
                                        <div>{{trans('core.no_generated_tree')}}</div>
                                    @endif

                                </div>

                            @endforeach
                        </div>
                        <br/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include("right-panel.tournament_menu")

    @include("errors.list")
@stop
@section('scripts_footer')
    {!! Html::script('js/pages/footer/trees.js')!!}
    <script>
        var facebook_id = "{{ env('FACEBOOK_CLIENT_ID') }}";
        var url_register = '{{ URL::action('TournamentController@register',$tournament->slug) }}';
        var url_show_tournament = '{{ URL::action('TournamentController@show',$tournament->slug) }}';
        <?php

        if (session()->has('activeTreeTab')) {
            $activeTreeTab = session('activeTreeTab');

            ?>

            $(function () {
            $('.trees a[href="#{{ $activeTreeTab }}"]').tab('show');

        });
        <?php } ?>


        $('.generate').on('click', function (e) {
            e.preventDefault();
            let form = $(this).parents('form:first');
            inputData = form.serialize();
            let count = form.data('gen');
            //JC2
            if (count != 0) {
                let form = $(this).parents('form');
                swal({
                        title: "{!!   trans('msg.are_you_sure') !!}",
                        text: "{!! trans('msg.this_will_delete_previous_tree') !!}",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#DD6B55',
                        confirmButtonText: "{{ trans('msg.do_it_again') }}",
                        cancelButtonText: "{{ trans('msg.cancel_it') }}",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            form.submit();
                        } else {
                            swal("{{ trans('msg.cancelled') }}", "{{ trans('msg.operation_cancelled') }}", "error");
                        }
                    });
            } else {
                form.submit();
            }
        });
    </script>
@stop
