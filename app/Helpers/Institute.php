<?php

use App\Models\CityCorporation;
use App\Models\Institute;
use App\Models\InstituteType;
use App\Models\Pourashava;
use App\Models\Union;

if (!function_exists('user_institute_information')) {
    function user_institute_information($institute_id)
    {
        $institute = Institute::find($institute_id);
        if ($institute) {
            $data['institute_type'] = "";
            $data['institute'] = "";
            switch ($institute->institute_type_id) {
                case 1:
                    $data['institute_type'] = "Union";
                    $data['institute'] = Union::find($institute->union_id);
                    break;
                case 2:
                    $data['institute_type'] = "Pourashava";
                    $data['institute'] = Pourashava::find($institute->pourashava_id);
                    break;
                case 3:
                    $data['institute_type'] = "City Corporation";
                    $data['institute'] = CityCorporation::find($institute->city_corporation_id);
                    break;
                default:
                    $data['institute_type'] = "";
                    $data['institute'] = "";
                    break;
            }
            return $data;
        }
    }
}

if (!function_exists('user_institute_name')) {
    function user_institute_name($institute_id)
    {
        $institute = Institute::find($institute_id);
        if ($institute) {
            $institute_name = "";
            switch ($institute->institute_type_id) {
                case 1:
                    $institute_name = Union::find($institute->union_id)->name;
                    break;
                case 2:
                    $institute_name = Pourashava::find($institute->pourashava_id)->name;
                    break;
                case 3:
                    $institute_name = CityCorporation::find($institute->city_corporation_id)->name;
                    break;
                default:
                    $institute_name = "";
                    break;
            }
            return $institute_name;
        }
    }
}

if (!function_exists('bnValue')) {

    function bnValue($value){
        $enValueList=[ "", ":","/","-",".","0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
        $bnValueList=[ "", ":","/","-",".","০","১","২","৩","৪","৫","৬","৭","৮","৯","এ","বি","সি","ডি","ই","এফ","জি","এইচ","আই","জে","কে","এল","এম","এন","ও","পি","কিউ","আর","এস","টি","ইউ","ভি","ডাব্লিউ","এক্স","ওয়াই","জেড","এ","বি","সি","ডি","ই","এফ","জি","এইচ","আই","জে","কে","এল","এম","এন","ও","পি","কিউ","আর","এস","টি","ইউ","ভি","ডাব্লিউ","এক্স","ওয়াই","জেড"];
        $converted_value=str_replace($enValueList,$bnValueList,$value);
        return $converted_value;
    }

}

// if (!function_exists('currencyFormat')) {

//     function currencyFormat($value){
//         if($value){
//             $result = number_format((float)($value ?? 0), 2, '.', '');
//         } else {
//             $result = '0.00';
//         }
//         return $result;
//     }

// }


if (!function_exists('currencyFormat')) {

    function currencyFormat($value)
    {
        $value = (float) ($value ?? 0);

        // Format to 2 decimal places
        $formatted = number_format($value, 2, '.', '');
        [$number, $decimal] = explode('.', $formatted);

        // If number is 3 digits or less
        if (strlen($number) <= 3) {
            return $number . '.' . $decimal;
        }

        // Split last 3 digits
        $lastThree = substr($number, -3);
        $rest = substr($number, 0, -3);

        // Add comma after every 2 digits
        $rest = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest);

        return $rest . ',' . $lastThree . '.' . $decimal;
    }

}








if(!function_exists('farmerTypes')){
    function farmerTypes($key=''){
        $records = [
            1 => 'Beginner (05-50)',
            2 => 'Smaller (51-250)',
            3 => 'Medium (251-700)',
            4 => 'Larger (701 - upper)'
        ];
        return  $key ? $records[$key] : $records;
    }
}

if(!function_exists('farmerTypesByLandQuantity')){
    function farmerTypesByLandQuantity($quantity = 0)
    {
        if ($quantity >= 5 && $quantity <= 50) {
            return 'প্রান্তিক';
        } elseif ($quantity >= 51 && $quantity <= 250) {
            return 'ক্ষুদ্র';
        } elseif ($quantity >= 251 && $quantity <= 700) {
            return 'মাঝারি';
        } elseif ($quantity > 700) {
            return 'বড়';
        } else {
            return 'অপর্যাপ্ত তথ্য'; // For <5 or invalid input
        }
    }

}

if(!function_exists('loanTypes')){
    function loanTypes($key=''){
        $records = [
            1 => 'কৃষি লোন',
            2 => 'শস্য লোন',
            3 => 'গোখাদ্য লোন',
        ];
        return  $key ? $records[$key] : $records;
    }
}

if(!function_exists('loanStatuses')){
    function loanStatuses($key=''){
        $records = [
            'pending' => 'পেন্ডিং',
            'approved' => 'অনুমোদিত',
            'declined' => 'বাতিল',
            'paid' => 'পরিশোধিত',
            'unpaid' => 'অপরিশোধিত'
        ];
        return  $key ? $records[$key] : $records;
    }
}

if(!function_exists('financialYears')){
    function financialYears($key=''){
        $records = [
            1 => '2020-2021',
            2 => '2021-2022',
            3 => '2022-2023',
            4 => '2023-2024',
            5 => '2024-2025',
            6 => '2025-2026'
        ];
        return  $key ? $records[$key] : $records;
    }
}


