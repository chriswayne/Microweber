<script type="text/javascript">
$(document).ready(function(){
    $(".richtext .user_activity_comments").click(function(){
        $("html, body").animate({scrollTop: $("#post_comments_list").offset().top - 40});
        return false;
    });
});
</script>

<h2 class="nomargin"><? print $post["content_title"]; ?></h2>
<div class="richtext"> <img src="<? print thumbnail($post['id'], 250); ?>" vspace="5" hspace="5" align="left" style="float:left;margin-right:10px;" /><? print $post["the_content_body"]; ?> <br />
  <div class="user_activity_bar">
    <div> <span class="st_sharethis" st_url="<? print post_link($the_post["id"]); ?>" st_title="<? print addslashes($the_post["content_title"]); ?>" displayText="Share this"></span>
       
      <a class="user_activity_comments" href="<? print post_link($post['id']); ?>"><strong><? print comments_count($post['id']); ?></strong><span></span><strong>Comments</strong></a> <a class="user_activity_likes" href="<? print voting_link($post['id'], '#post-likes-'.$post['id']); ?>"><strong id="post-likes-<? print ($post['id']); ?>"><? print votes_count($post['id']); ?></strong><span></span><strong >Like</strong></a> </div>
  </div>
</div>
      <div class="post_list" align="center">  <? include(TEMPLATE_DIR.'banner_wide.php')	; ?></div>
<h2 style="padding: 10px 0">Comments</h2>
<? comments_list($post['id'])  ?>
<br />
<br />
<h2 class="coment-title">Post your comment</h2>
<? comment_post_form($post['id'])  ?>
<div class="c">&nbsp;</div>
<br />
<br />
<div class="ghr"></div>
<br />
<h2>More on the subject</h2>
<?

  $params= array();
$params['display']= 'post_item_wide.php';
//$params['is_special'] = 'y';
$params['items_per_page'] = 10;
$params['curent_page'] = 1;
 get_posts($params);



  ?>
<br />
<br />
<!--<h2 class="coment-title">Reply</h2>
<form class="comment_form" id="reply_form" action="#" method="post">
  <textarea cols="" rows=""></textarea>
  <a class="submit mw_btn_x" href="javascript:void(0);"><span>Post question</span></a>
</form>-->
