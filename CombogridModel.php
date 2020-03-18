<?php

class CombogridModel extends CActiveRecord
{	

    
	public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
	
	
	public function tableName()
    {
        return 'subject';
    }
    
    public function totalcount($query,$searchTerm)
    {
    	$connection=Yii::app()->db; 
		$command=$connection->createCommand($query);		
    	$command->bindParam(":searchTerm", $searchTerm, PDO::PARAM_STR);
    	$result = $command->queryAll();
    	return $result;
    }
    
    public function selectall($SQL,$searchTerm)
    {
    	$connection=Yii::app()->db; 
		$command1=$connection->createCommand($SQL);		
    	$command1->bindParam(":searchTerm", $searchTerm, PDO::PARAM_STR);
    	$result = $command1->queryAll();
    	return $result;
    }
	
}