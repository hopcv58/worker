@extends('layouts.master')

@section('content')
    <div class="example">
        <div class="container">
            <h3 class="text-center">Search result</h3>
            <hr style="background-color: #2a2a2a; height: 1px">
            @if (isset($categories) && sizeof($categories) > 0)
                @foreach($categories as $category)
                    <div class="jumbotron">
                        <div class="jumbotron-contents">
                            <table class="table">
                                <tr>
                                    <td class="col-md-3"><b>Name</b></td>
                                    <td class="col-md-9">{{$category->name}}</td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><b>Description</b></td>
                                    <td class="col-md-9">{{$category->description}}</td>
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