<?php

$table_name = false;
$table_name = TABLE_PREFIX . "cart_promo_codes";
$query = CI::db()->query ( "show tables like '$table_name'" );
$query = $query->row_array ();
$query = (array_values ( $query ));

if ($query [0] != $table_name) {
	$sql = "CREATE TABLE " . $table_name . " (
		id int(11) NOT NULL auto_increment,
		UNIQUE KEY id (id)
		);
		ENGINE=MyISAM   DEFAULT CHARSET=utf8
		";
	CI::db()->query ( $sql );
}

$sql = "show tables like '$table_name'"; 
$query = CI::db()->query ( $sql );
$query = $query->row_array (); 
$query = (array_values ( $query ));
if ($query [0] == $table_name) {
	//$columns = $db->fetchAll("show columns from $table_name");
	/* 
	$sql = "show columns from $table_name";
	$query = CI::db()->query ( $sql );
	$columns = $query->result_array ();
	
	$exisiting_fields = array ();
	foreach ( $columns as $fivesdraft ) {
		$fivesdraft = array_change_key_case ( $fivesdraft, CASE_LOWER );
		$exisiting_fields [strtolower ( $fivesdraft ['field'] )] = true;
	}
	*/
	
	$fields_to_add = array ();
	
	$fields_to_add [] = array ('updated_on', 'datetime default NULL' );
	$fields_to_add [] = array ('created_on', 'datetime default NULL' );
	$fields_to_add [] = array ('promo_code', 'TEXT default NULL' );
	$fields_to_add [] = array ('amount_modifier', 'TEXT default NULL' );
	$fields_to_add [] = array ('amount_modifier_type', 'TEXT default NULL' );
	$fields_to_add [] = array ('description', 'TEXT default NULL' );
	
	$fields_to_add [] = array ('valid_from', 'datetime default NULL' );
	$fields_to_add [] = array ('valid_to', 'datetime default NULL' );
	$fields_to_add [] = array ('auto_apply_to_all', 'char(1) default "n"' );
	
	/*
	foreach ( $fields_to_add as $the_field ) {
		$sql = false;
		$the_field [0] = strtolower ( $the_field [0] );
		if ($exisiting_fields [$the_field [0]] != true) {
			$sql = "alter table $table_name add column {$the_field[0]} {$the_field[1]} ";
			CI::db()->query ( $sql );
		} else {
			$sql = "alter table $table_name modify {$the_field[0]} {$the_field[1]} ";
			CI::db()->query ( $sql );
		}
	
	}
	*/
	$this->set_db_tables($table_name, $fields_to_add );

}

?>