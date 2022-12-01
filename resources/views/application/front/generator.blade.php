@extends('application.front.template.main')

@section("css")
<style>
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

<section id="contest-numbers" class="container mt-3">
    <div id="resume-games">

    </div>
    <div class="row mb-2">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 d-flex align-items-end mt-2">
                    <button class="btn btn-secondary w-100" id="lottery-button" onclick="getNumbers()" disabled>
                        <i class="fas fa-thumbs-up"></i> Palpite Apostador
                    </button>
                </div>
            </div>
            <div id="contest-display" style="display: none">
                <span id="numbers-header" class="megasena">
                    <i>Mega-Sena</i>
                </span>
                <div id="numbers" class="w-100 megasena-border">

                </div>
            </div>
            <div class="row">
                <div class="col-md-6 d-flex align-items-end mt-2">
                    <button class="btn btn-outline-success w-100" id="selectGameButton" onclick="selectGame()" disabled>
                        <i class="fas fa-check"></i> Selecionar Jogo
                    </button>
                </div>
                <div class="col-md-6 d-flex align-items-end mt-2">
                    <button class="btn btn-outline-danger w-100" onclick="deleteAllGames()">
                        <i class="fa fa-trash"></i> Limpar Jogos
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="d-flex align-items-center justify-content-center mt-2 mb-2 w-100">
                <button class="btn btn-outline-info w-100" id="checkBet" onclick="checkBetsForGenerator()">
                    <i class="fas fa-chart-bar"></i> Conferir Premiação
                </button>
            </div>
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
                <span id="lastContestLabel">Repetidos do Anterior:</span>
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
            <div class="d-flex align-items-center justify-content-center mt-2 w-100">
                <button class="btn btn-outline-info w-100" id="lastGameButton" onclick="toggleLastGameContainer()" disabled>
                    Exibir último resultado
                </button>
            </div>

            <div id="lastGameContainer" class="row flex-row justify-content-center mt-2" style="display: none">
                <h4 class="text-center w-100" id="contestLabel">Estatísticas do Último Concurso</h4>
                <div class="col-md-12">
                    <div id="lastGame" class="row d-flex flex-row justify-content-center mb-2">
        
                    </div>
                    <div class="w-100 bg-black text-white p-2 text-center">
                        <b>Parâmetros Principais</b>
                    </div>
                    <div class="border p-2 d-flex flex-row justify-content-center">
                        <div class="col-md-6 d-flex flex-row justify-content-center">
                            <span>Par:</span>
                            <span id="lastEven" class="text-bold ml-2" style="border: none !important">0</span>
                        </div>
                        |
                        <div class="col-md-6 d-flex flex-row justify-content-center">
                            <span>Ímpar:</span>
                            <span id="lastOdd" class="text-bold ml-2" style="border: none !important">0</span>
                        </div>
                    </div>
                    <div class="border p-2 d-flex flex-row justify-content-center">
                        <span>Números de Fibonacci:</span>
                        <span id="lastFibonacci" class="text-bold ml-2" style="border: none !important">0</span>
                    </div>
                    <div class="w-100 bg-black text-white p-2 text-center mt-3">
                        <b>Parâmetros Secundários</b>
                    </div>
                    <div class="border p-2 d-flex flex-row justify-content-center">
                        <span>Primos:</span>
                        <span id="lastPrime" class="text-bold ml-2" style="border: none !important">0</span>
                    </div>
                    <div class="border p-2 d-flex flex-row justify-content-center">
                        <span>Múltiplos de 3:</span>
                        <span id="lastThreeMultiple" class="text-bold ml-2" style="border: none !important">0</span>
                    </div>
                    <div class="border p-2 d-flex flex-row justify-content-center">
                        <span>Soma das Dezenas:</span>
                        <span id="lastSum" class="text-bold ml-2" style="border: none !important">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="checked-games-container" class="container mt-3">
    <h4 class="text-center">Conferir a Premiação</h4>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Faixa</th>
                        <th class="text-center">Acertos</th>
                    </tr>
                </thead>
                <tbody id="check-resume-content">

                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Concurso</th>
                        <th class="text-center">Acertos</th>
                    </tr>
                </thead>
                <tbody id="check-game-by-game-content">

                </tbody>
            </table>
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
    $(document).ready(function(){
        axios.post("{{route('generate.last')}}", { lottery })
        .then(response => {
            $("#lastContestLabel").html(`Repetidas do (${response.data.lastResult.contestNumber})`);
            lastResult = response.data.lastResult;
            $("#selectGameButton").attr('disabled', false);
            $("#lastGameButton").attr('disabled', false);
            $("#lottery-button").attr('disabled', false);
            showGenerateResults('lastResults', lastResult);
        })
        .catch(error => {
            console.log(error.response.data);
        });
    })
    let lastResult;
    let generateInfoToGeneratorPage = true;

    applyLotteryNumbers(false, false);
    setCheckResumeLayout();

    function setCheckResumeLayout(){
        $("#check-resume-content").html('');
        let template = "";
        for(let i = getLotteryData().elegiblePrize; i <= getLotteryData().totalPrize; i++){
            template += `
                <tr>
                    <td class="text-center">${i}</td>
                    <td class="text-center" id="check-resume-${i}">0</td>
                </tr>
            `;
        }

        template +=`
            <tr>
                <td class="text-center">Total </td>
                <td class="text-center" id="check-resume-total">0</td>
            </tr>
        `

        $("#check-resume-content").html(template);
    }

    function getNumbers(){
        let maxNumber = getLotteryData().max;
        let maxPrize = getLotteryData().minSelected;

        let params = getDefaultParams();
        let randomNumber = 0;
        let releaseGenerator = false;
        let count = 0;
        while(releaseGenerator != true){
            let generatedDozens = [];
            while (generatedDozens.length < maxPrize){
                randomNumber = Math.floor(Math.random() * (maxNumber)) + 1;
                let generatedDozen = randomNumber.toString().padStart(2, "0");
                if (generatedDozen == "100") generatedDozen = "00";
                if (!generatedDozens.includes(generatedDozen)){
                    generatedDozens.push(generatedDozen);
                }
            }

            let info = getInfo(generatedDozens);

            count++;
            if (count > 15000){
                console.log(count);
                alert("Não conseguimos gerar um jogo adequado.");
                break;
            }

            info.lastLotteryDozensMatch = lastResult.dozens.filter((obj) => generatedDozens.indexOf(obj) !== -1).length;

            if (
                info.lastLotteryDozensMatch >= params.minCompare && info.lastLotteryDozensMatch <= params.maxCompare &&
                info.odd >= params.minOdd && info.odd <= params.maxOdd &&
                info.sum >= params.minSum && info.sum <= params.maxSum &&
                info.even >= params.minEven && info.even <= params.maxEven &&
                info.prime >= params.minPrime && info.prime <= params.maxPrime &&
                info.threeMultiple >= params.minThreeMultiple && info.threeMultiple <= params.maxThreeMultiple &&
                info.fibonacci >= params.minFibonacci && info.fibonacci <= params.maxFibonacci
            ) {
                dozens = generatedDozens;
                releaseGenerator = true;
                showGenerateResults('info', info);
            }
        }
    }

    let lastGameToggled = false;
    function toggleLastGameContainer(){
        if (!lastGameToggled){
            $("#lastGameContainer").show();
            $("#lastGameButton").html("<i class='fas fa-chart-bar'></i> Esconder último resultado")
        }else{
            $("#lastGameContainer").hide();
            $("#lastGameButton").html("<i class='fas fa-chart-bar'></i> Exibir último resultado")
        }
        lastGameToggled = !lastGameToggled;
    }

    function checkBetsForGenerator(){
        if (dozens.length < getLotteryData().totalPrize)
            return Swal.fire("Erro", `O total de números selecionados precisam ser maior ou igual a ${getLotteryData().totalPrize}`, "error");
        console.log(dozens);
        setCheckResumeLayout();
        $("#check-game-by-game-content").html('');
        axios.post("{{route('check.primes')}}", {
            lottery,
            dozens,
            minElegible: getLotteryData().elegiblePrize
        })
            .then(response =>{
                let countTotal = 0;
                let data = response.data;
                Object.keys(data).forEach(key => {
                    $(`#check-resume-${key}`).html(data[key].count);
                    countTotal += data[key].count;
                    data[key].contests.forEach(contest => {
                        $("#check-game-by-game-content").append(`
                            <tr class="${getLotteryClass('lottery')}">
                                <td class="text-center">${contest}</td>
                                <td class="text-center">${key}</td>
                            </tr>
                        `);
                    })
                });
                $("#check-resume-total").html(countTotal);
            })
            .catch(error => {
                console.log(error.response.data);
            })
    }
</script>
@endsection
