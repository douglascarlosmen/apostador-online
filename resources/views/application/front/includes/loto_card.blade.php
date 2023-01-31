<div class="col-md-12 d-flex align-items-end mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    {{ $lotoResult->name }}
                    <img src="{{ asset('img/simbolo.png') }}" alt="">
                </div>
                <div class="col-md-9">
                    @if ($lotoResult->accumulated)
                        <p><strong>Acumulou! R$ {{ $lotoResult->formatted_accumulated_next_contest }}</strong></p>
                    @endif
                    <p>Próximo Concurso: em {{ $lotoResult->nextContestInDays() }}</p>
                </div>
                <div class="col-md-3">
                    Concurso {{ $lotoResult->contest_number }}
                    {{ $lotoResult->contest_date->format('d/m/Y') }}
                </div>
            </div>
        </div>
    </div>
</div>
