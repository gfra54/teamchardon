<?php
/**
* debug.inc.php (02/01/2014 09:50:13)
* 
* Fonctions de debug
* @author Gilles FRANCOIS <gilles@sofoot.com>
* @version 1.0
* @copyright 2004-2014 SOFOOT/Gilles FRANCOIS
* @package Debug
*/

function e($data,$niveau=0){
	echo str_pad('', $niveau,"\t");
	echo "\n";
	print_r($data);
	echo "\n";
}
function ex($data,$niveau=0){
	e($data,$niveau);
	exit;
}

/**
* doTrace
* 
* doTrace($t)
* 
* @todo phpDoc
* 
* @param $t
* 
*/
function doTrace($t) {
	$t = array_reverse($t,true);
	$ret='';
	$c=1;
	foreach($t as $k=>$v){
		if(count($t)>1 && ($v['function'] == 'DB_query' || $v['function'] == 'DB_fetchAll' || $v['function'] == 'my_include')){
			continue;
		}
		$ret.="\n\t"; 
		$ret.=$c."\t".str_replace($GLOBALS['CHEMIN'],'/',$v['file']).'('.$v['line'].') <b>'.$v['function'].'()</b>';
		$c++;
	}
	return $ret;
}
/**
* mvd
* 
* mvd()
* 
* @todo phpDoc
* 
*/
function mvd()
{
	$args = dump_boolean(func_get_args());
	mpr_mvd('mvd',$args);
}
/**
* mse
* 
* mse()
* 
* @todo phpDoc
* 
*/
function mse() {
	echo "\n".'<!-- DEBUG ####################################################';
			echo "\n";
			echo "\n";
		$args = dump_boolean(func_get_args());
		foreach($args as $a=>$b) {
			print_r($b);
			echo "\n";
		}

			echo "\n";
	echo '-->';
	exit;
}
/**
* ms
* 
* ms()
* 
* @todo phpDoc
* 
*/
function ms() {
	echo "\n".'<!-- DEBUG ####################################################';
			echo "\n";
			echo "\n";
		$args = dump_boolean(func_get_args());
		foreach($args as $a=>$b) {
			print_r($b);
			echo "\n";
		}

			echo "\n";
	echo '-->';
}
/**
* ME
* 
* ME()
* 
* @todo phpDoc
* 
*/
function ME()
{
	$args = dump_boolean(func_get_args());
	mpr_mvd('mpr',$args);
	exit;
}
/**
* mpre
* 
* mpre()
* 
* @todo phpDoc
* 
*/
function mpre()
{
	$args = dump_boolean(func_get_args());
	mpr_mvd('mpr',$args);
	exit;
}
/**
* mvde
* 
* mvde()
* 
* @todo phpDoc
* 
*/
function mvde()
{
	$args = dump_boolean(func_get_args());
	mpr_mvd('mvd',$args);
	exit;
}
/**
* M
* 
* M()
* 
* @todo phpDoc
* 
*/
function M()
{
	$args = dump_boolean(func_get_args());
	mpr_mvd('mpr',$args);
}
/**
* mpr
* 
* mpr()
* 
* @todo phpDoc
* 
*/
function mpr()
{
	$args = dump_boolean(func_get_args());
	mpr_mvd('mpr',$args);
}

/**
* dump_boolean
* 
* dump_boolean($args)
* 
* @todo phpDoc
* 
* @param $args
* 
* @return $args
* 
*/
function dump_boolean($args) {
	foreach($args as $k=>$v) {
		if(is_bool($v)) {
			$args[$k]='boolean '.($v ? 'true' : 'false');
		}
	}
	return $args;
}

/**
* mpr_mvd
* 
* mpr_mvd($action, $args)
* 
* @todo phpDoc
* 
* @param $action
* @param  $args
* 
*/
function mpr_mvd($action, $args)
{
	
	$do=false;
	foreach($args as $arg) {
		if($arg == $_SERVER['REMOTE_ADDR']) {
			$do=true;
		}
	}
	foreach($args as $arg) {
		if($arg != $_SERVER['REMOTE_ADDR']) {
			_dump($arg, 'mpr');
		}
	}
}
/**
* _dump
* 
* _dump($v,$action)
* 
* @todo phpDoc
* 
* @param $v
* @param $action
* 
*/
function _dump($v,$action) {
	$uid = md5(microtime());
	if($action == 'raw'){
		$content=$v;
	} else {
		if($action == 'mpr') {
				$content = print_r($v,true); 
				$content = htmlspecialchars($content);
		} else {
			ob_start();
			var_dump($v);
			$content = htmlspecialchars(ob_get_contents());
			ob_end_clean();
		}
	}
	$bt = array_reverse(debug_backtrace());

	if(empty($GLOBALS['HEADER']) && empty($GLOBALS['HEADER_UTF'])){
		$GLOBALS['HEADER_UTF']=true;
		echo '<meta charset="utf-8">';
	}	
	?>
	<div style="background:#ccc;margin:15px;border:1px solid #555;color:black;text-align:left;padding:5px;font-family:Courier">
	<?php $cpt=0;foreach($bt  as $k=>$v) {if(strstr(sinon($v,'file'),'debug.inc.php')===false) {$cpt++;?>
		<div style="font-size:11px;padding-left:4px;"><?php echo $cpt;?> : <?php echo str_replace('/home/sofoot/','',sinon($v,'file'));?> (<?php echo sinon($v,'line','default:?');?>) <?php if($v['function'] != 'ME') {?>[<?php echo $v['function'];?>(<a href="javascript:void()" style="color:blue" onclick="document.getElementById('args_<?php echo $cpt;?>_<?php echo $uid;?>').style.display='block';">Args</a>)]</div>
		<blockquote style="padding:6px;background:#DDD;display:none;font-size:11px;" id="args_<?php echo $cpt;?>_<?php echo $uid;?>"><pre ><?php echo (htmlentities(print_r($v['args'],true)));?></pre></blockquote><?php } else {?></div><?php }?>
	<?php }}?>
	<div class="debugmessage" style="border-top:1px solid #555;font-size:12px;overflow:auto;/*max-height:500px;*/"><pre><?php echo $content;?>
	</pre>
	</div>
	</div>
	<?php
}


