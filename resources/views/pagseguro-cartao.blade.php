<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cartão transparente</title>
    <link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
    crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <h1>Pagar com cartão </h1>
        {!! Form::open(['id' => 'form']) !!}
        <!-- <label for="">Numero Cartão </label> -->
          <div classs="form-group">
            {!! Form::text('cardNumber', null, ['class' => 'form-control', 'Placeholder' => 'Numero do cartao', 'style' => 'margin-bottom:20px', 'required'])!!}
          </div>
          <div classs="form-group">
            <!-- <label for="">Mês de expiração</label> -->
            {!! Form::text('cardExpiryMonth', null, ['class' => 'form-control', 'Placeholder' => 'Mês de expiração', 'style' => 'margin-bottom:20px', 'required'])!!}
          </div>
          <div classs="form-group">
            <!-- <label for="">Ano Expiração</label> -->
            {!! Form::text('cardExpiryYear', null, ['class' => 'form-control', 'Placeholder' => 'Ano de Expiração', 'style' => 'margin-bottom:20px', 'required'])!!}
          </div>
          <div classs="form-group">
            <!-- <label for="">Codigo de segurança (3 digitos)</label> -->
            {!! Form::text('cardCVV', null, ['class' => 'form-control', 'Placeholder' => 'Codigo segurança', 'style' => 'margin-bottom:20px', 'required'])!!}
          </div>
          <div classs="form-group">
            {!! Form::hidden('cardName', null)!!}
            {!! Form::hidden('cardToken', null)!!}
            <button type="submit" name="button" class="btn btn-default btn-buy">Enviar</button>
          </div>
        {!! Form::close() !!}
        <div class="preloader" style="display:none;"> </div>
          <div class="message" style="display:none;"></div>
      </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{config('pagseguro.url_transparente_js_sanbox')}}"></script>
    <script>
      $(function(){
        setSessionId();
        $('#form').submit(function(){
          getBrand();
          startPreloader("Procurando ela");
          return false
        });
      });

      function setSessionId(){
        var data = $('#form').serialize();
        // alert(data);

        $.ajax( {
          url: "{{route('pag_transparente_code')}}",
          method: "POST",
          data: data,
          beforeSend: startPreloader('Roubaram a bicicleta do betim')
        }).done(function(data){
          PagSeguroDirectPayment.setSessionId(data);

        }).fail(function(){
          alert('Falha no engano');
        }).always(function(){
          endPreloader();
        });
      }

      function getBrand(){
        PagSeguroDirectPayment.getBrand({
          cardBin: $('input[name="cardNumber"]').val().replace(/ /g, ''),
          success: function(response){
          console.log(response);
            $("input[name=cardName]").val(response.brand.name);
            // createCardToken(response.brand.n);
            createCredCardToken();
          },
          error: function(response){
            console.log("Erro getBrand");
            console.log(response);
          },
          complete: function(response){
            console.log("Sucesso getBrand");
            // console.log(response);
          }
        });
      }

      function createCredCardToken(){
        // Responsabilizado para criar o token do cartão
        PagSeguroDirectPayment.createCardToken({
          cardNumber: $("input[name=cardNumber]").val().replace(/ /g, ''),
          brand: $("input[name=cardName]").val(),
          cvv: $("input[name=cardCVV]").val(),
          expirationMonth: $("input[name=cardExpiryMonth]").val(),
          expirationYear: $("input[name=cardExpiryYear]").val(),
          success: function(response){
            console.log(response);
            console.log("Entrou aqqui");
            $("input[name=cardToken]").val(response.card.token);
            createTransactionCard();
          },
          error: function(response){
            console.log(response);
            console.log("Erro ao criar token");
          },

          complete: function(response){
            console.log(response);
            endPreloader();
          }

        });
      }

      function createTransactionCard(){
        // 1- O método getSenderHash gera uma Hash com algumas
        // informações do comprador como IP, SO e etc. Com isso conseguimos efetuar
        //  uma análise da transação muito melhor.
        //   A execução deve ser efetuada em toda nova transação.
        var sendHash = PagSeguroDirectPayment.getSenderHash();
        var data = $('#form').serialize()+"&sendHash="+sendHash;
          $.ajax( {
            url: "{{route('pag_card_code')}}",
            method: "POST",
            data: data,
            beforeSend: startPreloader('Realizando o pagamento do cartão ')
          }).done(function(data){
            $(".message").html("Código da transação" + data);
            $(".message").show();
          }).fail(function(){
            alert('Falha no engano');
          }).always(function(){
            // O método `always()` recebe uma função de callback
            // que será executada quando a requisição de sucesso estiver completa.
            endPreloader();
          });
        }

      function startPreloader(msg){
        if(msg !== ''){
          $(".preloader").html(msg)
        }
        $(".preloader").show();
        $(".btn-buy").addClass('disabled');
      }

      function endPreloader(){
        $(".preloader").hide();
        $(".btn-buy").removeClass('disabled');
      }
    </script>
  </body>
</html>
