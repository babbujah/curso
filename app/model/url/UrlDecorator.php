<?php
class UrlDecorator implements IEncurtadorLink{
    protected $encurtadorLink;
    
    public function __construct(IEncurtadorLink $encurtadorLink){
        $this->encurtadorLink = $encurtadorLink;
    }
    
    public function encurtarLink(){
        return $this->encurtadorLink->encurtarLink();
    }
    
    public function cifrar(){
        return $this->encurtadorLink->cifrar();
    }
}
