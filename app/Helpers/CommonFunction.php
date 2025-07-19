<?php

namespace App\Helpers;

class CommonFunction
{
    /**
     * Create a new class instance.
     */
    public static function returnRandomState()
    {
        $stateList = 
        [           
            "Johor",
            "Kedah",
            "Kelantan",
            "Melaka",
            "Negeri Sembilan",
            "Pahang",
            "Penang",
            "Perak",
            "Perlis",
            "Sabah",
            "Sarawak",
            "Selangor",
            "Terengganu",
            "Kuala Lumpur",
            "Putrajaya",
            "Labuan"
        ];

        return $stateList[array_rand($stateList)];         
    }
}
