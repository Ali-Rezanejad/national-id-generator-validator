<?php
include_once "helper.php";

function check_national_code($nationalCode) {
    global $cityCodes; 

    if (!preg_match('/^\d{10}$/', $nationalCode)) {
        return ['valid' => false, 'city' => null];
    }

    $cityCode = substr($nationalCode, 0, 3);
    if (!array_key_exists($cityCode, $cityCodes)) {
        return ['valid' => false, 'city' => null];
    }

    for ($i = 0; $i < 10; $i++) {
        if (preg_match('/^' . $i . '{10}$/', $nationalCode)) {
            return ['valid' => false, 'city' => null];
        }
    }

    $sum = 0;
    for ($i = 0; $i < 9; $i++) {
        $sum += ((10 - $i) * intval(substr($nationalCode, $i, 1)));
    }

    $remainder = $sum % 11;
    $controlDigit = intval(substr($nationalCode, 9, 1));

    $isValid = ($remainder < 2 && $controlDigit == $remainder) ||
               ($remainder >= 2 && $controlDigit == 11 - $remainder);

    return [
        'valid' => $isValid,
        'city' => $cityCodes[$cityCode]
    ];
}

    $nationalCode = readline('Enter your national ID: '); 
    $result = check_national_code($nationalCode);
    if ($result['valid']) {
       echo fixPersianText("کد ملی معتبر است و متعلق به شهرستان {$result['city']} می‌باشد.") . "\n";
    } else {
        echo fixPersianText ("کد ملی نامعتبر است.") . "\n";
    }
