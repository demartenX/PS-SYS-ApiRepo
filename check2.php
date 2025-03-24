<?php

// Ustawienia API PrestaShop
$api_url = "https://fx-electronics.pl/api/";
$api_key = "V78WQYIA4KDQB8461I2QZKFGSR1NV4QA";

 include("zapytaniaAPI.php");
 
 
define("LAST_ORDER_FILE", "lastorder.txt");
define("NEW_ORDER_SCRIPT", "process_new_order.php");

// Funkcja odczytująca numer ostatniego zamówienia z pliku
function getLastOrderId() {
    if (file_exists(LAST_ORDER_FILE)) {
        return (int) file_get_contents(LAST_ORDER_FILE);
    }
    return 0;
}



// Pobranie zamówień z PrestaShop
$orders = getFromPrestaShopAPI("orders");
$lastor=0; 

// Sprawdzenie, czy API zwróciło dane
if (!empty($orders['orders'])) {
    echo "Lista zamówień:\n";
    foreach ($orders['orders'] as $order) {
		
		$lastorder= $order['id'];
        echo "<p>ID: " . $order['id']  . "\n</p>";
		
    }
} else {
    echo "Brak zamówień do wyświetlenia.\n";
}

if ($lastorder>getLastOrderId())
{
	
	echo "Nowe zamówienie wykryte!Uruchamiam skrypt: " . NEW_ORDER_SCRIPT . "</br>\n"  ;
    
    // Zapisanie nowego numeru zamówienia
    //saveLastOrderId($newOrderId);

    // Uruchomienie dodatkowego skryptu do przetwarzania zamówienia
    include(NEW_ORDER_SCRIPT);
	
	
}

?>
