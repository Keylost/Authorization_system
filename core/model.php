<?php //базовый класс модели. гетдата должен быть перекрыт в потомках
class Model
{
	public $err_msg;
	private $db; //mysqli connection descriptor
	
	public function db_connect()
	{
		if(empty($this->db))
		{
			include '/core/db.conf';
			$this->db = mysqli_connect($db_host,$db_user,$db_pass,$db_name) or die("Error " . mysqli_error($db_conn)); //mysql_connect is unsafe			
		}
		return $this->db;
	}
	public function db_disconnect()
	{
		if(!empty($this->db))
		{
			$this->db->close();
			$this->db = NULL;
		}
	}
    public function get_data()
    {
    }
}
?>