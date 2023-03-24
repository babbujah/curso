<?php
//include TravelPackage;

class AirPackage implements TravelPackage{

    protected $package;
    
    public function __construct(TravelPackage $package){
        $this->package = $package;
        
        //$this->buyTickets();
    }

    public function getPrice(){
        return $this->package() + 100;
    }
}
