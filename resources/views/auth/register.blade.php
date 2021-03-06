@extends('layouts.guest')

@section('content')
    <!-- Content area -->
    <div class="content">
        <!-- Registration form -->
        {{--@include("errors.list")--}}

        <form method="POST" action="{{ url('/register') }}">
            {!! csrf_field() !!}
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3">
                    @include('layouts.flash')

                    <div class="panel">
                        <div class="panel-body">
                            <div class="text-center">

                                <div class="icon-object border-success text-success"><i class="icon-plus3"></i>
                                </div>
                                <h5 class="content-group-lg">{{  Lang::get('auth.title_register') }}</h5>
                            </div>


                            <div class="row">
                                <div class="col-lg-6 col-lg-offset-3 col-xs-10 col-xs-offset-1">
                                    <div class="form-group has-feedback">
                                        <input type="text" name="name" class="form-control" id=""
                                               value="{{ old('name') }}"
                                               placeholder="{{  Lang::get('auth.choose_username') }}">

                                        <div class="form-control-feedback">
                                            <i class="icon-user-plus text-muted"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-lg-offset-3 col-xs-10 col-xs-offset-1">
                                    <div class="form-group has-feedback">
                                        <input type="email" id="email" name="email" class="form-control" placeholder="{{  Lang::get('auth.your_email') }}">

                                        <div class="form-control-feedback">
                                            <i class="icon-mention text-muted"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-lg-6 col-lg-offset-3 col-xs-10 col-xs-offset-1">
                                    <div class="form-group has-feedback">
                                        <input type="password" id="password" name="password"
                                               placeholder="{{  Lang::get('auth.create_password') }}"
                                               class="form-control">

                                        <div class="form-control-feedback">
                                            <i class="icon-user-lock text-muted"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-lg-offset-3 col-xs-10 col-xs-offset-1">
                                    <div class="form-group has-feedback">
                                        <input type="password" id="password_confirmation"
                                               name="password_confirmation"
                                               placeholder="{{  Lang::get('auth.repeat_password') }}"
                                               class="form-control">

                                        <div class="form-control-feedback">
                                            <i class="icon-user-lock text-muted"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                <a href="{!! URL::action('Auth\LoginController@showLoginForm') !!}" class="btn btn-link"><i
                                            class="icon-arrow-left13 position-left"></i> {{  Lang::get('auth.back_to_login_form') }}
                                </a>
                                <button type="submit"
                                        class="btn bg-success btn-labeled btn-labeled-right ml-10">
                                    <b><i class="icon-plus3"></i></b>{{  Lang::get('auth.create_account') }}
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </form>
        <!-- /registration form -->
        {!! JsValidator::formRequest('App\Http\Requests\AuthRequest') !!}
    </div>
@stop




