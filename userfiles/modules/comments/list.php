<? // p($params);

$page_id =  PAGE_ID;
$post_id =  POST_ID;

if(intval($post_id ) != 0){
	
	$content_id = $post_id;
} else {
	$content_id = PAGE_ID;
}

?>

<h2 style="padding-bottom: 5px">
  <? if($form_title): ?>
  <? print $form_title  ?>
  <? else : ?>
  Post your comment
  <? endif; ?>
</h2>
<? $update_element = 'comments_list_'.md5(serialize($content_id));
  $this->template ['comments_update_element'] = $update_element;
	$this->load->vars ( $this->template );
  ?>
<? if(user_id() != 0): ?>
<? comment_post_form($content_id)  ?>
<? else: ?>
Login to post comments.
<? endif; ?>
 
<div id="<? print $update_element ?>">
  <? if($list_title): ?>
  <h2 style="padding-bottom: 5px"><? print $list_title  ?></h2>
  <? else : ?>
  <h2 style="padding-bottom: 5px">Comments</h2>
  <? endif; ?>
  <? // comments_list($content_id)  ?>
</div>
