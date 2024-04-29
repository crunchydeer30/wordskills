<?php

namespace App;

class Helpers
{
  public static function randomString(int $length = 10): string
  {
    return bin2hex(random_bytes($length / 2));
  }

  public static function createUniqueFilename(mixed $file): string
  {
    $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
    return $name . '_' . self::randomString() . '.' . $extension;
  }
}
