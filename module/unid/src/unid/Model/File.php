<?php
namespace unid\Model;

use Composer\Downloader\FileDownloader;
use unid\Model\Data;
use unid\Model\DataTable;

class File
{

    const PATCH_NAME = './BaseFiles/';
    protected $user;

    protected $file_name;

    protected $year;
    protected $id_kaf;

    protected $patch;

    protected $catalog;

    public function __construct(Data $user, $patch = null){
        $this->user = $user;

        $this->year = $user->__year;
        //var_dump($user);

        if($user->in_vars('unid')){
            $this->catalog = 'unid/';
            if($patch != null)
            {
                $this->catalog.= $patch;
            }

        }else
        if($user->in_vars('kafedra'))
        {
            $this->id_kaf = $user->kafedra->id_kaf;
            $this->catalog = 'kaf/'.$this->id_kaf;
        }else{
            $this->catalog = 'user/'.$user->login;
        }


    }


    function patch(){
        return self::PATCH_NAME.$this->year.'/'.$this->catalog.'/';
    }

    public function getFilePatch($name, $type = '.xml'){
        return self::patch().$name.$type;
    }


    public function load($name_file, $text_file){

        $this->file_name = $name_file;

        $patch = self::patch();
        @mkdir($patch,0777, true);

        //$patch  = self::PATCH_NAME.$this->year.'/'.$this->catalog.'/'.$name_file.'.xml';

        var_dump(self::getFilePatch($name_file));
        $fp = fopen(self::getFilePatch($name_file),'w');
        fwrite($fp, $text_file);
        fclose($fp);
    }

    public function getInf($name){
        $array = array();

        $patch_file = self::getFilePatch($name);

       // var_dump($patch_file);
        if(file_exists($patch_file))
        {
            $array['size'] = filesize( $patch_file );
            $array['date'] = date ("F d Y H:i:s.",filemtime($patch_file));

        }

        return $array;

    }

    public function download($file){

        $file = self::getFilePatch($file);
        //var_dump($file);
            if (file_exists($file)) {
                // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
                // если этого не сделать файл будет читаться в память полностью!
                if (ob_get_level()) {
                    ob_end_clean();
                }
                // заставляем браузер показать окно сохранения файла
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . basename($file));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                // читаем файл и отправляем его пользователю
                readfile($file);
                exit;
            }
        }



}