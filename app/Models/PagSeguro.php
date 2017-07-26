<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client as Guzzle;

class PagSeguro extends Model
{
    public function generate(){

      $params = [
        'email' => config('pagseguro.email'),
        'token' => config('pagseguro.token'),
        'currency' => 'BRL',
        'itemId1' => '0001',
        'itemDescription1' => 'Produto PagSeguroI',
        'itemAmount1' => '99999.99',
        'itemQuantity1' => '1',
        'itemWeight1' => '1000',
        'itemId2' => '0002',
        'itemDescription2' => 'Produto PagSeguroII',
        'itemAmount2' => '99999.98',
        'itemQuantity2' => '2',
        'itemWeight2' => '750',
        'reference' => 'REF1234',
        'senderName' => 'Jose Comprador',
        'senderAreaCode' => '99',
        'senderPhone' => '99999999',
        'senderEmail' => 'comprador@uol.com.br',
        'shippingType' => '1',
        'shippingAddressStreet' => 'Av. PagSeguro',
        'shippingAddressNumber' => '9999',
        'shippingAddressComplement' => '99o andar',
        'shippingAddressDistrict' => 'Jardim Internet',
        'shippingAddressPostalCode' => '99999999',
        'shippingAddressCity' => 'Cidade Exemplo',
        'shippingAddressState' => 'SP',
        'shippingAddressCountry' => 'ATA',
      ];

      // $params = http_build_query($params);

      $guzzle = new Guzzle();

      $response = $guzzle->request('POST', config('pagseguro.url_checkout_sendbox'), [
        'form_params' => $params,
      ]);

      // dd($response);

      $body = $response->getBody();
      $content = $body->getContents();
      // $response->getStatusCode();
      $xml = simplexml_load_string($content);
      $code = $xml->code;

      return $code;
    }

    public function getSessionId() {
      $params = [
        'email' => config('pagseguro.email'),
        'token' => config('pagseguro.token'),
      ];

      $guzzle = new Guzzle();
      $response = $guzzle->request('POST', config('pagseguro.url_transparente_session_sandbox'), [
        'form_params' => $params,
      ]);

      // dd($response);

      $body = $response->getBody();
      $content = $body->getContents();
      $xml = simplexml_load_string($content);

      return $xml->id;

    }

    public function pagamentoBoleto($sendHash){
      $params = [
            'email' => config('pagseguro.email'),
            'token' => config('pagseguro.token'),
            'senderHash' => $request->senderHash,
            'paymentMode' => 'default',
            'paymentMethod' => 'boleto',
            'currency' => 'BRL',
            'itemId1' => '0001',
            'itemDescription1' => 'Produto PagSeguroI',
            'itemAmount1' => '99999.99',
            'itemQuantity1' => '1',
            'itemWeight1' => '1000',
            'itemId2' => '0002',
            'itemDescription2' => 'Produto PagSeguroII',
            'itemAmount2' => '99999.98',
            'itemQuantity2' => '2',
            'itemWeight2' => '750',
            'reference' => 'REF1234',
            'senderName' => 'Jose Comprador',
            'senderAreaCode' => '99',
            'senderPhone' => '99999999',
            'senderEmail' => 'c11694295081760608605@sandbox.pagseguro.com.br',
            'senderCPF' => '54793120652',
            'shippingType' => '1',
            'shippingAddressStreet' => 'Av. PagSeguro',
            'shippingAddressNumber' => '9999',
            'shippingAddressComplement' => '99o andar',
            'shippingAddressDistrict' => 'Jardim Internet',
            'shippingAddressPostalCode' => '99999999',
            'shippingAddressCity' => 'Cidade Exemplo',
            'shippingAddressState' => 'SP',
            'shippingAddressCountry' => 'ATA',
            'creditCardToken'=>$request->cardToken,
            'installmentQuantity'=>1,
            'installmentValue'=>300021.45,
            'noInterestInstallmentQuantity'=>2,
            'creditCardHolderName'=>'Jose Comprador',
            'creditCardHolderCPF'=>'11475714734',
            'creditCardHolderBirthDate'=>'01/01/1900',
            'creditCardHolderAreaCode'=>99,
            'creditCardHolderPhone'=>99999999,
            'billingAddressStreet'=>'Av. PagSeguro',
            'billingAddressNumber'=>9999,
            'billingAddressComplement'=>'99o andar',
            'billingAddressDistrict'=>'Jardim Internet',
            'billingAddressPostalCode'=>99999999,
            'billingAddressCity'=>'Cidade Exemplo',
            'billingAddressState'=>'SP',
            'billingAddressCountry'=>'ATA',
        ];

      // $params = http_build_query($params);

      $guzzle = new Guzzle();

      $response = $guzzle->request('POST', config('pagseguro.url_pagamento_transparente_sandbox'), [
        'form_params' => $params,
      ]);



      $body = $response->getBody();
      $content = $body->getContents();

      $xml  = simplexml_load_string($content);

      return $xml->paymentLink;
    }

    public function pagamentoComCartao($request){

      $params = [
        'email' => config('pagseguro.email'),
        'token' => config('pagseguro.token'),
        'senderHash' =>  $request->senderHash,
        'paymentMode' => 'default',
        'paymentMethod' => 'boleto',
        'currency' => 'BRL',
        'itemId1' => '0001',
        'itemDescription1' => 'Produto PagSeguroI',
        'itemAmount1' => '99999.99',
        'itemQuantity1' => '1',
        'itemWeight1' => '1000',
        'itemId2' => '0002',
        'itemDescription2' => 'Produto PagSeguroII',
        'itemAmount2' => '99999.98',
        'itemQuantity2' => '2',
        'itemWeight2' => '750',
        'reference' => 'REF1234',
        'senderName' => 'Jose Comprador',
        'senderAreaCode' => '99',
        'senderPhone' => '99999999',
        'senderEmail' => 'c73904650353493991757@sandbox.pagseguro.com.br',
        'senderCPF' => '41366515897',
        'shippingType' => '1',
        'shippingAddressStreet' => 'Av. PagSeguro',
        'shippingAddressNumber' => '9999',
        'shippingAddressComplement' => '99o andar',
        'shippingAddressDistrict' => 'Jardim Internet',
        'shippingAddressPostalCode' => '99999999',
        'shippingAddressCity' => 'Cidade Exemplo',
        'shippingAddressState' => 'SP',
        'creditCardToken ' => $request->cardToken,
        'installmentQuantity' => '1',
        'installmentValue' => 300021.45,
        'noInterestInstallmentQuantity' => 2,
        'creditCardHolderName' => 'Jose Comprador',
        'creditCardHolderCPF' => '11475714734',
        'creditCardHolderBirthDate' => '01/01/1900',
        'creditCardHolderAreaCode' =>99,
        'creditCardHolderPhone' =>99999999,
        'billingAddressStreet' => 'Av. PagSeguro',
        'billingAddressNumber' => 9999,
        'billingAddressComplement' =>'99o andar',
        'billingAddressDistrict' => 'Jardim Internet',
        'billingAddressPostalCode' => 99999999,
        'billingAddressCity' =>'Cidade Exemplo',
        'billingAddressState' =>'SP',
        'shippingAddressCountry' => 'ATA',
        'billingAddressCountry' => 'ATA'
      ];

      // $params = http_build_query($params);

      $guzzle = new Guzzle();

      $response = $guzzle->request('POST', config('pagseguro.url_pagamento_transparente_sandbox'), [
            'form_params' => $params,
        ]);

      // dd($response);

      $body = $response->getBody();
      $content = $body->getContents();

      $xml  = simplexml_load_string($content);

      return $xml->code;

    }
}
