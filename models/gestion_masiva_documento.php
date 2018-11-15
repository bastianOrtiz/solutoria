<?php

/**
 * Devuelve un array con las posiciones donde se encuentra un texto determinado
 * @param (string) $haystack Texto en el cual buscar
 * @param (string) $needle Texto que se quiere encontrar en $haystack
 * @return (array) $results Arreglo con las posiciones encontradas 
 */
function strpos_recursive($haystack, $needle, $offset = 0, &$results = array()) {                
    $offset = strpos($haystack, $needle, $offset);
    if($offset === false) {
        return $results;            
    } else {
        $results[] = $offset;
        return strpos_recursive($haystack, $needle, ($offset + 1), $results);
    }
}

?>