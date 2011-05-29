<?php

class kGraph
{
  public static function sha1ToColor($sha1)
  {
    $color = "";

    if(is_null($sha1) || !is_string($sha1) || strlen($sha1) != 40)
    {
      return $color;
    }

    $hRed   = str_pad(dechex(hexdec(substr($sha1, 0, 13)) % 256), 2, "0", STR_PAD_LEFT);
    $hGreen = str_pad(dechex(hexdec(substr($sha1, 13, 13)) % 256), 2, "0", STR_PAD_LEFT);
    $hBlue  = str_pad(dechex(hexdec(substr($sha1, 26)) % 256), 2, "0", STR_PAD_LEFT);

    return $hRed.$hGreen.$hBlue;
  }
}
