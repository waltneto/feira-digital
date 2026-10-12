<?php

namespace App\Helpers;

class PixHelper
{
    public static function generateStaticPayload($pixKey, $merchantName, $merchantCity, $amount = null, $transactionId = '***')
    {
        $payloadFormatIndicator = "000201";
        $merchantAccountInformation = self::getMerchantAccountInformation($pixKey);
        $merchantCategoryCode = "52040000";
        $transactionCurrency = "5303986";
        $transactionAmount = $amount ? "54" . sprintf("%02d", strlen($amount)) . $amount : "";
        $countryCode = "5802BR";
        $merchantName = substr(self::removeAccents($merchantName), 0, 25);
        $merchantCity = substr(self::removeAccents($merchantCity), 0, 15);
        $merchantNameFormatted = "59" . sprintf("%02d", strlen($merchantName)) . $merchantName;
        $merchantCityFormatted = "60" . sprintf("%02d", strlen($merchantCity)) . $merchantCity;
        $additionalDataFieldTemplate = self::getAdditionalDataFieldTemplate($transactionId);

        $payload = $payloadFormatIndicator
            . $merchantAccountInformation
            . $merchantCategoryCode
            . $transactionCurrency
            . $transactionAmount
            . $countryCode
            . $merchantNameFormatted
            . $merchantCityFormatted
            . $additionalDataFieldTemplate;

        return $payload . "6304" . self::crc16($payload . "6304");
    }

    private static function getMerchantAccountInformation($pixKey)
    {
        $gui = "0014BR.GOV.BCB.PIX";
        $key = "01" . sprintf("%02d", strlen($pixKey)) . $pixKey;
        $data = $gui . $key;
        return "26" . sprintf("%02d", strlen($data)) . $data;
    }

    private static function getAdditionalDataFieldTemplate($txid)
    {
        $txidFormatted = "05" . sprintf("%02d", strlen($txid)) . $txid;
        return "62" . sprintf("%02d", strlen($txidFormatted)) . $txidFormatted;
    }

    private static function crc16($payload)
    {
        $crc = 0xFFFF;
        $polynomial = 0x1021;
        for ($i = 0; $i < strlen($payload); $i++) {
            $crc ^= (ord($payload[$i]) << 8);
            for ($j = 0; $j < 8; $j++) {
                if (($crc & 0x8000)) {
                    $crc = ($crc << 1) ^ $polynomial;
                } else {
                    $crc <<= 1;
                }
            }
        }
        $crc &= 0xFFFF;
        return strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));
    }

    private static function removeAccents($string)
    {
        return preg_replace(['/([`^~\'"])/', '/&(.)(acute|cedil|circ|ring|tilde|uml);/'], ['', '$1'], htmlentities($string, ENT_QUOTES, 'UTF-8'));
    }
}
