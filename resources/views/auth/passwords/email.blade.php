@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h1>Επαναφορά Κωδικού</h1>
                    <p>Για να γίνει επαναφορά του κωδικού σας παρακαλούμε συμπληρώστε το email σας και πατήστε Αποστολή</p>
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-sm-12">
                                <input id="email" type="email" class="form-control form-control-lg" name="email" value="{{ old('email') }}" placeholder="Διεύθυνση E-mail" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Αποστολή Email επαναφοράς κωδικού
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
