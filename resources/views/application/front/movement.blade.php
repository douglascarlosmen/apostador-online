@extends('application.front.template.main')

@section("css")
<style>
    .border-black tr td, .border-black tr th{
        border-color:#000 !important;
    }

    table td:nth-child(5n + 1){
        border-right: 3px solid #000;
    }

    td{
        background-color: #CCC;
    }

    table td, table th{
        padding: 5px !important;
    }

    .bg-frequency-bad{
        background-color: rgb(216, 39, 39);
    }
    .bg-frequency-medium{
        background-color:  rgb(224, 165, 54);
    }
    .bg-frequency-good{
        background-color: rgb(63, 199, 63);
        color: white;
    }

    .label-box{
        color: transparent;
        border: 1px solid #333;
        padding: 2px 15px;
    }

    .bg-late-bad{
        background-color: #F7D2D1;
    }
    .bg-late-medium{
        background-color:  #D91E18;
    }
    .bg-late-good{
        background-color: #F9B42D;
    }

    .bg-dark-01{
        background-color: #000;
        color: #FFF;
    }
    .bg-dark-02{
        background: #555;
        color: #fff;
    }
    .bg-dark-03{
        background: #333;
        color: #fff;
    }

    td.lotofacil{
        background-color: #930989 !important;
    }

    .game-two{
        background-color: #cc0c32;
    }
</style>
@endsection

@section("content")
@include("application.front.template.navbar")

<section id="movement" class="container mt-3">
    <h1 id="header" class="text-center">Tabela de Movimentação</h1>
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-center">Filtragem Rápida</h3>
            <div class="row justify-content-center">
                <div class="col-md-2 fast-filter mt-1">
                    <input type="hidden" name="limit" value="10">
                    <button class="btn btn-outline-secondary w-100" onclick="fastFilter(10)">
                        Últimos <b>10</b> conc.
                    </button>
                </div>
                <div class="col-md-2 fast-filter mt-1">
                    <input type="hidden" name="limit" value="20">
                    <button class="btn btn-outline-secondary w-100" onclick="fastFilter(20)">
                        Últimos <b>20</b> conc.
                    </button>
                </div>
                <div class="col-md-2 fast-filter mt-1">
                    <input type="hidden" name="limit" value="30">
                    <button class="btn btn-outline-secondary w-100" onclick="fastFilter(30)">
                        Últimos <b>30</b> conc.
                    </button>
                </div>
                <div class="col-md-2 fast-filter mt-1">
                    <input type="hidden" name="limit" value="50">
                    <button class="btn btn-outline-secondary w-100" onclick="fastFilter(50)">
                        Últimos <b>50</b> conc.
                    </button>
                </div>
                <div class="col-md-2 fast-filter mt-1">
                    <input type="hidden" name="limit" value="150">
                    <button class="btn btn-outline-secondary w-100" onclick="fastFilter(150)">
                        Últimos <b>100</b> conc.
                    </button>
                </div>
                <div class="col-md-2 fast-filter mt-1">
                    <input type="hidden" name="limit" value="150">
                    <button class="btn btn-outline-secondary w-100" onclick="fastFilter('all')">
                        Todos concursos
                    </button>
                </div>
            </div>
        </div>
    </div>
    @if (request()->lottery == "dupla-sena")
        <div class="d-flex flex-column justify-content-center align-items-center mt-2">
            <p>Legenda Dupla-Sena</p>
            <div class="row">
                <p class="mr-2"><span class="dupla label-box">.</span> 1° Sorteio</p>
                <p><span class="game-two label-box">.</span> 2° Sorteio</p>
            </div>
        </div>
    @endif
    <div class="table-responsive mt-5" id="movement-table">

    </div>
</section>

@endsection

@section("scripts")
<script src="{{asset('js/apostador.js')}}"></script>
<script src="{{asset('js/movement.js')}}"></script>
<script>
    let lastResult;
    let generateInfoToGeneratorPage = false;
    let multiToggle = false;
    let extension = "";

    let oldLottery = lottery;
    let splittedUrl = location.href.split('/');
    lottery = splittedUrl[splittedUrl.length - 1];

    getMovementTable();

    async function getMovementTable(){
        let route = "{{route('tabela_movimentacao', 'lottery')}}".replace('lottery', lottery);
        axios.get(`${route}${extension}`)
            .then(response => {
                console.log(response.data);
                mountTable(response.data);
            })
            .catch(error => {
                console.log(error);
                console.log(error.response.data);
            })
    }

    function mountTable(data){
        $("#movement-table").html('');
        let tableHeaderTemplate = "<th style='width: 50px'>Conc.</th>";
        let tableRowTemplate = "";
        let template = "";

        for (let i = 1; i <= getLotteryData().max; i++){
            if (i == 100) tableHeaderTemplate += `<th>00</th>`;
            else tableHeaderTemplate += `<th>${i.toString().padStart(2, "0")}</th>`;
        }

        tableHeaderTemplate += `
            <th>Par</th>
            <th>Ímpar</th>
            <th>Repetidas</th>
        `;

        let lastCycle = "";

        Object.keys(data[1]).forEach((key, index) => {
            tableRowTemplate += "<tr class='text-center'>";
            let alreadySetted = 0;
            tableRowTemplate += `<th class="${getLotteryClass('lottery')}">${key}</th>`;
            if (lottery == "dupla-sena"){ //dupla-sena return 2 contests in one array result
                let dozenIndex = "";
                for(let i = 1; i <= getLotteryData().max; i++){
                    if (data[1][key].dozens.includes(i.toString().padStart(2, "0"))){
                        dozenIndex = data[1][key].dozens.indexOf(i.toString().padStart(2, "0"))
                        tableRowTemplate += `<td class="${getLotteryClass('lottery')} ${getDuplaSenaGameClass(dozenIndex)}">${data[1][key].dozens[dozenIndex]}</td>`;
                        alreadySetted++;
                    }else{
                        tableRowTemplate += `<td></td>`;
                    }
                }
            }else{
                for(let i = 1; i <= getLotteryData().max; i++){
                    if (alreadySetted <= getLotteryData().totalPrize && data[1][key].dozens.includes(i.toString().padStart(2, "0"))){
                        tableRowTemplate += `<td class="${getLotteryClass('lottery')}">${data[1][key].dozens[alreadySetted]}</td>`;
                        alreadySetted++;
                    }else{
                        //lotomania check
                        if (i == 100 && data[1][key].dozens.includes("00")) tableRowTemplate += `<td class="${getLotteryClass('lottery')}">00</td>`;
                        else tableRowTemplate += `<td></td>`;
                    }
                }
            }
            tableRowTemplate += `
                <td style="background-color: #FF6A6A"><b>${data[1][key].even ?? 0}</b></td>
                <td style="background-color: #FF6A6A"><b>${data[1][key].odd ?? 0}</b></td>
                <td style="background-color: #FF6A6A"><b>${data[1][key].repeat ?? 0}</b></td>
            `;

            tableRowTemplate += `</tr>`;
            if (data[1][key].cycle){
                lastCycle = data[1][key].cycle;
                tableRowTemplate += `<tr><td class="text-center" colspan="${getLotteryData().max + 4}"><b>Início do ciclo ${parseInt(data[1][key].cycle) + 1}</b></td></tr>`
            }
        });

        let row1 = "<tr><th class='text-center bg-dark-01'>Dezenas Atrasadas</th>";
        let row2 = "<tr><th class='text-center bg-dark-02'>Frequência</th>";
        let row4 = "<tr><th class='text-center'>Maior Atraso</th>";
        let row5 = "<tr><th class='text-center'>Maior Sequência</th>";

        for (let i = 1; i <= getLotteryData().max; i++){
            //lotomania check
            if (i == 100){
                console.log(data[0]["00"])
                if (data[0]["00"]?.atraso_atual) row1 += `<td class="text-center ${getLateBg(data[0]["00"].atraso_atual)}">${data[0]["00"].atraso_atual}</td>`;
                else row1 += `<td class="text-center ${getLateBg(0)}">-</td>`;

                if (data[0]["00"]?.freq_porc) row2 += `<td class="text-center ${getFrequencyBg(data[0]["00"].freq_porc)}">${data[0]["00"].freq_porc}</td>`;
                else row2 += `<td class="text-center ${getLateBg(0)}">-</td>`;

                if (data[0]["00"]?.maior_atraso)  row4 += `<td class="text-center">${data[0]["00"].maior_atraso}</td>`;
                else row4 += `<td class="text-center">-</td>`;

                if (data[0]["00"]?.maior_seq) row5 += `<td class="text-center">${data[0]["00"].maior_seq}</td>`;
                else row5 += `<td class="text-center">-</td>`;
            }else{
                let formattedIndex = i.toString().padStart(2, "0");

                if (data[0][formattedIndex]?.atraso_atual) row1 += `<td class="text-center ${getLateBg(data[0][formattedIndex].atraso_atual)}">${data[0][formattedIndex].atraso_atual}</td>`;
                else row1 += `<td class="text-center ${getLateBg(0)}">-</td>`;

                if (data[0][formattedIndex]?.freq_porc) row2 += `<td class="text-center ${getFrequencyBg(data[0][formattedIndex].freq_porc)}">${data[0][formattedIndex].freq_porc}</td>`;
                else row2 += `<td class="text-center ${getLateBg(0)}">-</td>`;

                if (data[0][formattedIndex]?.maior_atraso)  row4 += `<td class="text-center">${data[0][formattedIndex].maior_atraso}</td>`;
                else row4 += `<td class="text-center">-</td>`;

                if (data[0][formattedIndex]?.maior_seq) row5 += `<td class="text-center">${data[0][formattedIndex].maior_seq}</td>`;
                else row5 += `<td class="text-center">-</td>`;
            }
        }

        row1 += "</tr>";
        row2 += "</tr>";
        row3 += "</tr>";
        row4 += "</tr>";
        row5 += "</tr>";

        let cycleDozens = "";
        data[2].forEach((dozen, index) => {
            if (index != data[2].length - 1) cycleDozens += dozen + " | ";
            else cycleDozens += dozen;
        });

        template += `
            <table class="table ${getLotteryClass('border')} w-100 table-bordered border-black"">
                <thead class="${getLotteryClass('lottery')}">
                    <tr class="text-center">
                        ${tableHeaderTemplate}
                    <tr>
                </thead>

                <tbody>
                    ${tableRowTemplate}
                </tbody>

                <tfoot>
                    <tr>
                        <td style="background-color: white; border-width: 0px" colspan="${getLotteryData().max + 4}">
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <b>Ciclo (${lastCycle}) - Dezenas ausentes no ciclo</b>
                                <b>${cycleDozens}</b>
                                <b class="mt-2">Legenda</b>
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-4" style="width: 100px">
                                        <p><span class="bg-frequency-good label-box">.</span> Alta</p>
                                    </div>
                                    <div class="col-4" style="width: 100px">
                                        <p><span class="bg-frequency-medium label-box">.</span> Média</p>
                                    </div>
                                    <div class="col-4" style="width: 100px">
                                        <p><span class="bg-frequency-bad label-box">.</span> Baixa</p>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    ${row1}
                    ${row2}
                    ${row4}
                    ${row5}
                </tfoot>
            </table>
        `
        $("#movement-table").html(template);
    }

    function getFrequencyBg(number){
        if (number <= getLotteryData().frequencyBad)
            return "bg-frequency-bad";
        else if (number < getLotteryData().frequencyMedium)
            return "bg-frequency-medium";
        else
            return "bg-frequency-good";
    }

    function getLateBg(number){
        if (number <= getLotteryData().lateBad)
            return "bg-late-bad";
        else if (number <= getLotteryData().lateMedium)
            return "bg-late-medium";
        else
            return "bg-late-good";
    }

    function fastFilter(limit){
        extension = "";
        incrementExtension(`limit=${limit}`);
        getMovementTable();
    }

    function advancedFilter(){
        extension = "";
        incrementExtension(`start_contest=${$("#start_contest").val()}`);
        incrementExtension(`end_contest=${$("#end_contest").val()}`);
        getMovementTable();
    }

    function incrementExtension(increment){
        if (extension.length == 0){
            extension += `?${increment}`;
        }else{
            extension += `&${increment}`;
        }
    }

    function getDuplaSenaGameClass(index){
        if (index < 5) return "game-one";
        else return "game-two";
    }
</script>
@endsection
