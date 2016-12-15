<?php
	require("router.php");
	
	$Router = new Router;

 	$Router->get("/", function(){
		echo "PAGE Index";
	});

	$Router->get("/contato", function(){
		echo "PAGE Contato";
	});
	
	$Router->get("/usuarios", function(){
		echo "PAGE Usuarios";
	});
	
	
	//RESFULL API
 	$Router->get("/usuarios/:id", function($params){
		echo "LISTAR USUÁRIO PELO ID: ".$params["id"];
	});
	
	$Router->post("/usuarios/:nome", function($params){
		echo "SALVAR USUÁRIO: ".$params["nome"];
	});	
	
	$Router->put("/usuarios/:nome", function($params){
		echo "SALVAR USUÁRIO: ".$params["nome"];
	});
	
	$Router->delete("/usuarios/:id", function($params){
		echo "DELETAR USUÁRIO ID: ".$params["id"];
	});
?>