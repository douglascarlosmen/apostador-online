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

<section id="contest-selection" class="container mt-3">
    <div class="row">
        <div class="col-md-4">
            <label for="lottery">Escolha a loteria</label>
            <select name="lottery" id="lottery" class="form-control" onchange="applyLotteryNumbers(event)">
                <option value="megasena">Mega-Sena</option>
                <option value="lotofacil">Lotofácil</option>
                <option value="lotomania">Lotomania</option>
                <option value="duplasena">Dupla-Sena</option>
                <option value="quina">Quina</option>
                <option value="diadesorte">Dia de Sorte</option>
                <option value="timemania">Timemania</option>
            </select>
        </div>

        <div class="col-md-4">
            <label for="contest">Escolha um concurso</label>
            <select name="contest" id="contest" class="form-control">
                <option value=""></option>
            </select>
        </div>

        <div class="col-md-4 d-flex align-items-end">
            <button class="btn btn-success w-100">
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
            <textarea name="" id="" cols="30" rows="10" class="form-control bets mb-3" placeholder="01;02;03;04;05;06;"></textarea>
            <button class="btn w-100 megasena" id="check-bet">
                <b>Conferir Apostas<b>
            </button>
        </div>
    </div>
</section>


@endsection

@section("scripts")
<script>
    var lottery = "megasena";
    applyLotteryNumbers(null);

    function applyLotteryNumbers(event){
        let oldLottery = lottery;
        if (event != null) lottery = event.target.value;

        changeLotteryLayout(oldLottery, lottery);

        let megasenaNumbers = { min: 1, max: 60 }
        let lotofacilNumbers = { min: 1, max: 25 }
        let lotomaniaNumbers = { min: 1, max: 100 }
        let quinaNumbers = { min: 1, max: 80 }
        let duplaNumbers = { min: 1, max: 50 }
        let diaNumbers = { min: 1, max: 31 }
        let timeNumbers = { min: 1, max: 80 }

        const NUMBERS_CONTAINER = $("#numbers");
        NUMBERS_CONTAINER.html('');
        switch (lottery){
            case "megasena":
                for(let i = megasenaNumbers.min; i <= megasenaNumbers.max; i++){
                    NUMBERS_CONTAINER.append(`<span class="col-5 megasena-number"><strong>${leftPad(i, 2)}</strong></span>`)
                }
                break;
            case "lotofacil":
                for(let i = lotofacilNumbers.min; i <= lotofacilNumbers.max; i++){
                    NUMBERS_CONTAINER.append(`<span class="col-5 lotofacil-number"><strong>${leftPad(i, 2)}</strong></span>`)
                }
                break;
            case "lotomania":
                for(let i = lotomaniaNumbers.min; i <= lotomaniaNumbers.max; i++){
                    if (i == 100){
                        NUMBERS_CONTAINER.append(`<span class="col-5 lotomania-number"><strong>${leftPad(00, 2)}</strong></span>`)
                    }else{
                        NUMBERS_CONTAINER.append(`<span class="col-5 lotomania-number"><strong>${leftPad(i, 2)}</strong></span>`)
                    }
                }
                break;
            case "duplasena":
                for(let i = duplaNumbers.min; i <= duplaNumbers.max; i++){
                    NUMBERS_CONTAINER.append(`<span class="col-5 dupla-number"><strong>${leftPad(i, 2)}</strong></span>`)
                }
                break;
            case "quina":
                for(let i = quinaNumbers.min; i <= quinaNumbers.max; i++){
                    NUMBERS_CONTAINER.append(`<span class="col-5 quina-number"><strong>${leftPad(i, 2)}</strong></span>`)
                }
                break;
            case "diadesorte":
                for(let i = duplaNumbers.min; i <= duplaNumbers.max; i++){
                    NUMBERS_CONTAINER.append(`<span class="col-5 dia-number"><strong>${leftPad(i, 2)}</strong></span>`)
                }
                break;
            case "timemania":
                for(let i = timeNumbers.min; i <= timeNumbers.max; i++){
                    NUMBERS_CONTAINER.append(`<span class="col-5 time-number"><strong>${leftPad(i, 2)}</strong></span>`)
                }
                break;
        }
    }

    function changeLotteryLayout(oldLottery, lottery){
        const NUMBERS_CONTAINER = $("#numbers");
        const NUMBERS_HEADER = $("#numbers-header");
        const CHECK_BUTTON = $("#check-bet");
        //Remove old style
        switch (oldLottery){
            case "megasena":
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
            case "duplasena":
                NUMBERS_CONTAINER.removeClass("dupla-border");
                NUMBERS_HEADER.removeClass("dupla");
                CHECK_BUTTON.removeClass("dupla");
                break;
            case "quina":
                NUMBERS_CONTAINER.removeClass("quina-border");
                NUMBERS_HEADER.removeClass("quina");
                CHECK_BUTTON.removeClass("quina");
                break;
            case "diadesorte":
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
            case "megasena":
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
            case "duplasena":
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
            case "diadesorte":
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
</script>

@endsection