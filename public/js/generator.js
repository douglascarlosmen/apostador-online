function setDefaultParams(data){
    let params = getDefaultParams();

    if (data.info.lastLotteryDozensMatch >= params.minCompare && data.info.lastLotteryDozensMatch <= params.maxCompare) {
        $('#lastResultsMatch').addClass('ok');
    }else{
        $('#lastResultsMatch').removeClass('ok');
    }

    if (data.info.odd >= params.minOdd && data.info.odd <= params.maxOdd) {
        $('#odd').addClass('ok');
    }else{
        $('#odd').removeClass('ok');
    }

    if (data.info.even >= params.minEven && data.info.even <= params.maxEven) {
        $('#even').addClass('ok');
    }else{
        $('#even').removeClass('ok');
    }

    if (data.info.prime >= params.minPrime && data.info.prime <= params.maxPrime) {
        $('#prime').addClass('ok');
    }else{
        $('#prime').removeClass('ok');
    }

    if (data.info.threeMultiple >= params.minThreeMultiple && data.info.threeMultiple <= params.maxThreeMultiple) {
        $('#threeMultiple').addClass('ok');
    }else{
        $('#threeMultiple').removeClass('ok');
    }

    if (data.info.fibonacci >= params.minFibonacci && data.info.fibonacci <= params.maxFibonacci) {
        $('#fibonacci').addClass('ok');
    }else{
        $('#fibonacci').removeClass('ok');
    }

    if (data.info.sum >= params.minSum && data.info.sum <= params.maxSum) {
        $('#sum').addClass('ok');
    }else{
        $('#sum').removeClass('ok');
    }
}

function setLastGameParams(data){
    let params = getDefaultParams();

    if (data.lastResult.odd >= params.minOdd && data.lastResult.odd <= params.maxOdd) {
        $('#lastOdd').addClass('ok');
    }else{
        $('#lastOdd').removeClass('ok');
    }

    if (data.lastResult.even >= params.minEven && data.lastResult.even <= params.maxEven) {
        $('#lastEven').addClass('ok');
    }else{
        $('#lastEven').removeClass('ok');
    }

    if (data.lastResult.prime >= params.minPrime && data.lastResult.prime <= params.maxPrime) {
        $('#lastPrime').addClass('ok');
    }else{
        $('#lastPrime').removeClass('ok');
    }

    if (data.lastResult.threeMultiple >= params.minThreeMultiple && data.lastResult.threeMultiple <= params.maxThreeMultiple) {
        $('#lastThreeMultiple').addClass('ok');
    }else{
        $('#lastThreeMultiple').removeClass('ok');
    }

    if (data.lastResult.fibonacci >= params.minFibonacci && data.lastResult.fibonacci <= params.maxFibonacci) {
        $('#lastFibonacci').addClass('ok');
    }else{
        $('#lastFibonacci').removeClass('ok');
    }

    if (data.lastResult.sum >= params.minSum && data.lastResult.sum <= params.maxSum) {
        $('#lastSum').addClass('ok');
    }else{
        $('#lastSum').removeClass('ok');
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
                mineven: 6,
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
                mineven: 15,
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
                mineven: 1,
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
                mineven: 2,
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
                mineven: 2,
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
                mineven: 2,
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
                mineven: 2,
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
        }).then((result) => {
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
