<?php

/* FILE DA PASSARE A BRAINTREE GETAWAY */
return [
  'environment' => env('BRAINTREE_ENV', 'sandbox'),
  'merchantId' => env('BRAINTREE_MERCHANT_ID'),
  'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
  'privateKey' => env('BRAINTREE_PRIVATE_KEY')
];