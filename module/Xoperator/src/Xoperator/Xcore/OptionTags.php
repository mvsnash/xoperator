<?php

namespace Xoperator\Xcore;
use Xoperator\Xcore\Interfaces\InterfaceOptionTags;

class OptionTags implements InterfaceOptionTags
{

    public function cropLink($value) {
        if (!is_string($value))
            return $value;

        //$er = "/(http:\/\/(www\.|.*?\/)?|www\.)([a-zA-Z0-9]+|_|-)+(\.(([0-9a-zA-Z]|-|_|\/|\?|=|&)+))+/i";
        $er = "/((http:\/\/(www\.|.*?\/)?|www\.) | (https:\/\/(www\.|.*?\/)?|www\.))([a-zA-Z0-9]+|_|-)+(\.(([0-9a-zA-Z]|-|_|\/|\?|=|&)+))+/i";
        preg_match_all($er, $value, $match);

        foreach ($match[0] as $link) {
            //inset http if the link not have
            if(!stristr($link, "http://") == false || !stristr($link, "https://") == false){
                $link_full = $link;
            }else{
                $link_full = "http://".$link;
            }
            //$link_full = (stristr($link, "http://") === false) ? "http://" . $link : $link;

            $link_len = strlen($link);
            $array_a1 = array('http://','https://','&');
            $array_a2  = array('','','&amp;');
            $web_link_a = str_replace($array_a1, $array_a2, $link_full);
            $web_link = str_replace(array('&',' '), array('&amp;',''), $link_full);
            $value = str_ireplace($link, "<a href=\"" . strtolower($web_link) . "\" target=\"_blank\">" . (($link_len > 60) ? substr($web_link_a, 0, 25) . "..." . substr($web_link_a, -15) : $web_link_a) . "</a>", $value);
        }

        return $value;
    }
    
    public static function createUrl($text){

        $array1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
            , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç", " ","/");
        $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
            , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C", "-","_");
        return str_replace($array1, $array2, $text);
    }
}