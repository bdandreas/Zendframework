<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Converterapp\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class Kowabunga implements InputFilterAwareInterface
{
    
     public $fromcurrency;
     public $tocurrency;
     public $ratedate;
     public $amount;
     protected $inputFilter;                       // <-- Add this variable

     public function exchangeArray($data)
     {
         $this->fromcurrency     = (isset($data['fromcurrency']))     ? $data['fromcurrency']     : null;
         $this->tocurrency = (isset($data['tocurrency'])) ? $data['tocurrency'] : null;
         $this->ratedate = (isset($data['ratedate'])) ? $data['ratedate'] : null;
         $this->amount = (isset($data['amount'])) ? $data['amount'] : null;
        
     }

     // Add content to these methods:
     public function setInputFilter(InputFilterInterface $inputFilter)
     {
        //throw new (\Exception("Not used");
     }

     public function getInputFilter()
     {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

            $inputFilter->add(array(
                 'name'     => 'fromcurrency',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'tocurrency',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'ratedate',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'Date',
                         'options' => array(
                             'format' => 'Y-m-d',
                         ),
                     ),
                 ),
             ));

              $inputFilter->add(array(
                 'name'     => 'amount',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'NotEmpty',
                        
                     ),
                 ),
             ));
                       
            
             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }
 }
