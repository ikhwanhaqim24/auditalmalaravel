@extends('layouts.app')

@section('content')
<div class="wrapper create-pizza">
    <h1>Create a New Pizza</h1>
    {{-- <form action="/pizzas" method="POST">
        @csrf
        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name">

        <label for="type">Choose pizza type:</label>
        <select name="type" id="type">
            <option value="margarita">Margarita</option>
            <option value="hawaiian">Hawaiian</option>
            <option value="veg supreme">Veg Supreme</option>
            <option value="volcano">Volcano</option>
        </select>

        <label for="base">Choose base type:</label>
        <select name="base" id="base">
            <option value="cheesy crust">Cheesy Crust</option>
            <option value="garlic crust">Garlic Crust</option>
            <option value="thin & crispy">Thin & Crispy</option>
            <option value="thick">Thick</option>
        </select>

        <fieldset>
            <label>Extra Toppings:</label>
            <input type="checkbox" name="toppings[]" value="mushrooms">Mushrooms<br/>
            <input type="checkbox" name="toppings[]" value="peppers">Peppers<br/>
            <input type="checkbox" name="toppings[]" value="garlic">Garlic<br/>
            <input type="checkbox" name="toppings[]" value="olives">Olives<br/>
        </fieldset>

        <input type="submit" value="Order Pizza">
    </form> --}}
    @include('includes.messages')
    {!! Form::open(['action' => 'App\Http\Controllers\PizzaController@store', 'method' => 'POST']) !!}
        <div class="form-group">
            {{ Form::label('name', 'Name') }}
            {{ Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Name']) }}
        </div>
        {{-- <div class="form-group">
            {{ Form::label('body', 'Body') }}
            {{ Form::textarea('body', '', ['class' => 'form-control', 'placeholder' => 'Body']) }}
        </div> --}}
        <div class="form-group">
                {{ Form::label('toppings', 'Extra Toppings') }}
                @foreach ( $toppings as $topping )
                <div class="input-group">
                    {{ Form::checkbox('toppings[]', $topping, null, ['class' => 'form-check-input', 'id' => $topping, ])}}
                    {{ Form::label($topping, $topping, ['class' => 'text-right']) }}
                </div>
                @endforeach
        </div>
        <div class="form-group">
            {{ Form::label('base', 'Base') }}
            {{ Form::select('base', [
                'cheesy crust' => 'Cheesy crust',
                'garlic crust' => 'Garlic crust',
                'thin & crispy' => 'Thin & crispy'
            ]) }}
        </div>
        <div class="form-group">
            {{ Form::label('type', 'Type') }}
            {{ Form::select('type', [
                'margarita' => 'Margarita',
                'hawaiian' => 'Hawaiian',
                'veg supreme' => 'Veg Supreme',
                'volcano' => 'Volcano',
            ]) }}
        </div>
        {{ Form::submit('Submit'), ['class' => 'btn btn-primary'] }}
    {!! Form::close() !!}
</div>
@endsection