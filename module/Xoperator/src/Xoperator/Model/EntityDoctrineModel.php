<?php

namespace Xoperator\Model;

class EntityDoctrineModel{
        
  
    public static function getXopTable($name_table){
        
        return 'Xoperator\EntityTable'.$name_table;
        
    }
    
}
