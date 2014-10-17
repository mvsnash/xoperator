<?php

namespace Xoperator\Model\Interfaces;

interface InterfaceSettings
{
    public function openFileSettings($file);
    
    public function showDirectorySettings();
    
    public function updateFileSettings($nomeArquivo, $textoArquivo);
}