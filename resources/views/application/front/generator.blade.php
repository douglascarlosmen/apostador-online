@extends('application.front.template.main')

@section("css")
<style>
    .col-5{
        width: 20%;
        float:left;
        position: relative;
    }

    .ok{
        color: #28a745!important
    }

    .text-bold{
        color: #DC3545;
    }
</style>
@endsection

@section("content")
@include("application.front.template.navbar")

<section id="contest-selection" class="container pt-5">
    <div class="row">
        <div class="col-md-12 mt-2">
            <label for="lottery">Escolha a loteria</label>
            <select name="lottery" id="lottery-select" class="form-control" onchange="applyLotteryNumbers(event, false)">
                <option value="mega-sena">Mega-Sena</option>
                <option value="lotofacil">Lotofácil</option>
                <option value="lotomania">Lotomania</option>
                <option value="dupla-sena">Dupla-Sena</option>
                <option value="quina">Quina</option>
                <option value="dia-de-sorte">Dia de Sorte</option>
                <option value="timemania">Timemania</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 d-flex align-items-end mt-2">
            <button class="btn btn-secondary w-100" id="lottery-button" onclick="getNumbers()">
                <i class="fas fa-thumbs-up"></i> Palpite Apostador
            </button>
        </div>
        <div class="col-md-6 col-lg-3 d-flex align-items-end mt-2">
            <button class="btn btn-outline-info w-100" id="lastGameButton" onclick="toggleLastGameContainer()">
                <i class="fas fa-chart-bar"></i> Mostrar Premiação
            </button>
        </div>
        <div class="col-md-6 col-lg-3 d-flex align-items-end mt-2">
            <button class="btn btn-outline-success w-100" id="lastGameButton" onclick="selectGame()">
                <i class="fas fa-check"></i> Selecionar Jogo
            </button>
        </div>
        <div class="col-md-6 col-lg-3 d-flex align-items-end mt-2">
            <button class="btn btn-outline-danger w-100" onclick="deleteAllGames()">
                <i class="fa fa-trash"></i> Limpar Jogos
            </button>
        </div>
    </div>
</section>

<section id="lastGameContainer" class="container mt-3" style="display: none">
    <div class="row d-flex flex-row justify-content-center">
        <h4 class="text-center w-100" id="contestLabel">Estatísticas do Último Concurso</h4>
        <div class="col-md-6 p-2">
            <div id="lastGame" class="row d-flex flex-row justify-content-center mb-2">

            </div>
            <div class="w-100 bg-black text-white p-2 text-center">
                <b>Parâmetros Principais</b>
            </div>
            <div class="border p-2 d-flex flex-row justify-content-center">
                <div class="col-md-6 d-flex flex-row justify-content-center">
                    <span>Par:</span>
                    <span id="lastEven" class="text-bold ml-2">0</span>
                </div>
                |
                <div class="col-md-6 d-flex flex-row justify-content-center">
                    <span>Ímpar:</span>
                    <span id="lastOdd" class="text-bold ml-2">0</span>
                </div>
            </div>
            <div class="border p-2 d-flex flex-row justify-content-center">
                <span>Números de Fibonacci:</span>
                <span id="lastFibonacci" class="text-bold ml-2">0</span>
            </div>
            <div class="w-100 bg-black text-white p-2 text-center mt-3">
                <b>Parâmetros Secundários</b>
            </div>
            <div class="border p-2 d-flex flex-row justify-content-center">
                <span>Primos:</span>
                <span id="lastPrime" class="text-bold ml-2">0</span>
            </div>
            <div class="border p-2 d-flex flex-row justify-content-center">
                <span>Múltiplos de 3:</span>
                <span id="threeMultiple" class="text-bold ml-2">0</span>
            </div>
            <div class="border p-2 d-flex flex-row justify-content-center">
                <span>Soma das Dezenas:</span>
                <span id="lastSum" class="text-bold ml-2">0</span>
            </div>
        </div>
    </div>
</section>

<section id="contest-numbers" class="container mt-3">
    <div id="resume-games">

    </div>
    <div class="row mb-2">
        <div class="col-md-6">
            <div id="contest-display" style="display: none">
                <span id="numbers-header" class="megasena">
                    <i>Mega-Sena</i>
                </span>
                <div id="numbers" class="w-100 megasena-border">

                </div>
            </div>
        </div>

        <div class="col-md-6 pt-4">
            <div class="w-100 bg-black text-white p-2 text-center">
                <b>Parâmetros Principais</b>
            </div>
            <div class="border p-2 d-flex flex-row justify-content-center">
                <div class="col-md-6 d-flex flex-row justify-content-center">
                    <span>Par:</span>
                    <span id="even" class="text-bold ml-2">0</span>
                </div>
                |
                <div class="col-md-6 d-flex flex-row justify-content-center">
                    <span>Ímpar:</span>
                    <span id="odd" class="text-bold ml-2">0</span>
                </div>
            </div>
            <div class="border p-2 d-flex flex-row justify-content-center">
                <span>Repetidos do Anterior:</span>
                <span id="lastResultsMatch" class="text-bold ml-2">0</span>
            </div>
            <div class="border p-2 d-flex flex-row justify-content-center">
                <span>Números de Fibonacci:</span>
                <span id="fibonacci" class="text-bold ml-2">0</span>
            </div>
            <div class="w-100 bg-black text-white p-2 text-center mt-3">
                <b>Parâmetros Secundários</b>
            </div>
            <div class="border p-2 d-flex flex-row justify-content-center">
                <span>Primos:</span>
                <span id="prime" class="text-bold ml-2">0</span>
            </div>
            <div class="border p-2 d-flex flex-row justify-content-center">
                <span>Múltiplos de 3:</span>
                <span id="threeMultiple" class="text-bold ml-2">0</span>
            </div>
            <div class="border p-2 d-flex flex-row justify-content-center">
                <span>Soma das Dezenas:</span>
                <span id="sum" class="text-bold ml-2">0</span>
            </div>
        </div>
    </div>
</section>

<section id="selected-games-container" class="container mt-3">
    <h4 class="text-center">Jogos Selecionados</h4>
    <div id="selected-games">

    </div>
</section>

@endsection

@section("scripts")
<script src="{{asset('js/apostador.js')}}"></script>
<script src="{{asset('js/generator.js')}}"></script>
<script>
    blockClick = true;
    applyLotteryNumbers(false);

    async function getNumbers(){
        dozens = [];
        await clearDozens();

        axios.post(`{{route('generate')}}`,{
            lottery,
            maxNumber: getLotteryData().max,
            maxPrize: getLotteryData().minSelected,
        })
            .then(response => {
                console.log(response.data);
                //Primary
                $("#even").html(response.data.info.even);
                $("#odd").html(response.data.info.odd);
                $("#lastResultsMatch").html(response.data.info.lastLotteryDozensMatch);
                $("#fibonacci").html(response.data.info.fibonacci);
                //Secondary
                $("#prime").html(response.data.info.prime);
                $("#threeMultiple").html(response.data.info.threeMultiple);
                $("#sum").html(response.data.info.sum);
                blockClick = false;
                response.data.dozens.forEach(async item => {
                    await toggleDozen(`number-${item}`);
                });
                setDefaultParams(response.data);
                blockClick = true;

                $("#contestLabel").html(`Estatísticas do Último Concurso ${response.data.lastResult.contestNumber}`);
                //Primary
                $("#lastEven").html(response.data.lastResult.even);
                $("#lastOdd").html(response.data.lastResult.odd);
                $("#lastFibonacci").html(response.data.lastResult.fibonacci);
                //Secondary
                $("#lastPrime").html(response.data.lastResult.prime);
                $("#lastThreeMultiple").html(response.data.lastResult.threeMultiple);
                $("#lastSum").html(response.data.lastResult.sum);
                let resultsTemplate = "";
                response.data.lastResult.dozens.forEach(dozen => {
                    resultsTemplate += `<span class="numbers ${getLotteryClass()}"><b>${dozen}</b></span>`;
                });
                $("#lastGame").html(resultsTemplate);
                setLastGameParams(response.data);
            })
            .catch(error => {
                console.log(error);
                console.log(error.response.data);
            })
    }

    let lastGameToggled = false;
    function toggleLastGameContainer(){
        if (!lastGameToggled){
            $("#lastGameContainer").show();
            $("#lastGameButton").html("<i class='fas fa-chart-bar'></i> Esconder Premiação")
        }else{
            $("#lastGameContainer").hide();
            $("#lastGameButton").html("<i class='fas fa-chart-bar'></i> Mostrar Premiação")
        }
        lastGameToggled = !lastGameToggled;
    }
</script>
@endsection
