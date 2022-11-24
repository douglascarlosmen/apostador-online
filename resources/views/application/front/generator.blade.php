@extends('application.front.template.main')

@section("css")
<style>
    .col-5{
        width: 20%;
        float:left;
        position: relative;
    }
</style>
@endsection

@section("content")
@include("application.front.template.navbar")

<section id="contest-selection" class="container pt-5">
    <div class="row">
        <div class="col-md-8 mt-2">
            <label for="lottery">Escolha a loteria</label>
            <select name="lottery" id="lottery-select" class="form-control" onchange="applyLotteryNumbers(event)">
                <option value="mega-sena">Mega-Sena</option>
                <option value="lotofacil">Lotofácil</option>
                <option value="lotomania">Lotomania</option>
                <option value="dupla-sena">Dupla-Sena</option>
                <option value="quina">Quina</option>
                <option value="dia-de-sorte">Dia de Sorte</option>
                <option value="timemania">Timemania</option>
            </select>
        </div>

        <div class="col-md-4 d-flex align-items-end mt-2">
            <button class="btn btn-success w-100" id="lottery-button" onclick="getContestResult()">
                Escolher
            </button>
        </div>
    </div>
</section>

<section id="contest-numbers" class="container mt-3">
    <div id="resume-games">

    </div>
    <div class="row">
        <div class="col-md-6">
            <div id="contest-display">
                <span id="numbers-header" class="megasena">
                    <i>Mega-Sena</i>
                </span>
                <div id="numbers" class="w-100 megasena-border">

                </div>
            </div>
        </div>

        <div class="col-md-6 pt-4">
            
        </div>
    </div>
</section>

<section id="results" class="container mt-3" style="display: none">
    <h1 class="text-center">Veja o resultado de cada jogo</h1>
    <div id="place-games" class="row justify-content-center">

    </div>
</section>

@endsection

@section("scripts")
<script src="{{asset('js/apostador.js')}}"></script>
<script>
    applyLotteryNumbers(null);

    function getContestOptions(getResults = false){
        axios.get(`{{route('lottery.contest')}}?loto_name=${lottery}`)
            .then(response => {
                CONTEST_SELECT.html('');
                response.data.contestsNumbers.forEach(item => {
                    CONTEST_SELECT.append(`<option value=${item}>Concurso ${item}</option>`)
                });

                if (getResults)
                    getContestResult();
            })
            .catch(error => {
                console.log(error.response.data);
            })
    }
</script>
@endsection
