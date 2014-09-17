<?php

namespace Blogger\Form;

use Zend\Form\Form;

class BloggerUsersForm extends Form{

	public function __construct($name = null){
	
		
	parent::__construct('blogger-author');
		//$this->setAttribute('methode', 'POST');
		
	 $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'name',
             'type' => 'Text',
         	 'attributes' => array(
				'maxlength' => '50',
			  ),
             'options' => array(
                 'label' => 'Name',
             ),
         ));
         $this->add(array(
             'name' => 'email',
             'type' => 'Text',
         	  'attributes' => array(
				'maxlength' => '50',
			  ),
             'options' => array(
                 'label' => 'Email',
             ),
         ));
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
             ),
         ));
     }
 }
 
 
 