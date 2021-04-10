<?php

namespace App\Traits;

trait Payment {
  public function get_payment_for_str($payment_for) {
    switch($payment_for) {
      case 'services-dp-50%':
        return 'Services Fees Downpayment (50%)';
        break;

      case 'services-dp-completion':
        return 'Service Fees Completion (100%)';
        break;

      case 'buidling-permit-fees':
        return 'Building Permit Fees';
        break;

      default:
        return 'Invalid payment for';
    }
  }
}
