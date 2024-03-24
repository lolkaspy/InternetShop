@extends('layouts.app')
@section('content')

    <div>
        <hr>
    <div class="container">

    <div><h1>Все товары</h1></div>
    <hr>
    <form method="GET" class="row g-3 d-flex justify-content-center" action="{{route('products.index')}}">

        <div class="col-sm-4">
            <label for="name" class="label-14pt">Наименование</label>
            <input id="name" name="name" type="text"  class="form-control" value="{{request()->name}}"/>
        </div>
        <div class="col-sm-2">
            <label for="low_price" class="label-14pt">Цена от</label>
            <input id="low_price" name="low_price" type="number" min="0" class="form-control"  value="{{request()->low_price}}" placeholder="{{round($minPrice)}}"/>

        </div>
        <div class="col-sm-2">
            <label for="high_price" class="label-14pt">до</label>
            <input id="high_price" name="high_price" type="number" min="0" class="form-control" value="{{request()->high_price}}"  placeholder="{{round($maxPrice)}}"/>
        </div>
        <div class="col-sm-4">
        <label for="category" class="label-14pt">Категория</label>
            <select id="category" name="category" class="form-control form-select" >
                <option value="" selected disabled hidden></option>
                @foreach($categories as $category)
                    <option value="{{$category->slug}}" {{request()->category == $category->slug ? 'selected' : ''}}>{{$category->name}}</option>
                @endforeach
            </select>
            </div>
        <div class="col-sm-2">
            <label for="sort_by" class="label-14pt">Сортировка</label>
            <select name="sort_by" id="sort_by" class="form-control form-select" >
                <option value="id" {{ (request()->sort_by == 'id') ? 'selected' : '' }}>Номер</option>
                <option value="name" {{ (request()->sort_by == 'name') ? 'selected' : '' }}>Название товара</option>
                <option value="price" {{ (request()->sort_by == 'price') ? 'selected' : '' }}>Цена</option>
                <option value="category_id" {{ (request()->sort_by == '$category_id') ? 'selected' : '' }}>Категория</option>
            </select>
        </div>
        <div class="col-sm-2">
            <label for="sort_order"  class="label-14pt">Сортировать по</label>
            <select name="sort_order" id="sort_order" class="form-control form-select" >
                <option value="asc" {{ (request()->sort_order == 'asc') ? 'selected' : '' }}>По возрастанию</option>
                <option value="desc" {{ (request()->sort_order == 'desc') ? 'selected' : '' }}>По убыванию</option>
            </select>


        </div>
        <div class="row g-3 d-flex justify-content-center">

            <div class="col-sm-2">
            <a href="{{route('products.index')}}" class="btn btn-primary bg-black-pastel text-white form-control ">
                {{ __('Сбросить фильтры') }}
            </a>

        </div>

            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary bg-black-pastel text-white form-control ">
                    {{ __('Найти товары') }}
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
        @if(!$products->isEmpty())

    <table class="table text-center table-striped align-middle">
        <tr class="table-dark">
            <th>№</th>
            <th>Наименование</th>
            <th>Цена</th>
            <th>В наличии</th>
            <th></th>
            @if(Auth::check() && Auth::user()->role_id == 2)
                <th></th>
            @endif

        </tr>
@foreach($products  as $product)
            <tr>
        <td>{{$product->id}}</td>
        <td>{{$product->name}}</td>
        <td>{{round($product->price)}}</td>
        <td>{{$product->available_quantity}}</td>
                <td>
                    <a href="{{route('product.show', [$product->slug])}}"><button class="btn btn-primary bg-black-pastel text-white">Посмотреть информацию</button></a>
                </td>
                @if(Auth::check() && Auth::user()->role_id == 2) <td>

                    @if($product->available_quantity > 0)
                        <form action="{{ route('product.addToCart') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}"/>
                            <button type="submit" class="btn btn-primary bg-black-pastel text-white">Добавить в корзину</button>
                        </form>
                    @else
                        <p>Товар в настоящее время недоступен</p>
                    @endif
        </td> @endif
            </tr>

@endforeach
    </table>
        @else
            <div class="container label-14pt">Ничего не найдено!</div>
        @endif
    <hr>
{{$products->withQueryString()->links()}}
    </div>
@endsection
