<?php

namespace app\src\classes\modules\utils;

use Slim\Http\UploadedFile;

require_once __DIR__ . "/../../../classes/modules/service/sicService.php";

class uploadFile
{
    /**
     * @var $file UploadedFile
     */
    private $file;

    /**
     * @var $nameFile string
     */
    private $nameFile;

    /**
     * @var $newname string
     */
    private $newname;

    /**
     * @var $location string
     */
    private $location;

    /**
     * @var $extencao string
     */
    private $extencao;

    /**
     * @var $locationFolder string
     */
    private $locationFolder = "/../../../../../storage";

    /**
     * @var $generateTargetDate boolean
     */
    private $generateTargetDate = true;

    /**
     * @var $complementoNome string
     */
    private $complementoNome = '';

    /**
     * UploadFile constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getNameFile()
    {
        return $this->nameFile;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getExtencao()
    {
        return $this->extencao;
    }

    /**
     * @param string $extencao
     */
    public function setExtencao($extencao)
    {
        $this->extencao = $extencao;
    }

    /**
     * @return string
     */
    public function getLocationFolder()
    {
        return $this->locationFolder;
    }

    /**
     * @param string $locationFolder
     */
    public function setLocationFolder($locationFolder)
    {
        $this->locationFolder = $locationFolder;
    }

    /**
     * @return bool
     */
    public function isGenerateTargetDate()
    {
        return $this->generateTargetDate;
    }

    /**
     * @param bool $generateTargetDate
     */
    public function setGenerateTargetDate($generateTargetDate)
    {
        $this->generateTargetDate = $generateTargetDate;
    }

    /**
     * @return string
     */
    public function getNewname()
    {
        return $this->newname;
    }

    /**
     * @return string
     */
    public function getComplementoNome()
    {
        return $this->complementoNome;
    }

    /**
     * @param string $complementoNome
     */
    public function setComplementoNome($complementoNome)
    {
        $this->complementoNome = $complementoNome;
    }

    /**
     * @param $nameFile
     * @param bool $gerarand
     */
    public function setNameFile($nameFile, $gerarand = true) {

        $ext = pathinfo($nameFile,PATHINFO_EXTENSION);
        $this->setExtencao($ext);
        $data = date('Ymdhis');
        $rand = rand(1000,99999);

        if(!$gerarand) {
            $data = '';
            $rand = '';
        }

        $this->newname  = "{$data}{$rand}.{$ext}";
    }

    /**
     * @param $target
     * @return string
     */
    public function generateFolder($target)
    {
        $year = date('Y');
        $month = date('m');
        $day = date('d');

        if ($this->generateTargetDate) {

            $target = "{$target}/{$year}/{$month}/{$day}";
            $array_target = explode('/', $target);

            foreach ($array_target as $chv => $vlr) {
                $array_target[$chv] = $this->getNewname();
            }
        }

        $diretorio = $target;

        if (!file_exists(__DIR__ . $this->locationFolder . $diretorio)) {
            mkdir(__DIR__ . $this->locationFolder . $diretorio, 0775, true);
            chmod(__DIR__ . $this->locationFolder . $diretorio, 0775);
        }

        return $diretorio;
    }

    /**
     * @param $targetFolder
     * @param $targetFile
     * @return bool
     */
    public function copy($targetFolder, $targetFile) {

        $target = $this->generateFolder($targetFolder);

        $this->setNameFile($targetFile);
        $name = $this->getNewname();

        if (trim($this->newname) <> '') {
            $name = $this->newname;
        }

        $this->location = $target;
        $enderecoCompletoDestino = $target . '/c' . $name;
        $diretorio = __DIR__ . $this->locationFolder . $enderecoCompletoDestino;
        copy(__DIR__ . "/../../../" . $targetFile, $diretorio);
        return $enderecoCompletoDestino;
    }

    /**
     * @param $target
     * @param bool $createNewPaste
     * @return bool|int
     */
    public function upload($target, $createNewPaste = true) {

        /**
         * @var $uploadedFile UploadedFile
         */
        $uploadedFile = $this->getFile();

        if (!isset($this->file)) {
            return false;
        }

        if ($createNewPaste) {
            $target = $this->generateFolder($target);
        }

        if ($uploadedFile->getError() == 0) {

            $this->setNameFile($uploadedFile->getClientFilename());
            $name = $this->getNewname();

            if (trim($this->newname) <> '') {
                $name = $this->complementoNome . $this->newname;
            }

            $this->location = $target;

            $diretorio = __DIR__ . $this->locationFolder . $target . '/' . $name;

            return file_put_contents($diretorio, $uploadedFile->getStream()->getContents());
        }

        return false;
    }
}