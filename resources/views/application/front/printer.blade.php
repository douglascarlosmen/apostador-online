@extends('application.front.template.main')

@section("content")
@include("application.front.template.navbar")

<section id="contest-numbers" class="container mt-3">
  <form action="{{route('print.make')}}" method="POST" target="_blank">
    @csrf
    <div class="row">
        <div class="col-md-4 mt-5">
            <div class="row">
                <p>Configure a forma como deseja a sua impressão de forma rápida e fácil seguindo estes simples passos:</p>
                <ul class="mb-4 list-unstyled">
                    <li>1° Importe o seu jogo ou insira o seu jogo</li>
                    <li>2° Selecione a loteria desejada</li>
                    <li>3° Selecione a forma de preenchimento</li>
                    <li>4° Clique em imprimir</li>
                    <li>5° Você será redirecionado para uma tela com os jogos</li>
                    <li>6° Use o comando control+p ou selecione a opção de imprimir do seu navegador</li>
                    <li>7° Configure como deseja a impressão</li>
                    <li>8° Imprima os seus jogos</li>
                </ul>
                <div class="col-md-12 mb-4">
                  <select name="loto" id="loto" class="form-control">
                    <option value="lotofacil">Lotofacil</option>
                    <option value="megasena">Mega Sena</option>
                    <option value="quina">Quina</option>
                    <option value="duplasena">Dupla Sena</option>
                    <option value="lotomania">Lotomania</option>
                    <option value="diadesorte">Dia de Sorte</option>
                    <option value="timemania">Timemania</option>
                  </select>
                </div>
                <input type="hidden" name="type" value="dot" id="type_input">
                <div class="col-md-12 mb-4">
                    <button
                        class="btn btn-secondary w-100"
                        onclick="changeType('dot')"
                        type="button"
                    >
                        Marcar com ponto
                    </button>
                </div>
                <div class="col-md-12 mb-4">
                    <button
                        class="btn btn-secondary w-100"
                        onclick="changeType('full')"
                        type="button"
                    >
                        Preenchimento Completo
                    </button>
                </div>
                <p>Tipo de impressão: <b id="type">Ponto</b></p>
            </div>
        </div>
        <div class="col-md-8 mt-5">
            <button type="button" class="btn btn-secondary w-100" id="upload-button">
                Importar Jogos para Impressão
            </button>
            <small>Separe as dezenas por vírgula ou espaço</small><br>
            <b id="total-games">Total de jogos: 0</b>
            <textarea name="dozens_text" id="text-check" cols="30" rows="10" class="form-control bets mb-3" placeholder="01,02,03,04,05,06 ou 01 02 03 04 05 06" onchange="getLinesCount()"></textarea>
            <input id="text-file" type="file" accept=".txt" onchange="uploadFile()" class="form-control" style="display: none"/>
            <button class="btn btn-success w-100" type="submit">Imprimir</a>
        </div>
    </div>
  </form>
</section>

@endsection

@section("scripts")
<script src="{{asset('js/apostador.js')}}"></script>
<script>

$('#upload-button').on('click', function (){
    $('#text-file')[0].click();
});

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

let type = "circle";
function changeType(_type){
  type = _type
  if (type == 'dot') $("#type").html('Ponto');
  else $("#type").html('Completo');

  $("#type_input").val(type);
}

</script>
@endsection
