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
            @if (isset($categories))
                <div class="jumbotron">
                    <div class="jumbotron-contents">
                        <table class="table">
                            @foreach($categories as $category)
                                <tr>
                                    <td class="col-md-3"><b>Name</b></td>
                                    <td class="col-md-9">{{$category->name}}</td>
                                </tr>
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
@endsection
