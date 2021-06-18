<?php


    namespace Api;

    use Exception;

    class ApiStandard
    {
        private $baseUrl;
        private $sslStatus;

        function __construct($baseUrl, $sslStatus)
        {
            $this->baseUrl          =   $baseUrl;
            $this->sslStatus        =   $sslStatus;
        }

        function communicate($data, $requestMethod, $request, $header = [])
        {
            try
            {
                $url    =   "{$this->baseUrl}{$request->getUrn()}";

                $cURL   =   curl_init($url);
                            curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
                switch($requestMethod)
                {
                    case "GET":
                        curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "GET");
                    break;
                    case "POST":
                        curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "POST");
                    break;
                    case "PUT":
                        curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "PUT");
                    break;
                    case "DELETE":
                        curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "DELETE");
                    break;

                    default:
                    break;
                }
                curl_setopt($cURL, CURLOPT_POSTFIELDS, $data);
                if(isset($header) && !empty($header))
                {
                    curl_setopt($cURL, CURLOPT_HTTPHEADER, $header);
                }
                if($this->sslStatus)
                {
                    curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
                }
                $response = curl_exec($cURL);
                curl_close($cURL);
            }
            catch(Exception $e)
            {
                $response = $e->getMessage();
            }

            return json_decode($response);
        }
    }
