<?php

namespace Converterapp\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class KowabungaForm extends Form{

	public function __construct($name = null){
	
		
	parent::__construct('kowabunga');
		$this->setAttribute('methode', 'POST');
		
		$this->add(array(
		'name' => 'fromcurrency',
		'type' => 'Select',
		'attributes' => array(
            	/*'class' => 'form-control input-sm',*/
		),
        'options' => array(
                     'label' => 'Fromcurrency',
                     'empty_option' => 'Please choose your country',
                     'value_options' => $this->getCountryCodes(),
             )
		));
		$this->add(array(
		'name' => 'tocurrency',
		'type' => 'Select',
		'attributes' => array(
            	/*'class' => 'form-control input-sm',*/
		),
        'options' => array(
                     'label' => 'Tocurrency',
                     'empty_option' => 'Please choose your country',
                     'value_options' => $this->getCountryCodes(),
             )
		));
		$this->add(array(
		'name' => 'ratedate',
		'type' => 'DateTime',
		'attributes' => array(
        	 'id' => 'datetime',
			 'size' => '10',
			 'maxlength' => '10',
			 'required' => 'required',
			 'messages' => 'Numeric',
		
			 'value' => date("Y-m-d"),
     	),
		
        'options' => array(
                     'label' => 'Ratedate',
     				 'format' => 'Y-m-d',
     	    )
		));
		$this->add(array(
		'name' => 'amount',
		'type' => 'Number',
		'attributes' => array(
			'size' => '10',
			'maxlength' => '12',
			'value' => '0',
			'required' => 'required',	
			'min' => '0',
			'max' => '10',
			'step' => '1',
			//'pattern'  => '^[0-9]',
            	/*'class' => 'form-control input-sm',*/
		),
        'options' => array(
                     'label' => 'Amount',
					 
             )
		));
		
		
		
		$this->add(array(
            'name' => 'submit',
			'value' => 'Convert',
            'attributes' => array(
                'type'  => 'submit',
        		'class' => 'btn btn-xl',
            ),
        ));
		
	}


	public function getCountryCodes(){
	
	$country = 		 array(
						"AFA"=>"Afghanistan Afghani",
						"ALL"=>"Albanian Lek",
						"DZD"=>"Algerian Dinar",
						"ARS"=>"Argentine Peso",
						"AWG"=>"Aruba Florin",
						"AUD"=>"Australian Dollar",
						"BSD"=>"Bahamian Dollar",
						"BHD"=>"Bahraini Dinar",
						"BDT"=>"Bangladesh Taka",
						"BBD"=>"Barbados Dollar",
						"BZD"=>"Belize Dollar",
						"BMD"=>"Bermuda Dollar",
						"BTN"=>"Bhutan Ngultrum",
						"BOB"=>"Bolivian Boliviano",
						"BWP"=>"Botswana Pula",
						"BRL"=>"Brazilian Real",
						"GBP"=>"British Pound",
						"BND"=>"Brunei Dollar",
						"BIF"=>"Burundi Franc",
						"XOF"=>"CFA Franc (BCEAO)",
						"XAF"=>"CFA Franc (BEAC)",
						"KHR"=>"Cambodia Riel",
						"CAD"=>"Canadian Dollar",
						"CVE"=>"Cape Verde Escudo",
						"KYD"=>"Cayman Islands Dollar",
						"CLP"=>"Chilean Peso",
						"CNY"=>"Chinese Yuan",
						"COP"=>"Colombian Peso",
						"KMF"=>"Comoros Franc",
						"CRC"=>"Costa Rica Colon",
						"HRK"=>"Croatian Kuna",
						"CUP"=>"Cuban Peso",
						"CYP"=>"Cyprus Pound",
						"CZK"=>"Czech Koruna",
						"DKK"=>"Danish Krone",
						"DJF"=>"Dijibouti Franc",
						"DOP"=>"Dominican Peso",
						"XCD"=>"East Caribbean Dollar",
						"EGP"=>"Egyptian Pound",
						"SVC"=>"El Salvador Colon",
						"EEK"=>"Estonian Kroon",
						"ETB"=>"Ethiopian Birr",
						"EUR"=>"Euro",
						"FKP"=>"Falkland Islands Pound",
						"GMD"=>"Gambian Dalasi",
						"GHC"=>"Ghanian Cedi",
						"GIP"=>"Gibraltar Pound",
						"XAU"=>"Gold Ounces",
						"GTQ"=>"Guatemala Quetzal",
						"GNF"=>"Guinea Franc",
						"GYD"=>"Guyana Dollar",
						"HTG"=>"Haiti Gourde",
						"HNL"=>"Honduras Lempira",
						"HKD"=>"Hong Kong Dollar",
						"HUF"=>"Hungarian Forint",
						"ISK"=>"Iceland Krona",
						"INR"=>"Indian Rupee",
						"IDR"=>"Indonesian Rupiah",
						"IQD"=>"Iraqi Dinar",
						"ILS"=>"Israeli Shekel",
						"JMD"=>"Jamaican Dollar",
						"JPY"=>"Japanese Yen",
						"JOD"=>"Jordanian Dinar",
						"KZT"=>"Kazakhstan Tenge",
						"KES"=>"Kenyan Shilling",
						"KRW"=>"Korean Won",
						"KWD"=>"Kuwaiti Dinar",
						"LAK"=>"Lao Kip",
						"LVL"=>"Latvian Lat",
						"LBP"=>"Lebanese Pound",
						"LSL"=>"Lesotho Loti",
						"LRD"=>"Liberian Dollar",
						"LYD"=>"Libyan Dinar",
						"LTL"=>"Lithuanian Lita",
						"MOP"=>"Macau Pataca",
						"MKD"=>"Macedonian Denar",
						"MGF"=>"Malagasy Franc",
						"MWK"=>"Malawi Kwacha",
						"MYR"=>"Malaysian Ringgit",
						"MVR"=>"Maldives Rufiyaa",
						"MTL"=>"Maltese Lira",
						"MRO"=>"Mauritania Ougulya",
						"MUR"=>"Mauritius Rupee",
						"MXN"=>"Mexican Peso",
						"MDL"=>"Moldovan Leu",
						"MNT"=>"Mongolian Tugrik",
						"MAD"=>"Moroccan Dirham",
						"MZM"=>"Mozambique Metical",
						"MMK"=>"Myanmar Kyat",
						"NAD"=>"Namibian Dollar",
						"NPR"=>"Nepalese Rupee",
						"ANG"=>"Neth Antilles Guilder",
						"NZD"=>"New Zealand Dollar",
						"NIO"=>"Nicaragua Cordoba",
						"NGN"=>"Nigerian Naira",
						"KPW"=>"North Korean Won",
						"NOK"=>"Norwegian Krone",
						"OMR"=>"Omani Rial",
						"XPF"=>"Pacific Franc",
						"PKR"=>"Pakistani Rupee",
						"XPD"=>"Palladium Ounces",
						"PAB"=>"Panama Balboa",
						"PGK"=>"Papua New Guinea Kina",
						"PYG"=>"Paraguayan Guarani",
						"PEN"=>"Peruvian Nuevo Sol",
						"PHP"=>"Philippine Peso",
						"XPT"=>"Platinum Ounces",
						"PLN"=>"Polish Zloty",
						"QAR"=>"Qatar Rial",
						"ROL"=>"Romanian Leu",
						"RUB"=>"Russian Rouble",
						"WST"=>"Samoa Tala",
						"STD"=>"Sao Tome Dobra",
						"SAR"=>"Saudi Arabian Riyal",
						"SCR"=>"Seychelles Rupee",
						"SLL"=>"Sierra Leone Leone",
						"XAG"=>"Silver Ounces",
						"SGD"=>"Singapore Dollar",
						"SKK"=>"Slovak Koruna",
						"SIT"=>"Slovenian Tolar",
						"SBD"=>"Solomon Islands Dollar",
						"SOS"=>"Somali Shilling",
						"ZAR"=>"South African Rand",
						"LKR"=>"Sri Lanka Rupee",
						"SHP"=>"St Helena Pound",
						"SDD"=>"Sudanese Dinar",
						"SRG"=>"Surinam Guilder",
						"SZL"=>"Swaziland Lilageni",
						"SEK"=>"Swedish Krona",
						"TRY"=>"Turkey Lira",
						"CHF"=>"Swiss Franc",
						"SYP"=>"Syrian Pound",
						"TWD"=>"Taiwan Dollar",
						"TZS"=>"Tanzanian Shilling",
						"THB"=>"Thai Baht",
						"TOP"=>"Tonga Pa'anga",
						"TTD"=>"Trinidad&amp;Tobago Dollar",
						"TND"=>"Tunisian Dinar",
						"TRL"=>"Turkish Lira",
						"USD"=>"U.S. Dollar",
						"AED"=>"UAE Dirham",
						"UGX"=>"Ugandan Shilling",
						"UAH"=>"Ukraine Hryvnia",
						"UYU"=>"Uruguayan New Peso",
						"VUV"=>"Vanuatu Vatu",
						"VEB"=>"Venezuelan Bolivar",
						"VND"=>"Vietnam Dong",
						"YER"=>"Yemen Riyal",
						"YUM"=>"Yugoslav Dinar",
						"ZMK"=>"Zambian Kwacha",
						"ZWD"=>"Zimbabwe Dollar"
			);
	
	return $country;
	}





}