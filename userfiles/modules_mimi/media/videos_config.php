<? 

$config = array();
$config['name'] = "videos module";
$config['author'] = "Microweber";
$config['description'] = "A video gallery";
$config['no_cache'] = true;
$config['ui'] = true;




$config['params']['post_id']['name'] = "Gallery for post";
$config['params']['post_id']['help'] = "Choose the post to attach the media";
$config['params']['post_id']['type'] = "content_id";
$config['params']['post_id']['default'] = "";
$config['params']['post_id']['param'] = "post_id";

 
$config['params']['rel']['type'] = "hidden";
$config['params']['rel']['default'] = "post";
$config['params']['rel']['param'] = "rel";
