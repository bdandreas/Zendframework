<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Converterapp\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Facebook\FacebookRequest;
use Facebook\GraphObject;
use Facebook\FacebookRequestException;
use Zend\Db\Adapter\Adapter;
use Converterapp\Model\Kowabunga;
use Converterapp\Form\KowabungaForm;
use Converterapp\Model\Soapclient;

class KowabungaController extends AbstractActionController
{
    private $user;
    private $return;

    public $last_update;
    public $amount;
    public $rate;

    private $soap_url = "http://currencyconverter.kowabunga.net/converter.asmx?WSDL";
    private $soap_options;
    private $client;

    public function indexAction()
    {
        $form = new KowabungaForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (!$this->client) {
            $soapcall = new Soapclient();
            $this->soap_options = array(
                'soap_version' => SOAP_1_2,
                'compression' => SOAP_COMPRESSION_ACCEPT
            );

            $this->client = $soapcall->Soap_Connect($this->soap_url, $this->soap_options);
        }

        if (!$this->last_update) {
            $return = $soapcall->Kowabunga_SOAP_GetLastUpdateDate($this->client, false);
            $this->last_update = $return->GetLastUpdateDateResult;
        }

        if ($request->isPost()) {
            $service = new Kowabunga();
            $form->setInputFilter($service->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $service->exchangeArray($form->getData());
                $array = array(
                    "CurrencyFrom" => $request->getPost("fromcurrency"),
                    "CurrencyTo" => $request->getPost("tocurrency"),
                    "RateDate" => $request->getPost("ratedate"),
                    "Amount" => $request->getPost("amount"),
                );

                $return = $soapcall->Kowabunga_SOAP_GetConversionAmount($this->client, $array);

                if (isset($return->GetConversionAmountResult)) {
                    $this->amount = $return->GetConversionAmountResult;
                } else {
                    $this->amount = "No amount results";
                }

                $array = array(
                    "CurrencyFrom" => $request->getPost("fromcurrency"),
                    "CurrencyTo" => $request->getPost("tocurrency"),
                    "RateDate" => $request->getPost("ratedate"),
                );

                $return = $soapcall->Kowabunga_SOAP_GetConversionRate($this->client, $array);
                $this->rate = $return->GetConversionRateResult;

                if (isset($return->GetConversionRateResult)) {
                    $this->rate = $return->GetConversionRateResult;
                } else {
                    $this->rate = "No rate results";
                }
                $results = array('value' => array(
                    'fromcurrency' => $request->getPost("fromcurrency"),
                    'tocurrency' => $request->getPost("tocurrency"),
                    'ratedate' => $request->getPost("ratedate"),
                    'dateupdate' => $this->last_update,
                    'postamount' => $request->getPost("amount"),
                    'amount' => $this->amount,
                    'rate' => $this->rate,
                ),
                );

                return new ViewModel(array('form' => $form, 'Values' => $results));
            }
        }
        $results = array('value' => array(
            'dateupdate' => $this->last_update,
        ),
        );
        return array('form' => $form, 'Values' => $results);
    }

    public function addAction()
    {

        return new ViewModel();
    }


}
