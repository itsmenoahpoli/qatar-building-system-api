<?php

# STIPE KEYS (TESTING) -- Patrick Policarpio<account>
$test_stripe_key = 'pk_test_51IbgXqHy36r0CCKEReFYBLrWhWpcD9Tb25KMZqK6UwbiD5Mty3yTWEf1avmEuPMd96ZHws0CXytrrkrm5Wm9rKuh00rbchm1Xw';
$test_stripe_secret_key = 'sk_test_51IbgXqHy36r0CCKEG7QSIGTYmST3UdqjFUNddcQuRynhwJGJT4vWicJhn2Getm6J1HWpUEDQbJ79ihFe5rU8q7mQ00xRC3eHgw';

return [
  'keys' => [
    'STRIPE_KEY' => env('STRIPE_KEY', $test_stripe_key),
    'STRIPE_SECRET_KEY' => env('STRIPE_SECRET_KEY', $test_stripe_secret_key)
  ]
];