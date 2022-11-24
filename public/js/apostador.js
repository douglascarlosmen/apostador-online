let blockClick = false;

const NUMBERS_CONTAINER = $("#numbers");
const NUMBERS_HEADER = $("#numbers-header");
const CHECK_BUTTON = $("#check-bet");
const CONTEST_SELECT = $("#contest-select");
const LOTTERY_SELECT = $("#lottery-select");
const LOTTERY_BUTTON = $("#lottery-button");
const TEXT_CHECK = $("#text-check");
const TEXT_TOTAL_GAMES = $("#total-games");
const PLACE_GAMES = $("#place-games");
const RESUME_GAMES = $("#resume-games");
const RESULTS_CONTAINER = $("#results");

var resultsChoosen = false;
let dozens = [];
let selectedGames = [];
var lottery = "mega-sena";

var megasenaLottery = { min: 1, max: 60, totalPrize: 6, elegiblePrize: 4, minSelected: 6, maxSelected: 15 };
var lotofacilLottery = { min: 1, max: 25, totalPrize: 15, elegiblePrize: 11, minSelected: 15, maxSelected: 20  };
var lotomaniaLottery = { min: 1, max: 100, totalPrize: 20, elegiblePrize: 15, minSelected: 50, maxSelected: 50  };
var quinaLottery = { min: 1, max: 80, totalPrize: 5, elegiblePrize: 2, minSelected: 5, maxSelected: 15  };
var duplaLottery = { min: 1, max: 50, totalPrize: 6, elegiblePrize: 3, minSelected: 7, maxSelected: 15  };
var diaLottery = { min: 1, max: 31, totalPrize: 7, elegiblePrize: 4, minSelected: 6, maxSelected: 15  };
var timeLottery = { min: 1, max: 80, totalPrize: 5, elegiblePrize: 3, minSelected: 10, maxSelected: 10  };

function applyLotteryNumbers(event, getOptions = true){
    let oldLottery = lottery;
    if (event != null) lottery = event.target.value;

    if (lottery == "")
        return Swal.fire("Aviso!", "Escolha uma loteria para exibir os concursos.", "warning");

    resultsChoosen = false;
    changeLotteryLayout(oldLottery, lottery);
    dozens = [];

    if (getOptions) {
        getContestOptions(true);
    }

    RESUME_GAMES.hide();
    RESULTS_CONTAINER.hide();
    $("#selected-games").html('');
    selectedGames = [];

    NUMBERS_CONTAINER.html('');
    switch (lottery){
        case "mega-sena":
            for(let i = megasenaLottery.min; i <= megasenaLottery.max; i++){
                NUMBERS_CONTAINER.append(`<span class="col-5 megasena-number" id="number-${leftPad(i, 2)}" onclick="toggleDozen('number-${leftPad(i, 2)}')"><strong>${leftPad(i, 2)}</strong></span>`)
            }
            break;
        case "lotofacil":
            for(let i = lotofacilLottery.min; i <= lotofacilLottery.max; i++){
                NUMBERS_CONTAINER.append(`<span class="col-5 lotofacil-number" id="number-${leftPad(i, 2)}" onclick="toggleDozen('number-${leftPad(i, 2)}')"><strong>${leftPad(i, 2)}</strong></span>`)
            }
            break;
        case "lotomania":
            for(let i = lotomaniaLottery.min; i <= lotomaniaLottery.max; i++){
                if (i == 100){
                    NUMBERS_CONTAINER.append(`<span class="col-5 lotomania-number" id="number-00" onclick="toggleDozen('number-00')"><strong>00</strong></span>`)
                }else{
                    NUMBERS_CONTAINER.append(`<span class="col-5 lotomania-number" id="number-${leftPad(i, 2)}" onclick="toggleDozen('number-${leftPad(i, 2)}')"><strong>${leftPad(i, 2)}</strong></span>`)
                }
            }
            break;
        case "dupla-sena":
            for(let i = duplaLottery.min; i <= duplaLottery.max; i++){
                NUMBERS_CONTAINER.append(`<span class="col-5 dupla-number" id="number-${leftPad(i, 2)}" onclick="toggleDozen('number-${leftPad(i, 2)}')"><strong>${leftPad(i, 2)}</strong></span>`)
            }
            break;
        case "quina":
            for(let i = quinaLottery.min; i <= quinaLottery.max; i++){
                NUMBERS_CONTAINER.append(`<span class="col-5 quina-number" id="number-${leftPad(i, 2)}" onclick="toggleDozen('number-${leftPad(i, 2)}')"><strong>${leftPad(i, 2)}</strong></span>`)
            }
            break;
        case "dia-de-sorte":
            for(let i = duplaLottery.min; i <= duplaLottery.max; i++){
                NUMBERS_CONTAINER.append(`<span class="col-5 dia-number" id="number-${leftPad(i, 2)}" onclick="toggleDozen('number-${leftPad(i, 2)}')"><strong>${leftPad(i, 2)}</strong></span>`)
            }
            break;
        case "timemania":
            for(let i = timeLottery.min; i <= timeLottery.max; i++){
                NUMBERS_CONTAINER.append(`<span class="col-5 time-number" id="number-${leftPad(i, 2)}" onclick="toggleDozen('number-${leftPad(i, 2)}')"><strong>${leftPad(i, 2)}</strong></span>`)
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

function freeActions(){
    CONTEST_SELECT.attr("disabled", false);
    LOTTERY_SELECT.attr("disabled", false);
    LOTTERY_BUTTON.attr("disabled", false);
}

function getLotteryClass(classType = 'number'){
    let lotteryNumberClass = "";
    let lotteryClass = "";
    let lotteryBorderClass = "";

    if (classType == 'number'){
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
    }else if (classType == 'border'){
        switch(lottery){
            case "mega-sena":
                lotteryBorderClass = "megasena-border";
                break;
            case "lotofacil":
                lotteryBorderClass = "lotofacil-border";
                break;
            case "lotomania":
                lotteryBorderClass = "lotomania-border";
                break;
            case "dupla-sena":
                lotteryBorderClass = "dupla-border";
                break;
            case "quina":
                lotteryBorderClass = "quina-border";
                break;
            case "dia-de-sorte":
                lotteryBorderClass = "dia-border";
                break;
            case "timemania":
                lotteryBorderClass = "time-border";
                break;
        }

        return lotteryBorderClass;
    }else if (classType == 'lottery'){
        switch(lottery){
            case "mega-sena":
                lotteryClass = "megasena";
                break;
            case "lotofacil":
                lotteryClass = "lotofacil";
                break;
            case "lotomania":
                lotteryClass = "lotomania";
                break;
            case "dupla-sena":
                lotteryClass = "dupla";
                break;
            case "quina":
                lotteryClass = "quina";
                break;
            case "dia-de-sorte":
                lotteryClass = "dia";
                break;
            case "timemania":
                lotteryClass = "time";
                break;
        }

        return lotteryClass;
    }
}

function getPoints(index, points){
    return  points.filter(x => x==index).length;
}

function getLinesCount(lines = TEXT_CHECK.val().split("\n")){
    let lineCount = 0;
    for (var i = 0; i < lines.length; i++) {
        if (lines[i].length > 0) lineCount++;
    }
    TEXT_TOTAL_GAMES.html('');
    TEXT_TOTAL_GAMES.append(`Total de Jogos: ${lineCount}`);
}

function clearDozens(){
    for(let i = 0; i < NUMBERS_CONTAINER.children().length; i++){
        let children = NUMBERS_CONTAINER.children()[i];
        children.classList.remove("selected");
    }
}

function toggleDozen(id){
    if (blockClick) return;

    let element = NUMBERS_CONTAINER.children(`#${id}`)
    if (element.hasClass("selected")){
        element.removeClass('selected');
        let index = dozens.indexOf(element.children(0).html());
        dozens.splice(index, 1);
    }else{
        if ((dozens.length + 1) > getLotteryData().maxPrize)
            return Swal.fire("Aviso!", "Você selecionou o número máximo para essa loteria.", "warning");

        element.addClass('selected');
        dozens.push(element.children(0).html());
    }
}

function getLotteryData(){
    let data;
    switch(lottery){
        case "mega-sena":
            data = megasenaLottery;
            break;
        case "lotofacil":
            data = lotofacilLottery;
            break;
        case "lotomania":
            data = lotomaniaLottery;
            break;
        case "dupla-sena":
            data = duplaLottery;
            break;
        case "quina":
            data = quinaLottery;
            break;
        case "dia-de-sorte":
            data = diaLottery;
            break;
        case "timemania":
            data = timeLottery;
            break;
    };

    return data;
}