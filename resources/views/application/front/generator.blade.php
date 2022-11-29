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

    .loading-overlay{
        position: absolute;
        height: 100%;
        width: 100%;
        z-index: 1000;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
@endsection

@section("content")
@include("application.front.template.navbar")

<section id="contest-selection" class="container pt-5">
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
                <span id="lastThreeMultiple" class="text-bold ml-2">0</span>
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
    let lastResult;

    axios.post("{{route('generate.last')}}", { lottery })
        .then(response => {
            lastResult = response.data.lastResult;
        })
        .catch(error => {
            console.log(error.response.data);
        })

    applyLotteryNumbers(false, false);

    function getNumbers(){
        let maxNumber = getLotteryData().max;
        let maxPrize = getLotteryData().minSelected;

        let params = getDefaultParams();
        let randomNumber = 0;
        let releaseGenerator = false;
        let count = 0;
        while(releaseGenerator != true){
            let generatedDozens = [];
            let info = {
                even: 0,
                odd: 0,
                fibonacci: 0,
                prime: 0,
                sum: 0,
                threeMultiple: 0,
                dozens: 0
            };
            while (generatedDozens.length < maxPrize){
                randomNumber = Math.floor(Math.random() * (maxNumber)) + 1;
                let generatedDozen = randomNumber.toString().padStart(2, "0");
                if (generatedDozen == "100") generatedDozen = "00";
                if (!generatedDozens.includes(generatedDozen)){
                    generatedDozens.push(generatedDozen);
                }
            }

            generatedDozens.forEach(dozen => {
                let intDozen = parseInt(dozen);
                if (intDozen % 2 == 0) info.even++;
                else if (intDozen % 2 != 0) info.odd++;

                if (isPrime(intDozen)) info.prime++;

                if (isFibonacci(intDozen)) info.fibonacci++;

                if (intDozen % 3 == 0) info.threeMultiple++;

                info.sum += intDozen;
            });
            info.dozens = generatedDozens.length;

            count++;
            if (count > 2500){
                alert("Não conseguimos gerar um jogo adequado.");
                break;
            }
            //Check if the combination matches the parameters
            if (
                info.odd >= params.minOdd && info.odd <= params.maxOdd &&
                info.sum >= params.minSum && info.sum <= params.maxSum &&
                info.even >= params.minEven && info.even <= params.maxEven &&
                info.prime >= params.minPrime && info.prime <= params.maxPrime &&
                info.threeMultiple >= params.minThreeMultiple && info.threeMultiple <= params.maxThreeMultiple &&
                info.fibonacci >= params.minFibonacci && info.fibonacci <= params.maxFibonacci
            ) {
                info.lastLotteryDozensMatch = lastResult.dozens.filter((obj) => generatedDozens.indexOf(obj) !== -1).length;
                dozens = generatedDozens;
                releaseGenerator = true;
                showGenerateResults(info, lastResult);
            }
        }
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
