<?php
/**
 * Created By: Sugeng
 * Date: 1/26/17
 * Time: 14:46
 */

return [
    'url'           => env('FORLAP_URL', 'http://localhost:8082/ws/live.php?wsdl'),
    'username'      => env('FORLAP_USERNAME', ''),
    'password'      => env('FORLAP_PASSWORD', ''),
    'token-name'    => env('FORLAP_TOKEN', 'forlap-token')
];