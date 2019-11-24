<?php
/**
 * Created by PhpStorm.
 * User: Mourad
 * Date: 13/11/2019
 * Time: 19:00
 */

namespace App\Service;

use Hashids\Hashids;
use Twig\TwigFilter;

use Twig\Extension\AbstractExtension;

class ConvertMD5 extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('encode', [$this, 'encodeID']),
        ];
    }

    //public function encodeID($value, $padding)
            public function encodeID($value)
    {

      //  $hashids = new Hashids('', $padding);
      //  $hashids->encode($value);
      //  return $hashids;
        $hashids = base64_encode($value);

        return $hashids;

    }
}