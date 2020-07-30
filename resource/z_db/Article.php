<?php
	require_once './db/dbz_dbManager.php';
	
/*
 * SCHEMA DB Article
 * 
	{
		Description: {
			type: 'String', 
			required : true
		},
		Img: {
			type: 'String'
		},
		Tag: {
			type: 'String'
		},
		Title: {
			type: 'String', 
			required : true
		},
		seoDescription: {
			type: 'String', 
			required : true
		},
		seoImg: {
			type: 'String'
		},
		seoKey: {
			type: 'String'
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
		
	}
 * 
 */


//CRUD METHODS


//CRUD - CREATE


$app->post('/article',	function () use ($app){

	$body = json_decode($app->request()->getBody());
	
	$params = array (
		'Description'	=> $body->Description,
		'Img'	=> isset($body->Img)?$body->Img:'',
		'Tag'	=> isset($body->Tag)?$body->Tag:'',
		'Title'	=> $body->Title,
		'seoDescription'	=> $body->seoDescription,
		'seoImg'	=> isset($body->seoImg)?$body->seoImg:'',
		'seoKey'	=> isset($body->seoKey)?$body->seoKey:'',
		'seoTitle'	=> $body->seoTitle,
		
	);

	$obj = makeQuery("INSERT INTO article (_id, Description, Img, Tag, Title, seoDescription, seoImg, seoKey, seoTitle )  VALUES ( null, :Description, :Img, :Tag, :Title, :seoDescription, :seoImg, :seoKey, :seoTitle   )", $params, false);
    
	
	echo json_encode($body);
	
});
	
//CRUD - REMOVE

$app->delete('/article/:id',	function ($id) use ($app){
	
	$params = array (
		'id'	=> $id,
	);

	makeQuery("DELETE FROM article WHERE _id = :id LIMIT 1", $params);

});
	
//CRUD - GET ONE
	
$app->get('/article/:id',	function ($id) use ($app){
	$params = array (
		'id'	=> $id,
	);
	
	$obj = makeQuery("SELECT * FROM article WHERE _id = :id LIMIT 1", $params, false);
	
	
	
	echo json_encode($obj);
	
});
	
	
//CRUD - GET LIST

$app->get('/article',	function () use ($app){
	makeQuery("SELECT * FROM article");
});


//CRUD - EDIT

$app->post('/article/:id',	function ($id) use ($app){

	$body = json_decode($app->request()->getBody());
	
	$params = array (
		'id'	=> $id,
		'Description'	    => $body->Description,
		'Img'	    => isset($body->Img)?$body->Img:'',
		'Tag'	    => isset($body->Tag)?$body->Tag:'',
		'Title'	    => $body->Title,
		'seoDescription'	    => $body->seoDescription,
		'seoImg'	    => isset($body->seoImg)?$body->seoImg:'',
		'seoKey'	    => isset($body->seoKey)?$body->seoKey:'',
		'seoTitle'	    => $body->seoTitle
	);

	$obj = makeQuery("UPDATE article SET  Description = :Description,  Img = :Img,  Tag = :Tag,  Title = :Title,  seoDescription = :seoDescription,  seoImg = :seoImg,  seoKey = :seoKey,  seoTitle = :seoTitle   WHERE _id = :id LIMIT 1", $params, false);
    
	
	echo json_encode($body);
    	
});


/*
 * CUSTOM SERVICES
 *
 *	These services will be overwritten and implemented in  Custom.js
 */

			
?>