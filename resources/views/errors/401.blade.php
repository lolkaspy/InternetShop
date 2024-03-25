@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card label-14pt">
                    <div class="card-header bg-black-pastel text-white">{{ __('Ошибка')}}</div>
                    <div class="card-body">
                        {{ __('401. Нет прав доступа к содержимому.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
