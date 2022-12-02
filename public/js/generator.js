function setDefaultParams(info){
    let params = getDefaultParams();

    if (info.lastLotteryDozensMatch >= params.minCompare && info.lastLotteryDozensMatch <= params.maxCompare) {
        $('#lastResultsMatch').addClass('ok');
    }else{
        $('#lastResultsMatch').removeClass('ok');
    }

    if (info.odd >= params.minOdd && info.odd <= params.maxOdd) {
        $('#odd').addClass('ok');
    }else{
        $('#odd').removeClass('ok');
    }

    if (info.even >= params.minEven && info.even <= params.maxEven) {
        $('#even').addClass('ok');
    }else{
        $('#even').removeClass('ok');
    }

    if (info.prime >= params.minPrime && info.prime <= params.maxPrime) {
        $('#prime').addClass('ok');
    }else{
        $('#prime').removeClass('ok');
    }

    if (info.threeMultiple >= params.minThreeMultiple && info.threeMultiple <= params.maxThreeMultiple) {
        $('#threeMultiple').addClass('ok');
    }else{
        $('#threeMultiple').removeClass('ok');
    }

    if (info.fibonacci >= params.minFibonacci && info.fibonacci <= params.maxFibonacci) {
        $('#fibonacci').addClass('ok');
    }else{
        $('#fibonacci').removeClass('ok');
    }

    if (info.sum >= params.minSum && info.sum <= params.maxSum) {
        $('#sum').addClass('ok');
    }else{
        $('#sum').removeClass('ok');
    }
}

function getDefaultParams(){
    switch(lottery){
        case 'mega-sena':
            var params = {
                minSelected: 6,
                maxSelected: 15,
                minCompare: 0,
                maxCompare: 1,
                minOdd: 2,
                maxOdd: 4,
                minEven: 2,
                maxEven: 4,
                minBorder: 0,
                maxBorder: 0,
                minPrime: 1,
                maxPrime: 3,
                minThreeMultiple: 1,
                maxThreeMultiple: 3,
                minFibonacci: 0,
                maxFibonacci: 1,
                minSum: 140,
                maxSum: 230,
            };
        break;
        case 'lotofacil':
            var params = {
                minSelected: 15,
                maxSelected: 20,
                minCompare: 8,
                maxCompare: 10,
                minOdd: 7,
                maxOdd: 9,
                minEven: 6,
                maxEven: 8,
                minBorder: 9,
                maxBorder: 11,
                minPrime: 4,
                maxPrime: 6,
                minThreeMultiple: 4,
                maxThreeMultiple: 6,
                minFibonacci: 3,
                maxFibonacci: 5,
                minSum: 180,
                maxSum: 215,
            };
        break;
        case 'lotomania':
            var params = {
                minSelected: 50,
                maxSelected: 50,
                minCompare: 2,
                maxCompare: 15,
                minOdd: 15,
                maxOdd: 35,
                minEven: 15,
                maxEven: 35,
                minBorder: 0,
                maxBorder: 0,
                minPrime: 7,
                maxPrime: 50,
                minThreeMultiple: 9,
                maxThreeMultiple: 50,
                minFibonacci: 4,
                maxFibonacci: 50,
                minSum: 831,
                maxSum: 2000,
            };
        break;
        case 'quina':
            var params = {
                minSelected: 5,
                maxSelected: 15,
                minCompare: 0,
                maxCompare: 2,
                minOdd: 1,
                maxOdd: 4,
                minEven: 1,
                maxEven: 4,
                minBorder: 0,
                maxBorder: 0,
                minPrime: 0,
                maxPrime: 2,
                minThreeMultiple: 1,
                maxThreeMultiple: 3,
                minFibonacci: 0,
                maxFibonacci: 1,
                minSum: 130,
                maxSum: 250,
            };
        break;
        case 'dia-de-sorte':
            var params = {
                minSelected: 7,
                maxSelected: 15,
                minCompare: 1,
                maxCompare: 3,
                minOdd: 3,
                maxOdd: 5,
                minEven: 2,
                maxEven: 4,
                minBorder: 0,
                maxBorder: 0,
                minPrime: 1,
                maxPrime: 4,
                minThreeMultiple: 1,
                maxThreeMultiple: 3,
                minFibonacci: 1,
                maxFibonacci: 3,
                minSum: 80,
                maxSum: 130,
            };
        break;
        case 'dupla-sena':
            var params = {
                minSelected: 6,
                maxSelected: 15,
                minCompare: 0,
                maxCompare: 1,
                minOdd: 2,
                maxOdd: 4,
                minEven: 2,
                maxEven: 4,
                minBorder: 0,
                maxBorder: 0,
                minPrime: 1,
                maxPrime: 3,
                minThreeMultiple: 1,
                maxThreeMultiple: 3,
                minFibonacci: 0,
                maxFibonacci: 2,
                minSum: 110,
                maxSum: 190,
            };
        break;
        case 'timemania':
            var params = {
                minSelected: 10,
                maxSelected: 10,
                minCompare: 0,
                maxCompare: 2,
                minOdd: 2,
                maxOdd: 8,
                minEven: 2,
                maxEven: 8,
                minBorder: 0,
                maxBorder: 0,
                minPrime: 1,
                maxPrime: 5,
                minThreeMultiple: 1,
                maxThreeMultiple: 5,
                minFibonacci: 0,
                maxFibonacci: 2,
                minSum: 200,
                maxSum: 650,
            };
        break;
        case 'maismilionaria':
            var params = {
                minSelected: 6,
                maxSelected: 12,
                minCompare: 0,
                maxCompare: 1,
                minOdd: 2,
                maxOdd: 4,
                minEven: 2,
                maxEven: 4,
                minBorder: 0,
                maxBorder: 0,
                minPrime: 1,
                maxPrime: 3,
                minThreeMultiple: 1,
                maxThreeMultiple: 3,
                minFibonacci: 0,
                maxFibonacci: 2,
                minSum: 110,
                maxSum: 190,
            }
        break;
    }
    return params;
}

function selectGame(){
    if (dozens.length == 0)
        return Swal.fire("Aviso!", "Você precisa gerar um jogo para selecioná-lo.", "warning");
    selectedGames.push(dozens);
    renderSelectedgames();
}

function deleteAllGames(){
    return Swal.fire({
            title: 'Tem certeza?',
            text: "Ao remover todos os jogos pode não ser possível recuperá-los.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, remover'
        })
        .then((result) => {
            if (result.isConfirmed) {
                selectedGames = [];
                renderSelectedgames();
            }
        })
}

function deleteGame(index){
    return Swal.fire({
        title: 'Tem certeza?',
        text: "Ao remover esse jogo pode não ser possível recuperá-lo.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, remover'
        }).then((result) => {
        if (result.isConfirmed) {
            selectedGames.splice(index, 1);
            renderSelectedgames();
        }
    })
}

function renderSelectedgames(){
    let template = "";
    selectedGames.forEach((gameDozens, index) =>{
        let resultsTemplate = "";
        gameDozens.forEach(dozen => {
            resultsTemplate += `<span class="numbers ${getLotteryClass()}"><b>${dozen}</b></span>`;
        });
        template += `
                <div class="row justify-content-around align-items-center">
                    <div class="col-2 text-center">
                        <b>Jogo ${index + 1}</b>
                    </div>
                    <div class="col-8">
                        <div class="row justify-content-center">
                            ${resultsTemplate}
                        </div>
                    </div>
                    <div class="col-2 text-center" style="cursor: pointer" onclick="deleteGame(${index})">
                        <i class="fa fa-trash text-danger"></i>
                    </div>
                </div>
                <hr>
            `
    });

    $("#selected-games").html('').append(template);
}

function showGenerateResults(type, data, canToggleDozen = true){
    if (type == "info"){
        //Primary
        $("#even").html(data.even);
        $("#odd").html(data.odd);
        $("#lastResultsMatch").html(data.lastLotteryDozensMatch);
        $("#fibonacci").html(data.fibonacci);
        //Secondary
        $("#prime").html(data.prime);
        $("#threeMultiple").html(data.threeMultiple);
        $("#sum").html(data.sum);

        if (canToggleDozen){
            addDozen = false;
            clearDozens();
            dozens.forEach(async item => {
                await toggleDozen(`number-${item}`, true);
            });
            addDozen = true;
        }
        setDefaultParams(data);
    }else{
        $("#contestLabel").html(`Estatísticas do Último Concurso ${data.contestNumber}`);
        //Primary
        $("#lastEven").html(data.even);
        $("#lastEven").addClass(getLotteryClass('number'));
        $("#lastOdd").html(data.odd);
        $("#lastOdd").addClass(getLotteryClass('number'));
        $("#lastFibonacci").html(data.fibonacci);
        $("#lastFibonacci").addClass(getLotteryClass('number'));
        //Secondary
        $("#lastPrime").html(data.prime);
        $("#lastPrime").addClass(getLotteryClass('number'));
        $("#lastThreeMultiple").html(data.threeMultiple);
        $("#lastThreeMultiple").addClass(getLotteryClass('number'));
        $("#lastSum").html(data.sum);
        $("#lastSum").addClass(getLotteryClass('number'));
        let resultsTemplate = "";
        data.dozens.forEach(dozen => {
            resultsTemplate += `<span class="numbers ${getLotteryClass()}"><b>${dozen}</b></span>`;
        });
        $("#lastGame").html(resultsTemplate);
    }
}

function isPrime(number){
    if (number == 1)
        return false;

    for (i = 2; i <= number/2; i++){
        if (number % i == 0)
            return false;
    }
    return true;
}

function isPerfectSquare(number){
    s = parseInt(Math.sqrt(number));
    return (s * s == number);
}

// Returns true if n is a
// Fibonacci Number, else false
function isFibonacci(number){
    // n is Fibonacci if one of
    // 5*n*n + 4 or 5*n*n - 4 or
    // both is a perfect square
    return isPerfectSquare(5 * number * number + 4) ||
        isPerfectSquare(5 * number * number - 4);
}

function getInfo(arrayNumbers){
    let info = {
        even: 0,
        odd: 0,
        fibonacci: 0,
        prime: 0,
        sum: 0,
        threeMultiple: 0,
        dozens: 0
    };

    arrayNumbers.forEach(dozen => {
        let intDozen = parseInt(dozen);
        if (intDozen % 2 == 0) info.even++;
        else if (intDozen % 2 != 0) info.odd++;

        if (isPrime(intDozen)) info.prime++;

        if (isFibonacci(intDozen)) info.fibonacci++;

        if (intDozen % 3 == 0) info.threeMultiple++;

        info.sum += intDozen;
    });
    info.dozens = arrayNumbers.length;

    return info;
}