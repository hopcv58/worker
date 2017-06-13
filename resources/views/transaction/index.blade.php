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
            <h3 class="text-center">Transactions</h3>
            <hr style="background-color: #2a2a2a; height: 1px">
            @if (isset($transactions))
                @foreach($transactions as $transaction)
                    <div class="col-md-3 section-row">
                        <a href="{{route('transactions.show',$transaction->id)}}"><img
                                    src="{{$transaction->customer->avatar_path}})}}"
                                    class="img-responsive margin" alt="Image"></a>
                        <a href="{{route('transactions.show',$transaction->id)}}">{{$transaction->title}}</a>
                        <p>{{ $transaction->address }}</p>
                    </div>
                @endforeach
            @else
                You have not posted any transactions
            @endif
        </div>
    </div>
@endsection
