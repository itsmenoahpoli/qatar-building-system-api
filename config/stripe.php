<?php

# STIPE KEYS (TESTING) -- Patrick Policarpio<account>
$test_stripe_key = 'pk_test_51IbgXqHy36r0CCKEReFYBLrWhWpcD9Tb25KMZqK6UwbiD5Mty3yTWEf1avmEuPMd96ZHws0CXytrrkrm5Wm9rKuh00rbchm1Xw';
$test_stripe_secret_key = 'sk_test_51IbgXqHy36r0CCKEG7QSIGTYmST3UdqjFUNddcQuRynhwJGJT4vWicJhn2Getm6J1HWpUEDQbJ79ihFe5rU8q7mQ00xRC3eHgw';

# STRIPE KEYS (STAGING) -- KIS
$test_stripe_key_KIC = 'pk_test_51IkR3KJ5NKPKu9n1Y5sWKxPNDcSc5UenSTU7ETvTYlKsIGg8uYbvaLp1mrbE4H15c2MMOzJiAQ9duLAUoNIpo8dY00qng7ZkvJ';
$test_stripe_secret_key_KIC = 'sk_test_51IkR3KJ5NKPKu9n1POpsBwI2UeCgv2SIlwOtQ6VmqEA1dYu5JElnozNNBgEH8skQ0qpoJoPRRDeBJnm4PnTNSiQz00ZATJCBMy';

return [
  'keys' => [
    'STRIPE_KEY' => env('STRIPE_KEY', $test_stripe_key_KIC),
    'STRIPE_SECRET_KEY' => env('STRIPE_SECRET_KEY', $test_stripe_secret_key_KIC)
  ]
];