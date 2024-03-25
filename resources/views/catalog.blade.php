@extends('layouts.app')
@section('content')
    <hr>
    <div><h1>Каталог</h1></div>
    <hr>
    <div><h2>Выберите категорию товара</h2></div>
    <div class="py-3 py-md-5 bg-black-pastel">
        <div class="container">
            <div class="row">
                @foreach($categories as $category)

                    <div class="col-6 col-md-3">
                        <div class="category-card">
                            <a class="nav-link text-white" href="category/{{$category->slug}}">
                                <div class="category-card-img">
                                    <img src="/images/{{$category->id}}.png" class="w-100" alt="{{$category->name}}">
                                </div>
                                <div class="category-card-body text-center">
                                    <h5>{{$category->name}}</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
