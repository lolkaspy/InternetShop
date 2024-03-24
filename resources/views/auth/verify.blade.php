@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-black-pastel text-white">{{ __('Подтвердите ваш адрес электронной почты') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Ссылка для верификации отправлена на вашу электронную почту.') }}
                        </div>
                    @endif

                    {{ __('Проверьте вашу почту на наличие письма') }}
                    {{ __('Если не получали письмо') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('кликните, чтобы получить новую ссылку') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
