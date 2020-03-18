<?php
Yii::import('zii.widgets.jui.CJuiInputWidget');

class ComboGridWidget extends CJuiInputWidget
{

	public $source=array();
	public $sourceUrl;
	public $model;
	public $attribute;
	
		

	public function run()
	{
		list($name,$id)=$this->resolveNameID();

		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;
		if(isset($this->htmlOptions['name']))
			$name=$this->htmlOptions['name'];

		if($this->hasModel())
			echo CHtml::activeTextField($this->model,$this->attribute,$this->htmlOptions);
		else
			echo CHtml::textField($name,$this->value,$this->htmlOptions);
			
		if($this->sourceUrl!==null)
			$this->options['source']=CHtml::normalizeUrl($this->sourceUrl);
		else
			$this->options['source']=$this->source;
			
        //$this->options['url']=CHtml::normalizeUrl($this->url);
		
		$options=CJavaScript::encode($this->options);
		$this->registerScripts();
		Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$id,"jQuery('#{$id}').combogrid($options);");
	}
	
	
/**
	 * Publishes and registers the necessary script files.
	 *
	 * @param string the id of the script to be inserted into the page
	 * @param string the embedded script to be inserted into the page
	 */
	protected function registerScripts()
	{
		//$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
		//$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
		
		$asseturl=Yii::app()->getAssetManager()->publish(Yii::getPathofAlias('ext.combogrid.assets'));

		$cs = Yii::app()->clientScript;
		
		//$cs->registerScriptFile($asseturl.'/resources/jquery/jquery-1.9.1.min.js');
		$cs->registerScriptFile($asseturl.'/resources/jquery/jquery-ui-1.10.1.custom.min.js');
		$cs->registerScriptFile($asseturl.'/resources/plugin/jquery.ui.combogrid-1.6.3.js');
				
		//$cs->registerCssFile($asseturl.'/resources/css/smoothness/jquery-ui-1.10.1.custom.css');
		$cs->registerCssFile($asseturl.'/resources/css/smoothness/combo-grid-custom.css');
		$cs->registerCssFile($asseturl.'/resources/css/smoothness/jquery.ui.combogrid.css');
	}
	
	/**
	 * @return boolean whether this widget is associated with a data model.
	 */
	protected function hasModel()
	{
		return $this->model instanceof CModel && $this->attribute!==null;
	}

}