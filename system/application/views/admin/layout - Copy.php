<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0051)http://themes.mudodesigns.com/adminbase/index.html# -->
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK type="text/css" rel="stylesheet" media="all" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/base.css">
<LINK type="text/css" rel="stylesheet" media="all" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/jquery-ui.css">
<LINK type="text/css" rel="stylesheet" media="all" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/grid.css">
<LINK type="text/css" rel="stylesheet" media="all" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/visualize.css">
 
 <title>Admin</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="Robots" content="noindex,nofollow" />

 
<?php include_once ('layout_headers.php') ?>
<style>
#loadingDiv{display:none}
 
</style>
</HEAD>
<BODY>
<DIV id="header">
<div id="loadingDiv">Loading...</div>
  <DIV class="header-top tr">
  
         <?php $the_user = $this->session->userdata ( 'the_user' );
	  $site_url = site_url ();
	   $exit_url = site_url ('login/leave');
	  ?>
        <?php //var_Dump($the_user); ?>
     
          
          
    <P>Hello, <strong><?php print  $the_user['username'] ?></strong>  | <strong><a href="<?php print $site_url ?>" title="<?php print $site_url ?>" target="_blank">Site</a></strong> | <a href="javascript:clear_cache_admin_link()" id="clear_cache_admin_link">Clear cache</a> | <a href="<?php print $exit_url ?>">Exit 
          <!--<img src="<?php print_the_static_files_url() ; ?>icons/lock_small.png"  border="0" alt=" " />--> 
          </a> </P>
    <!-- start dialogue box -->
    <!-- end dialogue box -->
  </DIV>
  <DIV class="header-middle">
    <!-- Start Nav -->
    <UL id="nav" class="fr ">
      <!-- Nav - Start Help -->
      <LI class="help"><A class="help" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Help</A>
        <UL>
          <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Documentation</A></LI>
          <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Forums</A></LI>
          <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Contact</A></LI>
        </UL>
      </LI>
      <!-- Nav - End Help -->
      <!-- Nav - Start Settings -->
      <LI class="settings"><A class="settings" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Settings</A>
        <UL>
          <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">System Settings</A></LI>
          <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Server Setup</A></LI>
        </UL>
      </LI>
      <!-- Nav - End Settings -->
      <!-- Nav - Start Users -->
      <LI class="users"><A class="users" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Users</A>
        <UL>
          <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">User Manager</A></LI>
          <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Manage Users  »</A>
            <UL>
              <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Add User</A></LI>
              <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Edit User</A></LI>
              <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Delete User</A></LI>
            </UL>
          </LI>
          <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">User Reports</A></LI>
          <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Usergoups</A></LI>
        </UL>
      </LI>
      <!-- Nav - End Users -->
      <!-- Nav - Start Content -->
      <LI class="content"><A class="content" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Content</A>
        <UL>
          <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Manage Pages  »</A>
            <UL>
              <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Add Page  »</A>
                <UL>
                  <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">HTML Page</A></LI>
                  <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Widget Page</A></LI>
                  <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Custom Page</A></LI>
                </UL>
              </LI>
              <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Edit Page</A></LI>
              <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Delete Page</A> </LI>
            </UL>
          </LI>
          <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Page Statstics</A></LI>
          <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Page Categories</A></LI>
          <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Page Tags</A></LI>
        </UL>
      </LI>
      <!-- Nav - End Content -->
      <!-- Nav - Start Help -->
      <LI class="dashboard"><A class="dashboard" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Dashboard</A></LI>
      <!-- Nav - End Dashboard -->
    </UL>
    <!-- End Nav -->
    <!-- Start Logo -->
    <IMG id="logo" src="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/logo.png" alt="Admin Theme">
    <!-- End Logo -->
    <BR class="cl">
  </DIV>
  <DIV class="header-bottom">
    <!-- Start Breadcrumbs -->
    <UL id="breadcrumbs">
      <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Base</A> »</LI>
      <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Level One</A> »</LI>
      <LI><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Level Two</A></LI>
    </UL>
    <!-- End Breadcrumbs -->
  </DIV>
</DIV>
<DIV id="page-wrapper">
  <DIV class="page">
    <!-- Start Sidebar -->
    <DIV id="sidebar">
      <!-- Start Live Search  -->
      <FORM class="searchform" action="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">
        <INPUT id="livesearch" type="text" onblur="if (this.value == &#39;&#39;) {this.value = &#39;Live Search...&#39;;}" onfocus="if (this.value == &#39;Live Search...&#39;) {this.value = &#39;&#39;;}" value="Live Search..." class="searchfield ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
        <INPUT type="button" value="Go" class="searchbutton">
      </FORM>
      <!-- End Live Search  -->
      <!-- Start Content Nav  -->
      <SPAN class="ul-header"><A id="toggle-pagesnav" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" class="toggle visible">Content</A></SPAN>
      <UL id="pagesnav">
        <LI><A class="icn_manage_pages" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Manage Pages</A></LI>
        <LI><A class="icn_add_pages" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Add Pages</A></LI>
        <LI><A class="icn_edit_pages" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Edit Pages</A></LI>
        <LI><A class="icn_delete_pages" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Delete Pages</A></LI>
      </UL>
      <!-- End Content Nav  -->
      <!-- Start Comments Nav  -->
      <SPAN class="ul-header"><A id="toggle-commentsnav" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" class="toggle visible">Comments</A></SPAN>
      <UL id="commentsnav">
        <LI><A class="icn_manage_comments" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Manage Comments</A></LI>
        <LI><A class="icn_add_comments" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Add Comments</A></LI>
        <LI><A class="icn_edit_comments" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Edit Comments</A></LI>
        <LI><A class="icn_delete_comments" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Delete Comments</A></LI>
      </UL>
      <!-- End Comments Nav  -->
      <!-- Start Users Nav  -->
      <SPAN class="ul-header"><A id="toggle-userssnav" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" class="toggle visible">Users</A></SPAN>
      <UL id="userssnav">
        <LI><A class="icn_manage_users" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Manage Users</A></LI>
        <LI><A class="icn_add_users" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Add Users</A></LI>
        <LI><A class="icn_edit_users" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Edit Users</A></LI>
        <LI><A class="icn_delete_users" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Delete Users</A></LI>
      </UL>
      <!-- End Users Nav  -->
      <!-- Start Gallery Nav  -->
      <SPAN class="ul-header"><A id="toggle-imagesnav" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" class="toggle visible">Gallery</A></SPAN>
      <UL id="imagesnav">
        <LI><A class="icn_manage_image" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Manage Images</A></LI>
        <LI><A class="icn_add_image" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Add Images</A></LI>
        <LI><A class="icn_edit_image" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Edit Images</A></LI>
        <LI><A class="icn_delete_image" href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Delete Images</A></LI>
      </UL>
      <!-- End Gallery Nav  -->
      <!-- Start Statistics Area  -->
      <SPAN class="ul-header">Statistics</SPAN>
      <UL>
        <LI>Pages: 183</LI>
        <LI>Comments: 432</LI>
        <LI>Users: 1094</LI>
        <!-- End Statistics Area  -->
      </UL>
    </DIV>
    <!-- End Sidebar  -->
    <!-- Star Page Content  -->
    <DIV id="page-content">
      <!-- Start Page Header -->
      <DIV id="page-header">
        <H1>Dashboard</H1>
      </DIV>
      <!-- End Page Header -->
      <!-- Start Grid -->
      <DIV class="container_12">
        <!-- Start Web Stats -->
        <DIV class="grid_12">
          <DIV class="box-header"> <SPAN class="fr"><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Week</A> | <A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">Month</A></SPAN> Web Stats </DIV>
          <DIV class="box stats">
            <TABLE cellspacing="0" cellpadding="0" width="100%" id="stats" style="display: none; ">
              <THEAD>
                <TR>
                  <TD>&nbsp;</TD>
                  <TH scope="col">1st</TH>
                  <TH scope="col">2nd</TH>
                  <TH scope="col">3rd</TH>
                  <TH scope="col">4th</TH>
                  <TH scope="col">5th</TH>
                  <TH scope="col">6th</TH>
                  <TH scope="col">7th</TH>
                  <TH scope="col">8th</TH>
                  <TH scope="col">9th</TH>
                  <TH scope="col">10th</TH>
                  <TH scope="col">11th</TH>
                  <TH scope="col">12th</TH>
                  <TH scope="col">13th</TH>
                  <TH scope="col">14th</TH>
                </TR>
              </THEAD>
              <TBODY>
                <TR style="background-color: rgb(251, 251, 251);">
                  <TH scope="row">New Pages</TH>
                  <TD>2</TD>
                  <TD>1</TD>
                  <TD>0</TD>
                  <TD>3</TD>
                  <TD>2</TD>
                  <TD>2</TD>
                  <TD>3</TD>
                  <TD>1</TD>
                  <TD>4</TD>
                  <TD>2</TD>
                  <TD>0</TD>
                  <TD>2</TD>
                  <TD>3</TD>
                  <TD>1</TD>
                </TR>
                <TR>
                  <TH scope="row">New Comments</TH>
                  <TD>10</TD>
                  <TD>15</TD>
                  <TD>14</TD>
                  <TD>16</TD>
                  <TD>20</TD>
                  <TD>24</TD>
                  <TD>20</TD>
                  <TD>25</TD>
                  <TD>28</TD>
                  <TD>26</TD>
                  <TD>30</TD>
                  <TD>28</TD>
                  <TD>30</TD>
                  <TD>32</TD>
                </TR>
                <TR>
                  <TH scope="row">New Users</TH>
                  <TD>5</TD>
                  <TD>8</TD>
                  <TD>9</TD>
                  <TD>5</TD>
                  <TD>10</TD>
                  <TD>14</TD>
                  <TD>12</TD>
                  <TD>10</TD>
                  <TD>8</TD>
                  <TD>12</TD>
                  <TD>14</TD>
                  <TD>19</TD>
                  <TD>22</TD>
                  <TD>24</TD>
                </TR>
              </TBODY>
            </TABLE>
            <DIV class="visualize visualize-line" role="img" aria-label="Chart representing data from the table: " style="height: 300px; width: 600px; ">
              <UL class="visualize-labels-x" style="width: 600px; height: 300px; ">
                <LI style="left: 0px; "><SPAN class="line" style="border-top-style: none; border-right-style: none; border-bottom-style: none; border-left-style: none; border-width: initial; border-color: initial; "></SPAN><SPAN style="margin-left: 0px; " class="label">1st</SPAN></LI>
                <LI style="left: 46.153846px; "><SPAN class="line"></SPAN><SPAN style="margin-left: -10.5px; " class="label">2nd</SPAN></LI>
                <LI style="left: 92.307692px; "><SPAN class="line"></SPAN><SPAN style="margin-left: -9px; " class="label">3rd</SPAN></LI>
                <LI style="left: 138.461538px; "><SPAN class="line"></SPAN><SPAN style="margin-left: -8.5px; " class="label">4th</SPAN></LI>
                <LI style="left: 184.615385px; "><SPAN class="line"></SPAN><SPAN style="margin-left: -8.5px; " class="label">5th</SPAN></LI>
                <LI style="left: 230.769231px; "><SPAN class="line"></SPAN><SPAN style="margin-left: -8.5px; " class="label">6th</SPAN></LI>
                <LI style="left: 276.923077px; "><SPAN class="line"></SPAN><SPAN style="margin-left: -8.5px; " class="label">7th</SPAN></LI>
                <LI style="left: 323.076923px; "><SPAN class="line"></SPAN><SPAN style="margin-left: -8.5px; " class="label">8th</SPAN></LI>
                <LI style="left: 369.230769px; "><SPAN class="line"></SPAN><SPAN style="margin-left: -8.5px; " class="label">9th</SPAN></LI>
                <LI style="left: 415.384615px; "><SPAN class="line"></SPAN><SPAN style="margin-left: -12px; " class="label">10th</SPAN></LI>
                <LI style="left: 461.538462px; "><SPAN class="line"></SPAN><SPAN style="margin-left: -12px; " class="label">11th</SPAN></LI>
                <LI style="left: 507.692308px; "><SPAN class="line"></SPAN><SPAN style="margin-left: -12px; " class="label">12th</SPAN></LI>
                <LI style="left: 553.846154px; "><SPAN class="line"></SPAN><SPAN style="margin-left: -12px; " class="label">13th</SPAN></LI>
                <LI style="left: 600px; "><SPAN class="line" style="border-top-style: none; border-right-style: none; border-bottom-style: none; border-left-style: none; border-width: initial; border-color: initial; "></SPAN><SPAN style="margin-left: -24px; " class="label">14th</SPAN></LI>
              </UL>
              <UL class="visualize-labels-y" style="width: 600px; height: 300px; ">
                <LI style="bottom: 300px; "><SPAN class="line" style="border-top-style: none; border-right-style: none; border-bottom-style: none; border-left-style: none; border-width: initial; border-color: initial; "></SPAN><SPAN style="margin-top: 0px; " class="label">32</SPAN></LI>
                <LI style="bottom: 262.5px; "><SPAN class="line"></SPAN><SPAN style="margin-top: -7.5px; " class="label">28</SPAN></LI>
                <LI style="bottom: 225px; "><SPAN class="line"></SPAN><SPAN style="margin-top: -7.5px; " class="label">24</SPAN></LI>
                <LI style="bottom: 187.5px; "><SPAN class="line"></SPAN><SPAN style="margin-top: -7.5px; " class="label">20</SPAN></LI>
                <LI style="bottom: 150px; "><SPAN class="line"></SPAN><SPAN style="margin-top: -7.5px; " class="label">16</SPAN></LI>
                <LI style="bottom: 112.5px; "><SPAN class="line"></SPAN><SPAN style="margin-top: -7.5px; " class="label">12</SPAN></LI>
                <LI style="bottom: 75px; "><SPAN class="line"></SPAN><SPAN style="margin-top: -7.5px; " class="label">8</SPAN></LI>
                <LI style="bottom: 37.5px; "><SPAN class="line"></SPAN><SPAN style="margin-top: -7.5px; " class="label">4</SPAN></LI>
                <LI style="bottom: 0px; "><SPAN class="line" style="border-top-style: none; border-right-style: none; border-bottom-style: none; border-left-style: none; border-width: initial; border-color: initial; "></SPAN><SPAN style="margin-top: -15px; " class="label">0</SPAN></LI>
              </UL>
              <CANVAS height="300" width="600"></CANVAS>
              <DIV class="visualize-info">
                <DIV class="visualize-title"></DIV>
                <UL class="visualize-key">
                  <LI><SPAN class="visualize-key-color" style="background: #be1e2d"></SPAN><SPAN class="visualize-key-label">New Pages</SPAN></LI>
                  <LI><SPAN class="visualize-key-color" style="background: #666699"></SPAN><SPAN class="visualize-key-label">New Comments</SPAN></LI>
                  <LI><SPAN class="visualize-key-color" style="background: #92d5ea"></SPAN><SPAN class="visualize-key-label">New Users</SPAN></LI>
                </UL>
              </DIV>
            </DIV>
            <BR>
          </DIV>
        </DIV>
        <!-- End Web Stats -->
        <!-- Start Table -->
        <DIV class="grid_8">
          <DIV class="box-header"> Table Example </DIV>
          <DIV class="box table">
            <TABLE cellspacing="0">
              <THEAD>
                <TR>
                  <TD class="tc"><INPUT type="checkbox" value="" class="checkbox"></TD>
                  <TD>Name</TD>
                  <TD>Email</TD>
                  <TD>Joined</TD>
                  <TD>Usergroup</TD>
                  <TD>Options</TD>
                </TR>
              </THEAD>
              <TBODY>
                <TR>
                  <TD class="tc"><INPUT type="checkbox" value="" class="checkbox"></TD>
                  <TD> John </TD>
                  <TD>lorm@ipsum.com </TD>
                  <TD>9/5/2010</TD>
                  <TD> Member </TD>
                  <TD class="tc"><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" title="Edit User"><IMG src="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/user_edit.png" alt="edit user" border="0"></A> <A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" title="Delete User"><IMG src="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/user_delete.png" alt="delete user" border="0"></A></TD>
                </TR>
                <TR>
                  <TD class="tc"><INPUT type="checkbox" value="" class="checkbox"></TD>
                  <TD> John </TD>
                  <TD>lorm@ipsum.com </TD>
                  <TD>9/5/2010</TD>
                  <TD> Member </TD>
                  <TD class="tc"><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" title="Edit User"><IMG src="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/user_edit.png" alt="edit user" border="0"></A> <A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" title="Delete User"><IMG src="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/user_delete.png" alt="delete user" border="0"></A></TD>
                </TR>
                <TR>
                  <TD class="tc"><INPUT type="checkbox" value="" class="checkbox"></TD>
                  <TD> John </TD>
                  <TD>lorm@ipsum.com </TD>
                  <TD>9/5/2010</TD>
                  <TD> Member </TD>
                  <TD class="tc"><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" title="Edit User"><IMG src="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/user_edit.png" alt="edit user" border="0"></A> <A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" title="Delete User"><IMG src="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/user_delete.png" alt="delete user" border="0"></A></TD>
                </TR>
                <TR>
                  <TD class="tc"><INPUT type="checkbox" value="" class="checkbox"></TD>
                  <TD> John </TD>
                  <TD>lorm@ipsum.com </TD>
                  <TD>9/5/2010</TD>
                  <TD> Member </TD>
                  <TD class="tc"><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" title="Edit User"><IMG src="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/user_edit.png" alt="edit user" border="0"></A> <A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" title="Delete User"><IMG src="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/user_delete.png" alt="delete user" border="0"></A></TD>
                </TR>
                <TR>
                  <TD class="tc"><INPUT type="checkbox" value="" class="checkbox"></TD>
                  <TD> John </TD>
                  <TD>lorm@ipsum.com </TD>
                  <TD>9/5/2010</TD>
                  <TD> Member </TD>
                  <TD class="tc"><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" title="Edit User"><IMG src="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/user_edit.png" alt="edit user" border="0"></A> <A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" title="Delete User"><IMG src="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/user_delete.png" alt="delete user" border="0"></A></TD>
                </TR>
                <TR>
                  <TD class="tc"><INPUT type="checkbox" value="" class="checkbox"></TD>
                  <TD> John </TD>
                  <TD>lorm@ipsum.com </TD>
                  <TD>9/5/2010</TD>
                  <TD> Member </TD>
                  <TD class="tc"><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" title="Edit User"><IMG src="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/user_edit.png" alt="edit user" border="0"></A> <A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" title="Delete User"><IMG src="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/user_delete.png" alt="delete user" border="0"></A></TD>
                </TR>
                <TR>
                  <TD class="tc"><INPUT type="checkbox" value="" class="checkbox"></TD>
                  <TD> John </TD>
                  <TD>lorm@ipsum.com </TD>
                  <TD>9/5/2010</TD>
                  <TD> Member </TD>
                  <TD class="tc"><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" title="Edit User"><IMG src="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/user_edit.png" alt="edit user" border="0"></A> <A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" title="Delete User"><IMG src="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/user_delete.png" alt="delete user" border="0"></A></TD>
                </TR>
                <TR>
                  <TD class="tc"><INPUT type="checkbox" value="" class="checkbox"></TD>
                  <TD> John </TD>
                  <TD>lorm@ipsum.com </TD>
                  <TD>9/5/2010</TD>
                  <TD> Member </TD>
                  <TD class="tc"><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" title="Edit User"><IMG src="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/user_edit.png" alt="edit user" border="0"></A> <A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" title="Delete User"><IMG src="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/user_delete.png" alt="delete user" border="0"></A></TD>
                </TR>
                <TR>
                  <TD class="tc"><INPUT type="checkbox" value="" class="checkbox"></TD>
                  <TD> John </TD>
                  <TD>lorm@ipsum.com </TD>
                  <TD>9/5/2010</TD>
                  <TD> Member </TD>
                  <TD class="tc"><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" title="Edit User"><IMG src="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/user_edit.png" alt="edit user" border="0"></A> <A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" title="Delete User"><IMG src="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/user_delete.png" alt="delete user" border="0"></A></TD>
                </TR>
              </TBODY>
            </TABLE>
          </DIV>
        </DIV>
        <!-- End Table -->
        <!-- Start Formatting -->
        <DIV class="grid_4">
          <DIV class="box-header"> Formatting </DIV>
          <DIV class="box">
            <H2>Headline</H2>
            <P> Lorem ipsum dolor sit amet, consectetur <A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">adipisicing</A> elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </P>
            <H3>Headline</H3>
            <UL>
              <LI>Cupidatat non</LI>
              <LI>Officia deserunt mollit</LI>
              <LI>Velit esse cillum</LI>
            </UL>
            <H4>Headline</H4>
            <OL>
              <LI>Ullamco laboris</LI>
              <LI>Pcupidatat non proident</LI>
              <LI>Duis aute irure dolor</LI>
            </OL>
          </DIV>
        </DIV>
        <BR class="cl">
        <!-- End Formatting -->
        <!-- Start Forms -->
        <DIV class="grid_7">
          <DIV class="box-header"> Forms </DIV>
          <DIV class="box">
            <FORM method="post" action="">
              <DIV class="row">
                <LABEL>Input label:</LABEL>
                <INPUT type="text">
              </DIV>
              <DIV class="row">
                <LABEL>Error example:</LABEL>
                <INPUT type="text" class="error">
              </DIV>
              <DIV class="row">
                <LABEL>Select label:</LABEL>
                <SELECT>
                  <OPTGROUP label="Group 1">
                  <OPTION>Option one</OPTION>
                  <OPTION>Option two</OPTION>
                  <OPTION>Option three</OPTION>
                  </OPTGROUP>
                </SELECT>
              </DIV>
              <DIV class="row">
                <LABEL>Checkbox buttons:</LABEL>
                <INPUT type="checkbox" checked="checked">
                <LABEL class="checkbox">This</LABEL>
                <INPUT type="checkbox">
                <LABEL class="checkbox">That</LABEL>
                <INPUT type="checkbox">
                <LABEL class="checkbox">The Other</LABEL>
                <INPUT type="checkbox">
                <LABEL class="checkbox">Them</LABEL>
                <BR class="cl">
              </DIV>
              <DIV class="row">
                <LABEL>Radio buttons:</LABEL>
                <INPUT name="demoradio" type="radio" class="radio" checked="checked">
                <LABEL class="radio">Yes</LABEL>
                <INPUT name="demoradio" type="radio" class="radio">
                <LABEL class="radio">No</LABEL>
                <BR class="cl">
              </DIV>
              <DIV class="row">
                <LABEL>Text area:</LABEL>
                <TEXTAREA name="text area" rows="6" cols="34"></TEXTAREA>
              </DIV>
              <DIV class="row">
                <LABEL>Big Button:</LABEL>
                <INPUT type="submit" value="Large Button" class="button">
              </DIV>
              <DIV class="row">
                <LABEL>Smaller Buttons:</LABEL>
                <INPUT type="submit" value="Medium Button" class="button medium">
                <INPUT type="submit" value="Small Button" class="button small">
              </DIV>
            </FORM>
          </DIV>
        </DIV>
        <!-- Start Forms -->
        <!-- Start Notifcations -->
        <DIV class="grid_5">
          <DIV class="box-header"> Notifications </DIV>
          <DIV class="box">
            <DIV class="notification success" style="display: block; "> <SPAN class="strong">SUCCESS!</SPAN> This is a success message. <SPAN class="close" title="Dismiss"></SPAN></DIV>
            <DIV class="notification error" style="display: block; "> <SPAN class="strong">ERROR!</SPAN> This is a error message. <SPAN class="close" title="Dismiss"></SPAN></DIV>
            <DIV class="notification warning" style="display: block; "> <SPAN class="strong">WARNING!</SPAN> This is a warning message. <SPAN class="close" title="Dismiss"></SPAN></DIV>
            <DIV class="notification info" style="display: block; "> <SPAN class="strong">INFORMATION!</SPAN> This is a informative message. <SPAN class="close" title="Dismiss"></SPAN></DIV>
            <DIV class="notification tip" style="display: block; "> <SPAN class="strong">TIP:</SPAN> This is a tip message. <SPAN class="close" title="Dismiss"></SPAN></DIV>
          </DIV>
        </DIV>
        <BR class="cl">
        <!-- End Notifcations -->
        <!-- Start Layout Example -->
        <DIV class="grid_12">
          <DIV class="box-header"> Grids within grids </DIV>
          <DIV class="box">
            <P>The fluid grid system is flexible enough for grids to be nested inside grids of grids.</P>
            <DIV class="container_12">
              <DIV class="grid_4">
                <DIV class="box-header"> Column One </DIV>
                <DIV class="box">
                  <DIV class="container_12">
                    <DIV class="grid_6">
                      <DIV class="box-header"> Inner Column </DIV>
                      <DIV class="box"> This is the content of the inner column. </DIV>
                    </DIV>
                    <DIV class="grid_6">
                      <DIV class="box-header"> Inner Column </DIV>
                      <DIV class="box"> This is the content of the inner column. </DIV>
                    </DIV>
                    <BR class="cl">
                  </DIV>
                </DIV>
              </DIV>
              <DIV class="grid_4">
                <DIV class="box-header"> Column Two </DIV>
                <DIV class="box"> This is the content for column two. </DIV>
              </DIV>
              <DIV class="grid_4">
                <DIV class="box-header"> Column Three </DIV>
                <DIV class="box"> This is the content for column three. </DIV>
              </DIV>
              <BR class="cl">
            </DIV>
          </DIV>
        </DIV>
        <BR class="cl">
        <!-- End Layout Example -->
        <!-- End Grid -->
      </DIV>
      <!-- End Page Wrapper -->
    </DIV>
    <!-- End Page Content  -->
  </DIV>
</DIV>
<!-- Start Footer -->
<DIV class="footer"> Copyright ©2010, A <A href="http://www.mudodesigns.com/">Mudo Design</A> for <A href="http://themeforest.net/?ref=maestrox">Theme Forest</A>. </DIV>
<!-- End Footer -->
<UL class="ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all" role="listbox" aria-activedescendant="ui-active-menuitem" style="z-index: 1; top: 0px; left: 0px; display: none; ">
</UL>
<DIV style="display: none; z-index: 1000; outline-width: 0px; outline-style: initial; outline-color: initial; position: absolute; " class="ui-dialog ui-widget ui-widget-content ui-corner-all  ui-draggable ui-resizable" tabindex="-1" role="dialog" aria-labelledby="ui-dialog-title-dialog">
  <DIV class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix" unselectable="on"><SPAN class="ui-dialog-title" id="ui-dialog-title-dialog" unselectable="on">Messages</SPAN><A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm" class="ui-dialog-titlebar-close ui-corner-all" role="button" unselectable="on"><SPAN class="ui-icon ui-icon-closethick" unselectable="on">close</SPAN></A></DIV>
  <DIV id="dialog" class="ui-dialog-content ui-widget-content">
    <DIV class="notification info" style="display: block; "> <SPAN class="strong">INFORMATION!</SPAN> You have 1 new message. <SPAN class="close" title="Dismiss"></SPAN></DIV>
    <!-- start new message -->
    <DIV class="message new">
      <H4>Welcome...<SMALL class="fr">28rd April 2010 from <A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">MaestroX</A></SMALL></H4>
      <P> This is an example of the dialog box. It's powered by jQuery UI so there's tons of options and it's flexible. Checkout the documentation for more information.</P>
    </DIV>
    <!-- end new message -->
    <!-- start old message -->
    <DIV class="message">
      <H4>Old Message<SMALL class="fr">28rd April 2010 from <A href="<?php   print( ADMIN_STATIC_FILES_URL);  ?>/Admin Base.htm">System</A></SMALL></H4>
      <P> Welcome to your shiny new admin panel. Take a look around!</P>
    </DIV>
    <!-- end old message -->
    <!-- start write new message -->
    <FORM method="post" action="">
      <H3>New Message</H3>
      <FIELDSET>
        <TEXTAREA rows="5" cols="55" name="textfield" class="textarea" style="width:97%"></TEXTAREA>
      </FIELDSET>
      <FIELDSET>
        <INPUT type="submit" value="Send" class="button medium fr">
      </FIELDSET>
    </FORM>
    <!-- end write new message -->
  </DIV>
  <DIV class="ui-resizable-handle ui-resizable-n" unselectable="on"></DIV>
  <DIV class="ui-resizable-handle ui-resizable-e" unselectable="on"></DIV>
  <DIV class="ui-resizable-handle ui-resizable-s" unselectable="on"></DIV>
  <DIV class="ui-resizable-handle ui-resizable-w" unselectable="on"></DIV>
  <DIV class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se ui-icon-grip-diagonal-se" style="z-index: 1001; " unselectable="on"></DIV>
  <DIV class="ui-resizable-handle ui-resizable-sw" style="z-index: 1002; " unselectable="on"></DIV>
  <DIV class="ui-resizable-handle ui-resizable-ne" style="z-index: 1003; " unselectable="on"></DIV>
  <DIV class="ui-resizable-handle ui-resizable-nw" style="z-index: 1004; " unselectable="on"></DIV>
</DIV>
</BODY>
</HTML>