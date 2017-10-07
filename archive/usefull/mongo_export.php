<?php 
		include '../config.php';
		//$collection = $database->archive;
		//$documents	= $collection->find();
		
		//$collection = $database->cover;
		
		
		//$name   = array('ダンボおる-箱', '木製の盾', '木刀', '竹刀');
		//$name_  = array('Danbooru', 'Wooden Shield', 'Bokutou - Wooden Sword', 'Shinai - Bamboo Sword');
		//$effect = array('10_ATK/5_DEF', '5_DEF', '5_ATK', '10_ATK');
		//$slots  = array(3,2,4,1);
		//
		//$collection = $database->equipament;
		//for($i=0; $i < 4; $i++){
		//	$array = array(
		//		'name'	 => $name[$i],
		//		'name_'  => $name_[$i],
		//		'effect' => $effect[$i],
		//		'slots'  => $slots[$i]
		//	);
		//	
		//	$collection->insert($array);
		//}
		
		$collection = $database->equipament;
		$documents  = $collection->find();
		$level = array(2,1,1,0);
		$i = 0;
		$collection = $database->backpack;
		foreach($documents as $document){
			$array = array(
				'_id'   => $document['_id'],
				'level' => $level[$i],
				'use' 	=> false 
			);
			$i++;
			$collection->insert($array);
		}
?>