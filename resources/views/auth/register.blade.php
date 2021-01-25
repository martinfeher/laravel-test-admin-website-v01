@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registrovať používateľa') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="meno" class="col-md-4 col-form-label text-md-right">{{ __('Meno') }}</label>
                            <div class="col-md-6">
                                <input id="meno" type="text" class="form-control @error('meno') is-invalid @enderror" name="meno" value="{{ old('meno') }}"  autocomplete="meno" autofocus>
                                @error('meno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Emailová adresa') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="heslo" class="col-md-4 col-form-label text-md-right">{{ __('Heslo') }}</label>

                            <div class="col-md-6">
                                <input id="heslo" type="password" class="form-control @error('heslo') is-invalid @enderror" name="heslo" autocomplete="new-heslo">

                                @error('heslo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="heslo-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Potvrdiť Heslo') }}</label>

                            <div class="col-md-6">
                                <input id="heslo-confirm" type="password" class="form-control" name="heslo_confirmation" autocomplete="new-heslo">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="rola" class="col-md-4 col-form-label text-md-right">{{ __('Rola') }}</label>
                            <div class="col-md-6">
                                <select name="rola" id="rola">
                                    <option value="user">user</option>

                                    @if(Auth::user()->jeAdministrator())
                                        <option value="admin">admin</option>
                                    @endif
                                </select>
                                @error('rola')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrovať') }}
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
