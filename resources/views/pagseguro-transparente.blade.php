<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Transparente</title>
  </head>
  <body>

    {!! Form::open(['id' => 'form'])!!}

    {!! Form::close() !!}
    <a href="" class="btn-finished">pagar com boleto</a>
    <div class="payments-methods">

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src = "{{config('pagseguro.url_transparente_js_sanbox')}}"></script>
    <script>
      $(function(){
        $('.btn-finished').click(function(){
          setSessionId();
          return false;
        });
      });

      function setSessionId(){
        var data = $('#form').serialize();
        alert(data);
        // serialize pega todos os campos do form
        $.ajax( {
          url: "{{route('pag_transparente_code')}}",
          method: "POST",
          data: data
        }).done(function(data){
          PagSeguroDirectPayment.setSessionId(data);
          // getPaymentsMethod();
          paymentBillet();
        }).fail(function(){
          alert('Falha no engano');
        } );
      }

      function getPaymentsMethod(){

        PagSeguroDirectPayment.getPaymentMethods({
          success: function(response){
            if(response.error == false){
              $.each(response.paymentsMethods, function (index, value){
                $('.payments-methods').append(key+ "</br>");
              });
            }
          },
          error: function(response){
            console.log(response);
          },
          complete: function(response){
            console.log(response);
          }
        });
      }

      function paymentBillet(){
        var sendHash = PagSeguroDirectPayment.getSenderHash();
        var data = $('#form').serialize()+"&sendHash="+sendHash;
        $.ajax({
          url: "{{route('pag_boleto')}}",
          method: "POST",
          data: data
        }).done(function(url){
          console.log(url);

          location.href=url;
        }).fail(function(){
          alert('Falha no engano');
        });
      }
    </script>
  </body>
</html>
