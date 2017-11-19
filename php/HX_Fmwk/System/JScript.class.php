<?php

class JScript {

  private static $vars = array();

  private static $scripts = array();

  private static $scriptsDR = array();

  private static $scriptsWO = array();

  private function __construct() {}

  public static function registerScript($script) {
    JScript::$scripts[] = $script;
  }

  public static function windowOnload($script) {
    JScript::$scriptsWO[] = $script;
  }

  public static function documentReady($script) {
    JScript::$scriptsDR[] = $script;
  }

  public static function registerVar($key, $value) {
    JScript::$vars[$key] = json_encode($value);
  }

  public static function render() {
    if (count(JScript::$scriptsDR) == 0 && count(JScript::$scriptsWO) == 0 && count(JScript::$scripts) == 0 && count(JScript::$vars) == 0)
      return "";

    $ret = "\n";
    $ret .= "<script type=\"text/javascript\">\n";

    if (count(JScript::$scriptsWO) > 0) {
      $ret .= "window.onload = function () {\n";
      foreach (JScript::$scriptsDR as $s) {
        $ret .= "$s\n";
      }
      $ret .= "};\n";
    }
    if (count(JScript::$scriptsDR) > 0) {
      $ret .= "\$(document).ready(function() {\n";
      foreach (JScript::$scriptsDR as $s) {
        $ret .= "$s\n";
      }
      $ret .= "});\n";
    }

    foreach (JScript::$scripts as $s) {
      $ret .= "$s\n";
    }
    foreach (JScript::$vars as $k => $v) {
      $ret .= "var $k=" . $v . ";";
    }
    $ret .= "\n</script>\n";

    return $ret;
  }

  public static function closeWindow() {
    ob_end_clean();
    echo ("<script>self.close();</script>");
    exit();
  }

  public static function redirect($url) {
    ob_end_clean();
    echo ("<script> top.location.href='$url'</script>");
    exit();
  }

  public static function downloadTmpFile($file, $nombre = "archivo", $utf8Decode = false) {
    $a["file"] = $file;
    $a["nombre"] = $nombre;
    $a["utf8Decode"] = $utf8Decode;
    $data = base64_encode(json_encode($a));
    JScript::registerScript("\$b.downloadTmpFile('$data');");
  }

  public static function downloadFile($url, $data = "", $method = "post") {
    $k = Random::nextAlphaNumeric(30);
    Session::set("ss_key", $k);
    $data .= "&ss_id=" . session_id() . "&ss_key=" . $k;
    JScript::registerScript("\$b.download('$url','$data', '$method');");
  }
}
?>