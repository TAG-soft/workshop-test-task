<?php


namespace App\Http\Controllers;


class ShopifyController extends Controller
{
    /**
     * @return mixed
     */
    public function getCustomers()
    {
        $real_url = "https://8522e497732817fa8a36d4a36b6749da:bb2adc93b8016981af2d0f45c4d3a38d@dev-giraffe.myshopify.com/admin/api/2019-04/customers/search.json";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $real_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        $result = json_decode(curl_exec($ch),true);
        curl_close($ch);

        return $result;
    }
}
