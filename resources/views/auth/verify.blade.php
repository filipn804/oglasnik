@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Potvrdi svoju email adresu') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Link je poslan na vaš email.') }}
                        </div>
                    @endif

                    {{ __('Prije nastavka, provjerite vaš email.') }}
                    {{ __('Ako niste zaprimili email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('kliknite ovdje da zatražite novi link') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
