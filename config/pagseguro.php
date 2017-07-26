<?php

return [

  'environment' => env('PAGSEGURO_ENVIRONMENT'),
  'email' => env('PAGSEGURO_EMAIL_SENDBOX'),
  'token' => env('PAGSEGURO_TOKEN_SENDBOX'),

  'url_checkout_sendbox' => 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout',
  'url_checkout_production' => 'https://ws.pagseguro.uol.com.br/v2/checkout',
  'url_redirect_after_request' => 'https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code=',

  'url_lightbox_sandbox' => 'https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js',
  'url_lightbox_production' => 'https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js',

  'url_transparente_session_sandbox' => 'https://ws.sandbox.pagseguro.uol.com.br/v2/sessions',
  'url_transparente_session_production' => 'https://ws.pagseguro.uol.com.br/v2/sessions',

  'url_transparente_js_sanbox' => 'https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js',
  'url_transparente_js_production' => 'https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js',

  'url_pagamento_transparente_production' => 'https://ws.pagseguro.uol.com.br/v2/transactions',
  'url_pagamento_transparente_sandbox' => 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/'



];

?>
