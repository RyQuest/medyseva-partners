

<section id="sin-up">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="img">
                    <img src="https://medyseva.com/assets/img/logo/logo.png">
                </div>
                <div class="card">
                    <div class="head-txt">
                        <h2>Sign In to Good</h2>
                        <p>New Here? <a href="">Create an Account</a></p>
                    </div>
                   

                    <div class="card-body">
                       <form wire:submit.prevent="login">
                            

                        <div>
                            @if (session()->has('error'))
                                <div class="alert alert-success">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-12 col-form-label">{{ __('Email Address') }}</label>

                                <div class="col-md-12">
                                    <input id="email" type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label">{{ __('Password') }}</label>

                                <div class="col-md-12">
                                    <input id="password" wire:model="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-12">
                                    <button  class="btn btn-primary"type="submit">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>