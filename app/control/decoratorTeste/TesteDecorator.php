<?php
//include DefaultPackage;

class TesteDecorator extends TPage{
    public function __construct(){
        parent::__construct();
        
        $camiseta = new Camiseta();
        $camisetaEstampada = new ProdutoEstampaDecorator($camiseta);
        $camisetaEstampadaFrenteTras = new ProdutoEstampaDecorator($camisetaEstampada);
        $camisetaCustomizada = new ProdutoCustomizadoDecorator($camiseta);
        
        print_r($camiseta->getValor() . " - {$camiseta->getNome()}");
        echo '<br>';
        print_r($camisetaEstampada->getValor() . " - {$camisetaEstampada->getNome()}");
        echo '<br>';
        print_r($camisetaEstampadaFrenteTras->getValor() . " - {$camisetaEstampadaFrenteTras->getNome()}");
        echo '<br>';
        print_r($camisetaCustomizada->getValor() . " - {$camisetaCustomizada->getNome()}");
        
        /*
        print_r($frances->getNome() . " - R$ " . number_format($frances->valor(), 2, ',', '.').".<br>");
        
        $baguete = new Baguete();
        $baguete = new Calabresa($baguete);
        $baguete = new Salame($baguete);
        
        print_r($baguete->getNome() . " - R$ " . number_format($baguete->valor(), 2, ',', '.').".");
        */
        
    }
}
