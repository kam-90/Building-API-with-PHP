<?php
 // Connect to database
	//require_once('database.php');
     

	$request_method=$_SERVER["REQUEST_METHOD"];
    
	switch($request_method)
	{
		case 'GET':
			// Retrive Products
			if(!empty($_GET["product_id"]))
			{
				
				$product_id=intval($_GET["product_id"]);
				//echo$product_id;
				get_prod($product_id);
			}
			else
			{
				get_products();
			}
			break;
		case 'POST':
		//echo "\n Posting=- data";
			// Insert Product
			insert_product();
			break;
		case 'PUT':
			// Update Product
		    
			$product_id=intval($_GET["product_id"]);
			//echo($product_id);
			update_product($product_id);
			break;
		case 'DELETE':
		    //echo'In delete';
			// Delete Product
			$product_id=intval($_GET["product_id"]);
			delete_product($product_id);
			break;
		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}

function insert_product()
	{
	    //global $connection;
		//echo"Got here ";
		//echo"\n"+$_POST;
		$_product_name=$_POST["product_name"];
		$_price=$_POST["price"];
		$_quantity=$_POST["quantity"];
		$_seller=$_POST["seller"];
		//echo$_product_name;
		//echo$_price;
		//echo $_quantity;
		//echo $_seller;
		
        require_once('database.php');
        $query = 'INSERT INTO products
                 (Product_name, Price, Quantity,Seller)
              VALUES
                 (:product_name, :price, :quantity, :seller)';
                 //echo $query;
                 //$pd=4;
    $statement = $db->prepare($query);
    //$statement->bindValue(':category_id', $category_id);
    //$statement->bindValue(':_product_ID', $pd);
    $statement->bindValue(':product_name', $_product_name);
    $statement->bindValue(':price', $_price);
    $statement->bindValue(':quantity', $_quantity);
    $statement->bindValue(':seller', $_seller);
    $bool=$statement->execute();
    echo$bool;
    //$statement->closeCursor();

		if($bool)
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Product Added Successfully.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Product Addition Failed.'
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	//$db = null;
	// Close database connection
	//mysqli_close($connection);
     

function get_products()
	{
	   require_once('database.php');
       $query = 'SELECT * FROM products';
       $statement2 = $db->prepare($query);
       $bool=$statement2->execute();
       $prods= $statement2->fetchAll(PDO::FETCH_ASSOC);
       $statement2->closeCursor();
       
       $response=array();
		if($bool)
		{
			$json=json_encode($prods);
			//$response=json_encode($prods);
			
		}
		else{
			$response=array(
				'status' => 0,
				'status_message' =>'Product Retrieval Failed.'
			);
			$json=json_encode($response);
		}
		header('Content-Type: application/json');
		echo $json;
		//echo json_encode($response);
	}

	function get_prod($product_id)
	{
	   require_once('database.php');
       $query = 'SELECT * FROM products WHERE Product_ID= :prodid';
       $statement2 = $db->prepare($query);
       $statement2->bindParam(':prodid', $product_id);
       
       $bool=$statement2->execute();
       $prods= $statement2->fetch(PDO::FETCH_ASSOC);
       $statement2->closeCursor();
       //echo $prods; 
       //echo $bool;
       $response=array();
		if($prods)
		{
			//echo $prods; 
			$json=json_encode($prods);
			//$response=json_encode($prods);
			
		}
		else{
			$response=array(
				'status' => 0,
				'status_message' =>'Product Retrieval Failed.'
			);
			$json=json_encode($response);
		}
		header('Content-Type: application/json');
		echo $json;
		//echo json_encode($response);
	}

   
   function delete_product($product_id)
	{
       require_once('database.php');
       $sql = $db->prepare("SELECT COUNT(*) AS `total` FROM products WHERE Product_ID  = :prod");
       $sql->execute(array(':prod' =>$product_id));
       $result = $sql->fetchObject();
   
       if ($result->total > 0) 
       {
          $query = 'DELETE FROM products
              WHERE Product_ID = :_product_ID';
		       $statement = $db->prepare($query);
		       $statement->bindValue(':_product_ID', $product_id);
		       $success = $statement->execute();
		       $statement->closeCursor();    
       
				if($success)
				{
					$response=array(
						'status' => 1,
						'status_message' =>'Product Deleted Successfully.'
					);
				}
       }
      else 
         {
           $response=array(
				'status' => 0,
				'status_message' =>'Product Deletion Failed.'
			);
         }


        header('Content-Type: application/json');
		echo json_encode($response);

		


    }



function update_product($product_id){

       require_once('database.php');
       $sql = $db->prepare("SELECT COUNT(*) AS `total` FROM products WHERE Product_ID  = :prod");
       $sql->execute(array(':prod' =>$product_id));
       $result = $sql->fetchObject();
       $response=array();
       //parse_str(file_get_contents("php://input"),$post_vars);
       //$_product_name=$post_vars["product_name"];
       //echo$_product_name;
       if ($result->total > 0) 
       {
       	  parse_str(file_get_contents("php://input"),$post_vars);
          $_product_name=$post_vars["product_name"];
		  $_price=$post_vars["price"];
		  $_quantity=$post_vars["quantity"];
		  $_seller=$post_vars["seller"];

          $statement = $db->prepare("Update products SET Product_name=:product_name,Price=:price, Quantity=:quantity,Seller=:seller WHERE Product_ID= :prod");
		      
               $statement->bindValue(':product_name', $_product_name);
               $statement->bindValue(':price', $_price);
  			   $statement->bindValue(':quantity', $_quantity);
    		   $statement->bindValue(':seller', $_seller);
    		   $statement->bindValue(':prod',$product_id);
		       $statement->execute();
		       $statement->closeCursor();    
       
				
				$response=array(
						'status' => 1,
						'status_message' =>'Product Updated Successfully.'
					);
				
       }
      else 
         {
           $response=array(
				'status' => 0,
				'status_message' =>'Product Updation Failed.'
			);
         }


        header('Content-Type: application/json');
		echo json_encode($response);


}


	?>