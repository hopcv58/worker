@extends('layouts.master')

@section('content')
    <div class="example">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if (isset($category))
                    <div class="jumbotron">
                        <div class="jumbotron-contents">
                            <table class="table">
                                @foreach($children as $child)
                                    <tr>
                                        <td class="col-md-3"><b>Name</b></td>
                                        <td class="col-md-9">{{$child->name}}</td>
                                    </tr>
                                    @foreach($child->new_transactions as $transaction)
                                        <tr>
                                            <td class="col-md-3 pull-right"><b>Title</b></td>
                                            <td class="col-md-9 col-md-offset-3">{{$transaction->title}}</td>
                                        </tr>
                                    @endforeach
                                    @foreach($child->old_transactions as $transaction)
                                        <tr>
                                            <td class="col-md-3 pull-right"><strike>Title</strike></td>
                                            <td class="col-md-9 col-md-offset-3">{{$transaction->title}}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
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
