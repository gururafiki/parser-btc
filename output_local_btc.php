<?php
require "db.php";
function output_buyers(){
	$table = R::getAll( 'SELECT * FROM `chat`.`buyers` ORDER BY `currency` ASC, `price` ASC LIMIT 1000;');
	//var_dump($table);
	$currency=null;
	$i==0;
	    foreach( $table as $table ) {
	    	if($i==0){
	    		echo "<table class=\"table table-striped table-condensed table-bordered table-hover\"><tbody>
					   <thead>
					    <tr>
					      <th>buyer</th>
					      <th>Price in ".$table['currency']."</th>
					      <th>Price in UAH</th>
					      <th>Limits</th>
					      <th>Button</th>
					      <th>Location</th>
					    </tr>
					  </thead>";
		        echo "<tr class=\"clickable\">";
		        echo "<td>".$table['buyer']."</td>";
		        echo "<td>".$table['price']."</td>";
		        echo "<td>".$table['price_in_uah']."</td>";
		        echo "<td>".$table['limit']."</td>";
		        echo "<td><a href=\"".$table['url']."\">sell</a></td>";
		        if (isset($table['location'])) echo "<td>".$table['location']."</td>";
		        echo "</tr>";
		        $currency=$table['currency'];
		        $i++;
	    	}
	    	else{
		    	if ($table['currency']!=$currency) {
		    		echo "</tbody></table><br><table class=\"table table-striped table-condensed table-bordered table-hover\"><tbody>
						   <thead>
						    <tr>
						      <th>buyer</th>
						      <th>Price in ".$table['currency']."</th>
						      <th>Price in UAH</th>
						      <th>Limits</th>
						      <th>Button</th>
						      <th>Location</th>
						    </tr>
						  </thead>";
			    	$currency=$table['currency'];    
			    }
		        echo "<tr class=\"clickable\">";
		        echo "<td>".$table['buyer']."</td>";
		        echo "<td>".$table['price']."</td>";
		        echo "<td>".$table['price_in_uah']."</td>";
		        echo "<td>".$table['limit']."</td>";
		        echo "<td><a href=\"".$table['url']."\">sell</a></td>";
		        if (isset($table['location'])) echo "<td>".$table['location']."</td>";
		        echo "</tr>";  
	        } 
	    }
	echo "</tbody></table>";
}
function output_sellers(){
	$table = R::getAll( 'SELECT * FROM `chat`.`sellers` ORDER BY `currency` ASC, `price` ASC LIMIT 1000;');
	//var_dump($table);
	$currency=null;
	$i==0;
	    foreach( $table as $table ) {
	    	if($i==0){
	    		echo "<table class=\"table table-striped table-condensed table-bordered table-hover\"><tbody>
					   <thead>
					    <tr>
					      <th>Seller</th>
					      <th>Price in ".$table['currency']."</th>
					      <th>Price in UAH</th>
					      <th>Limits</th>
					      <th>Button</th>
					      <th>Location</th>
					    </tr>
					  </thead>";
		        echo "<tr class=\"clickable\">";
		        echo "<td>".$table['seller']."</td>";
		        echo "<td>".$table['price']."</td>";
		        echo "<td>".$table['price_in_uah']."</td>";
		        echo "<td>".$table['limit']."</td>";
		        echo "<td><a href=\"".$table['url']."\">buy</a></td>";
		        if (isset($table['location'])) echo "<td>".$table['location']."</td>";
		        echo "</tr>";
		        $currency=$table['currency'];
		        $i++;
	    	}
	    	else{
		    	if ($table['currency']!=$currency) {
		    		echo "</tbody></table><br><table class=\"table table-striped table-condensed table-bordered table-hover\"><tbody>
						   <thead>
						    <tr>
						      <th>Seller</th>
						      <th>Price in ".$table['currency']."</th>
						      <th>Price in UAH</th>
						      <th>Limits</th>
						      <th>Button</th>
						      <th>Location</th>
						    </tr>
						  </thead>";
			    	$currency=$table['currency'];    
			    }
		        echo "<tr class=\"clickable\">";
		        echo "<td>".$table['seller']."</td>";
		        echo "<td>".$table['price']."</td>";
		        echo "<td>".$table['price_in_uah']."</td>";
		        echo "<td>".$table['limit']."</td>";
		        echo "<td><a href=\"".$table['url']."\">buy</a></td>";
		        if (isset($table['location'])) echo "<td>".$table['location']."</td>";
		        echo "</tr>";  
	        } 
	    }
	echo "</tbody></table>";
}
output_sellers();
output_buyers();
?>