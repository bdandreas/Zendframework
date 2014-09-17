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
use Converterapp\Model\Webservicex;
use Converterapp\Form\WebservicexForm;
use Converterapp\Model\Soapclient;



class WebservicexController extends AbstractActionController
{
	private $user;
	private $soapcall;
	private $soap_options;
    private $client;
   
   
	private $soap_url = "http://www.webservicex.net/currencyconvertor.asmx?WSDL";
	
	
    public function indexAction()
     {
         $form = new WebservicexForm();
         $form->get('submit')->setValue('Add');

         $request = $this->getRequest();
   		
         if ($request->isPost()) {
         	 $service = new Webservicex();
         	 $form->setInputFilter($service->getInputFilter());
         	 $form->setData($request->getPost());

         	 if ($form->isValid()) {
         	 	 $service->exchangeArray($form->getData());
            //     $this->getContactTable()->saveContact($service);
				 
         	 	 
         	 	 
         	 	 $soapcall = new Soapclient();
         	 	 $this->soap_options = array(
         			'soap_version'=> SOAP_1_2,
         			'compression' => SOAP_COMPRESSION_ACCEPT
         		);
         		 $client = $soapcall->Soap_Connect($this->soap_url, $this->soap_options);
         	 	 
         		 $options = array(
         	 	 'FromCurrency' => $request->getPost("fromcurrency"),
       			 'ToCurrency' => $request->getPost("tocurrency"),
         	 	 );
         	 	 
         		 $results = $soapcall->Webservicex_SOAP_ConversionRate($client,$options);
         		          		 
         		 $RateResult = $results->ConversionRateResult;
         		 
         	 	  if (is_float($RateResult)){
         	 		$RateResult = $RateResult;
				  }else{
					$RateResult	= "No results";
				  }
         		 
				 // Return values to view
         	 	 $results = array( 'value' => array(
         	 	 'fromcurrency' => $request->getPost("fromcurrency"),
       			 'tocurrency' => $request->getPost("tocurrency"),
         	 	 'rate' => $RateResult,
         	 	 	),
         	 	 );
         	 	 
                 // Redirect to list of albums
                 //return $this->redirect()->toRoute('webservicex');
         	 	return new ViewModel(array('form' => $form, 'Values' => $results));
         	 }
         
         }
            
        
         
         
         return array('form' => $form);
     }
   	
     
   	public function addAction()
     {
     	return new ViewModel();
     }
     
   
	public function getContactTable()
     {
         if (!$this->ContactTable) {
             $sm = $this->getServiceLocator();
             $this->ContactTable = $sm->get('Coverterapp\Model\WebservicexTable');
         }
         return $this->WebservicexTable;
     }

  
     
}
