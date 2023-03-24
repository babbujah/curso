<?php
class TourPackage implements TravelPackage{
    protected $package;
    
    public function __construct(TravelPackage $package){
        $this->package = $package;
        
        //$this->buy();
    }
    
    public function getPrice(){
        return $this->package() + 50;
    }
}
