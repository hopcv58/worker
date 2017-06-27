@extends('layouts.master')

@section('content')
    <div class="example">
        <div class="container">
            <h3 class="text-center">Search result</h3>
            <hr style="background-color: #2a2a2a; height: 1px">
            @if (isset($workers) && sizeof($workers) > 0)
                @foreach($workers as $worker)
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
                @endforeach
            @else
                No result found!
            @endif
        </div>
    </div>
@endsection