<?php

$table_name = false;
$table_name = TABLE_PREFIX . "rss_grabber_plugin_feeds";
$query = $this->db->query ( "show tables like '$table_name'" );
$query = $query->row_array ();
$query = (array_values ( $query ));

if ($query [0] != $table_name) {
	$sql = "CREATE TABLE " . $table_name . " (
		id int(11) NOT NULL auto_increment,
		UNIQUE KEY id (id)	
		);";
	$this->db->query ( $sql );
}

$sql = "show tables like '$table_name'";
$query = $this->db->query ( $sql );
$query = $query->row_array ();
$query = (array_values ( $query ));
if ($query [0] == $table_name) {
	//$columns = $db->fetchAll("show columns from $table_name");
	$sql = "show columns from $table_name";
	$query = $this->db->query ( $sql );
	$columns = $query->result_array ();
	
	$exisiting_fields = array ( );
	foreach ( $columns as $fivesdraft ) {
		$fivesdraft = array_change_key_case ( $fivesdraft, CASE_LOWER );
		$exisiting_fields [strtolower ( $fivesdraft ['field'] )] = true;
	}
	$fields_to_add = array ( );
	
	$fields_to_add [] = array ('feed_name', 'varchar(1500) default NULL' );
	$fields_to_add [] = array ('feed_url', 'varchar(2500) default NULL' );
	$fields_to_add [] = array ('feed_url_md5', 'varchar(1500) default NULL' );
	$fields_to_add [] = array ('is_active', 'char(1) default "y"' ); 
	$fields_to_add [] = array ('feed_check_interval', "TEXT default NULL" );
	$fields_to_add [] = array ('feed_content_category', "int(11)  default NULL" );
	$fields_to_add [] = array ('original_link_no_follow', 'char(1) default "n"' ); 
	
	
	
	$fields_to_add [] = array ('updated_on', 'datetime default NULL' );
	$fields_to_add [] = array ('last_get_on', 'datetime default NULL' );
	
	
	$fields_to_add [] = array ('created_on', 'datetime default NULL' );
	foreach ( $fields_to_add as $the_field ) {
		$sql = false;
		$the_field [0] = strtolower ( $the_field [0] );
		if ($exisiting_fields [$the_field [0]] != true) {
			$sql = "alter table $table_name add column {$the_field[0]} {$the_field[1]} ";
			$this->db->query ( $sql );
		} else {
			$sql = "alter table $table_name modify {$the_field[0]} {$the_field[1]} ";
			$this->db->query ( $sql );
		}
	
	}

}

?>