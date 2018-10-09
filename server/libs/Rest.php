<?php


namespace libs;

include_once 'config.php';
include_once 'View.php';

class Rest
{
	protected $api;
	protected $param;
	protected $opt;


	public function __construct()
	{
		$this->urlEncode();
		$this->reqMethod();
	}


	private function urlEncode()
	{
		$url = $_SERVER['REQUEST_URI'];
//		list($a, $b, $c, $d, $e, $f, $this->table, $this->param) = explode('/', $url, 8);

		list($a, $b, $this->api, $this->param) = explode('/', $url, 4);

		//echo "a - $a <br>b - $b <br> api - $this->api <br> param - $this->param <br>";
		//echo "$a - a <br>$b - b <br> $c - c <br> $d - d <br> $e - e <br> $f - f <br> $this->table - tbl <br> $this->param - prm <br>";
	}


	private function reqMethod()
	{
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'GET':
				$this->setMethod('get'.ucfirst($this->api), explode('/', $this->param));
				break;
			case 'POST':
				$this->setMethod('post'.ucfirst($this->api), explode('/', $this->param));
				break;
			case 'PUT':
				$data = json_decode(file_get_contents("php://input"), true);
				$this->setMethod('put'.ucfirst($this->api), explode('/', $this->param), $data);
				break;
			case 'DELETE':
				$this->setMethod('delete'.ucfirst($this->api), explode('/', $this->param));
				break;
			default:
				return false;
		}
	}

	private function setMethod($method, $param, $data = false)
	{
		//var_dump($method,  $param);
		if ( method_exists($this, $method) )
		{
			$this->$method($param, $data);
		}
		else
		{
			View::sendData('error', CODE_405, 405);
		}
	}
}

