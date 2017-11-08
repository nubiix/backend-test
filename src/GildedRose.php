<?php

namespace Runroom\GildedRose;

class GildedRose {

    private $items;

    function __construct($items) {
        $this->items = $items;
    }

    function update_quality() {
        foreach ($this->items as $item) {
            //instanciado de punteros hacia los valores del objeto item
            $sell_in =& $item->sell_in;
            $quality =& $item->quality;
            $name =& $item->name;
            //comprobamos si el nombre no es ni Aged Brie ni Backstage passes to a TAFKAL80ETC concert
            if ($this->no_aged($name) and $this->no_backstage($name)) {
                //comprobamos que la calidad es mas que 0 y el nombre no es Sulfuras, Hand of Ragnaros
                if ($this->quality_more_than_0($quality) && $this->no_sulfuras($name)) {
                    //en caso de serlo, quitamos 1 a la calidad
                    $this->quality_op($quality,true);
                }
                //si la calidad es menor que 50...
            } else if($this->quality_no_more_than_50($quality)){  
                //sumamos calidad
                $this->quality_op($quality,false);
                //Comprobamos que el nombre es Backstage passes to a TAFKAL80ETC concert y la calidad no es mas que 50
                if ($this->si_backstage($name) && $this->quality_no_more_than_50($quality)) {                        
                    //Comprobamos cuanto es la venta. Si es menor que 6, entrará a el primer caso, sumando 1 e inmediatamente al segundo una vez se resuelva, sumando otro. Si no, solo al segundo
                    switch($sell_in){
                        case $sell_in<6:   
                            $this->quality_op($quality,false);                              
                        case $sell_in<11:
                            $this->quality_op($quality,false);
                            break;                                            
                    }                                                
                }                
            }
            //Comprobamos que el nombre no fuese Sulfuras, Hand of Ragnaros. Si no lo es, quitamos uno a la venta
            if ($this->no_sulfuras($name)) $this->less_sell($sell_in);            
            //comprobamos que la venta no es mas que 0
            if ($this->sell_no_more_than_0($sell_in)) {
                //comprobamos que el nombre no sea Aged Brie
                if ($this->no_aged($name)) {
                    //Comprobamos que el nombre no sea Backstage passes to a TAFKAL80ETC concert
                    if ($this->no_backstage($name)) {
                        //comprobamos que la calidad es mas que 0 y el nombre no es Sulfuras, Hand of Ragnaros
                        if($this->quality_more_than_0($quality) && $this->no_sulfuras($name)){
                            //Si se cumple, quitamos 1 a la calidad
                            $this->quality_op($quality,true);                                              
                        }                        
                    } else {
                        //Si no se ha cumplido, instanciamos a 0 la calidad
                        $this->quality_0($quality)                        
                    }
                    //si no se ha cumplido comprobamos si la calidad no es mas de 50, y de ser asi, sumamos 1 a la calidad
                }else if ($this->quality_no_more_than_50($quality)){                     
                    $this->quality_op($quality,false);
                }
            }
        }
    }
    //retorna true si el nombre no coincide con 'Sulfuras, Hand of Ragnaros'
    function no_sulfuras($name){
        return ($name!='Sulfuras, Hand of Ragnaros');
    }
    //retorna true si el nombre no coincide con 'Backstage passes to a TAFKAL80ETC concert'
    function no_backstage($name){
        return ($name != 'Backstage passes to a TAFKAL80ETC concert');
    }
    //retorna true si el nombre no coincide con 'Aged Brie'
    function no_aged($name){
        return ($name != 'Aged Brie');
    }
    //retorna true si la calidad es menor que 50
    function quality_no_more_than_50($quality){
        return ($quality < 50);
    }
    //retorna true si la calidad es mas que 0
    function quality_more_than_0($quality){
        return ($quality > 0);
    }
    //retorna true si el nombre coincide con 'Backstage passes to a TAFKAL80ETC concert'
    function si_backstage($name){
        return ($name == 'Backstage passes to a TAFKAL80ETC concert');
    }
    //retorna true si la venta es menor que 0
    function sell_no_more_than_0($sell_in){
        return ($sell_in < 0);
    }
    //si llega a la variable $masOMenos true, restará 1 a la calidad, si llega false, lo sumará
    function quality_op(&$quality,$masOMenos){
        return ($masOMenos ? $quality-- : $quality++);        
    }
    //resta 1 a la venta
    function less_sell(&$sell_in){
        ;
    }
    //instancia la calidad a 0
    function quality_0(&$quality){
        $quality = 0;
    }
}
