<?php
namespace App\Helpers;

class RupiahHelper {
    public static function format($angka){
        $output = number_format($angka, 0, ',', '.');
        return 'Rp.' . $output;
    }

    public static function terbilang($rupiah)
    {   
        $angka = abs($rupiah);
        $baca = array("", "satu", "dua", "tiga", "empat", "lima",
        "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $terbilang = "";
        if ($angka <12) {
            $terbilang = " ". $baca[$angka];
        } else if ($angka <20) {
            $terbilang = RupiahHelper::terbilang($angka - 10). " belas";
        } else if ($angka <100) {
            $terbilang = RupiahHelper::terbilang($angka/10)." puluh". RupiahHelper::terbilang($angka % 10);
        } else if ($angka <200) {
            $terbilang = " seratus" . RupiahHelper::terbilang($angka - 100);
        } else if ($angka <1000) {
            $terbilang = RupiahHelper::terbilang($angka/100) . " ratus" . RupiahHelper::terbilang($angka % 100);
        } else if ($angka <2000) {
            $terbilang = " seribu" . RupiahHelper::terbilang($angka - 1000);
        } else if ($angka <1000000) {
            $terbilang = RupiahHelper::terbilang($angka/1000) . " ribu" . RupiahHelper::terbilang($angka % 1000);
        } else if ($angka <1000000000) {
            $terbilang = RupiahHelper::terbilang($angka/1000000) . " juta" . RupiahHelper::terbilang($angka % 1000000);
        }    
        
        return $terbilang;
    }
}