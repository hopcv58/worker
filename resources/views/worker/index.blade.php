@extends('layouts.master')

@section('extra_js')
    <script>
        $.getJSON("{{route('worker.index')}}", function (result) {
//            $.each(result, function(i, row){
            alert(row.id);
//            });
        });
    </script>
@endsection
@section('content')
    <div class="example">
        <div class="container">
            <h3 class="text-center">Your Worker's Profile</h3>
            <hr style="background-color: #2a2a2a; height: 1px">
            @if (isset($worker))
                <div class="jumbotron">
                    <div class="jumbotron-contents">
                        <table class="table">
                            <tr>
                                <td class="col-md-3"><b>Website</b></td>
                                <td class="col-md-9">{{$worker->website}}</td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>Address</b></td>
                                <td class="col-md-9">{{$worker->address}}</td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>Description</b></td>
                                <td class="col-md-9">{{$worker->description}}</td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>Type</b></td>
                                <td class="col-md-9">{{$worker->type ? "Group" : "Single"}}</td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>Bank account</b></td>
                                <td class="col-md-9">{{$worker->bank_account}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr style="background-color: #2a2a2a; height: 1px">
                <h3 class="text-center">Your Job</h3>
                @if (isset($transactions))
                    @foreach($transactions as $transaction)
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail">
                                <a href="{{route('transactions.show',$transaction->id)}}">
                                    <img src="{{$transaction->customer->avatar_path}})}}" class="img-responsive margin"
                                         alt="Image">
                                </a>
                                <div class="caption text-center">
                                    <h3>
                                        <a href="{{route('transactions.show',$transaction->id)}}">{{$transaction->title}}</a>
                                    </h3>
                                    <p>{{ $transaction->address }}</p>
                                    <p><a href="#" class="btn btn-warning" role="button">Button</a></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    You have not accepted any transactions
                @endif
            @else
                You have not been a worker yet. Do you want to <a href="{{route('workers.create')}}">join</a> us for
                free?
            @endif
        </div>
    </div>
@endsection
