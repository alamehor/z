<?php
	require_once './db/dbz_dbManager.php';
	
/*
 * SCHEMA DB Media
 * 
	{
		Description: {
			type: 'String', 
			required : true
		},
		Name: {
			type: 'String', 
			required : true
		},
		Title: {
			type: 'String', 
			required : true
		},
		seoDescription: {
			type: 'String', 
			required : true
		},
		seoTitle: {
			type: 'String', 
			required : true
		},
		//RELAZIONI
		
		
		//RELAZIONI ESTERNE
		
		Article: [{
			type: Schema.ObjectId,
			ref : "Media"
		}],
		User: {
			type: Schema.ObjectId,
			ref : "Media"
		},
		
	}
 * 
 */


//CRUD METHODS


//CRUD - CREATE


$app->post('/media',	function () use ($app){

	$body = json_decode($app->request()->getBody());
	
	$params = array (
		'Description'	=> $body->Description,
		'Name'	=> $body->Name,
		'Title'	=> $body->Title,
		'seoDescription'	=> $body->seoDescription,
		'seoTitle'	=> $body->seoTitle,
		

		'User' => isset($body->User)?$body->User:'',
	);

	$obj = makeQuery("INSERT INTO media (_id, Description, Name, Title, seoDescription, seoTitle , User )  VALUES ( null, :Description, :Name, :Title, :seoDescription, :seoTitle , :User   )", $params, false);
    
    
	// Delete not in array
	$in = " and id_Article NOT IN (:Article)";
	$sql = "DELETE FROM Media_Article WHERE id_Media=:id_Media ";
		
	$params = array (
		'id_Media'	=> $obj['id']
	);
	
	if (isset($body->Article) && $body->Article != null && sizeOf($body->Article) > 0) {
		$sql = $sql.$in;
		$params['Article'] = join("', '", $body->Article);
	}
	
	makeQuery($sql, $params, false);
	
	
	// Get actual
	$sql="SELECT id_Article FROM Media_Article WHERE id_Media=:id";
	$params = array (
		'id'	=> $obj['id'],
	);
    $actual = makeQuery($sql, $params, false);
	$actualArray=[];
	foreach ($actual as $val) {
		array_push($actualArray, $val->id_Article);
	}

	// Insert new
	if (isset($body->Article)) {
    	foreach ($body->Article as $id_Article) {
    		if (!in_array($id_Article, $actualArray)){
    			$sql = "INSERT INTO Media_Article (_id, id_Media, id_Article ) VALUES (null, :id_Media, :id_Article)";
    
    			$params = array (
    				'id_Media'	=> $obj['id'],
    				'id_Article'	=> $id_Article
    			);
        		makeQuery($sql, $params, false);
    		}
    	}
	}
	
	    
	
	echo json_encode($body);
	
});
	
//CRUD - REMOVE

$app->delete('/media/:id',	function ($id) use ($app){
	
	$params = array (
		'id'	=> $id,
	);

	makeQuery("DELETE FROM media WHERE _id = :id LIMIT 1", $params);

});

//CRUD - FIND BY User

$app->get('/media/findByUser/:key',	function ($key) use ($app){	

	$params = array (
		'key'	=> $key,
	);
	makeQuery("SELECT * FROM media WHERE User = :key", $params);
	
});
	
//CRUD - GET ONE
	
$app->get('/media/:id',	function ($id) use ($app){
	$params = array (
		'id'	=> $id,
	);
	
	$obj = makeQuery("SELECT * FROM media WHERE _id = :id LIMIT 1", $params, false);
	
	
	$list_Article = makeQuery("SELECT id_Article FROM Media_Article WHERE id_Media = :id", $params, false);
	$list_Article_Array=[];
	foreach ($list_Article as $val) {
		array_push($list_Article_Array, $val->id_Article);
	}
	$obj->Article = $list_Article_Array;
	
	
	
	echo json_encode($obj);
	
});
	
	
//CRUD - GET LIST

$app->get('/media',	function () use ($app){
	makeQuery("SELECT * FROM media");
});


//CRUD - EDIT

$app->post('/media/:id',	function ($id) use ($app){

	$body = json_decode($app->request()->getBody());
	
	$params = array (
		'id'	=> $id,
		'Description'	    => $body->Description,
		'Name'	    => $body->Name,
		'Title'	    => $body->Title,
		'seoDescription'	    => $body->seoDescription,
		'seoTitle'	    => $body->seoTitle
,
		'User'      => isset($body->User)?$body->User:'' 
	);

	$obj = makeQuery("UPDATE media SET  Description = :Description,  Name = :Name,  Title = :Title,  seoDescription = :seoDescription,  seoTitle = :seoTitle  , User=:User  WHERE _id = :id LIMIT 1", $params, false);
    
	// Delete not in array
	$in = " and id_Article NOT IN (:Article)";
	$sql = "DELETE FROM Media_Article WHERE id_Media=:id_Media ";
	
	$params = array (
		'id_Media'	=> $body->_id
	);
	
	if (isset($body->Article) && $body->Article != null && sizeOf($body->Article) > 0) {
		$sql = $sql.$in;
		$params['Article'] = join("', '", $body->Article);
	}
	
	makeQuery($sql, $params, false);
	
	
	// Get actual
	$sql="SELECT id_Article FROM Media_Article WHERE id_Media=:id";
	$params = array (
		'id'	=> $body->_id,
	);
    $actual = makeQuery($sql, $params, false);
	$actualArray=[];
	foreach ($actual as $val) {
		array_push($actualArray, $val->id_Article);
	}

	// Insert new
	if (isset($body->Article)) {
    	foreach ($body->Article as $id_Article) {
    		if (!in_array($id_Article, $actualArray)){
    			$sql = "INSERT INTO Media_Article (_id, id_Media, id_Article ) VALUES (null, :id_Media, :id_Article)";
    
    			$params = array (
    				'id_Media'	=> $body->_id,
    				'id_Article'	=> $id_Article
    			);
        		makeQuery($sql, $params, false);
    		}
    	}
	}
	
	    
	
	echo json_encode($body);
    	
});


/*
 * CUSTOM SERVICES
 *
 *	These services will be overwritten and implemented in  Custom.js
 */

			
?>