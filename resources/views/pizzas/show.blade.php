@extends('layouts.app')

@section('content')
<div class="wrapper pizza-details">
    <h1>Order for {{ $pizza->name }} ({{ $pizza->id }})</h1>
    <p class="type">Type - {{ $pizza->type }}</p>
    <p class="base">Base - {{ $pizza->base }}</p>
    <p class="toppings">Extra toppings:</p>
    <ul>
        @forelse ($pizza->toppings as $topping)
        <li>{{ $topping }}</li>
        @empty
        <li>None</li>
        @endforelse
    </ul>
    <form action="{{ route('pizzas.destroy', $pizza->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button>Complete Order</button>
    </form>
</div>
<a href="/pizzas" class="back"><= Back to all pizza</a>
@endsection