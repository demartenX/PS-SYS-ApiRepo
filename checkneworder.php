<?php

// Ustawienia API PrestaShop
$api_url = "https://fx-electronics.pl/api/";
$api_key = "V78WQYIA4KDQB8461I2QZKFGSR1NV4QA";


define("LAST_ORDER_FILE", "lastorder.txt");
define("NEW_ORDER_SCRIPT", "process_new_order.php");

// Funkcja odczytująca numer ostatniego zamówienia z pliku
function getLastOrderId() {
    if (file_exists(LAST_ORDER_FILE)) {
        return (int) file_get_contents(LAST_ORDER_FILE);
    }
    return 0;
}

// Funkcja pobierająca dane z API
function getFromPrestaShopAPI($endpoint) {
    global $api_url, $api_key;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url . $endpoint . "?ws_key=" . $api_key . "&output_format=JSON");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code != 200) {
        die("Błąd podczas pobierania danych: HTTP " . $http_code);
    }

    return json_decode($response, true);
}

// Pobranie zamówień z PrestaShop
$orders = getFromPrestaShopAPI("orders");
$lastor=0; 

// Sprawdzenie, czy API zwróciło dane
if (!empty($orders['orders'])) {
    echo "Lista zamówień:\n";
    foreach ($orders['orders'] as $order) {
		
		$lastor= $order['id'];
        echo "ID: " . $order['id'] . " | Data: " . $order['date_add'] . " | Status: " . $order['current_state'] . "\n";
		
    }
} else {
    echo "Brak zamówień do wyświetlenia.\n";
}

if ($lastor>getLastOrderId())
{
	echo "nowe zamowieniee";
}

?>
