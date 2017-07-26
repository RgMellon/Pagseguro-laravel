<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PagSeguro;

class PagSeguroController extends Controller
{
    public function pagseguro(PagSeguro $pagseguro) {
      $code = $pagseguro->generate();
      $url_redirect = config('pagseguro.url_redirect_after_request').$code;

      // dd($url_redirect);
      return redirect()->away($url_redirect);

    }

    public function lightbox(){

      return view('pagseguro');
    }

    public function lightboxCode(PagSeguro $pagseguro){
        return $pagseguro->generate();
    }

    public function transparente(){
      return view('pagseguro-transparente');
    }

    public function getCode(PagSeguro $pagseguro){
      return $pagseguro->getSessionId();
    }

    public function boleto(Request $request, PagSeguro $pagseguro){

        return $pagseguro->pagamentoBoleto($request->sendHash);
    }

    public function cartao(){
      return view('pagseguro-cartao');
    }

    public function transacaoCartao(Request $request, PagSeguro $pagseguro){
      return $pagseguro->pagamentoComCartao($request);
      // retorna o objeto json
    }
}
