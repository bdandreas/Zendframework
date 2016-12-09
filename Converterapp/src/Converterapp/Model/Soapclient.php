<?php
/*
 * We Use Default PEAR SOAP Class
 * 
 * 
 * 
 */
namespace Converterapp\Model;
// Loading Soap Client..
ini_set('include_path', '/public/data/webpages/burnworld.nl/Zend/vendor/zendframework/zendframework/library');

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Soap\Client;

// Zend Framework 1.8
//include_once 'Zend/Loader/Autoloader.php';
require_once "Zend/Soap/Server.php";
require_once "Zend/Soap/AutoDiscover.php";
require_once "Zend/Soap/Client.php";

Class Soapclient
{

    Public Function Webservicex_SOAP_ConversionRate($client = false, $array = false)
    {
        try {
            $result = $client->ConversionRate($array);
        } catch (Exception $e) {
            echo $e->getMessage();
            $result = $client->__getLastResponse();
        }
        return $result;
    }


    Public function Kowabunga_SOAP_GetCurrencies($client = false, $array = false)
    {
        try {
            $result = $client->GetCurrencies($array);
        } catch (Exception $e) {
            echo "Error!";
            echo $e->getMessage();
            $result = $client->__getLastResponse();
        }
        return $result;
    }

    Public function Kowabunga_SOAP_GetLastUpdateDate($client = false, $array = false)
    {
        try {
            $result = $client->GetLastUpdateDate($array);
        } catch (Exception $e) {
            echo "Error!";
            echo $e->getMessage();
            $result = $client->__getLastResponse();
        }
        return $result;
    }

    Public function Kowabunga_SOAP_GetConversionRate($client = false, $array = false)
    {
        try {
            $result = $client->GetConversionRate($array);
        } catch (Exception $e) {
            echo "Error!";
            echo $e->getMessage();
            $result = $client->__getLastResponse();
        }
       return $result;
    }

    Public function Kowabunga_SOAP_GetConversionAmount($client = false, $array = false)
    {
        try {
            $result = $client->GetConversionAmount($array);
        } catch (Exception $e) {
            echo "Error!";
            echo $e->getMessage();
            $result = $client->__getLastResponse();
        }
        return $result;
    }

    Public Function Soap_Connect($uri = false, $options = false)
    {
        ini_set("soap.wsdl_cache_enabled", 0);
        ini_set('soap.wsdl_cache_ttl', '0');

        try {
            $client = new Client($uri, $options);
        } catch (SoapFault $s) {
            die('ERROR: [' . $s->faultcode . '] ' . $s->faultstring);
        } catch (Exception $e) {
            die('ERROR: ' . $e->getMessage());
        }

        return $client;
    }

    Public Function url_decode($string)
    {
        return utf8_decode(urldecode($string));
    }

}