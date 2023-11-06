@extends('layouts.app')

@section('title')
{{$product->name}}
@endsection

@section('content')

@livewire('frontend.product.view', ['category' => $category, 'product' => $product])


@endsection