@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" style="width: 100%;">
            <div class="card mb-5">
                <div class="card-body">
                    <div class="row justify-content-md-left mb-3">
                        <div class="col-sm-4">
                            <div class="container-sm">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Current Balance</h4>
                                        <div class="row justify-content-md-center">
                                            <div class="col-md-auto">
                                                <h1>RM100,000.00</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="container-sm">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Percent +/-</h4>
                                        <div class="row justify-content-md-center">
                                            <div class="col-md-auto">
                                                <h1>69.42%</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center mb-3">
                        <div class="col">
                            <div class="container">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Transaction by Week (7days)</h4>
                                        <div class="row justify-content-md-center">
                                            <div class="col-md-auto">
                                                <canvas id="weeklyChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="container">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Transaction by Month (4Weeks)</h4>
                                        <div class="row justify-content-md-center">
                                            <div class="col-md-auto">
                                                <canvas id="monthlyChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="container">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Transaction by Year (12Months)</h4>
                                        <div class="row justify-content-md-center">
                                            <div class="col-md-auto">
                                                <canvas id="yearlyChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                {{-- <div class="card-header">Test</div> --}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card-body">
                                <h1 class="card-title" style="width: 90%;float: left;vertical-align:auto">Audit List</h1>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card mb-3" style="width: 80%;float: right;">
                              <div class="card-body">
                                {!! Form::open(['action' => 'App\Http\Controllers\EntryController@index', 'method' => 'POST']) !!}
                                <div class="input-group">
                                    {{ Form::text('query', '', ['class' => 'form-control']) }}
                                    {{ Form::submit('Search', ['style' => 'font-size:125%', 'id' => 'button-addon2', 'class' => ['btn btn-outline-secondary', 'type' => 'button']]) }}
                                </div>
                                {!! Form::close() !!}
                              </div>
                            </div>
                          </div>
                    </div>
                    @if (session('msg'))
                        <div class="alert alert-success" role="alert">
                            {{ session('msg') }} <i><a href="/restore/{{ session('id') }}">Undo this</a></i>
                        </div>
                    @endif
                    @if (session('err'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('err') }}
                    </div>
                    @endif
                    <table class="table table-hover table-bordered mb-5" style="width: 100%;table-layout: auto;">
                        <thead>
                            <tr class="table-secondary" style="font-size:125%; text-align:center;vertical-align:middle">
                                <th class="labels" scope="col">ID</th>
                                <th class="labels" scope="col">Date</th>
                                <th class="labels" style="text-align: left" scope="col">Details</th>
                                <th class="labels" scope="col">Amount</th>
                                <th class="labels" scope="col">Category</th>
                                {{-- <th class="labels" scope="col">Author ID</th> --}}
                                {{-- <th class="labels" scope="col">Attachment</th> --}}
                                {{-- <th class="labels" scope="col">External Info</th> --}}
                                <th class="labels" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($entries as $entry)
                                <tr style="vertical-align:middle;font-size:125%;">
                                    <th style="text-align:right; width: 1%;"scope="row">{{ $entry->id }}</th>
                                    <td style="text-align:center; width: 5%;">{{ date('d/m/Y', strtotime($entry->created_at));}}</td>
                                    <td style="word-wrap: break-word;text-align:left;"><p>{{ $entry->details }}</p></td>
                                    @if ($categories[$entry->category_id]->type == "credit")
                                        <td title="Income" style="text-align:center; width: 10%; white-space: nowrap;" class="table-success">RM{{ number_format($entry->amount, 2) }}</td>
                                    @else
                                        <td title="Expense" style="text-align:center; width: 10%; white-space: nowrap;" class="table-danger">RM{{ number_format($entry->amount, 2) }}</td>
                                    @endif
                                    <td title="{{ ucfirst($categories[$entry->category_id ]->type) }}" style="text-align:center; width: 5%; white-space: nowrap;">{{ $categories[$entry->category_id ]->name }}</td>
                                    <td title="View this entry" style="text-align:center; width: 5%;"><a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-view-{{ $entry->id }}">View</a></td>
                                </tr>
                                <div class="modal fade" size="sm" id="modal-view-{{ $entry->id }}" tabIndex="-1" aria-hidden="true" aria-labelledby="modalLabel">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="modalLabel">Item Details</h3>
                                            </div>
                                            <div class="modal-body">
                                                @include('includes.messages')
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
                                                    <div class="col">
                                                        {{ Form::textArea('details', $entry->details, ['class' => 'form-control', 'readonly']) }}
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    {{ Form::label('amount', 'Amount', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) }}
                                                    <div class="col-sm-5">
                                                        <div class="input-group input-group-lg">
                                                            <div class="input-group-text">RM</div>
                                                            {{ Form::text('amount', number_format(floatval($entry->amount), 2), ['class' => 'form-control', 'readonly']) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    {{ Form::label('category', 'Category', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) }}
                                                    <div class="col-sm-5">
                                                        {{ Form::select('category', $categorylist, $entry->category_id, ['class' => 'form-select form-select-lg', 'disabled']) }}
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    {{ Form::label('author', 'Created by', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) }}
                                                    <div class="col-sm-3">
                                                        <div class="input-group input-group-lg">
                                                            {{ Form::text('author', $authors[$entry->author_id], ['class' => 'form-control', 'readonly']) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- attachment --}}
                                                <div class="row mb-3">
                                                    {{ Form::label('created_at', 'Creation Date', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) }}
                                                    <div class="col-4">
                                                        <div class="input-group input-group-lg">
                                                            @php
                                                                $diffDate = Carbon\Carbon::parse($entry->created_at)->diffForHumans();
                                                            @endphp
                                                            {{ Form::date('created_at', $entry->created_at, ['title' => $diffDate, 'class' => 'form-control', 'readonly']) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    {{ Form::label('updated_at', 'Last Update Since', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) }}
                                                    <div class="col-4">
                                                        <div class="input-group input-group-lg">
                                                            @php
                                                            $diffDate = Carbon\Carbon::parse($entry->updated_at)->diffForHumans();
                                                            @endphp
                                                            {{ Form::date('updated_at', $entry->updated_at, ['title' => $diffDate, 'class' => 'form-control', 'readonly']) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    {{ Form::textArea('external info', $entry->external_info, ['width' => '100px', 'height' => '100px', 'class' => 'form-control', 'readonly', 'disabled']) }}
                                                    {{ Form::label('external_info', 'Additional Remarks') }}
                                                </div>
                                                <div class="d-grid gap-2 d-md-flex">
                                                    {{-- <a class="btn btn-secondary btn-lg mr-3" href="{{ url()->previous() }}">Back</a> --}}
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-lg mr-3 btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <a href="{{ route('entry.show', $entry->id) }}" class="btn btn-primary btn-lg mr-3">Edit Entry</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <th style="text-align:center;vertical-align:middle;" scope="row" colspan="6"><span><i>No User Available</i></span></th>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {!! $entries->onEachSide(5)->links('pagination::bootstrap-4') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('chart1')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script> --}}
  
{{-- <script type="text/javascript">
  
    const DATA_COUNT = 7;
    const NUMBER_CFG = {count: DATA_COUNT, min: -100, max: 100};
  
    const labels = ['january','february','august','sept','may','june','july'];
    const data = {
    labels: labels,
    datasets: [
        {
        label: 'Dataset 1',
        data: [100,69,420,69,20,22,31],
        borderColor: "blue",
        backgroundColor: "white",
        },
        {
        label: 'Dataset 2',
        data: [30,23,32,69,20,22,52],
        borderColor: "red",
        backgroundColor: "white",
        }
    ]
    };
  
    const config = {
    type: 'bar',
    data: data,
    options: {
        responsive: true,
        plugins: {
        legend: {
            position: 'top',
        },
        title: {
            display: true,
            text: 'Chart.js Bar Chart'
        }
        }
    },
    };
  
      const myChart = new Chart(
        document.getElementById('myChart'),
        config
      );
</script> --}}
<script>
    const xValues = [50,60,70,80,90,100,110,120,130,140,150];
    const yValues = [7,8,8,9,9,9,10,11,14,14,15];
    
    document.addEventListener("DOMContentLoaded", 
    function () {
        new Chart("weeklyChart", {
        type: "line",
        data: {
            labels: ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'],
            datasets: [{
            fill: false,
            lineTension: 0,
            backgroundColor: "rgba(0,0,255,1.0)",
            borderColor: "rgba(0,0,255,0.1)",
            data: yValues
            }]
        },
        options: {
            legend: {display: false},
            scales: {
            yAxes: [{ticks: {min: 6, max:16}}],
            }
        }
        });

        new Chart("monthlyChart", {
        type: "bar",
        data: {
            labels: ['Week 1','Week 2','Week 3','Week 4','Week 5'],
            datasets: [{
            fill: false,
            lineTension: 0,
            backgroundColor: "rgba(0,0,255,1.0)",
            borderColor: "rgba(0,0,255,0.1)",
            data: yValues
            }]
        },
        options: {
            legend: {display: false},
            scales: {
            yAxes: [{ticks: {min: 6, max:16}}],
            }
        }
        });

        new Chart("yearlyChart", {
        type: "line",
        data: {
            labels: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            datasets: [{ 
            data: [860,1140,1060,1060,1070,1110,1330,2210,7830,2478,420,69],
            borderColor: "red",
            fill: false
            }, { 
            data: [1600,1700,1700,1900,2302,2700,4000,5000,6000,7000,424,64],
            borderColor: "green",
            fill: false
            }, { 
            data: [300,700,2000,5000,6043,4000,2000,1000,200,100,422,61],
            borderColor: "blue",
            fill: false
            }]
        },
        options: {
            legend: {display: true},
            scales: {
                yAxes: [{ticks: {min: 6, max:16}}]
            }}
        });
    });
    </script>
@endpush