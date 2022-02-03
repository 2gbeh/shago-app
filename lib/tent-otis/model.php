<?PHP
class tent_otis_json
{	
	final public function read($dir) 
	{
		$json = file_get_contents($dir);
		return json_decode($json,true);
	}		
	final public function write($dir, $array) 
	{ 
		$json = json_encode($array);
		return file_put_contents($dir,$json,LOCK_EX);
	}
	final public function append($dir, $array)
	{
		$json = json_encode($array);
		$seed = file_get_contents($dir);
		$data = strlen($seed) < 1? $json: ','.$json;
		return file_put_contents($dir,$data,FILE_APPEND);
	}	
	final public function publish($data, $type = false) {
		$res = new stdClass();
		$res->data = $data;	
		$res->type = $type;
		echo json_encode($res);
	}
	final public function display($json) 
	{
		print_r($json);
	}
	final public function proxy() 
	{
		// get IP
		$svr = $_SERVER;
		if ($svr['HTTP_CLIENT_IP']) $ip = $svr['HTTP_CLIENT_IP'];
		else if ($svr['HTTP_X_FORWARDED_FOR']) $ip = $svr['HTTP_X_FORWARDED_FOR'];
		else if ($svr['HTTP_X_FORWARDED']) $ip = $svr['HTTP_X_FORWARDED'];
		else if ($svr['HTTP_FORWARDED_FOR']) $ip = $svr['HTTP_FORWARDED_FOR'];
		else if ($svr['HTTP_FORWARDED']) $ip = $svr['HTTP_FORWARDED'];
		else if ($svr['REMOTE_ADDR']) $ip = $svr['REMOTE_ADDR'];
		else $ip = $svr['SERVER_ADDR'];
		// validate IP
		if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false) return $ip;
		else if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false) return $ip;
		else return $ip;	
	}
	final public function now() 
	{
		return date('Y-m-d H:i:s');
	}	
	final public function today() 
	{
		return date('Y-m-d');
	}		
	final public function date_f($ts = NULL) 
	{
		$f = 'Y-m-d';
		return is_null($ts)? date($f): date($f,strtotime($ts));	
	}
	final public function time_f($ts = NULL) 
	{
		$f = 'H:i:s';
		return is_null($ts)? date($f): date($f,strtotime($ts));
	}
	final public function date_i($ts = NULL) 
	{
		$ts = is_null($ts)? date('Y-m-d H:i:s'): $ts;		
		$csv = 'j,d,S,D,l,w,n,m,M,F,t,y,Y,W,z,L,g,H,i,s,u,a,A,e,T,P,c,r,U';
		$format = explode(',',$csv);
		$arr = array();		
		foreach ($format as $f)
			$arr[$f] = date($f,strtotime($ts));
		$arr['x'] = date('YmdHis',strtotime($ts));	
		return $arr;		
		//j=1-31, d=01-31, S=st-th, 
		//D=Sun-Fri, l=Sunday-Friday, w=0-6,
		//n=1-12, m=01-12, M=Jan-Dec, F=January-December, t=28-31
		//y=70-20, Y=1970-2020, W=52, z=365, L=0-1
		//g=01-12, H=00-23, i=00-59, s=00-59, u=msec, 
		//a=am-pm, A=AM-PM, e=UTC-GMT, T=EST-MDT, U=unix (Epoch), P=GMT H:i offset
		//c=2013-05-05T16:34:42+00:00, r=Fri, 12 Apr, 2013 12:01;05+0200 (RFC 2822),
		//WIN=Fri, 4 Sep, 2020, TEL=Fri, Sep 4, 2020, BBM=Apr 17, MAC=20130505163442,
	}	
}

class tent_otis_crud extends tent_otis_json
{
	protected $dir, $data, $ip, $row;
	function __construct ($dir, $ip = NULL) 
	{
		$this->dir = $dir;
		$this->data = $this->read($dir);
		$this->ip = is_null($ip)? $this->proxy(): $ip;
		$this->row = $this->data[$this->ip];
	}	
	final public function exist() 
	{
		return array_key_exists($this->ip,$this->data);
	}	
	final public function insert() 
	{
		$this->data[$this->ip] = array(
			'iter'=>"1", 
			'date'=>$this->now()
		);
		$this->write($this->dir,$this->data);
		return $this->select();
	}
	final public function select() 
	{
		return $this->data[$this->ip];
	}
	final public function update() 
	{
		$iter = (int) $this->row['iter'];
		$iter += 1;
		$this->data[$this->ip] = array(
			'iter'=>(string) $iter,
			'date'=>$this->now()
		);
		$this->write($this->dir,$this->data);
		return $this->select();
	}
	final public function delete() 
	{
		unset($this->data[$this->ip]);
		$this->write($this->dir,$this->data);	
		return $this->select();
	}
	final public function report() 
	{
		$data = $this->data;
		$unique = $total = $mean = $today = $rate = 0;
		$this_week = $this_month = 0;
		$last_7days = $last_30days = $last_90days = 0;		
		foreach ($data as $ip => $row) 
		{
			// total ip
			$unique += 1;			
			// total visits
			$total += (int) $row['iter'];
			// total ip today
			if ($this->date_f($row['date']) == $this->today())
				$today += 1;
			// total ip this week
			$date_x = $this->date_i();
			$date_y = $this->date_i($row['date']);
			if ($date_x['Y'] == $date_y['Y'])
			{
				if ($date_x['W'] == $date_y['W'])
					$this_week += 1;
				// total ip this month
				if ($date_x['m'] == $date_y['m'])
					$this_month += 1;
				// total ip last 7 days
				if (in_array($date_y['z'],range($date_x['z']-6,$date_x['z'])))
					$last_7days += 1;
				// total ip last 30 days
				if (in_array($date_y['z'],range($date_x['z']-29,$date_x['z'])))
					$last_30days += 1;
				// total ip last 90 days
				if (in_array($date_y['z'],range($date_x['z']-89,$date_x['z'])))
					$last_90days += 1;
			}
		}
		// average visits per ip
		$mean = round($total / $unique); 
		// total ip growth rate today
		$rate = round(($today * 100) / $unique);
		$output = compact(
			'unique','total','mean','today','rate',
			'this_week','this_month',
			'last_7days','last_30days','last_90days'
		);
		return $output;
		var_dump($output);
	}		
}

class tent_otis_bean extends tent_otis_crud
{
	final public function set_data ($dir) 
	{
		$this->data = $this->read($dir);
	}
	final public function get_data() 
	{
		return $this->data;
	}	
	final public function set_ip ($ip) 
	{
		$this->ip = $ip;	
	}
	final public function get_ip() 
	{
		return $this->ip;
	}
	final public function get_ips() 
	{
		return array_keys($this->data);
	}	
	final public function get_size() 
	{
		return count($this->data);
	}	
	final public function get_row() 
	{
		return $this->data[$this->ip];
	}			
	final public function get_id()
	{
		$key = $this->ip;
		$keys = array_keys($this->data);
		if (in_array($key,$keys))
			return array_search($key,$keys) + 1;
	}
}



?>