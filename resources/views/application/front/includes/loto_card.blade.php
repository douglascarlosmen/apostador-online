<div class="@if ($lotoResult->loto->name == 'lotofacil') col-md-12 @else col-md-6 @endif d-flex align-items-end mt-2">
    <div class="card w-100 shadow-lg">
        <div class="card-body">
            <div class="row">
                <div class="col-4 d-flex flex-column justify-content-center align-items-center">
                    <span class="{{$lotoResult->getStyleClassByName()}} text-bold" style="border: none !important">{{ $lotoResult->formatted_name }}</span>
                    <img src="{{ asset('img/simbolo.png') }}" alt="" width="60px" height="60px">
                    <small>Concurso {{ $lotoResult->contest_number }}</small>
                    <small>{{ $lotoResult->contest_date->format('d/m/Y') }}</small>
                </div>
                <div class="col-8 text-center">
                    <div class="p-2 w-100 mb-3 rounded border border-dark" style="background-color: blanchedalmond">
                        @if ($lotoResult->accumulated)
                            <span><strong>Acumulou! R$ {{ $lotoResult->formatted_accumulated_next_contest }}</strong></span>
                        @else
                            <span><strong>Prêmio distribuído!</strong></span>
                        @endif
                    </div>
                    <p>Próximo Concurso: em {{ $lotoResult->nextContestInDays() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
