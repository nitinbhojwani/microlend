<?php
/**
 * Created by PhpStorm.
 * User: dk-jarvis
 * Date: 25/10/15
 * Time: 12:50 AM
 */

namespace Deviab\TransactionBundle\Services;


class UtilityService
{
    public function sendSMS($toMobile, $sms)
    {
        $post_data = array(
// 'From' doesn't matter; For transactional, this will be replaced with your SenderId;
// For promotional, this will be ignored by the SMS gateway
            'From' => '8147140836',
            'To' => $toMobile,
            'Body' => $sms,
        );

        $exotel_sid = "deviab"; // Your Exotel SID - Get it from here: http://my.exotel.in/Exotel/settings/site#api-settings
        $exotel_token = "341a3e124909068ab8439c94bc9edcde718c73fe"; // Your exotel token - Get it from here: http://my.exotel.in/Exotel/settings/site#api-settings

        $url = "https://" . $exotel_sid . ":" . $exotel_token . "@twilix.exotel.in/v1/Accounts/" . $exotel_sid . "/Sms/send";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));

        $http_result = curl_exec($ch);
        $error = curl_error($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return $http_result;
    }

}