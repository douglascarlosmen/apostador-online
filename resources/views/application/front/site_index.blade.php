@extends('application.front.template.main')

@section('content')
    @include('application.front.template.navbar')

    <section class="container pt-5">
        <div class="row">
            @foreach ($recentlyLotosResults as $lotoResult)
                @include('application.front.includes.loto_card', compact('lotoResult'))
            @endforeach
        </div>
    </section>
@endsection
