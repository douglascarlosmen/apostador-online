@extends('application.front.template.main')

@section("css")
<style>
    .col-5{
        width: 20%;
        float:left;
        position: relative;
    }

    .border-black tr td, .border-black tr th{
        border-color:#000 !important;
    }

    table{
        font-weight: bold
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

    .bg-frequency-bad{
        background-color: #C5EFF7;
    }
    .bg-frequency-medium{
        background-color:  gray;
    }
    .bg-frequency-good{
        background-color: blue;
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
</style>
@endsection

@section("content")
@include("application.front.template.navbar")

<section id="movement" class="container mt-3">
    <h1 id="header" class="text-center">Tabela de Movimentação</h1>
    <p>Mostra a movimentação das dezenas nos últimos concursos, caso queira utilize os filtros.</p>
    <hr>
    <h3 class="text-center">Filtragem Avançada</h3>
    <form action="" method="GET" class="row" id="advanced-filter">
        <div class="col-6">
            <label for="">Concurso Inicial:</label>
            <input type="text" name="start_contest" class="form-control" value="{{Request::get('start_contest')}}">
        </div>
        <div class="col-6">
            <label for="">Concurso Final:</label>
            <input type="text" name="end_contest" class="form-control" value="{{Request::get('end_contest')}}">
        </div>
        <button class="btn btn-outline-secondary w-100 mt-2" type="submit">
            Filtrar
        </button>
    </form>
    <hr>
    <h3 class="text-center">Filtragem Rápida</h3>
    <div class="row justify-content-center">
        <form action="" method="GET" class="col-md-2 fast-filter mt-1">
            <input type="hidden" name="limit" value="10">
            <button class="btn btn-outline-secondary w-100" type="submit">
                Últimos <b>10</b> conc.
            </button>
        </form>
        <form action="" method="GET" class="col-md-2 fast-filter mt-1">
            <input type="hidden" name="limit" value="20">
            <button class="btn btn-outline-secondary w-100" type="submit">
                Últimos <b>20</b> conc.
            </button>
        </form>
        <form action="" method="GET" class="col-md-2 fast-filter mt-1">
            <input type="hidden" name="limit" value="30">
            <button class="btn btn-outline-secondary w-100" type="submit">
                Últimos <b>30</b> conc.
            </button>
        </form>
        <form action="" method="GET" class="col-md-2 fast-filter mt-1">
            <input type="hidden" name="limit" value="50">
            <button class="btn btn-outline-secondary w-100" type="submit">
                Últimos <b>50</b> conc.
            </button>
        </form>
        <form action="" method="GET" class="col-md-2 fast-filter mt-1">
            <input type="hidden" name="limit" value="150">
            <button class="btn btn-outline-secondary w-100" type="submit">
                Últimos <b>150</b> conc.
            </button>
        </form>
    </div>
    <div class="table-responsive mt-5" id="movement-table">

    </div>
</section>

<section class="container mt-3">
    <h1 class="text-center">Legenda da Tabela de Movimentação</h1>
    <div class="row justify-content-center align-items-center w-100">
        <div class="col-md-6">
            <h3>Legenda - Atraso Atual</h3>
            <p><span class="bg-late-bad label-box">.</span> - Atraso normal </p>
            <p><span class="bg-late-medium label-box">.</span> - Provavelmente vai sair </p>
            <p><span class="bg-late-good label-box">.</span> - Deve Sair </p>
        </div>

        <div class="col-md-6">
            <h3>Legenda - Frequência em %</h3>
            <p><span class="bg-frequency-bad label-box">.</span> - Frequência Ruim <small>(Menor ou Igual a 10%)</small></p>
            <p><span class="bg-frequency-medium label-box">.</span> - Frequência Média <small>(Maior que 10% e Menor ou igual a 30%)</small></p>
            <p><span class="bg-frequency-good label-box">.</span> - Frequência Ruim <small>(Maior ou igual a 30%)</small></p>
        </div>
    </div>
</section>


@endsection

@section("scripts")
<script src="{{asset('js/apostador.js')}}"></script>
<script src="{{asset('js/movement.js')}}"></script>
<script>
    let lastResult;
    let generateInfoToGeneratorPage = false;

    getMovementTable();

    async function getMovementTable(){
        const params = await new Proxy(new URLSearchParams(window.location.search), {
            get: (searchParams, prop) => searchParams.get(prop),
        });

        setExtension(params);

        let route = "{{route('tabela_movimentacao', 'lottery')}}".replace('lottery', lottery);
        axios.get(`${route}${extension}`)
            .then(response => {
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
            tableHeaderTemplate += `<th>${i.toString().padStart(2, "0")}</th>`;
        }

        Object.keys(data[1]).forEach((key, index) => {
            tableRowTemplate += "<tr class='text-center'>";
            tableRowTemplate += `<th class="${getLotteryClass('lottery')}">${key}</th>`;
            let alreadySetted = 0;
            for(let i = 1; i <= getLotteryData().max; i++){
                if (alreadySetted <= getLotteryData().totalPrize && data[1][key].includes(i.toString().padStart(2, "0"))){
                    tableRowTemplate += `<td class="${getLotteryClass('lottery')}">${data[1][key][alreadySetted]}</td>`;
                    alreadySetted++;
                }else{
                    tableRowTemplate += `<td></td>`;
                }
            }
            tableRowTemplate += `</tr>`;
        });

        let row1 = "<tr><th class='text-center bg-dark-01'>Atraso Atual</th>";
        let row2 = "<tr><th class='text-center bg-dark-02'>Frequência em %</th>";
        let row3 = "<tr><th class='text-center bg-dark-03'>Frequência em Qtd.</th>";
        let row4 = "<tr><th class='text-center'>Maior Atraso</th>";
        let row5 = "<tr><th class='text-center'>Maior Sequência</th>";

        for (let i = 1; i <= getLotteryData().max; i++){
            row1 += `<td class="text-center ${getLateBg(data[0][i].atraso_atual)}">${data[0][i].atraso_atual}</td>`;
            row2 += `<td class="text-center ${getFrequencyBg(data[0][i].freq_porc)}">${data[0][i].freq_porc}</td>`;
            row3 += `<td class="text-center">${data[0][i].freq_qtd}</td>`;
            row4 += `<td class="text-center">${data[0][i].maior_atraso}</td>`;
            row5 += `<td class="text-center">${data[0][i].maior_seq}</td>`;
        }

        row1 += "</tr>";
        row2 += "</tr>";
        row3 += "</tr>";
        row4 += "</tr>";
        row5 += "</tr>";

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
                    ${row1}
                    ${row2}
                    ${row3}
                    ${row4}
                    ${row5}
                </tfoot>
            </table>
        `
        $("#movement-table").html(template);
    }

    function getFrequencyBg(number){
        if (number < 10)
            return "bg-frequency-bad";
        else if (number < 30)
            return "bg-frequency-medium";
        else
            return "bg-frequency-good";
    }

    function getLateBg(number){
        if (number <= 10)
            return "bg-late-bad";
        else if (number <= 20)
            return "bg-late-medium";
        else
            return "bg-late-good";
    }

    let extension = "";
    function setExtension(params){
        extension = '';

        if (params.limit) incrementExtension(`limit=${params.limit}`);
        if (params.start_contest) incrementExtension(`start_contest=${params.start_contest}`);
        if (params.end_contest) incrementExtension(`end_contest=${params.end_contest}`);
    }
    function incrementExtension(increment){
        if (extension.length == 0){
            extension += `?${increment}`;
        }else{
            extension += `&${increment}`;
        }
    }
</script>
@endsection
