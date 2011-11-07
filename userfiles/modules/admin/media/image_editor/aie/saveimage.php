<?php
/*-- ***** BEGIN LICENSE BLOCK *****
  -   Version: MPL 1.1/GPL 2.0/LGPL 2.1
  -
  - The contents of this file are subject to the Mozilla Public License Version
  - 1.1 (the "License"); you may not use this file except in compliance with
  - the License. You may obtain a copy of the License at
  - http://www.mozilla.org/MPL/
  - 
  - Software distributed under the License is distributed on an "AS IS" basis,
  - WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License
  - for the specific language governing rights and limitations under the
  - License.
  -
  - The Original Code is AIE (Ajax Image Editor).
  -
  - The Initial Developer of the Original Code is
  - Julian Stricker.
  - Portions created by the Initial Developer are Copyright (C) 2006
  - the Initial Developer. All Rights Reserved.
  -
  - Contributor(s):
  -
  - Alternatively, the contents of this file may be used under the terms of
  - either the GNU General Public License Version 2 or later (the "GPL"), or
  - the GNU Lesser General Public License Version 2.1 or later (the "LGPL"),
  - in which case the provisions of the GPL or the LGPL are applicable instead
  - of those above. If you wish to allow use of your version of this file only
  - under the terms of either the GPL or the LGPL, and not to allow others to
  - use your version of this file under the terms of the MPL, indicate your
  - decision by deleting the provisions above and replace them with the notice
  - and other provisions required by the GPL or the LGPL. If you do not delete
  - the provisions above, a recipient may use your version of this file under
  - the terms of any one of the MPL, the GPL or the LGPL.
  - 
  - ***** END LICENSE BLOCK ***** */
include_once( 'config.inc.php' );
//if (!isset($_SESSION["tcode"])) die();
$dir = "images/album/";
$tempname=$_GET["tempname"];
$newname=$_GET["newname"];
if (@copy( $server_temp_dir.$tempname,$web_root_dir.$newname )){
  echo '{"status":"ok"}';
}


//lösche mal kurz alte dateien im temp-verzeichnis:
$d = dir($server_temp_dir);
while($name = $d->read()){  
    if ($name=="." || $name==".." || @getimagesize($server_temp_dir.$name)==false) continue;
    $lastmod = filemtime($server_temp_dir.$name);
    if ($lastmod<time()-24*60*60) unlink($server_temp_dir.$name);
}
$d->close();
?>
