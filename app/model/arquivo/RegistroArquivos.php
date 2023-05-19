<?php
/**
 * RegistroArquivos Active Record
 * @author  <your-name-here>
 */
class RegistroArquivos extends TRecord
{
    const TABLENAME = 'registro_arquivos';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    const CREATEDAT = 'date';
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('date');
        parent::addAttribute('qnt_files');
        parent::addAttribute('size_total_files_original');
        parent::addAttribute('size_total_files_reduced');
    }


}
