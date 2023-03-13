<!DOCTYPE html>
<html>
  <head>
    <style>
      html, body{
        margin: 0;
        padding: 0;
      }

      body{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        min-height: 100vh;
      }

      .ticket{
        width: 8.2cm;
        height: 18.6cm;
        border: 1px solid #000;
      }

      .ticket-header{
        padding-top: 5.2cm;
      }

      .ticket-body{
        margin-left: 0.95cm;
        margin-right: 0.2cm;
        margin-bottom: 0.25cm;
        width: 7.2cm;
        height: 2cm;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
      }

      .ticket-dozen{
        width: 0.4cm;
        height: 0.2cm;
        border: 1px solid transparent;
        margin-top: 0.08cm;
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .ticket-body > .column{
        margin: 0 0.1cm;
      }

      .full{
        width: 100%;
        height: 100%;
        background-color: #000;
      }

      .dot{
        width: 5px;
        height: 5px;
        border-radius: 100%;
        background-color: #000;
        display: inline-block;
      }

      .ticket-footer{
        margin-left: 0.75cm;
        margin-right: 0.2cm;
        margin-top: 0.5cm;
        margin-bottom: 0.1cm;
        width: 7.2cm;
        height: 0.2cm;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
      }

      .footer-box{
        width: 0.3cm;
        height: 0.2cm;
        margin-left: 0.3cm;
        border: 1px solid transparent;
        display: flex;
        justify-content: center;
        align-items: center;
      }
    </style>
    <title>Imprimir Jogo</title>
  </head>
  <body>
    @foreach ($tickets as $ticket)
      {!! $ticket !!}
    @endforeach
  </body>
</html>
