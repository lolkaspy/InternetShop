@extends('layouts.app')
@section('content')

<div class="container">
    <hr>
    <h1>Корзина</h1>
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
<table class="table text-center table-striped align-middle">
    <tr class="table-dark">
        <th>№ позиции</th>
        <th>Наименование товара</th>
        <th></th>
        <th>Количество</th>
        <th>Сумма заказа</th>

    </tr>
    @php
        $i = 0;
        $sum = 0;
        $subsum = 0;
    @endphp
    @foreach($cart as $position)

        <tr>
            <td>{{++$i}}</td>
            <td>{{$position->product->name}}</td>
            <td><a href="{{route('product.show', [$position->product->slug])}}"><button class="btn btn-primary bg-black-pastel text-white">Посмотреть информацию</button></a></td>
            <td>{{$position->quantity}}</td>
            <td>{{$subsum=round($position->quantity*$position->product->price)}}</td>

            @php

                $sum += $subsum;
            @endphp
        </tr>
        @endforeach
    <tr class="sum-border-top no-border-bottom">
        <td></td>
        <td></td>
        <td></td>
        <th class="table-dark sum-border-bottom">Итого:</th>
        <th class="sum-border-bottom">{{$sum}}</th>
    </tr>
    <tr class="no-border-bottom">
        <td></td>
        <td></td>
        <td></td>

        <td>
            <form method="POST" action="{{route('cart.destroy')}}">
                @csrf
                @method('DELETE')

                <button class="btn btn-primary bg-black-pastel text-white">Очистить корзину</button>
            </form>
        </td>

        <td><form action="{{route('order.create')}}" method="POST">
                @csrf
                @foreach($cart as $position)
                    <input type="hidden" name="products[{{$position->product->id}}]" value="{{$position->quantity}}">
                @endforeach
                <button type="submit" class="btn btn-primary bg-black-pastel text-white">Заказать</button>
            </form>
        </td>
    </tr>
</table>
    <hr>
{{$cart->withQueryString()->links()}}
@endsection
