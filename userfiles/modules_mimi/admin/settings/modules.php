Modules


<? 
$modules_options = array();
//$modules_options['skip_admin'] = true;
$modules_options['ui'] = true;


$modules = CI::model('template')->getModules($modules_options );


//

?>

<script type="text/javascript">
function uninstall_module($module_name){
	$.ajax({
	  type: 'POST',
	  url: '<? print site_url('api/template/uninstall_module'); ?>',
	  data: ({module : $module_name }),
	  success: function(resp3) {
		 // alert(resp3);
		 
		   
	  },
	  dataType: 'html'
	});
}

function install_module($module_name){
	$.ajax({
	  type: 'POST',
	  url: '<? print site_url('api/template/install_module'); ?>',
	  data: ({module : $module_name }),
	  success: function(resp3) {
		 // alert(resp3);
		 
		   
	  },
	  dataType: 'html'
	});
}

</script>

<table width="100%" border="0">
<? foreach($modules as $module): ?>

  <tr>
    <td>
	
	<?

 //p($module ); 


?>

	<? print $module['name'] ?></td>
    <td>
    <? if($module['uninstalled'] == true): ?>
    
    <input value="Install" onclick="install_module('<? print $module['module'] ?>')" type="button" />
    <? else: ?>
    
    
         <? 
           $iframe_module_params = array();
           $iframe_module_params['module'] = $module['module'] ;
           $iframe_module_params = base64_encode(serialize($iframe_module_params));
           
           
           
           ?>
            <a href="<? print site_url('api/module/iframe:'. $iframe_module_params) ?>" target="_blank">Open</a>
    
    <input value="Uninstall" onclick="uninstall_module('<? print $module['module'] ?>')" type="button" />
    
    <? endif; ?>
    </td>
  </tr>
<? endforeach; ?>  
  
</table>


