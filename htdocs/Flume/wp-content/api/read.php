<?php
  
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "flume_db";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "
            select
              p.ID as order_id,
              p.post_date,
              max( CASE WHEN pm.meta_key = '_billing_email' and p.ID = pm.post_id THEN pm.meta_value END ) as billing_email,
              max( CASE WHEN pm.meta_key = '_billing_first_name' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_first_name,
              max( CASE WHEN pm.meta_key = '_billing_last_name' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_last_name,
              max( CASE WHEN pm.meta_key = '_billing_address_1' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_address_1,
              max( CASE WHEN pm.meta_key = '_billing_address_2' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_address_2,
              max( CASE WHEN pm.meta_key = '_billing_city' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_city,
              max( CASE WHEN pm.meta_key = '_billing_state' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_state,
              max( CASE WHEN pm.meta_key = '_billing_postcode' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_postcode,
              max( CASE WHEN pm.meta_key = '_shipping_first_name' and p.ID = pm.post_id THEN pm.meta_value END ) as _shipping_first_name,
              max( CASE WHEN pm.meta_key = '_shipping_last_name' and p.ID = pm.post_id THEN pm.meta_value END ) as _shipping_last_name,
              max( CASE WHEN pm.meta_key = '_shipping_address_1' and p.ID = pm.post_id THEN pm.meta_value END ) as _shipping_address_1,
              max( CASE WHEN pm.meta_key = '_shipping_address_2' and p.ID = pm.post_id THEN pm.meta_value END ) as _shipping_address_2,
              max( CASE WHEN pm.meta_key = '_shipping_city' and p.ID = pm.post_id THEN pm.meta_value END ) as _shipping_city,
              max( CASE WHEN pm.meta_key = '_shipping_state' and p.ID = pm.post_id THEN pm.meta_value END ) as _shipping_state,
              max( CASE WHEN pm.meta_key = '_shipping_postcode' and p.ID = pm.post_id THEN pm.meta_value END ) as _shipping_postcode,
              max( CASE WHEN pm.meta_key = '_order_total' and p.ID = pm.post_id THEN pm.meta_value END ) as order_total,
              max( CASE WHEN pm.meta_key = '_order_tax' and p.ID = pm.post_id THEN pm.meta_value END ) as order_tax,
              max( CASE WHEN pm.meta_key = '_paid_date' and p.ID = pm.post_id THEN pm.meta_value END ) as paid_date,
              max( CASE WHEN oim.meta_key = '_product_id' THEN oim.meta_value END ) as product_id,
              max( CASE WHEN oim.meta_key = '_qty' THEN oim.meta_value END ) as quantity,
              ( select group_concat( order_item_name separator '|' ) from wp_woocommerce_order_items where order_id = p.ID ) as order_items,
              ( select max( term_taxonomy_id ) from wp_term_relationships where object_id = ( max( CASE WHEN oim.meta_key = '_product_id' THEN oim.meta_value END ) ) ) as taxonomy_id,
              ( select name from wp_terms where term_id = (( select max( term_taxonomy_id ) from wp_term_relationships where object_id = ( max( CASE WHEN oim.meta_key = '_product_id' THEN oim.meta_value END ) ) )) ) as category

          from
              wp_posts p
              join wp_postmeta pm on p.ID = pm.post_id
              join wp_woocommerce_order_items oi on p.ID = oi.order_id
              join wp_woocommerce_order_itemmeta oim on oi.order_item_id = oim.order_item_id
          where
              p.post_type = 'shop_order'
          group by
              p.ID
          having
              ( select name from wp_terms where term_id = (( select max( term_taxonomy_id ) from wp_term_relationships where object_id = ( max( CASE WHEN oim.meta_key = '_product_id' THEN oim.meta_value END ) ) )) ) = 'Tickets'
          ";

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      // output data of each row
      $rows = array();
      while($row = $result->fetch_assoc()) {
        $rows[] = $row;

      }
      echo json_encode($rows);
  } else {
      echo "0 results";
  }

  $conn->close();
?>
