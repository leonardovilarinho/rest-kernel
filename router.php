<?php
	class Router
	{
		protected $params = [];
		
		private function resolverUrl($_url, $_callback)
		{
			if(  strstr( $_url, ":" ) )
			{
				//o parametro url informado na rota
				$url           = explode("/", $_url);
				$totalParams   = count($url);
				
				//a url real
				$request       = explode("/", $_SERVER ['REQUEST_URI']);
				$totalRequest  = count($request);

				if( $totalParams == $totalRequest )
				{
					for( $x=1; $x<$totalParams; $x++ )if(  strstr($url[$x],":") )$this->params[substr($url[$x], 1)] = urldecode($request[$x]);
					call_user_func($_callback, $this->params);
				}
			}
			if(  $_SERVER ['REQUEST_URI'] == $_url )call_user_func($_callback);
		}
		
 		public function get($_url, $_callback)
		{
			if( $_SERVER['REQUEST_METHOD'] == "GET" )$this->resolverUrl($_url, $_callback);
		}
		
		public function post($_url, $_callback)
		{
			if( $_SERVER['REQUEST_METHOD'] == "POST" )$this->resolverUrl($_url, $_callback);
		}
		
		public function put($_url, $_callback)
		{
			if( $_SERVER['REQUEST_METHOD'] == "PUT" )$this->resolverUrl($_url, $_callback);
		}
		
		public function delete($_url, $_callback)
		{
			if( $_SERVER['REQUEST_METHOD'] == "DELETE" )$this->resolverUrl($_url, $_callback);
		}
	}
?>