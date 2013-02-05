<?php

class Fonterator
{
  private $_file = NULL;
  protected $_options = array();

  public function __construct($options = array())
  {
    $this->_options = $options;
    $this->_file = $options['file'];
    
    $this->imageText();
    if(isset($this->_options['gradient_1'], $this->_options['gradient_2']))
      $this->textGradient();
    if($this->_options['shadow'])
      $this->textShadow();
    #die;
  }

  public function imageText()
  {
    $this->execute("convert 
    ( -background none -fill '#{$this->_options[color]}' -font '{$this->_options[font]}' -pointsize {$this->_options[size]} label:'{$this->_options[text]}' ) 
    $this->_file"
    );
  }

  public function textShadow()
  {
    $this->execute(
    "convert $this->_file 
    ( -background none -fill black -font '{$this->_options[font]}' -pointsize {$this->_options[size]} label:'{$this->_options[text]}' -geometry +0+2 ) 
    -compose dstover -composite $this->_file"
    );
  }

  public function textGradient()
  {
    $imageSize = $this->getDimensions();
    $this->execute(
    "convert 
    -size $imageSize[0]x$imageSize[1] xc:transparent -tile gradient:'#{$this->_options[gradient_1]}-#{$this->_options[gradient_2]}' 
    -font '{$this->_options[font]}' -pointsize {$this->_options[size]}  -gravity center -annotate +2+0 '{$this->_options[text]}'  
    $this->_file"
    );
  }
  
  public function getDimensions()
  {
    return getimagesize($this->_file);
  }

  public function output()
  {
    header('Content-Type: image/png');
    return readfile($this->_file);
  }
  
  function execute($command)
  {
    #echo $command;
    $command = str_replace(array(
      "\n",
      "'",
      '(',
      ')'), array(
      '',
      '"',
      '\(',
      '\)'), $command);
    $command = preg_replace('#(\s){2,}#is', ' ', $command);
    return shell_exec($command);
  }
}
