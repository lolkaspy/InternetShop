@extends('layouts.app')
@section('content')
    @php
        $i = 0;
        $total=0;
    @endphp
    <div class="container">
        <hr>
        @if($orderList->first() !== null)
        <h1>Позиции заказа от {{date_format($orderList->first()->order->created_at,"d.m.Y")}}
            @if(Auth::check() && Auth::user()->role_id == 1)
                пользователя {{$orderList->first()->order->user->name}}
            @endif
        </h1>
        <hr>
        <form method="GET" class="row g-3 d-flex justify-content-center"
              action="{{route('order_list.show', [$orderList->first()->order_id])}}">
            <div class="col-sm-3">
                <label for="name" class="label-14pt">Наименование товара</label>
                <input id="name" name="name" type="text" class="form-control" value="{{request()->name}}"/>
            </div>
            <div class="col-sm-2">
                <label for="low_subtotal" class="label-14pt">Сумма от</label>
                <input id="low_subtotal" name="low_subtotal" type="number" min="0" class="form-control"
                       value="{{request()->low_subtotal}}" placeholder="{{$minSubtotal}}"/>
            </div>
            <div class="col-sm-2">
                <label for="high_subtotal" class="label-14pt">до</label>
                <input id="high_subtotal" name="high_subtotal" type="number" min="0" class="form-control"
                       value="{{request()->high_subtotal}}" placeholder="{{$maxSubtotal}}"/>
            </div>
            <div class="col-sm-2">
                <label for="sort_by" class="label-14pt">Сортировка</label>
                <select name="sort_by" id="sort_by" class="form-control form-select">
                    <option value="product_id" {{ (request()->sort_by == 'product_id') ? 'selected' : '' }}>№ товара
                    </option>
                    <option value="name" {{ (request()->sort_by == 'name') ? 'selected' : '' }}>Наименование</option>
                    <option value="subtotal" {{ (request()->sort_by == 'subtotal') ? 'selected' : '' }}>Сумма</option>
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
                    <a href="{{route('order_list.show', [$orderList->first()->order_id])}}"
                       class="btn btn-primary bg-black-pastel text-white form-control ">
                        {{ __('Сбросить фильтры') }}
                    </a>
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary bg-black-pastel text-white form-control ">
                        {{ __('Найти позиции') }}
                    </button>
                </div>
            </div>
        </form>
        <hr>
    </div>
    <table class="table text-center">
        <tr class="table-dark">
            <th>№ позиции</th>
            <th>Наименование товара</th>
            <th></th>
            <th>Количество</th>
            <th>Сумма заказа</th>
        </tr>
        @foreach($orderList as $order)
            @php
                $total+=$order->subtotal;
            @endphp
            <tr>
                <td>{{++$i}}</td>
                <td>{{$order->product->name}}</td>
                <td><a href="{{route('product.show', [$order->product->slug])}}">
                        <button class="btn btn-primary bg-black-pastel text-white">Посмотреть информацию</button>
                    </a></td>
                <td>{{$order->quantity}}</td>
                <td>{{round($order->subtotal)}}</td>
            </tr>
        @endforeach
        <tr class="sum-border-top no-border-bottom">
            <td></td>
            <td></td>
            <td></td>
            <th class="table-dark sum-border-bottom">Итого:</th>
            <th class="sum-border-bottom">{{$total}}</th>
        </tr>
    </table>
    @else
        <h1>Товар не найден</h1>
    @endif
@endsection
