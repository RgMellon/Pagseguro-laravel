<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title> lightbox </title>
  </head>
  <body>

    <a href="#" class="btn-buy">Finalizar Compra</a>
    {!! csrf_field()!!}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
      $(function(){
        $('.btn-buy').click(function(){
          $.ajax({
             url: "{{ route('paglight.code') }}",
             method: "POST",
             data: {_token: $('input[name=_token]').val()}
          }).done(function(code){
              console.log(code);
              // data retorna o codigo da requisição
              lightbox(code);
          }).fail(function(){
            console.log('Falha chamada ajax');
          });
          return false;
        });
      });

      function lightbox(code){
          PagSeguroLightbox({
            code: code
          }, {
            success:function(transactionCode){
              alert('Compra certo');
            },
            abort: function(){
              alert('compra abortada');
            }
          });
      }

    </script>
    <script src="{{config('pagseguro.url_lightbox_sandbox')}}">  </script>
  </body>
</html>
