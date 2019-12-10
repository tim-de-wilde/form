<?php


namespace form\src\Helpers;

/**
 * Class PostCodeApi
 *
 * @package form\src\Helpers
 */
class PostCodeApi
{
    private $apiKey;
    private $apiUrl;

    /**
     * PostCodeApi constructor.
     *
     * @param String $apiKey
     * @param String $apiUrl
     */
    public function __construct(String $apiKey, String $apiUrl)
    {
        $this->apiKey = $apiKey;
        $this->apiUrl = $apiUrl;
    }

    /**
     * @param String $zipcode
     *
     * @return object|null
     */
    public function getPostcode(String $zipcode): ?object
    {
        $url = "$this->apiUrl?postcode=$zipcode";
        $curl = $this->getBasicCurl($url);

        $result = json_decode(curl_exec($curl));

        if (empty($result) || isset($result->error)) {
            return null;
        }
        return $result;
    }

    /**
     * @param $url
     *
     * @return false|resource
     */
    private function getBasicCurl($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ["token: $this->apiKey"]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        return $curl;
    }
}