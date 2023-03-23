<?php
/**
 * FileForm Form
 * @author  <your name here>
 */
class FormImageUploader extends TPage
{
    protected $form; // form
    private $formFields = [];
    private static $database = 'exemplos';
    private static $activeRecord = 'Habilidades';
    private static $primaryKey = 'id';
    private static $formName = 'list_Habilidades';

    use Adianti\Base\AdiantiFileSaveTrait;

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle('Upload de arquivos');

        $file      = new TFile('file');
        $multifile = new TMultiFile('multifile');

        $file->setAllowedExtensions(['png', 'jpg']);
        $multifile->setAllowedExtensions(['png', 'jpg']);

        $file->setSize('70%');
        $multifile->setSize('70%');

        $file->enableFileHandling();
        $multifile->enableFileHandling();

        $this->form->addContent([new TFormSeparator('Upload de arquivos', '#333333', '18', '#eeeeee')]);
        $this->form->addFields([new TLabel('Um arquivo:')],[$file]);
        $this->form->addFields([new TLabel('Multiplos arquivos:')],[$multifile]);

        // create the form actions
        $btn_onsave = $this->form->addAction('Salvar', new TAction([__CLASS__, 'onSave']), 'fa:floppy-o #ffffff');
        $btn_onsave->addStyleClass('btn-primary');

        $btn_onclear = $this->form->addAction('Limpar formulário', new TAction([$this, 'onClear']), 'fa:eraser #dd5a43');

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);

        parent::add($container);

    }

    public static function onSave($param = null)
    {
        try
        {
            $file      = "";
            $multifile = "";

            if (!empty($param['file']))
            {
                $file = json_decode(urldecode($param['file']))->fileName;
            }

            if (!empty($param['multifile']))
            {
                foreach ($param['multifile'] as $aFile)
                {
                    $f =  json_decode(urldecode($aFile))->fileName;
                    $multifile .= $f . "<br>";
                }
            }

            new TMessage('info', "Arquivos: <br> {$file} <br> {$multifile}");
            TScript::create("
            setTimeout(function(){
                $('.sweet-alert').find('p').css('word-wrap', 'break-word')
            }, 400);
            ");

            return;
            TTransaction::open(self::$database); // open a transaction

            /**
            // Enable Debug logger for SQL operations inside the transaction
            TTransaction::setLogger(new TLoggerSTD); // standard output
            TTransaction::setLogger(new TLoggerTXT('log.txt')); // file
            **/

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Habilidades(); // create an empty object

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object

            $this->saveFile($object, $data, 'file', 'app/output');

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id;

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            /**
            // To define an action to be executed on the message close event:
            $messageAction = new TAction(['className', 'methodName']);
            **/

            new TMessage('info', AdiantiCoreTranslator::translate('Record saved'), $messageAction);

        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Habilidades($key); // instantiates the Active Record

                $this->form->setData($object); // fill the form

                TTransaction::close(); // close the transaction
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onShow()
    {

    }

}