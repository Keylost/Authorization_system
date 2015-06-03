<?php //базовый класс модели. гетдата должен быть перекрыт в потомках
class Model
{
	static private $db_host = "127.0.0.1";
	static private $db_user = "KGB";
	static private $db_pass = "1234";
	static private $db_name = "KGB";
	protected $db_conn;
	
	function __construct() {
       $this->db_conn = mysqli_connect($db_host,$db_user,$db_pass,$db_name) or die("Error " . mysqli_error($db_conn)); //mysql_connect is unsafe
   }
	
    public function get_data()
    {
    }
}
?>