<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Σύνδεση Χρήστη</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
          {{ csrf_field() }}

          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <label for="email" class="col-md-4 control-label">E-Mail</label>

              <div class="col">
                  <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                  @if ($errors->has('email'))
                      <span class="help-block">
                          <strong>{{ $errors->first('email') }}</strong>
                      </span>
                  @endif
              </div>
          </div>

          <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              <label for="password" class="col-md-4 control-label">Κωδικός</label>

              <div class="col">
                  <input id="password" type="password" class="form-control" name="password" required>

                  @if ($errors->has('password'))
                      <span class="help-block">
                          <strong>{{ $errors->first('password') }}</strong>
                      </span>
                  @endif
              </div>
          </div>

          <div class="form-group">
              <div class="col-sm-12 text-center">
                  <div class="checkbox">
                      <label>
                          <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Να παραμείνω συνδεδεμένος
                      </label>
                  </div>
              </div>
          </div>

          <div class="form-group">
              <div class="col-sm-12 text-center">
                  <button type="submit" class="btn btn-primary">
                      Σύνδεση
                  </button>
                </div>

                <div class="col-sm-12 text-center">
                  <a class="btn btn-link" href="{{ route('password.request') }}">
                      Ξέχασα το κωδικό μου
                  </a>
              </div>
          </div>
        </form>

        <div class="row">
          <div class="col-sm-12 text-center">
            <p>ή</p>
          </div>
          <div class="col-sm-12 text-center">
            <a href="{{url('register')}}" class="btn btn-outline-success btn-lg btn-block">
              <i class="fas fa-edit"></i> Δημιουργία Λογαριασμού
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>