<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	die();
}
$supplierId = $_GET['id'];

$getOrders = $conn->query("SELECT * FROM orders GROUP BY code ORDER BY id DESC");

if ($getOrders->num_rows > 0) {
    $result = array();

    while ($res = $getOrders->fetch_assoc()) {
        $order_sql = $conn->query("SELECT * FROM orders WHERE code='".$res['code']."'");

        $productCount = 0;
        $productList = array();

        $totalProd = 0;

        while ($order = $order_sql->fetch_assoc()) {
            $product_sql = $conn->query("SELECT p.* FROM products p, business_info b  WHERE p.business_id=b.id AND p.id='".$order['product_id']."' and b.users_id='$supplierId'");

            if ($product_sql->num_rows > 0) {
                $productCount ++;
                $product_arr = $product_sql->fetch_array();

                $productPrice = ($product_arr['price'] * $order['quantity']);
                $discount = $order['quantity'] >= '5' ? $productPrice * 0.05 : 0;
                $totalProd = $totalProd + ($productPrice - $discount);

                $productImg = $conn->query("SELECT * FROM product_image WHERE product_id='".$order['product_id']."'");
                $imageArr = $productImg->fetch_array();

                $item = array(
                        'productId' => $order['product_id'],
                        'name' => $product_arr['name'],
                        'description' => $product_arr['description'],
                        'price' => $product_arr['price'],
                        'quantity' => $order['quantity'],
                        'discount' => $discount ? true : false,
                        'image' => $imageArr['image']
                    );
                array_push($productList, $item);
            }

        }

        if ($productCount) {
            $ordersArr = array(
                        'code' => $res['code'],
                        'status' => $res['status'],
                        'totalPrice' => $totalProd,
                        'products' => $productList
                    );

            array_push($result, $ordersArr);
        }
    }

    echo json_encode($result);

} else {
    echo json_encode(array());
}

// $sql = "SELECT code, status FROM orders WHERE user_id='$id' GROUP BY code";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     $return = array();

//     while ($row = $result->fetch_assoc()) {
//         extract($row);

//         $order_sql = $conn->query("SELECT * FROM orders WHERE code='$code'");

//         $order_arr = array(
//             'code' => $code,
//             'status' => $status,
//             'totalProducts' => 0,
//             'totalPrice' => 0,
//             'products' => array()
//         );

//         $subTotal = 0;
//         $totalProd = 0;

//         while ($order = $order_sql->fetch_assoc()) {
//             $prod_id = $order['product_id'];

//             $product_sql = $conn->query("SELECT * FROM products WHERE id='$prod_id'");
//             $prod_info = $product_sql->fetch_array();

//             $image = $conn->query("SELECT * FROM product_image WHERE product_id='$prod_id'");
//             $image_arr = $image->fetch_array();

//             $subTotal = ($prod_info['price'] * $order['quantity']) + $subTotal;
//             $totalProd = $totalProd + $order['quantity'];

//             $review_get = $conn->query("SELECT * FROM feedback WHERE user_id='$id' AND product_id='$prod_id'");

//             $item = array(
//                 'id' => $order['id'],
//                 'product_id' => $prod_id,
//                 'name' => $prod_info['name'],
//                 'price' => $prod_info['price'],
//                 'description' => $prod_info['description'],
//                 'quantity' => $order['quantity'],
//                 'status' => $order['status'],
//                 'image' => $image_arr['image'],
//                 'date' => $order['date'],
//                 'isReviewed' => $review_get->num_rows ? true : false
//             );

//             array_push($order_arr['products'], $item);
//         }

//         $order_arr['totalPrice'] = $subTotal;
//         $order_arr['totalProducts'] = $totalProd;

//         array_push($return, $order_arr);
//     }

//     echo json_encode($return);
// } else {
//     echo json_encode(
//         array()
//     );
// }
