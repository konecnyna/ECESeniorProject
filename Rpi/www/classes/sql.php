<?php
//sql.php
/**
 * mbe.ro
 *
 * @author     Ciprian Mocanu <http://www.mbe.ro> <ciprian@mbe.ro>
 * @license    Do whatever you like, just please reference the author
 * @version    1.56
 */
 //Taken from: https://mbe.ro/2009/08/30/fast-and-easy-php-mysql-class/
class mysql {
	var $con;
	function __construct($db=array()) {	//connect function, only one we use
		$default = array(
			'host' => 'localhost',
			'user' => 'root',
			'pass' => 'houlihan9',
			'db' => 'login'
		);
		$db = array_merge($default,$db);
		$this->con=mysql_pconnect($db['host'],$db['user'],$db['pass'],true) or die ('Error connecting to MySQL');
		mysql_select_db($db['db'],$this->con) or die('Database '.$db['db'].' does not exist!');
	}
	function __destruct() {
		mysql_close($this->con);
	}
	
	function gen_selectmenu($query, $id, $value, $selectname)
	{
		$res = "";
		$res .= "<select id='$selectname'>\n";
		$query = mysql_query($query, $this->con);
		//print "<option value='{$data['$id']}'>{$data['$value']}</option>\n";
	
		while ($row = mysql_fetch_assoc($query) )
		{
			$res .= "<option value='{$row[$id]}'>{$row[$value]}</option>\n";
		}

		$res .= "</select>\n";
		return $res;
	}
	
		function gen_selectmenu_regex($query, $id, $value, $selectname, $pattern)
	{
		$res = "";
		$res .= "<select id='$selectname'>\n";
		$query = mysql_query($query, $this->con);
		//print "<option value='{$data['$id']}'>{$data['$value']}</option>\n";
	
		$items = array();
		while ($row = mysql_fetch_assoc($query) )
		{
			$s = preg_replace('/^.*?(\d+(?=\D*$)\s*)/', '', $row['Ingredient_Portion']);
			if( in_array($s,$items) == false && $s !== ''){
				array_push($items,$s);
			}
		}
		
		asort($items);
		$oz = ["Oz."];
		$items = $oz + $items;
		foreach($items as $item){
			$res .= "<option >$item</option>\n";
		}
		$res .= "</select>\n";
		return $res;
	}
	

	
	function query($s='',$rows=false,$organize=true) {
		if (!$q=mysql_query($s,$this->con)) return false;
		if ($rows!==false) $rows = intval($rows);
		$rez=array(); $count=0;
		$type = $organize ? MYSQL_NUM : MYSQL_ASSOC;
		while (($rows===false || $count<$rows) && $line=mysql_fetch_array($q,$type)) {
			if ($organize) {
				foreach ($line as $field_id => $value) {
					$table = mysql_field_table($q, $field_id);
					if ($table==='') $table=0;
					$field = mysql_field_name($q,$field_id);
					$rez[$count][$table][$field]=$value;
				}
			} else {
				$rez[$count] = $line;
			}
			++$count;
		}
		if (!mysql_free_result($q)) return false;
		return $rez;
	}
	function execute($s='') {
		if (mysql_query($s,$this->con)) return true;
		return false;
	}
	function select($options) {
		$default = array (
			'table' => '',
			'fields' => '*',
			'condition' => '1',
			'order' => '1',
			'limit' => 50
		);
		$options = array_merge($default,$options);
		$sql = "SELECT {$options['fields']} FROM {$options['table']} WHERE {$options['condition']} ORDER BY {$options['order']} LIMIT {$options['limit']}";
		return $this->query($sql);
	}
	function select_raw($sql) {
		//$sql = "SELECT * FROM  `drink_names` LIMIT 0 , 30";
		return mysql_query($sql, $this->con);
	}
	function row($options) {
		$default = array (
			'table' => '',
			'fields' => '*',
			'condition' => '1',
			'order' => '1'
		);
		$options = array_merge($default,$options);
		$sql = "SELECT {$options['fields']} FROM {$options['table']} WHERE {$options['condition']} ORDER BY {$options['order']}";
		$result = $this->query($sql,1,false);
		if (empty($result[0])) return false;
		return $result[0];
	}
	function get($table=null,$field=null,$conditions='1') {
		if ($table===null || $field===null) return false;
		$result=$this->row(array(
			'table' => $table,
			'condition' => $conditions,
			'fields' => $field
		));
		if (empty($result[$field])) return false;
		return $result[$field];
	}
	function update($table=null,$array_of_values=array(),$conditions='FALSE') {
		if ($table===null || empty($array_of_values)) return false;
		$what_to_set = array();
		foreach ($array_of_values as $field => $value) {
			if (is_array($value) && !empty($value[0])) $what_to_set[]="`$field`='{$value[0]}'";
			else $what_to_set []= "`$field`='".mysql_real_escape_string($value,$this->con)."'";
		}
		$what_to_set_string = implode(',',$what_to_set);
		return $this->execute("UPDATE $table SET $what_to_set_string WHERE $conditions");
	}
	function insert($table=null,$array_of_values=array()) {
		if ($table===null || empty($array_of_values) || !is_array($array_of_values)) return false;
		$fields=array(); $values=array();
		foreach ($array_of_values as $id => $value) {
			$fields[]=$id;
			if (is_array($value) && !empty($value[0])) $values[]=$value[0];
			else $values[]="'".mysql_real_escape_string($value,$this->con)."'";
		}
		$s = "INSERT INTO $table (".implode(',',$fields).') VALUES ('.implode(',',$values).')';
		if (mysql_query($s,$this->con)) return mysql_insert_id($this->con);
		return false;
	}
	function delete($table=null,$conditions='FALSE') {
		if ($table===null) return false;
		return $this->execute("DELETE FROM $table WHERE $conditions");
	}
}
?>
