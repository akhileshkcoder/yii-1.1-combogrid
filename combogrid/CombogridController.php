<?php

class CombogridController extends CExtController
{	
	public function actionServer()
	{
		$this->renderPartial('server');
	}	
	
	
	
	public function actionGenerateOptions()
	{	
		$res = array();
		$query = $_GET['sql'];
		
		$searchTerm = mysql_escape_string($_GET['searchTerm']);
		$page = mysql_escape_string($_GET['page']);
		$limit = mysql_escape_string($_GET['rows']);
		$sidx = mysql_escape_string($_GET['sidx']);
		$sord = mysql_escape_string($_GET['sord']);	

		$displayColumns = mysql_escape_string($_GET['dColumns']);	

		if(!$sidx) $sidx =1;
	
		if ($searchTerm=="") 
		{
			$searchTerm="%";
		} else 
		{
			$searchTerm = "%" . $searchTerm . "%";
		}
		
		
		
		
		$model=new CombogridModel;
		$result = $model->totalcount($query,$searchTerm); 
    	
    	
    
    	$count = count($result);

    	if($count >0 ) {
	   		$total_pages = ceil($count/$limit);
   		} else {
	   		$total_pages = 0;
   		}
   		if ($page > $total_pages) $page = $total_pages;
   		$start = $limit*$page - $limit;
   		
   		// ===-==-=-
   		$tmpquery1 = '';
  		$tmpquery2 = '';
  		
  		
		$strOrder = "ORDER BY";
		if (strpos($query, $strOrder) !== false) //found
		{
			$tmpquery1 = str_ireplace("ORDER BY","ORDER BY $sidx $sord, ",$query);   // name asc,author desc etc
			$tmpquery1.=" LIMIT $limit OFFSET $start";
			$tmpquery2 = str_ireplace("ORDER BY","ORDER BY $sidx $sord, ",$query);
		}
		else
		{
			$tmpquery1 = $query. " ORDER BY $sidx $sord LIMIT $limit OFFSET $start";
  			$tmpquery2 = $query. " ORDER BY $sidx $sord";
		}
  		
  		if($total_pages!=0) $SQL = $tmpquery1;
   		else $SQL = $tmpquery2;
		
   		
   		
   		
   		$result = $model->selectall($SQL,$searchTerm);
    	
    	
   		
   		$response->page = $page;
   		$response->total = $total_pages;
   		$response->records = $count;
   		
   		
   		
   		$i=0;  	   		
   		
   		foreach($result as $row) 
   		{ 
   			$fields = explode(',', $displayColumns);
   			$cnt = count($fields);
   			
   			foreach($fields as $val)
   			{
   				$response->rows[$i][$val]=$row[$val];   			
   			}   			
       		
       		$i++;
   		}   
   		
   				
	
		$this->renderPartial('server',array('response'=>$response));		    
   	}
	
	public function actionGenerateOptionsExtra()
	{	
		$res = array();
		$query = $_GET['sql'];
		
		$searchTerm = mysql_escape_string($_GET['searchTerm']);
		$extraParam = mysql_escape_string($_GET['extraParam']);
		$page = mysql_escape_string($_GET['page']);
		$limit = mysql_escape_string($_GET['rows']);
		$sidx = mysql_escape_string($_GET['sidx']);
		$sord = mysql_escape_string($_GET['sord']);	

		$displayColumns = mysql_escape_string($_GET['dColumns']);	

		if(!$sidx) $sidx =1;
	
		if ($searchTerm=="") 
		{
			$searchTerm="%";
		} else 
		{
			$searchTerm = "%" . $searchTerm . "%";
		}
                
                if(empty($extraParam)||$extraParam=="")
                    $extraParam=NULL;
		
		
		
		
		$model=new CombogridExtraModel;
		$result = $model->totalcount($query,$searchTerm,$extraParam); 
    	
    	
    
    	$count = count($result);

    	if($count >0 ) {
	   		$total_pages = ceil($count/$limit);
   		} else {
	   		$total_pages = 0;
   		}
   		if ($page > $total_pages) $page = $total_pages;
   		$start = $limit*$page - $limit;
   		
   		// ===-==-=-
   		$tmpquery1 = '';
  		$tmpquery2 = '';
  		
  		
		$strOrder = "ORDER BY";
		if (strpos($query, $strOrder) !== false) //found
		{
			$tmpquery1 = str_ireplace("ORDER BY","ORDER BY $sidx $sord, ",$query);   // name asc,author desc etc
			$tmpquery1.=" LIMIT $limit OFFSET $start";
			$tmpquery2 = str_ireplace("ORDER BY","ORDER BY $sidx $sord, ",$query);
		}
		else
		{
			$tmpquery1 = $query. " ORDER BY $sidx $sord LIMIT $limit OFFSET $start";
  			$tmpquery2 = $query. " ORDER BY $sidx $sord";
		}
  		
  		if($total_pages!=0) $SQL = $tmpquery1;
   		else $SQL = $tmpquery2;
		
   		
   		
   		
   		$result = $model->selectall($SQL,$searchTerm,$extraParam);
    	
    	
   		
   		$response->page = $page;
   		$response->total = $total_pages;
   		$response->records = $count;
   		
   		
   		
   		$i=0;  	   		
   		
   		foreach($result as $row) 
   		{ 
   			$fields = explode(',', $displayColumns);
   			$cnt = count($fields);
   			
   			foreach($fields as $val)
   			{
   				$response->rows[$i][$val]=$row[$val];   			
   			}   			
       		
       		$i++;
   		}   
   		
   				
	
		$this->renderPartial('server',array('response'=>$response));		    
   	}
	
	
}