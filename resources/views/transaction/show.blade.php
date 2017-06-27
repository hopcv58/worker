@extends('layouts.master')

@section('extra_js')
    {{--<script>--}}
    {{--$.getJSON("{{route('worker.show',$id)}}", function (result, status) {--}}
    {{--//            alert(result.id);--}}
    {{--});--}}
    {{--</script>--}}
@endsection
@section('content')
    <div class="example">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if (isset($transaction))
                    <div class="jumbotron">
                        <div class="jumbotron-contents">
                            <table class="table">
                                <tr>
                                    <td class="col-md-3"><b>Title</b></td>
                                    <td class="col-md-9">{{$transaction->title}}</td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><b>Category</b></td>
                                    <td class="col-md-9">{{$transaction->category->name}}</td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><b>Description</b></td>
                                    <td class="col-md-9">{{$transaction->description}}</td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><b>Customer</b></td>
                                    <td class="col-md-9">{{$transaction->customer->name}}</td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><b>Worker</b></td>
                                    <td class="col-md-9">{{$transaction->worker_id?: "No one accepted"}}</td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><b>Images</b></td>
                                    <td class="col-md-9">
                                        @foreach(json_decode($transaction->images) as $image)
                                            <img class="col-md-3" src="{{asset('images/'.$image)}}">
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><b>Address</b></td>
                                    <td class="col-md-9">{{$transaction->address}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @else
                    You have not been a worker yet. Do you want to <a href="{{route('workers.create')}}">join</a> us for
                    free?
                @endif
            </div>
        </div>
    </div>
@endsection
