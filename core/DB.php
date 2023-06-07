	<?php

// Lớp database
class DB
{
	// Các biến thông tin kết nối
	private //$hostname = 'localhost',
			$hostname = '192.168.0.200',
			$username = 'EGN',
			$password = 'egnSmd!3579',
			$dbname = 'em';

	// Biến lưu trữ kết nối
	public $cn = NULL;

	// Hàm kết nối
	public function connect()
	{
		try{ $this->cn = mysqli_connect($this->hostname, $this->username, $this->password, $this->dbname);}
		catch(mysqli_sql_exception $e){
			echo $e->getMessage();
			exit(); // dừng chương trình
		}
	}

	// Hàm ngắt kết nối
	public function close()
	{
	    if ($this->cn)
	    {
	        mysqli_close($this->cn);
	    }
	}

	// Hàm truy vấn
	public function query($sql = null) 
	{	
	    if ($this->cn)
	    {
			if(!mysqli_query($this->cn, $sql))
			{
				mysqli_error($sql);
			}
	    }
	}

	// Hàm đếm số hàng
	public function num_rows($sql = null) 
	{
		if ($this->cn)
		{
			$query = mysqli_query($this->cn, $sql);
			if ($query)
			{
				$row = mysqli_num_rows($query);
				return $row;
			}	
		}		
	}

	// Hàm lấy dữ liệu
	public function fetch_assoc($sql = null, $type)
	{
		if ($this->cn)
		{
			$query = mysqli_query($this->cn, $sql);
			if ($query)
			{
				if ($type == 0)
				{
					// Lấy nhiều dữ liệu gán vào mảng
					while ($row = mysqli_fetch_assoc($query))
					{
						$data[] = $row;
					}
					return $data;
				}
				else if ($type == 1)
				{
					// Lấy một hàng dữ liệu gán vào biến
					$data = mysqli_fetch_assoc($query);
					return $data;
				}
			}		
		}
	}
	//Hàm kiểm tra dữ liệu nhập
	public function escape($str = null){
		$str = trim(htmlspecialchars(addslashes($str)));
		if($this->cn) return mysqli_real_escape_string($this->cn, $str);
	}

	// Hàm lấy ID cao nhất
	public function insert_id()
	{
		if ($this->cn)
		{
			$count = mysqli_insert_id($this->cn);
			if ($count == '0')
			{
				$count = '1';
			}
			else
			{
				$count = $count;
			}
			return $count;
		}
	}

	// Hàm charset cho database
	public function set_char($uni)
	{
		if ($this->cn)
		{
			mysqli_set_charset($this->cn, $uni);
		}
	}
}



?>