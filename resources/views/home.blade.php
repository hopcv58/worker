@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Need a Worker? What do you want?</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="get" action="{{route('transactions.create')}}">

                            <div class="form-group">
                                <label for="type" class="col-md-4 control-label">Select one: </label>

                                <div class="col-md-6">
                                    <select class="selecter_1" id="grand_category">
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    <select name="category" class="" id="child_category">
                                        @foreach($category->child as $cate)
                                            <option value="{{$cate->id}}">{{$cate->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Next step
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra_js')
    <script>
        $(document).ready(function () {
            $("#grand_category").change(function () {
                alert(3);
            });
        });
    </script>
@endsection