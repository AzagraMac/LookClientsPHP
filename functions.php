<?php

function getRealIP() {
            if (!empty($_SERVER['HTTP_CLIENT_IP']))
                return $_SERVER['HTTP_CLIENT_IP'];

            if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
                return $_SERVER['HTTP_X_FORWARDED_FOR'];

            return $_SERVER['REMOTE_ADDR'];
}


function detect(){
    $browser=array("IE","OPERA","MOZILLA","NETSCAPE","FIREFOX","SAFARI","CHROME");
    $os=array("WIN","MAC","LINUX","IOS","ANDROID","OSX");

    # definimos unos valores por defecto para el navegador y el sistema operativo
    $info['browser'] = "OTHER";
    $info['os'] = "OTHER";

    # buscamos el navegador con su sistema operativo
    foreach($browser as $parent)
      {
        $s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
        $f = $s + strlen($parent);
        $version = substr($_SERVER['HTTP_USER_AGENT'], $f, 15);
        $version = preg_replace('/[^0-9,.]/','',$version);

        if ($s)
          {
          $info['browser'] = $parent;
          $info['version'] = $version;
        }
      }

    # obtenemos el sistema operativo
    foreach($os as $val)
      {
      if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),$val)!==false)
      $info['os'] = $val;
    }

    # devolvemos el array de valores
    return $info;

}

# Generamos el log, crear el directorio "dl" en la raiz
$info = detect();
$archivo = "./dl/data.csv";
$fp = fopen( $archivo,"a+");
$contador = fwrite($fp, date("d/m/Y H:i:s") . "\nIP: " . getRealIP() . "\nOS: " . $info["os"] . "\nBrowser: " . $info["browser"] . "\nVersion Browser: " . $info["version"] . "\nUser Agent HTTP: " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
fclose($fp);

?>
