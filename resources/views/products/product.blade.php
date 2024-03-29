@extends('layouts.app')
@section('content')
    <div>
        <hr>
        <div class="container">
            <div><h1>{{$product->category->name}} / {{$product->name}}</h1></div>
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
            <div class="card mb-3" style="max-width: 1920px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="/images/{{$product->category_id}}.png" class="w-100" alt="{{$product->name}}">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body card-product">
                            <p><b>Наименование:</b> {{$product->name}}</p>
                            <p><b>Категория:</b> {{$product->category->name}}</p>
                            <p><b>В наличии:</b> {{$product->available_quantity}}</p>
                            <p><b>Характеристики:</b></p>
                            <ul>
                                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua.
                                </li>
                                <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                                    ex ea commodo consequat.
                                </li>
                                <li>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                                    fugiat nulla pariatur.
                                </li>
                                <li>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                    mollit anim id est laborum.
                                </li>
                            </ul>
                            <hr>
                        </div>
                        <p class="d-flex justify-content-end label-price px-4">Цена: {{round($product->price)}}</p>
                    </div>
                </div>
            </div>
            @if(Auth::check() && Auth::user()->role_id == 2)
                @if($product->available_quantity > 0)
                    <form action="{{ route('product.addToCart') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}"/>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary bg-black-pastel text-white ">Добавить в корзину</button>
                        </div>
                    </form>
                @else
                    <p>Товар в настоящее время недоступен</p>
                @endif

            @endif
        </div>
@endsection
