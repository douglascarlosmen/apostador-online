@extends('application.front.template.main')

@section("css")
<style>

</style>
@endsection

@section("content")
@include("application.front.template.navbar")

<section id="contest-numbers" class="container mt-3">
    <button class="btn btn-secondary w-100 mt-5" id="upload-button">
        Importar Jogos
    </button>
    <small>Separe as dezenas por vírgula ou espaço</small><br>
    <b id="total-games">Total de jogos: 0</b>
    <textarea name="dozens_text" id="text-check" cols="30" rows="10" class="form-control bets mb-3" placeholder="01,02,03,04,05,06 ou 01 02 03 04 05 06" onchange="getLinesCount()"></textarea>
    <input id="text-file" type="file" accept=".txt" onchange="uploadFile()" class="form-control" style="display: none"/>
    <button class="btn btn-success w-100" onclick="sort()">
        Ordenar
    </button>
</section>

@endsection

@section("scripts")
<script src="{{asset('js/apostador.js')}}"></script>
<script>

$('#upload-button').on('click', function (){
    $('#text-file')[0].click();
});

function sort(){
    axios.post("{{route('order')}}", {
        dozens_text: $("#text-check").val(),
    })
        .then(response => {
            let row = "";
            response.data.forEach(game => {
                game.forEach((dozen, index) => {
                    if (index == game.length - 1) row += `${dozen}\n`
                    else row += `${dozen},`
                });
            })

            var textArea = document.getElementById("text-check");
            textArea.value = row;

            getLinesCount(row.split('\n'));
        })
        .catch(error =>{
            console.log(error.response.data)
        });
}

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

</script>
@endsection
