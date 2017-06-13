@extends('layouts.master')

@section('extra_js')
    <script>
        $.getJSON("{{route('worker.show',$id)}}", function (result, status) {
//            alert(result.id);
        });
    </script>
@endsection
@section('content')
    <div class="example">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

            </div>
        </div>
    </div>
@endsection
