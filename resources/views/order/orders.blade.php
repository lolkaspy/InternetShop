@extends('layouts.app')
@section('content')
    <hr>
    <div class="container">
        <div><h1>Заказы</h1></div>
        <hr>
        <form method="GET" class="row g-3 d-flex justify-content-center" action="
    @if(Auth::check() && Auth::user()->role_id == 1)
    {{route('orders')}}
    @else
    {{route('orders.index')}}
    @endif
    ">
            <div class="col-sm-3">
                <label for="name" class="label-14pt">Наименование товара в заказе</label>
                <input id="name" name="name" type="text" class="form-control" value="{{request()->name}}"/>
            </div>
            <div class="col-sm-2">
                <label for="state" class="label-14pt">Статус</label>
                <select id="state" name="state" class="form-control form-select">
                    <option value="" selected disabled hidden></option>
                    <option value="{{\App\Enums\StateEnum::Cancelled->value}}" {{ (request()->state == \App\Enums\StateEnum::Cancelled) ? 'selected' : '' }}>Отменённый</option>
                    <option value="{{\App\Enums\StateEnum::New->value}}" {{ (request()->state == \App\Enums\StateEnum::New) ? 'selected' : '' }}>Новый</option>
                    <option value="{{\App\Enums\StateEnum::Approved->value}}" {{ (request()->state == \App\Enums\StateEnum::Approved) ? 'selected' : '' }}>Подтверждённый</option>
                </select>
            </div>
            <div class="col-sm-2">
                <label for="low_total" class="label-14pt">Сумма от</label>
                <input id="low_total" name="low_total" type="number" min="0" class="form-control"
                       value="{{request()->low_total}}" placeholder="{{round($minTotal)}}"/>
            </div>
            <div class="col-sm-2">
                <label for="high_total" class="label-14pt">до</label>
                <input id="high_total" name="high_total" type="number" min="0" class="form-control"
                       value="{{request()->high_total}}" placeholder="{{round($maxTotal)}}"/>
            </div>
            <div class="col-sm-2">
                <label for="created_at" class="label-14pt">Дата</label>
                <input id="created_at" name="created_at" type="date" class="form-control"
                       value="{{request()->created_at}}"/>
            </div>
            @if(Auth::check() && Auth::user()->role_id == 1)
                <div class="col-sm-3">
                    <label for="user" class="label-14pt">Пользователь</label>
                    <input id="user" name="user" type="text" class="form-control" value="{{request()->user}}"/>
                </div>
            @endif
            <div class="col-sm-2">
                <label for="sort_by" class="label-14pt">Сортировка</label>
                <select name="sort_by" id="sort_by" class="form-control form-select">
                    <option value="id" {{ (request()->sort_by == 'id') ? 'selected' : '' }}>Номер заказа</option>
                    <option value="state" {{ (request()->sort_by == 'state') ? 'selected' : '' }}>Статус</option>
                    <option value="total" {{ (request()->sort_by == 'total') ? 'selected' : '' }}>Сумма</option>
                    <option value="date" {{ (request()->sort_by == 'date') ? 'selected' : '' }}>Дата</option>
                    @if(Auth::check() && Auth::user()->role_id == 1)
                        <option value="user" {{ (request()->sort_by == 'user') ? 'selected' : '' }}>Пользователь
                        </option>
                    @endif
                </select>
            </div>
            <div class="col-sm-2">
                <label for="sort_order" class="label-14pt">Сортировать по</label>
                <select name="sort_order" id="sort_order" class="form-control form-select">
                    <option value="asc" {{ (request()->sort_order == 'asc') ? 'selected' : '' }}>По возрастанию</option>
                    <option value="desc" {{ (request()->sort_order == 'desc') ? 'selected' : '' }}>По убыванию</option>
                </select>
            </div>
            <div class="row g-3 d-flex justify-content-center">
                <div class="col-sm-2">
                    @if(Auth::check() && Auth::user()->role_id == 1)
                        <a href="{{route('orders')}}" class="btn btn-primary bg-black-pastel text-white form-control ">
                            {{ __('Сбросить фильтры') }}
                        </a>
                    @endif
                    @if(Auth::check() && Auth::user()->role_id == 2)
                        <a href="{{route('orders.index')}}"
                           class="btn btn-primary bg-black-pastel text-white form-control ">
                            {{ __('Сбросить фильтры') }}
                        </a>
                    @endif
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary bg-black-pastel text-white form-control ">
                        {{ __('Найти заказы') }}
                    </button>
                </div>
            </div>
        </form>
        <hr>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    <hr>
    @if(!$orders->isEmpty())
        @php
            $i = 0;
        @endphp
        <table class="table text-center table-striped align-middle">
            <tr class="table-dark">
                <th>№ заказа</th>
                <th></th>
                <th>Сумма заказа</th>
                <th>Дата заказа</th>
                <th><label for="state_change">Статус</label></th>
                @if(Auth::check() && Auth::user()->role_id == 1)
                    <th>Пользователь</th>
                @endif
                @if(Auth::check() && Auth::user()->role_id == 2)
                    <th></th>
                @endif
            </tr>
            @foreach($orders as $order)
                <tr>
                    <td>{{++$i}}</td>
                    <td>
                        <a href="{{route('order_list.show', [$order->id])}}">
                            <button class="btn btn-primary bg-black-pastel text-white">Посмотреть позиции</button>
                        </a>
                    </td>
                    <td>{{round($order->total)}}</td>
                    <td>{{date_format($order->created_at, "d.m.Y, H:i")}}</td>
                    <td>
                        @if(Auth::check() && Auth::user()->role_id == 2)
                            @switch($order->state)
                                @case(-1)
                                    Отменённый
                                    @break

                                @case(1)
                                    Подтверждённый
                                    @break

                                @default
                                    Новый
                            @endswitch
                        @endif

                        @if(Auth::check() && Auth::user()->role_id == 1)
                            <form action="{{ route('order.updateState', $order->id) }}" method="POST">
                                @csrf
                                <div class="d-flex justify-content-between">
                                    <select name="state_change" id="state_change" class="form-control form-select w-50">
                                        <option value="{{\App\Enums\StateEnum::Cancelled}}" {{ $order->state == \App\Enums\StateEnum::Cancelled->value ? 'selected' : '' }}>Отменённый
                                        </option>
                                        <option value="{{\App\Enums\StateEnum::New}}" {{ $order->state == \App\Enums\StateEnum::New->value ? 'selected' : '' }}>Новый</option>
                                        <option value="{{\App\Enums\StateEnum::Approved}}" {{ $order->state == \App\Enums\StateEnum::Approved->value ? 'selected' : '' }}>Подтверждённый
                                        </option>
                                    </select>
                                    <button type="submit" class="btn btn-primary bg-black-pastel text-white">Обновить
                                        статус
                                    </button>
                                </div>
                            </form>
                        @endif
                    </td>
                    @if(Auth::check() && Auth::user()->role_id == 1)
                        <td>
                            {{$order->user->name}} ({{$order->user->email}})
                        </td>
                    @endif
                    @if(Auth::check() && Auth::user()->role_id == 2)
                        <td>
                            <form action="{{ route('order.cancel', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary bg-black-pastel text-white">Отменить
                                    заказ
                                </button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>
    @else
        <div class="container label-14pt">Ничего не найдено!</div>
    @endif
    <hr>
    {{$orders->withQueryString()->links()}}
@endsection
