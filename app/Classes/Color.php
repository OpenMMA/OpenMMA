<?php
namespace App\Classes;

class Color {

    protected int $r, $g, $b;
    protected int $h, $s, $l;
    protected int $opacity;

    public function __construct($rgb="#ffffff")
    {
        switch (strlen($rgb)) {
            case 4:
                list($r, $g, $b) = preg_split('/#([0-9a-f]{1})([0-9a-f]{1})([0-9a-f]{1})/', $rgb);
                list($this->r, $this->g, $this->b, $this->opacity) = [hexdec($r)*16, hexdec($g)*16, hexdec($b)*16, 255];
                break;
            case 7:
                list($r, $g, $b) = preg_split('/#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})/', $rgb);
                list($this->r, $this->g, $this->b, $this->opacity) = [hexdec($r), hexdec($g), hexdec($b), 255];
                break;
            case 9:
                list($r, $g, $b, $opacity) = preg_split('/#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})/', $rgb);
                list($this->r, $this->g, $this->b, $this->opacity) = [hexdec($r), hexdec($g), hexdec($b), hexdec($opacity)];
                break;
            default:
                list($this->r, $this->g, $this->b, $this->opacity) = [0, 0, 0, 255];
        }

    }

    public static function RGBtoHSV(array $RGB = ['r' => 0, 'g' => 0, 'b' => 0])
    {
        $HSV = ['h' => 0,
                's' => 0,
                'l' => 0];

        $normalized = ['r' => $RGB['r'] / 255,
                       'g' => $RGB['g'] / 255,
                       'b' => $RGB['b'] / 255];

        $min = min($normalized);
        $max = max($normalized);
        $delta_max = $max - $min;

        $HSV['l'] = $max;

        if ($delta_max == 0)
            return $HSV;

        $HSV['s'] = $delta_max / $max;

        $delta = ['r' => ((($max - $normalized['r']) / 6) + ($delta_max / 2)) / $delta_max,
                  'g' => ((($max - $normalized['g']) / 6) + ($delta_max / 2)) / $delta_max,
                  'b' => ((($max - $normalized['b']) / 6) + ($delta_max / 2)) / $delta_max];

        if ($normalized['r'] == $max)
            $HSV['h'] = $delta['b'] - $delta['g'];
        else if ($normalized['g'] == $max)
            $HSV['h'] = ( 1 / 3 ) + $delta['r'] - $delta['b'];
        else
            $HSV['h'] = ( 2 / 3 ) + $delta['g'] - $delta['r'];

        if ($HSV['h'] < 0)
            $HSV['h']++;
        if ($HSV['h'] > 1)
            $HSV['h']--;

        return $HSV;
    }

    public static function HSVtoRGB(array $HSV = ['h' => 0, 's' => 0, 'l' => 0])
    {
        $HSV['h'] *= 6;

        $sextant = floor($HSV['h']);
        $h_n = $HSV['h'] - $sextant;

        $m = $HSV['v'] * (1 - $HSV['s']);
        $n = $HSV['v'] * (1 - $HSV['s'] * $h_n);
        $k = $HSV['v'] * (1 - $HSV['s'] * (1 - $h_n));

        switch ($sextant) {
            case 0:
                $RGB = ['r' => $HSV['v'], 'g' => $k, 'b' => $m];
                break;
            case 1:
                $RGB = ['r' => $n, 'g' => $HSV['v'], 'b' => $m];
                break;
            case 2:
                $RGB = ['r' => $m, 'g' => $HSV['v'], 'b' => $k];
                break;
            case 3:
                $RGB = ['r' => $m, 'g' => $n, 'b' => $HSV['v']];
                break;
            case 4:
                $RGB = ['r' => $k, 'g' => $m, 'b' => $HSV['v']];
                break;
            case 5:
            case 6:
                $RGB = ['r' => $HSV['v'], 'g' => $m, 'b' => $n];
                break;
        }

        return ['r' => (int)($RGB['r'] * 255),
                'g' => (int)($RGB['g'] * 255),
                'b' => (int)($RGB['b'] * 255)];
    }
}
