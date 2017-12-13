<?php
class counter{

	var $session_id			= null;
	var $session_time		= null;
	var $session_gid		= null;
	var $session_guest		= null;
	
	function counter($lifetime=1800){
	
		$this->session_id = session_id();
		$this->session_savepath = uploadPath.'cache/cnisession/';
		$this->session_file = $this->session_savepath.$this->session_id.'.txt';
		$this->counter_file = $this->session_savepath.'counter.txt';
		$this->session_lifetime = $lifetime;
	}
	
	function initSession(){
	
		$this->destroySession();

		if( $this->loadSession() ){
		
			$this->session_time = time();
			$this->updateSession();
		} 
		else {
		
			$this->session_gid		= '';
			$this->session_guest	= 1;
			$this->session_time		= time();
			
			$this->insertSession();
		}
	}
	
	function insertSession() {		
	
		$data = $this->session_time.'|'.$this->session_guest.'|'.$this->session_gid;
		
		if(!file_exists($this->session_file)){
			$handle = fopen($this->session_file, 'w');
			fwrite($handle, $data);
			fclose($handle);
    	}
		
		if(!file_exists($this->counter_file)){
			$handle = fopen($this->counter_file, 'w');
			fwrite($handle, '0|0');
			fclose($handle);
    	}

    	$fp = fopen($this->counter_file, 'r');
		$counters = fread($fp, filesize($this->counter_file) );
		fclose($fp);
		
		$counters = explode('|', $counters);
		
		if( is_array($counters) ){
			$guest = $counters[0] + 1;
			$total = $counters[1] + 1;
		} else {
			$guest = 1;
			$total = 1;
		}
		
		$data_counter = $guest.'|'.$total;
		
    	if(is_writable($this->counter_file)){
			$handle = fopen($this->counter_file, 'w+');
			fwrite($handle, $data_counter);
			fclose($handle);
    	}
		
		return true;
	}
	
	function loadSession(){
	
		if( file_exists($this->session_file) ){	
		
			$fp = fopen($this->session_file, 'r');
			$sessions = fread($fp, filesize($this->session_file) );
			fclose($fp);
			
			$sessions = explode('|',$sessions);
			if( is_array($sessions) ){
				$this->session_time	= $sessions[0];
				$this->session_guest = $sessions[1];
				$this->session_gid = $sessions[2];
			}
			
			return true;
		}
		
		return false;
	}
	
	function updateSession(){
	
		if( file_exists($this->session_file) ){	
		
			$fp = fopen($this->session_file, 'r');
			$sessions = fread($fp, filesize($this->session_file) );
			fclose($fp);
			
			$sessions = explode('|',$sessions);
			
			if( is_array($sessions) ){
				$session_time  = @$sessions[0];
				$session_guest = @$sessions[1];
				$session_gid   = @$sessions[2];
			}
		}
		
		if(file_exists($this->counter_file)){
		
			$fp = fopen($this->counter_file, 'r');
			$counters = fread($fp, filesize($this->counter_file) );
			fclose($fp);
			
			$counters = explode('|', $counters);
			
			if( is_array($counters) ){
				$guest = $counters[0];
				$total = $counters[1];
			}
		}
		
		$data = $this->session_time.'|'.$this->session_guest.'|'.$this->session_gid;
		if(is_writable($this->session_file)){
			$handle = fopen($this->session_file, 'w+');
			fwrite($handle, $data);
			fclose($handle);
    	}
		
		if( $session_guest == '0' && $this->session_guest == '1' ){
			$guest = $guest + 1;
		}
		
		if( $session_guest == '1' && $this->session_guest == '0' ){
			$guest = @$guest > 1 ? ($guest -1 ):0;
		}
		
		$data_counter = $guest.'|'.$total;
		
    	if(is_writable($this->counter_file)){
			$handle = fopen($this->counter_file, 'w+');
			fwrite($handle, $data_counter);

			fclose($handle);
    	}
		return true;
	}
	
	function destroySession(){
	
		$past = time() - $this->session_lifetime;
		
		
		// destroy non active session
		$exclude_dir = array(".", ".." );
		$d = dir($this->session_savepath);
		while( false !== ($entry = $d->read()) ) {
		
			if ( in_array($entry, $exclude_dir) || is_dir($entry) )	{
				continue;
			}
			$files[] = $entry;
			$time = filemtime($this->session_savepath.'/'.$entry);

			if( $time < $past ){
				// read the session
				$fp = fopen($this->session_savepath.'/'.$entry, 'r');
				$sessions = fread($fp, filesize($this->session_savepath.'/'.$entry) );
				fclose($fp);
				
				$sessions = explode('|',$sessions);
				
				if( is_array($sessions) ){
					$session_time	= @$sessions[0];
					$session_guest  = @$sessions[1];
					$session_gid    = @$sessions[2];
				}
				
				// read counter
				if(file_exists($this->counter_file)){
					$fp = fopen($this->counter_file, 'r');
					$counters = fread($fp, filesize($this->counter_file) );
					fclose($fp);
					
					$counters = explode('|', $counters);
					
					if( is_array($counters) ){
						$guest = $counters[0];
						$total = $counters[1];
					}
				}
				
				if( $session_guest == '1' ){
					$guest = @$guest > 1 ? ($guest - 1):0;
				}
				
				$data_counter = $guest.'|'.$total;
				if(is_writable($this->counter_file)){
					$handle = fopen($this->counter_file, 'w+');
					fwrite($handle, $data_counter);
					fclose($handle);
				}
				//@session_destroy();
				if( $entry != 'counter.txt' ){
					@unlink($this->session_savepath.'/'.$entry);
				}
			}
		}
	}
	
	function loadCounter(){
	
		// read counter
		$return = new stdClass();
		
		if(file_exists($this->counter_file)){
			$fp = fopen($this->counter_file, 'r');
			$counters = fread($fp, filesize($this->counter_file) );
			fclose($fp);
			
			$counters = explode('|', $counters);
			
			if( is_array($counters) ){
				$return->guest = $counters[0];
				$return->total = $counters[1];
			}
		}
		
		return $return;
	}
}
?>