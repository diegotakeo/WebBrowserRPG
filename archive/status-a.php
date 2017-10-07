<?php
session_start(); // <-- for $_SESSION['mypage']

	/* get USER INFORMATIONS */
	include 'config.php';
	$query		= array('url-name' => $_SESSION['this_page']);
	$projection = array('_id' => 0, 'str' => 1,'def' => 1, 'wis' => 1, 'agi' => 1, 'vit' => 1);
	
	$collection = $database->players;
	$documents	= $collection->find($query, $projection);	
	
	if ($documents->count() === 1) {
		foreach($documents as $document){
			$str = $document['str'];
			$def = $document['def'];
			$wis = $document['wis'];
			$agi = $document['agi'];
			$vit = $document['vit'];
		}
	}
	else // ERROR: no document!
		exit;
?>

<style>
	/* BAR & PROGRESS BAR */
	div#status-a {position:absolute; top:30px;}
	div#status-a .bar {margin:20px 50px;}
	
	div#status-a .progress, div#status-a  .first {background-color:#379125;}
	.progress-bar	{position:absolute; opacity:0.5; -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)"; filter: alpha(opacity=50);}
	.progress-bar	{padding-left:2px; width:299px!important;}
	.progress-bar .progress {margin:0; opacity:1;}	
	
	div#status-a .bar span {top:-28px; font-size:15pt;}
	div#status-a .bar span:first-child {left:0;}
	
	div#status-a .progress-num {right:0;}
	/* (+ and -) buttons */
	div#status-a span[data^="-"] {left:-30px;}
	div#status-a span[data^="+"] {right:-35px; }
	div#status-a span[data]:hover {color:#000;}
	div#status-a span[data] {
		position:absolute; 
		font-size:30pt!important; 
		top:-18px; 
		color:#999; 
		cursor:pointer;
		display:none;
		}
</style>
<?php
// ------------------------------------------------------------------------------------------------------------------------------ //
function attr_bar($id,$val) {

$color = array('#379125','#6cd258','#517f2d','#80c848','#2c734d','#3bb172','#83a831','#acdc40','#298c60','#3bcb8b');	

		// eg.STRENGTH  				  
		if($val > 10){ 	
			$n_val = substr(strval($val),-1); 				// UNIT
			$p_val = ((int) substr(strval($val),-2,-1))+1;	// PREVIOUS BAR Nº

			if ($p_val == 10) { // <-- for 90
				$p_val = 8;	
				if ($n_val) $c_val = $color[$p_val+1]; // <-- .first color (issue)
				else		$c_val = $color[$p_val];
			}
			else {
				if ($n_val) $c_val = $color[$p_val-1];
				else		$c_val = $color[$p_val];		// COLOR BAR
			}

			if ($val > 99) { // <-- for 100+
				$p_val = ((int) substr(strval($val),-2,-1))-1;

				if ($p_val == -1) // <-- (dozen = 0)
					$p_val = 9;
			}
		}
		else {	// <-- no previous bar
			$n_val = $val;		 // <-- unit
			$p_val = false; 	 // <-- any dozen
			$c_val = $color[0];  // <-- #379125
		}
		
		
		
		
// ------------------------------------------------------------ //		

$name 	= array('str' => 'Strenght','def' => 'Defense','wis' => 'Wisdom','agi' => 'Agility','vit' => 'Vitality');	



echo '		<div class="bar" id="'.$id.'">	
				<span>'.$name[$id].'</span>	
				
					<!-- NUMBER -->
					<span class="progress-num">
						<data class="plus"></data>
						<data class="atual">'.$val.'</data>
					</span>
					
				<!-- ADD + SUBTRACT -->';
				if ($_SESSION['mypage']) echo '
				<span data="-'.$id.'">-</span>
				<span data="+'.$id.'">+</span>';
				
echo '			<!-- GRID detachment -->
				<div class="first" style="background:'.$c_val.'"></div>
				<div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
				
				
				
				<div class="progress-bar">
				
				
					<!-- previous BAR -->';
					if ($p_val || $p_val === 0) echo '
					<div class="progress" style="width:100%; background:'.$color[$p_val].'"></div>';
						
						
echo '				<!-- actual BAR -->
					<div class="progress" style="width:'.$n_val.'0%; background:'.$c_val.'"></div>	
					
	
				</div>
			</div>
';
} // END - function attr_bar();
// ------------------------------------------------------------------------------------------------------------------------------ //



	attr_bar('str',$str);
	attr_bar('def',$def);
	attr_bar('wis',$wis);
	attr_bar('agi',$agi);
	attr_bar('vit',$vit);




?>								

								

<script>
$(function(){
	// stop LOADER.gif
	$('div#user-status').css('background', '#fff');
});



<?php
// --------------------------- CUSTOM JAVASCRIPT
if ($_SESSION['mypage'])
	include 'status-a.js';
?>
</script>