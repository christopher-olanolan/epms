<?
if (!defined('__CONTROL__')) die ("You Cannot Access This Script Directly");

class Select extends mySQL {

	/**
	 * Contruct select option from database query.
	 * 
	 * @param $table
	 *            table name
	 * @param $name and $id
	 *			  select name='$name' and id='$id'
	 * @param $value
	 *            field name for option value
	 * @param $name
	 *            field name for option name
	 * @param $selected
	 *            default selected value
	 * @param $where
	 *            query condition(s)
	 * @param $order
	 *            'order by' field name 
	 * @param $dir
	 *            sort order 'asc' or 'desc'
	 * @param $class
	 *            class value(s)
	 * @param $default
	 *            default null option name 'Choose option...'
	 * @param $type
	 *            select type 1 = multiple or 0 = single
	 */
	function option_query($table, $id, $name, $key, $value, $selected, $where='', $order='', $dir='', $class='', $default='', $type='0'){
		$where = $where != "" ? "WHERE $where ":"";
		$order = $order != "" ? "ORDER BY $order $dir":"";

		$options = $this->open_select($id, $name, $class, $default, $type);
		$row = $this->get_array_result("SELECT $key, $value FROM $table $where $order");
		$count = count($row);

		for ($x=0;$x<$count;$x++):
			$active = $selected == $row[$x][$key] ? 'selected="selected"':'';
			$options .= '<option value="'.$row[$x][$key].'" '.$active.'>'.$row[$x][$value]."</option>";	
		endfor;

		$options .= $this->close_select();
		
		return $options;
	}
	
	/**
	 * Contruct select option from variable array.	
	 *
	 * @param $data
	 *			array ('value'=>'value','name'=>'name')
	 *			use 'value' key for option value and 'name' key for option name
	 * @param $name and $id
	 *			select name='$name' and id='$id'
	 * @param $selected
	 *			default selected value
	 * @param $class
	 *          class value(s)
	 * @param $default
	 *          default null option name 'Choose option...'
	 * @param $type
	 *          select type 1 = multiple or 0 = single
	 */
	function option_array($data, $id, $name, $selected, $class='', $default='', $type='0'){
		if (!is_array($data)) return "Error: Not valid data";
		
		$options = $this->open_select($id, $name, $class, $default, $type);
		$count = count($data);

		for ($x=0;$x<$count;$x++):
			$active = $selected == $data[$x]['value'] ? 'selected="selected"':'';
			$options .= '<option value="'.$data[$x]['value'].'" '.$active.'>'.$data[$x]['name']."</option>";	
		endfor;

		$options .= $this->close_select();
		
		return $options;
	}
	
	function open_select($id, $name, $class, $default, $type){
		$multiple = $type == '1' ? 'multiple="multiple"':'';
		$name = $type == '1' ? 'name="'.$name.'[]"': 'name="'.$name.'"';
		
		$open  = "<select $name id=\"$id\" class=\"$class\" $multiple>";
		$open .= "<option value=\"0\">$default</option>";
		return $open;
	}
	
	function close_select(){
		$close = "</select>";
		return $close;
	}
	
}
?>