<?php

namespace App;

class Helpers
{
  public static function formatPhoneNumber(string $phoneNumber): string
  {
    $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

    if ($phoneNumber[0] === '7' || $phoneNumber[0] === '8') {
      $phoneNumber = '+7' . substr($phoneNumber, 1);
    } else {
      $phoneNumber = '+' . $phoneNumber[0] . substr($phoneNumber, 2);
    }

    return $phoneNumber;
  }
}
