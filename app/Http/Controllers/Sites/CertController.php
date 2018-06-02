<?php

namespace App\Http\Controllers\Sites;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CertController extends Controller
{
    public function getApi($uri, $params = [])
    {
        $url = $uri;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'cURL Request',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => http_build_query($params)
        ));
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }

    public function checkCert(Request $request)
    {
        $param['cert'] = $request->cert;
        $uri = 'http://cert.local/api/v1/check-cert';
        $resultAPI = self::getApi($uri, $param);
        $data = json_decode($resultAPI, true);
        
        return $data;
    }
}
