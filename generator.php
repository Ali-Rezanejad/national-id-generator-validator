<?php
include_once "helper.php";

function generateNationalCode() {
    global $cityCodes;

    $cityCodeKeys = array_keys($cityCodes); 
    $randomCityCode = $cityCodeKeys[array_rand($cityCodeKeys)]; 
    $cityName = $cityCodes[$randomCityCode]; 

    $randomDigits = '';
    for ($i = 0; $i < 6; $i++) {
        $randomDigits .= rand(0, 9);
    }

    $partialNationalCode = $randomCityCode . $randomDigits;

    $sum = 0;
    for ($i = 0; $i < 9; $i++) {
        $sum += intval(substr($partialNationalCode, $i, 1)) * (10 - $i);
    }
    $remainder = $sum % 11;

    $controlDigit = ($remainder < 2) ? $remainder : (11 - $remainder);

    $finalNationalCode = $partialNationalCode . $controlDigit;

    return [
        'national_code' => $finalNationalCode,
        'city_name' => $cityName,
        'city_code' => $randomCityCode,
    ];
}

$generatedCodes = [];
for ($i = 0; $i < 5; $i++) { 
    $result = generateNationalCode();
    echo fixPersianText ("کد ملی: {$result['national_code']} ,شهرستان: {$result['city_name']}, کد شهرستان: {$result['city_code']}") . "\n";
}
