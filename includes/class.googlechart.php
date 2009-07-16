<?php
/**
 *
 * @author Jeck Lamnent
 * @version 1.02
 * @GNU public dec 2007
 * modify it and change it as much as you'd like
 * I made it quickly for what I needed so its not optimized for a 15,000 charts per second server
 * 


Examples after these quick field/function descriptions

The chart is displayed as an image. The style sheet class is class="googleChart"

If your new to using classes then look at the examples section.
For the below "var something;" entries, instance is a references to 
the $blah variable in $blah=new googleChart();

Google charts require supplied data to be separated using commas and | pipes so I
keep the commas and pipes in check inside the functions. If things don't work 
right then look at the examples so see what to do.

If the supplied data is negative numbers then set negativeMode=true and load the data using ->loadData();.

data/labels can be arrays or strings.
var $barWidth=null; 					//sets the width of the bars for vert/horiz bar charts.
	instance->barWidth=10;
var $negativeMode;						//Set to true if data is negative data
	instance->negativeMode=true;
var $dimensions;						//dimensions are width x height
	instance->dimensions='300x100';
var $colors; 							//colors are separated by commas
	instance->colors='8888ff,4444ff'; 	//used to colour charts, can be 1 or many colour sets separated by commas
var $legend; 							//legend items are separated by pipes
	instance->legend='Cows|Dogs|Buffalo';
var $title;								//title is plane text
	instance->title='My chart';
var $fillColor;							//colors don't have # preceeding them
	instance->fillcolor='76A4FB';
var $showGrid;							//if 1 tries to auto calc grid. If > 1 then show this many grid lines
	instance->showGrid=1;
	instance->showGrid=30;

f googleChart($data=null,$type=null,$title=null,$dimensions=null);
	-data is an array or a comma separated string. 
	
f setLabels(string or array,string); default 'left'
	-sets labels on the chart, 2nd param is 'top' 'left' 'bottom' or 'right'
	
f draw(boolean,$append='&chxr.png'); default (true,'&chxr.png')
	-prints an img tag with the chart, if set to false, returns the chart url.
	-The value of $append is append to the chart url. By default it will append &chxr.png so the url is detected as an image
	
f smartDataLabel(array);
	-Adds a legend and data based on array keys
	$dat2=array(
		'cows'=>array(4,5,6,7,9),
		'dogs'=>array(6,1,4,2,6),
		'peas'=>array(5.4,9,1,6,2)
	);
	
f simpleDataMode()
	-for 0..61 different plottable values. Default options can plot 1000 values
f setLabelsMinMax(integer,string); default (3,'left')
	-
f setType(string) default ('line')
	-sets the type of chart (pie,pie3d,barx,bary,line)
	
******EXAMPLES******

BASIC CHART:
	$data=array('4,6,21,7,1,6,17,5,2,1,7,9'); //note arrays don't have | pipes in them
	$moo=new googleChart($data);
	$moo->draw();


CHART WITH LABEL:
	$moo= new googleChart('4,6,21,7,1,6,17,5,2,1,7,9');
	$moo->setLabels('june|july|aug','bottom');
	$moo->draw();

CHART BASIC WITH LABELS
	$chart1= new googleChart('4,1,6,8,1','pie','foods','300x200');
	$chart1->setLabels('cake|pie|muffins|cookies|icecream');
	$chart1->draw();
	
	
CHART WITH LABEL AND MIN/MAX VALUES ON RIGHT
	$moo= new googleChart('4,6,21,7,1,6,17,5,2,1,7,9');
	$moo->setLabelsMinMax(5,'right'); //call before other funcs that make labels
	$moo->setLabels('june|july|aug','bottom');
	$moo->draw();

PIE CHART WITH LABELS
	$data='4,23,65';
	$moo= new googleChart($data,'pie');
	$moo->setLabels('cows|dogs|peas');
	$moo->draw(true);
	
	//or an alternative to above 'pie' you can use $moo->setType('pie');

CHART WITH 3 DIFFERENT DATA SETS using smartDataLabel(), A LEGEND AND MINMAX LABELS
	$data=array(
		'cows'=>array(4,5,6,7,9),
		'dogs'=>array(6,1,4,2,6),
		'peas'=>array(5.4,9,1,6,2)
	);
	$moo= new googleChart();
	$moo->smartDataLabel($data);
	$moo->setLabelsMinMax(5,'left'); 
	$moo->draw(true);

CHART USING NEGATIVE NUMBERS
	$chart=new googleChart(null,$chartType); //don't load data yet
	$chart->negativeMode=true; //set negative mode first
	$chart->loadData($chartData); //then load data
	$chart->setLabelsMinMax();
	$chart->draw();

CHART WITH LOTS OF OPTIONS, data sets are supplied in a string 
	$data='1,4,6,8,2|3,7,8,3,2';
	$chart1=new googleChart($data);
	$chart1->dimensions='400x125';
	$chart1->fillColor='76A4FB';
	$chart1->setLabelsMinMax();
	$chart1->legend='Ammount of cookies|Raisens';
	$chart1->setLabels('jan|feb|march|apr|may','bottom');
	$chart1->setLabels('+low|mid|top','left');
	$chart1->showGrid=1;
	$chart1->draw();

CHART USING NEGATIVE NUMBERS AND GRID
	$month='May';
	$daysInMonth=31;
	$chartDates='';
	for ($i=1;$i<=$daysInMonth;$i++) {
		if ($chartDates) $chartDates.='|';
		$chartDates.=$i;
	}
	$chartData='0,0,-109.9,0,0,0,-12310.58,-478.5,0,0,-473.38,0,0,0,-398,0,0,0,0,0,-134.6,-1513.1,0,0,-454.26,0,0,0,0,-1258.04,-2237.8';
	$chart=new googleChart(null,'line','Expenses','700x250');
	$chart->negativeMode=true; //values are negative
	$chart->loadData($chartData);
	$chart->barWidth=10; //makes bars thinner
	$chart->setLabelsMinMax();
	$chart->setLabels($chartDates,'bottom');
	$chart->setLabels($month,'bottom');
	$chart->showGrid=1;
	$chart->draw();
	
	
	
	
	
	
	
TO ADD A LEGEND MANUALLY:
$moo->legend='cows|dogs|carrots|rubber';

CHART WITH OTHER FUNCTIONS

To convert data to simple mode (for smaller data sets I guess. I don't see a purpose)
	$moo->simpleDataMode();
	
To changes some colors (you can supply more than needed)
	$moo->colors='8888ff,4444ff,670032';
*/


/**
 * Displays a visual data chart
 * $data can be an array of values from 0.0 to 100.0 or a comma separated string
 * Separate multiple data sets with |
 * Put -1 for any missing values
 * If the last parameter set is 'noreturn' then the chart is output as an image
 * EXAMPLE: googleChart('4,6,2.3,5|7,9.2,1,12','noreturn');
 * 
 * @param string or array $data
 * @param string $type
 * @param string $label
 * @param string $dimensions
 */
class googleChart {
	var $url='http://chart.apis.google.com/chart?';
	var $simple = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'; //simple data chart
	var $numericBase='t'; //'t' = numeric 0-1000 url data, 's' = simple 0..61 data
	var $dimensions='450x200'; 
	var $data=''; //array of 0.0 to 100.0 or comman separated string (use -1 for missing values)
	var $type='lc'; //type of chart
	var $title;	//chart's title
	var $legend=''; //data description legend
	var $labels=''; //for pie charts
	var $minMaxLabel=false; //is turned on via function
	var $lineLabels=''; //for non pie charts
	var $lineLabelAxis=''; //for non pie charts
	var $labelCount=0; //for non pie chart labels
	var $colors='0088ff,8800ff,4444ff'; //colors for multiple sets
	var $fillColor=''; //used to paint fill. hex rgb ('8054a1')
	var $showGrid=''; //if more than one data set it wiil auto create a grid, else will place (int)showGrid gridlines
	var $max=100; //is autoset when data is supplied
	var $min=0; //is autoset when data is supplied
	var $negativeMode=false; //negative mode converts numbers to positive so google can display them
	var $barWidth=null; //sets the width of the bars for vert/horiz bar charts.
	
	function googleChart($data=null,$type=null,$title=null,$dimensions=null) {
		if ($data) $this->loadData($data);
		if ($type) $this->setType($type);
		if ($title) $this->title=$title;
		if ($dimensions) $this->dimensions=$dimensions;
	} 
	
	/**
	 * Draw chart or return chart
	 *
	 * @param string_or_boolean $noReturn
	 * @return string
	 */
	function draw($noReturn=true,$append='&chxr.png') {
		//convert arrays
		if ($this->numericBase=='t') $this->normalDataMode();
		if (is_array($this->data)) $this->data=implode(',',$this->data); 
		if (is_array($this->legend)) $this->legend=implode('|',$this->legend); 
		//build chart url
		$return=$this->url.'chs='.$this->dimensions;
		$return.='&cht='.$this->type; //chart type
		if ($this->title) $return.='&chtt='.str_replace(' ','+',$this->title); //chart label
		if ($this->legend) $return.='&chdl='.$this->legend;
		if ($this->labels) $return.='&chl='.$this->labels;
		if ($this->barWidth) $return.='&chbh='.$this->barWidth;
		if ($this->minMaxLabel) {
			
		}
		if ($this->lineLabelAxis) {
			$this->lineLabelAxis=rtrim($this->lineLabelAxis,'|');
			$return.='&chxt='.$this->lineLabels.'&chxl='.$this->lineLabelAxis;
		}
		if ($this->fillColor) $return.='&chm=B,'.$this->fillColor.',0,0,0';
		if ($this->showGrid) {
			if (($gridx=$this->showGrid)==1) {
				$items=substr_count($this->data,',');
				$sets=substr_count($this->data,'|')+1;
				$items+=$sets;
				if ($sets>=1) 
					$gridx=round($items/$sets);//get count of items per set
				else 
					$gridx=0;
				if ($gridx==0) $gridx=$this->showGrid;
				if ($this->type=='lc') $gridx--;
			}
			if ($this->minMaxLabel) 
				$gridy=round(100/($this->minMaxLabel));
			else 
				$gridy=25;
			$return.='&chg='.(floor(10000/$gridx)/100).','.$gridy.',1';
		}
		$return.='&chco='.$this->colors;
		$return.='&chd='.$this->numericBase.':'.$this->data; //chart data
		$return.='&chxr=';
		if ($noReturn) echo '<img class="googleChart" src="'.$return.$append.'" />'; else return $return.$append;
	}
	
	/**
	 * Sets the type of chart
	 *
	 * @param unknown_type $type
	 */
	function setType($type) {
		switch ($type) {
			case 'barx':$type='bhg';break; //horizontal bars
			case 'bary':$type='bvg';break; //vertical bars
			case 'pie':	$type='p';break; //pie chart
			case 'pie3d':$type='p3';break; //3d pie chart
			case 'line': //line graph
			default: $type='lc';
		}
		$this->type=$type;
	}
	
	/**
	 * Put labels on the sides of the chart. This must be called first before any other labels
	 *
	 */
	function setLabelsMinMax($spread=3,$side='left') {
		$this->minMaxLabel=$spread-1;
		$this->setLabels('minmax',$side);
	}
	
	/**
	 * Put labels on the sides of the chart
	 *
	 * @param array or string $labels
	 * @param string(left,right,bottom,top) $side
	 */
	function setLabels($labels,$side='left') {
		if (is_array($labels)) $labels=implode('|',$labels); 
		$labels=str_replace(' ','+',$labels);
		switch ($side) {
			case 'top':$type='t';break;
			case 'left':$type='y';break;
			case 'bottom':$type='x';break;
			case 'right':$type='r';break;
		}
		if ($this->type[0]=='p') { //for pie charts
			if ($labels=='minmax') { //for auto settings min/max range
				$this->labels='';
				$xLabel=round($this->max/$this->minMaxLabel);
				for ($i=0;$i++;$i<=$xLabel) {
					if ($this->labels) $this->labels.='|'; 
					$this->labels.=$xLabel*$i;
				}
					
			} 
			else if ($this->labels) $this->labels.='|'; //do pie chart label
				$this->labels.=$labels;
			
		} else { //non pie charts
			if ($labels=='minmax') { //auto set min/max range
				$this->lineLabels='';
				$this->labels='';
				$xLabel=round($this->max/$this->minMaxLabel);
				$this->lineLabels=$type; //set side to display on
				$this->lineLabelAxis='0:';
				if ($this->lineLabelAxis!='') $this->lineLabelAxis.='|'; 
				for ($i=0;$i<=($this->minMaxLabel);$i++) {
					
					$this->lineLabelAxis.=($xLabel*$i);
					$this->lineLabelAxis.='|'; 
				}
				$this->labelCount++;
			} else {
				if ($this->lineLabels) $this->lineLabels.=','; //don't separate if empty
				$this->lineLabels.=$type;
				$this->lineLabelAxis.=(string)$this->labelCount.':|'.$labels.'|';//strip trailing pipe in draw proc
				$this->labelCount++;
			}
		}
	}
	
	/**
	 * Is auto loaded, don't need to call this func
	 *
	 * @param string or array $data
	 */
	function loadData($data) {
		if (is_array($data)) $data=implode(',',$data);
		$this->data.=$data;
		//determine min/max
		$data=str_replace('|',',',$data);
		$data=explode(',',$data);
		if ($this->negativeMode) 
			foreach ($data as &$datum)
				$datum=abs($datum);
		$this->max=max($data);
		$this->min=min($data);
		
	}
	
	/**
	 * Sets mode to Allow for 1000 different values. Is default. Don't need to call this func
	 *
	 */
	function normalDataMode() {
		$delta=$this->max/100; //convert to 0.0 to 100.0
		if ($delta==0) $delta=1; //stops div by 0
		$data=explode('|',$this->data);
		$newData='';
		foreach ($data as $datum) {
			$dataInner=explode(',',$datum);
			if($newData) $newData.='|';
			$innerData='';
			foreach ($dataInner as $item) {
				if ($item===-1) $val=$item; //missing val
				else if ($item===0) $val=(-1); //missing val
				else {
					if ($this->negativeMode) $item=abs($item);
					$val=round(($item*10) / $delta)/10;
					if ($val>100) $val=100; //limit val.
				}
				if($innerData != '') $innerData.=',';
				$innerData.=$val;
			}
			$newData.=$innerData;
			
		}echo '<br/>';
		if ($newData) {
			$this->numericBase='t';//simple mode
			$this->data=$newData;
		}
	}
	
	/**
	 * Sets the chart mode to simple (62 different values. Only call this mode if data was already specified
	 *
	 */
	function simpleDataMode() { //values 0 to 61;
		$delta=$this->max/strlen($this->simple); //convert to 0..61
		if ($delta==0) $delta=1; //stops div by 0
		$data=explode('|',$this->data);
		$newData='';
		foreach ($data as $datum) {
			$dataInner=explode(',',$datum);
			if($newData) $newData.=',';
			foreach ($dataInner as $item) {
				if ($item==-1) $newData.='_'; //missing val
				elseif ($item===0) $newData.='_'; //missing val
				else {
					if ($this->negativeMode) $item=abs($item);
					$val=round(($item*10) / $delta)/10;
					if ($val>61) $val=61; //limit val.
					$newData.=$this->simple[$val];
				}
			}
		}
		if ($newData) {
			$this->numericBase='s';//set simple mode
			$this->data=$newData;
		}
	}
	
	function smartDataLabel($labelData) {
		$newData='';
		foreach ($labelData as $label => $data) {
			$this->legend.=str_replace(' ','+',$label).'|';
			$label=str_replace(' ','+',$label);
			if (is_array($data)) $this->data.=implode(',',$data).'|'; 
				else $this->data.=$data.'|';
		}
		$this->legend=rtrim($this->legend,'|'); //trim trailing pipe
		$this->loadData(rtrim($this->data,'|')); //load Data
	}
	
	

	
}

?>