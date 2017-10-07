<?php
include 'config.php';

			$collection = $database->players;

			// ATTR + COUNT (from database)
			$query 		= array('url-name'=> $_GET['user']);
			$projection = array(
				'str' 		 => 1, 
				'def' 		 => 1, 
				'wis' 		 => 1, 
				'agi' 		 => 1, 
				'vit' 		 => 1, 
				'attack'	 => 1, 
				'resistence' => 1, 
				'm_attack'	 => 1, 
				'speed'		 => 1,
				'health'	 => 1
			);
			$document 	= $collection->find($query,$projection);			
			
			foreach($document as $stuff){
				$str	  = $stuff['str'];
				$def	  = $stuff['def'];
				$wis	  = $stuff['wis'];
				$agi	  = $stuff['agi'];
				$vit	  = $stuff['vit'];
				$_atk     = $stuff['attack'] 	 + (10 * $str);
				$_res 	  = $stuff['resistence'] + (10 * $def);
				$_mag     = $stuff['m_attack'] 	 + (10 * $wis);
				$_spd     = $stuff['speed'] 	 + (10 * $agi);
				$_hp   	  = $stuff['health']	 + (10 * $vit);
			}
			$array = $_atk.', '.$_res.', '.$_hp.', '.$_mag.', '.$_spd;
?>

<script src="js/highcharts.js"></script>
<script src="js/highcharts-more.js"></script>


<div id="chart" style="width:400px; height:400px; margin-left:-10px;"></div>


<style>
text[x="390"] {display:none;}
</style>

<script>
$(function(){
	/* RADAR CHART */
	$('#chart').highcharts({
	            
	    chart: { polar: true, type: 'area', backgroundColor: 'none'},
	    title: { text: ''},
		pane: { size: '72%'},
		xAxis: {
	        categories: ['Attack', 'Resistence', 'Health', 'Magic Attack', 'Speed'],
	        tickmarkPlacement: 'on',
	        lineWidth: 0
	    },
	    yAxis: {
	        gridLineInterpolation: 'polygon',
	        lineWidth: 0,
	        min: 0
	    },
		colors: ['#567cc1'],
	    tooltip: {
	    	shared: true,
	        pointFormat: '<span style="color:{series.color}">{point.y:,.0f}<br/>'
	    },
	    
	    legend: { enabled:false },
	    
	    series: [{
	        data: [<?php echo $array;?>],
	        pointPlacement: 'on'
	    }]
	}); /* END // radar CHART */

	
});
</script>
