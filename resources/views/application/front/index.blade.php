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
        <div class="col-md-6 mt-2">
            <label for="contest">Escolha um concurso</label>
            <select name="contest" id="contest-select" class="form-control" onchange="applyLotteryNumbers(null)">

            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end mt-2">
            <button class="btn btn-secondary w-100" id="upload-button">
                Importar Jogos
            </button>
        </div>
        <div class="col-md-3 d-flex align-items-end mt-2">
            <button class="btn w-100 megasena" id="check-bet" onclick="checkBets()" style="display: none">
                <b>Conferir Apostas</b>
            </button>
        </div>
    </div>
</section>

<section id="contest-numbers" class="container mt-3">
    <div id="resume-games">

    </div>
    <div class="row">
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
            <small>Use uma nova linha para conferir mais de uma aposta. Siga o padrão proposto abaixo:</small><br>
            <b id="total-games">Total de Jogos: 0</b>
            <textarea name="dozens_text" id="text-check" cols="30" rows="10" class="form-control bets mb-3" placeholder="01,02,03,04,05,06" onchange="getLinesCount()"></textarea>
            <input id="text-file" type="file" accept=".txt" onchange="uploadFile()" class="form-control" style="display: none"/>
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
    applyLotteryNumbers();

    function uploadFile(){
        var file = document.getElementById("text-file").files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            const text = this.result;
            var textArea = document.getElementById("text-check");
            textArea.value = e.target.result;

            getLinesCount(text.split('\n'));

        };
        reader.readAsText(file);
    }

    $('#upload-button').on('click', function (){
        $('#text-file')[0].click();
    });

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

    let resultsTemplate = "";
    async function getContestResult(){
        let contestNumber = CONTEST_SELECT.val();

        if (contestNumber == "")
            return Swal.fire("Aviso!", "Escolha um concurso para exibir os resultados.", "warning");

        dozens = [];
        await clearDozens();

        CONTEST_SELECT.attr("disabled", true);
        LOTTERY_SELECT.attr("disabled", true);
        LOTTERY_BUTTON.attr("disabled", true);
        axios.get(`{{route('lottery.results')}}?loto_name=${lottery}&contest_number=${contestNumber}`)
            .then(response => {
                resultsChoosen = true;
                response.data.dozens.forEach(async item => {
                    await toggleDozen(`number-${item}`);
                })
                freeActions();
            })
            .catch(error => {
                console.log(error);
                console.log(error.response.data);
                freeActions();
            })
    }

    function checkBets(){
        if (!TEXT_CHECK.val())
            return Swal.fire("Aviso!", "Preencha pelo menos um jogo para conferir os resultados", "warning");
        if (!(dozens.length + 1) > getLotteryData().maxPrize)
            return Swal.fire("Aviso!", "Os resultados para essa loteria estão inválidos.", "warning");


        resultsTemplate = "";
        dozens.forEach(dozen => {
            resultsTemplate += `<span class="numbers ${getLotteryClass()}"><b>${dozen}</b></span>`;
        });

        CHECK_BUTTON.attr("disabled", true);
        CONTEST_SELECT.attr("disabled", true);
        LOTTERY_SELECT.attr("disabled", true);
        LOTTERY_BUTTON.attr("disabled", true);
        PLACE_GAMES.html('');
        RESUME_GAMES.html('');
        axios.post("{{route('check.results')}}", {
            dozens_text: TEXT_CHECK.val(),
            dozens,
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
                        betsTemplate += `<span class="numbers ${getLotteryClass()}"><b>${bet}</b></span>`;
                    });

                    let matchesTemplate = "";
                    splittedMatch.forEach(match => {
                        if (match)
                            matchesTemplate += `<span class="numbers ${getLotteryClass()} selected"><b>${match}</b></span>`;
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
                RESUME_GAMES.append(getBetsResume(response.data.bets.length, response.data.points));
                RESULTS_CONTAINER.show();
                RESUME_GAMES.show();
                CHECK_BUTTON.attr("disabled", false);
                freeActions();
            })
            .catch(error => {
                console.log(error.response.data);
                CHECK_BUTTON.attr("disabled", false);
                freeActions();
            })
    }

    function getBetsResume(totalGames, points){
        let template = "";
        template += `
            <div class="row justify-content-between">
                <div class="col-md-10">
                    <b mb-2>${lottery.replace('-', " ").toUpperCase()} CONCURSO ${CONTEST_SELECT.val()}</b>
                    <div class="row mt-1 mb-1">${resultsTemplate}</div>
                </div>
                <div class="col-md-2">
                    <img src="{{asset('img/logo-apostador.png')}}" alt="logo" class="w-100">
                </div>
            </div>
        `

        let tableHeaderTemplate = "<th style='width: 50px'>PONTOS</th>";
        let tableRowTemplate = "<th style='width: 50px'>ACERTOS</th>";
        let icon = ""
        switch(lottery){
            case "mega-sena":
                for(let i = megasenaLottery.totalPrize; i >= 1; i--){
                    if (i >= megasenaLottery.elegiblePrize)
                        icon = `<i class="fas fa-trophy"></i>`;
                    else
                        icon = "";
                    tableHeaderTemplate += `<th>${icon} ${i}</th>`;
                    tableRowTemplate += `<td>${getPoints(i, points)}</td>`
                }
                break;
            case "lotofacil":
                for(let i = lotofacilLottery.totalPrize; i >= 1; i--){
                    if (i >= lotofacilLottery.elegiblePrize)
                        icon = `<i class="fas fa-trophy"></i>`;
                    else
                        icon = "";
                    tableHeaderTemplate += `<th>${icon} ${i}</th>`;
                    tableRowTemplate += `<td>${getPoints(i, points)}</td>`
                }
                break;
            case "lotomania":
                for(let i = lotomaniaLottery.totalPrize; i >= 1; i--){
                    if (i >= lotomaniaLottery.elegiblePrize)
                        icon = `<i class="fas fa-trophy"></i>`;
                    else
                        icon = "";
                    tableHeaderTemplate += `<th>${icon} ${i}</th>`;
                    tableRowTemplate += `<td>${getPoints(i, points)}</td>`
                }
                break;
            case "dupla-sena":
                for(let i = duplaLottery.totalPrize; i >= 1; i--){
                    if (i >= duplaLottery.elegiblePrize)
                        icon = `<i class="fas fa-trophy"></i>`;
                    else
                        icon = "";
                    tableHeaderTemplate += `<th>${icon} ${i}</th>`;
                    tableRowTemplate += `<td>${getPoints(i, points)}</td>`
                }
                break;
            case "quina":
                for(let i = quinaLottery.totalPrize; i >= 1; i--){
                    if (i >= quinaLottery.elegiblePrize)
                        icon = `<i class="fas fa-trophy"></i>`;
                    else
                        icon = "";
                    tableHeaderTemplate += `<th>${icon} ${i}</th>`;
                    tableRowTemplate += `<td>${getPoints(i, points)}</td>`
                }
                break;
            case "dia-de-sorte":
                for(let i = diaLottery.totalPrize; i >= 1; i--){
                    if (i >= diaLottery.elegiblePrize)
                        icon = `<i class="fas fa-trophy"></i>`;
                    else
                        icon = "";
                    tableHeaderTemplate += `<th>${icon} ${i}</th>`;
                    tableRowTemplate += `<td>${getPoints(i, points)}</td>`
                }
                break;
            case "timemania":
                for(let i = timeLottery.totalPrize; i >= 1; i--){
                    if (i >= timeLottery.elegiblePrize)
                        icon = `<i class="fas fa-trophy"></i>`;
                    else
                        icon = "";
                    tableHeaderTemplate += `<th>${icon} ${i}</th>`;
                    tableRowTemplate += `<td>${getPoints(i, points)}</td>`
                }
                break;
        };

        template += `
            <div class="table-responsive">
                <table class="table ${getLotteryClass('border')} w-100">
                    <thead class="${getLotteryClass('lottery')}">
                        <tr class="text-center">
                            ${tableHeaderTemplate}
                        <tr>
                    </thead>

                    <tbody>
                        <tr class="text-center">
                            ${tableRowTemplate}
                        <tr>
                    <tbody>
                </table>
            </div>
        `
        return template;
    }
</script>
@endsection
