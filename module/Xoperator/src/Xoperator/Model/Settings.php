<?php

namespace Xoperator\Model;
use Xoperator\Model\Interfaces\InterfaceSettings;

class Settings implements InterfaceSettings
{
    
     public function openFileSettings($file) {
        return @file_get_contents(__xopFOLDERsettings__ . $file);
     }
     
     public function showDirectorySettings() {

        $itens = array();

        $ponteiro = opendir($this->url_folder_home);

        while ($nome_itens = readdir($ponteiro)) {

            $itens[] = $nome_itens;
        }
        return $itens;
    }

    public function updateFileSettings($nomeArquivo, $textoArquivo) {
        if (@file($nomeArquivo))
            $abre = fopen($nomeArquivo, 'w+');
        fwrite($abre, $textoArquivo);
        fclose($abre);
        $this->blocos_msg = "Bloco criado com sucesso!";
        return true;
    }
}