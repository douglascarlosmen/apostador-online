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
        <div class="col-md-4 mt-2">
            <label for="lottery">Escolha a loteria</label>
            <select name="lottery" id="lottery-select" class="form-control" onchange="applyLotteryNumbers(event)">
                <option value="">CLIQUE AQUI E ESCOLHA</option>
                <option value="mega-sena">Mega-Sena</option>
                <option value="lotofacil">Lotofácil</option>
                <option value="lotomania">Lotomania</option>
                <option value="dupla-sena">Dupla-Sena</option>
                <option value="quina">Quina</option>
                <option value="dia-de-sorte">Dia de Sorte</option>
                <option value="timemania">Timemania</option>
            </select>
        </div>

        <div class="col-md-4 mt-2">
            <label for="contest">Escolha um concurso</label>
            <select name="contest" id="contest-select" class="form-control" onchange="applyLotteryNumbers(null, false)">
                <option value="">CLIQUE AQUI E ESCOLHA</option>
            </select>
        </div>

        <div class="col-md-4 d-flex align-items-end">
            <button class="btn btn-success w-100" id="lottery-button" onclick="getContestResult()">
                Escolher
            </button>
        </div>
    </div>
</section>

<section id="contest-numbers" class="container mt-3">
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
            <small>Use uma nova linha para conferir mais de uma aposta. Siga o padrão proposto abaixo:</small>
            <textarea name="dozens_text" id="text-check" cols="30" rows="10" class="form-control bets mb-3" placeholder="01,02,03,04,05,06"></textarea>
            <input id="text-file" type="file" accept=".txt" onchange="uploadFile()" class="form-control" style="display: none"/>
            <button class="btn btn-secondary w-100 mb-2" id="upload-button">
                Importar Jogos
            </button>
            <button class="btn w-100 megasena" id="check-bet" onclick="checkBets()" disabled>
                <b>Conferir Apostas</b>
            </button>
        </div>
    </div>
</section>

<section id="results" class="container mt-3" style="display: none">
    <h1 class="text-center">Confira os seus resultados</h1>
    <div id="place-games" class="row justify-content-center">

    </div>
</section>

@endsection

@section("scripts")
<script>
    const NUMBERS_CONTAINER = $("#numbers");
    const NUMBERS_HEADER = $("#numbers-header");
    const CHECK_BUTTON = $("#check-bet");
    const CONTEST_SELECT = $("#contest-select");
    const LOTTERY_SELECT = $("#lottery-select");
    const LOTTERY_BUTTON = $("#lottery-button");
    const TEXT_CHECK = $("#text-check");
    const PLACE_GAMES = $("#place-games");
    const RESULTS_CONTAINER = $("#results");


    var resultsChoosen = false;
    var lottery = "mega-sena";

    applyLotteryNumbers(null);

    function applyLotteryNumbers(event, getOptions = true){
        let oldLottery = lottery;
        if (event != null) lottery = event.target.value;
        resultsChoosen = false;
        changeLotteryLayout(oldLottery, lottery);

        if (getOptions) {
            getContestOptions(lottery);
        }else{
            RESULTS_CONTAINER.hide();
        }

        let megasenaNumbers = { min: 1, max: 60 }
        let lotofacilNumbers = { min: 1, max: 25 }
        let lotomaniaNumbers = { min: 1, max: 100 }
        let quinaNumbers = { min: 1, max: 80 }
        let duplaNumbers = { min: 1, max: 50 }
        let diaNumbers = { min: 1, max: 31 }
        let timeNumbers = { min: 1, max: 80 }

        NUMBERS_CONTAINER.html('');
        switch (lottery){
            case "mega-sena":
                for(let i = megasenaNumbers.min; i <= megasenaNumbers.max; i++){
                    NUMBERS_CONTAINER.append(`<span class="col-5 megasena-number" id="number-${leftPad(i, 2)}"><strong>${leftPad(i, 2)}</strong></span>`)
                }
                break;
            case "lotofacil":
                for(let i = lotofacilNumbers.min; i <= lotofacilNumbers.max; i++){
                    NUMBERS_CONTAINER.append(`<span class="col-5 lotofacil-number" id="number-${leftPad(i, 2)}"><strong>${leftPad(i, 2)}</strong></span>`)
                }
                break;
            case "lotomania":
                for(let i = lotomaniaNumbers.min; i <= lotomaniaNumbers.max; i++){
                    if (i == 100){
                        NUMBERS_CONTAINER.append(`<span class="col-5 lotomania-number" id="number-${leftPad(i, 2)}"><strong>${leftPad(00, 2)}</strong></span>`)
                    }else{
                        NUMBERS_CONTAINER.append(`<span class="col-5 lotomania-number" id="number-${leftPad(i, 2)}"><strong>${leftPad(i, 2)}</strong></span>`)
                    }
                }
                break;
            case "dupla-sena":
                for(let i = duplaNumbers.min; i <= duplaNumbers.max; i++){
                    NUMBERS_CONTAINER.append(`<span class="col-5 dupla-number" id="number-${leftPad(i, 2)}"><strong>${leftPad(i, 2)}</strong></span>`)
                }
                break;
            case "quina":
                for(let i = quinaNumbers.min; i <= quinaNumbers.max; i++){
                    NUMBERS_CONTAINER.append(`<span class="col-5 quina-number" id="number-${leftPad(i, 2)}""><strong>${leftPad(i, 2)}</strong></span>`)
                }
                break;
            case "dia-de-sorte":
                for(let i = duplaNumbers.min; i <= duplaNumbers.max; i++){
                    NUMBERS_CONTAINER.append(`<span class="col-5 dia-number" id="number-${leftPad(i, 2)}"><strong>${leftPad(i, 2)}</strong></span>`)
                }
                break;
            case "timemania":
                for(let i = timeNumbers.min; i <= timeNumbers.max; i++){
                    NUMBERS_CONTAINER.append(`<span class="col-5 time-number" id="number-${leftPad(i, 2)}"><strong>${leftPad(i, 2)}</strong></span>`)
                }
                break;
        }
    }

    function changeLotteryLayout(oldLottery, lottery){
        //Remove old style
        switch (oldLottery){
            case "mega-sena":
                NUMBERS_CONTAINER.removeClass("megasena-border");
                NUMBERS_HEADER.removeClass("megasena");
                CHECK_BUTTON.removeClass("megasena");
                break;
            case "lotofacil":
                NUMBERS_CONTAINER.removeClass("lotofacil-border");
                NUMBERS_HEADER.removeClass("lotofacil");
                CHECK_BUTTON.removeClass("lotofacil");
                break;
            case "lotomania":
                NUMBERS_CONTAINER.removeClass("lotomania-border");
                NUMBERS_HEADER.removeClass("lotomania");
                CHECK_BUTTON.removeClass("lotomania");
                break;
            case "dupla-sena":
                NUMBERS_CONTAINER.removeClass("dupla-border");
                NUMBERS_HEADER.removeClass("dupla");
                CHECK_BUTTON.removeClass("dupla");
                break;
            case "quina":
                NUMBERS_CONTAINER.removeClass("quina-border");
                NUMBERS_HEADER.removeClass("quina");
                CHECK_BUTTON.removeClass("quina");
                break;
            case "dia-de-sorte":
                NUMBERS_CONTAINER.removeClass("dia-border");
                NUMBERS_HEADER.removeClass("dia");
                CHECK_BUTTON.removeClass("dia");
                break;
            case "timemania":
                NUMBERS_CONTAINER.removeClass("time-border");
                NUMBERS_HEADER.removeClass("time");
                CHECK_BUTTON.removeClass("time");
                break;
        }

        //add new style
        NUMBERS_HEADER.html('');
        switch(lottery){
            case "mega-sena":
                NUMBERS_CONTAINER.addClass("megasena-border");
                NUMBERS_HEADER.addClass("megasena");
                NUMBERS_HEADER.append("<i>Mega-Sena</i>");
                CHECK_BUTTON.addClass("megasena");
                break;
            case "lotofacil":
                NUMBERS_CONTAINER.addClass("lotofacil-border");
                NUMBERS_HEADER.addClass("lotofacil");
                NUMBERS_HEADER.append("<i>Lotofácil</i>");
                CHECK_BUTTON.addClass("lotofacil");
                break;
            case "lotomania":
                NUMBERS_CONTAINER.addClass("lotomania-border");
                NUMBERS_HEADER.addClass("lotomania");
                NUMBERS_HEADER.append("<i>Lotomania</i>");
                CHECK_BUTTON.addClass("lotomania");
                break;
            case "dupla-sena":
                NUMBERS_CONTAINER.addClass("dupla-border");
                NUMBERS_HEADER.addClass("dupla");
                NUMBERS_HEADER.append("<i>Dupla-Sena</i>");
                CHECK_BUTTON.addClass("dupla");
                break;
            case "quina":
                NUMBERS_CONTAINER.addClass("quina-border");
                NUMBERS_HEADER.addClass("quina");
                NUMBERS_HEADER.append("<i>Quina</i>");
                CHECK_BUTTON.addClass("quina");
                break;
            case "dia-de-sorte":
                NUMBERS_CONTAINER.addClass("dia-border");
                NUMBERS_HEADER.addClass("dia");
                NUMBERS_HEADER.append("<i>Dia de Sorte</i>");
                CHECK_BUTTON.addClass("dia");
                break;
            case "timemania":
                NUMBERS_CONTAINER.addClass("time-border");
                NUMBERS_HEADER.addClass("time");
                NUMBERS_HEADER.append("<i>Timemania</i>");
                CHECK_BUTTON.addClass("time");
                break;
        }

    }

    function leftPad(value, totalWidth, paddingChar) {
        var length = totalWidth - value.toString().length + 1;
        return Array(length).join(paddingChar || '0') + value;
    }

    function uploadFile(){
        var file = document.getElementById("text-file").files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            var textArea = document.getElementById("text-check");
            textArea.value = e.target.result;
        };
        reader.readAsText(file);
    }

    $('#upload-button').on('click', function (){
        $('#text-file')[0].click();
    });

    function getContestOptions(){
        axios.get(`{{route('lottery.contest')}}?loto_name=${lottery}`)
            .then(response => {
                CONTEST_SELECT.html('');
                CONTEST_SELECT.append('<option value="">CLIQUE AQUI E ESCOLHA</option>')
                response.data.contestsNumbers.forEach(item => {
                    CONTEST_SELECT.append(`<option value=${item}>${item}</option>`)
                })
            })
            .catch(error => {
                console.log(error.response.data);
            })
    }

    function getContestResult(){
        let contestNumber = CONTEST_SELECT.val();
        CHECK_BUTTON.attr("disabled", false);
        CONTEST_SELECT.attr("disabled", true);
        LOTTERY_SELECT.attr("disabled", true);
        LOTTERY_BUTTON.attr("disabled", true);
        axios.get(`{{route('lottery.results')}}?loto_name=${lottery}&contest_number=${contestNumber}`)
            .then(response => {
                resultsChoosen = true;
                response.data.dozens.forEach(item => {
                    NUMBERS_CONTAINER.children(`#number-${item}`).addClass('selected')
                })
                freeActions();
            })
            .catch(error => {
                console.log(error.response.data);
                freeActions();
            })
    }

    function freeActions(){
        CONTEST_SELECT.attr("disabled", false);
        LOTTERY_SELECT.attr("disabled", false);
        LOTTERY_BUTTON.attr("disabled", false);
    }

    function checkBets(){
        if (!resultsChoosen)
            return Swal.fire("Aviso!", "Escolha um concurso para exibir os resultados.", "warning");
        if (!TEXT_CHECK.val())
            return Swal.fire("Aviso!", "Preencha pelo menos um jogo para conferir os resultados", "warning");

        CHECK_BUTTON.attr("disabled", true);
        CONTEST_SELECT.attr("disabled", true);
        LOTTERY_SELECT.attr("disabled", true);
        LOTTERY_BUTTON.attr("disabled", true);
        PLACE_GAMES.html('')
        axios.post("{{route('check.results')}}", {
            dozens_text: TEXT_CHECK.val(),
            contest_number: CONTEST_SELECT.val(),
            loto_name: lottery
        })
            .then(response => {
                let splittedBet = "";
                let splittedMatch = "";
                response.data.bets.forEach((item, i) => {
                    splittedBet = item.split(',');
                    splittedMatch = response.data.matches[i].split(',');

                    let betsTemplate = "";
                    splittedBet.forEach(bet => {
                        betsTemplate += `<span class="numbers ${getLotteryNumberClass()}"><b>${bet}</b></span>`;
                    });

                    let matchesTemplate = "";
                    splittedMatch.forEach(match => {
                        if (match)
                            matchesTemplate += `<span class="numbers ${getLotteryNumberClass()} selected"><b>${match}</b></span>`;
                        else
                            matchesTemplate += `<span> Nenhuma dezena acertada. </span>`
                    });

                    let template = `
                    <div id="bet-${i}" class="card col-md-3 m-2 p-2 shadow-lg">
                        <div class="card-body">
                            <b>Jogo ${i + 1} - ${response.data.points[i]} Acertos</b>
                            <div class="row">
                                <div class="row">
                                    ${betsTemplate}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="row">
                                    ${matchesTemplate}
                                </div>
                            </div>
                        </div>
                    </div>
                    `
                    PLACE_GAMES.append(template);
                })
                RESULTS_CONTAINER.show();
                CHECK_BUTTON.attr("disabled", false);
                freeActions();
            })
            .catch(error => {
                console.log(error.response.data);
                CHECK_BUTTON.attr("disabled", false);
                freeActions();
            })
    }

    function getLotteryNumberClass(){
        let lotteryNumberClass = "mega-sena";

        switch(lottery){
            case "mega-sena":
                lotteryNumberClass = "megasena-number";
                break;
            case "lotofacil":
                lotteryNumberClass = "lotofacil-number";
                break;
            case "lotomania":
                lotteryNumberClass = "lotomania-number";
                break;
            case "dupla-sena":
                lotteryNumberClass = "dupla-number";
                break;
            case "quina":
                lotteryNumberClass = "quina-number";
                break;
            case "dia-de-sorte":
                lotteryNumberClass = "dia-number";
                break;
            case "timemania":
                lotteryNumberClass = "time-number";
                break;
        }

        return lotteryNumberClass;
    }
</script>

@endsection
