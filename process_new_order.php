<?php
define("GET_CUSTOMER", "getCustomer.php");
// Pobranie danych o konkretnym zamówieniu
$order = getFromPrestaShopAPI("orders/$lastorder");

// Sprawdzenie, czy API zwróciło dane
if (!empty($order['order'])) {
    echo "Dane zamówienia ID: $lastorder\n";
    echo "Data: " . $order['order']['date_add'] . "\n";
    //echo "Status: " . $order['order']['current_state'] . "\n";
	echo "ID klienta: " . $order['order']['id_customer'] . "\n"; 
	$customerID= $order['order']['id_customer'];
	if (!empty ($customerID))
	{
	echo "Pobieram id adresow klienta ". $customerID . " Uruchamiam skrypt: " . GET_CUSTOMER . "\n";
	 include(GET_CUSTOMER);
	}
	
	
} else {
    echo "Nie znaleziono zamówienia o numerze: $lastorder\n";
}
 
?>
