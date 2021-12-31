<?php 
namespace StaticFabric;

class StaticFactory{

    public static function create(string $type) : IFactory {
        // to do 
        return new $type();
        //if($type == 'save') {
          //  return new FactoryClass(); 
        //}
    }

}
