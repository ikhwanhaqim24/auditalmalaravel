@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" style="width: 100%;">
            <div class="card">
                {{-- <div class="card-header">Test</div> --}}
                <div class="card-body">
                    @if (session('msg'))
                        <div class="alert alert-success" role="alert">
                            {{ session('msg') }}
                        </div>
                    @endif
                    @if (session('err'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('err') }}
                    </div>
                    @endif
                    @if (session('warn'))
                    <div class="alert alert-warning" role="alert">
                        {{ session('warn') }}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card-body">
                                <h1 class="card-title" style="width: 90%;float: left;vertical-align:auto">Item Details</h1>
                            </div>
                        </div>
                        <div class="col-sm-6">
                        </div>
                    </div>
                    <div class="card-body">
                        @include('includes.messages')
                        {!! Form::open(['action' => 'App\Http\Controllers\EntryController@postMethod', 'method' => 'POST']) !!}
                        {{-- id, details, amount, category, author, attachment, created at, last updated, external info --}}
                        <div class="row mb-3">
                            {{ Form::label('id', 'Entry ID', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) }}
                            <div class="col-sm-3">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text" id="basic-addon1">#</span>
                                    {{ Form::text('id', $entry->id, ['class' => 'form-control', 'readonly']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            {{ Form::label('details', 'Details', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) }}
                            <div class="col-sm-5">
                                {{ Form::textArea('details', $entry->details, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            {{ Form::label('amount', 'Amount', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) }}
                            <div class="col-sm-3">
                                <div class="input-group input-group-lg">
                                    <div class="input-group-text">RM</div>
                                    {{ Form::text('amount', number_format(floatval($entry->amount), 2, '.', ''), ['class' => 'form-control']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            {{ Form::label('category', 'Category', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) }}
                            <div class="col-sm-3">
                                {{ Form::select('category', $categories, $entry->category_id, ['class' => 'form-select form-select-lg']) }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            {{ Form::label('author', 'Created by', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) }}
                            <div class="col-sm-3">
                                <div class="input-group input-group-lg">
                                    {{ Form::text('author', $author->name, ['class' => 'form-control', 'readonly', 'disabled']) }}
                                </div>
                            </div>
                        </div>
                        {{-- attachment --}}
                        <div class="row mb-3">
                            {{ Form::label('created_at', 'Creation Date', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) }}
                            <div class="col-sm-2">
                                <div class="input-group input-group-lg">
                                    @php
                                        $diffDate = Carbon\Carbon::parse($entry->created_at)->diffForHumans();
                                    @endphp
                                    {{ Form::date('created_at', $entry->created_at, ['title' => $diffDate, 'class' => 'form-control', 'readonly', 'disabled']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            {{ Form::label('updated_at', 'Last Update Since', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) }}
                            <div class="col-sm-2">
                                <div class="input-group input-group-lg">
                                    @php
                                    $diffDate = Carbon\Carbon::parse($entry->updated_at)->diffForHumans();
                                    @endphp
                                    {{ Form::date('updated_at', $entry->updated_at, ['title' => $diffDate, 'class' => 'form-control', 'readonly', 'disabled']) }}
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            {{ Form::textArea('external info', $entry->external_info, ['width' => '100px', 'height' => '100px', 'class' => 'form-control', 'readonly', 'disabled']) }}
                            {{  Form::label('external_info', 'Additional Remarks') }}
                        </div>
                        <div class="d-grid gap-2 d-md-flex">
                            <a class="btn btn-secondary btn-lg mr-3" href="{{ session()->previousUrl() == url()->current() ? route('entry.index') : url()->previous() }}">Back</a>
                            {{ Form::submit('Edit', ['name' => 'action', 'value' => 'save', 'style' => 'font-size:125%', 'id' => 'button_edit', 'class' => 'btn btn-primary btn-lg mr-3', 'type' => 'button']) }}
                            {{ Form::submit('Delete', ['name' => 'action', 'value' => 'save-draft', 'style' => 'font-size:125%', 'id' => 'button_delete', 'class' => 'btn btn-danger btn-lg', 'type' => 'button']) }}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
