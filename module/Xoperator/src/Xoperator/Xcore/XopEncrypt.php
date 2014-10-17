<?php

namespace Xoperator\Xcore;

use Zend\Crypt\BlockCipher;
use Zend\Crypt\Symmetric\Mcrypt;
use Zend\Crypt\Password\Bcrypt;

class XopEncrypt
{
    protected $result;

    /*
     * @return $result
     */    
    public function toPassEncrypt($password){
        
        $bcrypt = new Bcrypt();
        $this->result = $bcrypt->create($password);
        return $this->result;
    }
    
    public function hasPassEncrypt($password, $has){
        $bcrypt = new Bcrypt();
        if($bcrypt->verify($password, $has))
            return true;
        else
            return false;
        
    }
    
    public function toEncrypt($text){
        $blockCipher = new BlockCipher(new Mcrypt(array('algo' => 'aes')));
        $blockCipher->setKey('encryption key');
        $this->result = $blockCipher->encrypt($text);
        return $this->result;
        //return $text;
    }
    
    public function toDecrypt($text){
        $blockCipher = new BlockCipher(new Mcrypt(array('algo' => 'aes')));
        $blockCipher->setKey('encryption key');
        $this->result = $blockCipher->decrypt($text);
        return $this->result;
    }
}