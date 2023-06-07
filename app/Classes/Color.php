<?php
namespace App\Classes;

class Color {

    protected string $color;

    public function __construct($rgb="#ffffff")
    {
        $this->color = $rgb;
    }

    public function RGB()
    {
        return $this->color;
    }

    public function saturatedRGB($amt=0.6)
    {
        $colourstr = str_replace('#', '', $this->color);
        $rhex = substr($colourstr, 0, 2);
        $ghex = substr($colourstr, 2, 2);
        $bhex = substr($colourstr, 4, 2);

        $r = hexdec($rhex);
        $g = hexdec($ghex);
        $b = hexdec($bhex);

        $r = max(0, min(255, $r + (255 - $r) * $amt));
        $g = max(0, min(255, $g + (255 - $g) * $amt));
        $b = max(0, min(255, $b + (255 - $b) * $amt));

        return '#'.dechex($r).dechex($g).dechex($b);
    }

    // public static function RGBtoHSV(array $RGB = ['r' => 0, 'g' => 0, 'b' => 0])
    // {
    //     $HSV = ['h' => 0,
    //             's' => 0,
    //             'v' => 0];

    //     $normalized = ['r' => $RGB['r'] / 255,
    //                    'g' => $RGB['g'] / 255,
    //                    'b' => $RGB['b'] / 255];

    //     $min = min($normalized);
    //     $max = max($normalized);
    //     $delta_max = $max - $min;

    //     $HSV['v'] = $max;

    //     if ($delta_max == 0)
    //         return $HSV;

    //     $HSV['s'] = $delta_max / $max;

    //     $delta = ['r' => ((($max - $normalized['r']) / 6) + ($delta_max / 2)) / $delta_max,
    //               'g' => ((($max - $normalized['g']) / 6) + ($delta_max / 2)) / $delta_max,
    //               'b' => ((($max - $normalized['b']) / 6) + ($delta_max / 2)) / $delta_max];

    //     if ($normalized['r'] == $max)
    //         $HSV['h'] = $delta['b'] - $delta['g'];
    //     else if ($normalized['g'] == $max)
    //         $HSV['h'] = ( 1 / 3 ) + $delta['r'] - $delta['b'];
    //     else
    //         $HSV['h'] = ( 2 / 3 ) + $delta['g'] - $delta['r'];

    //     if ($HSV['h'] < 0)
    //         $HSV['h']++;
    //     if ($HSV['h'] > 1)
    //         $HSV['h']--;

    //     return $HSV;
    // }

    // public static function HSVtoRGB(array $HSV = ['h' => 0, 's' => 0, 'v' => 0])
    // {
    //     $HSV['h'] *= 6;

    //     $sextant = floor($HSV['h']);
    //     $h_n = $HSV['h'] - $sextant;

    //     $m = $HSV['v'] * (1 - $HSV['s']);
    //     $n = $HSV['v'] * (1 - $HSV['s'] * $h_n);
    //     $k = $HSV['v'] * (1 - $HSV['s'] * (1 - $h_n));

    //     switch ($sextant) {
    //         case 0:
    //             $RGB = ['r' => $HSV['v'], 'g' => $k, 'b' => $m];
    //             break;
    //         case 1:
    //             $RGB = ['r' => $n, 'g' => $HSV['v'], 'b' => $m];
    //             break;
    //         case 2:
    //             $RGB = ['r' => $m, 'g' => $HSV['v'], 'b' => $k];
    //             break;
    //         case 3:
    //             $RGB = ['r' => $m, 'g' => $n, 'b' => $HSV['v']];
    //             break;
    //         case 4:
    //             $RGB = ['r' => $k, 'g' => $m, 'b' => $HSV['v']];
    //             break;
    //         case 5:
    //         case 6:
    //             $RGB = ['r' => $HSV['v'], 'g' => $m, 'b' => $n];
    //             break;
    //     }

    //     return ['r' => (int)($RGB['r'] * 255),
    //             'g' => (int)($RGB['g'] * 255),
    //             'b' => (int)($RGB['b'] * 255)];
    // }
}
