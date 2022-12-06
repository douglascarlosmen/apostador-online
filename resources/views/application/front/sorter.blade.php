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
    <div class="row mt-2">
        <div class="col-md-6">
            <button class="btn btn-outline-secondary w-100" onclick="copy()">
                <i class="fa fa-copy"></i> Copiar
            </button>
        </div>
        <div class="col-md-6">
            <button class="btn btn-outline-secondary w-100" onclick="saveTextAsFile()">
                <i class="fa fa-download"></i> Baixar
            </button>
        </div>
    </div>
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

function saveTextAsFile()
{
    var textFileAsBlob = new Blob([document.getElementById("text-check").value], {type:'text/plain'}); 
    var downloadLink = document.createElement("a");
    downloadLink.download = "jogos ordenados.txt";
    downloadLink.innerHTML = "Download File";
    if (window.webkitURL != null)
    {
        // Chrome allows the link to be clicked
        // without actually adding it to the DOM.
        downloadLink.href = window.webkitURL.createObjectURL(textFileAsBlob);
    }
    else
    {
        // Firefox requires the link to be added to the DOM
        // before it can be clicked.
        downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
        downloadLink.onclick = destroyClickedElement;
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
    }

    downloadLink.click();
}

function copy(eventName, eventId) {
    let textToCopy = document.getElementById("text-check").value;
    if (navigator.clipboard && window.isSecureContext) {
        // navigator clipboard api method'
        navigator.clipboard.writeText(textToCopy);
    } else {
        // text area method
        let textArea = document.createElement("textarea");
        textArea.value = textToCopy;
        // make the textarea out of viewport
        textArea.style.position = "fixed";
        textArea.style.left = "-999999px";
        textArea.style.top = "-999999px";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        new Promise((res, rej) => {
            // here the magic happens
            document.execCommand('copy') ? res() : rej();
            textArea.remove();
        });
    }

    return Swal.fire("Jogo copiado!", "Use o CTRL + V para colar o seu jogo em algum campo de texto!", "success");
}

</script>
@endsection
