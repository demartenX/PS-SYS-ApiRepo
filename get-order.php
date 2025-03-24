<?php
// Ustawienia API PrestaShop
$api_url = "https://fx-electronics.pl/api/";
$api_key = "V78WQYIA4KDQB8461I2QZKFGSR1NV4QA";

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

// Pobranie listy zamówień
$orders = getFromPrestaShopAPI("orders");

// Wyświetlenie szczegółów zamówień
if (!empty($orders['orders'])) {
    foreach ($orders['orders'] as $order) {
        echo "ID Zamówienia: " . $order['id'] . "\n";

        // Pobranie szczegółów zamówienia
        $order_details = getFromPrestaShopAPI("orders/" . $order['id']);

        // Pobranie informacji o produktach w zamówieniu
        if (!empty($order_details['order']['associations']['order_rows'])) {
            foreach ($order_details['order']['associations']['order_rows'] as $product) {
                $product_id = $product['product_id'];
                $product_info = getFromPrestaShopAPI("products/" . $product_id);
                
                echo " - Produkt: " . $product_info['product']['name'][1]['value'] . "\n";
                echo "   Cena: " . $product_info['product']['price'] . " zł\n";

        
            }
        }
        echo "---------------------------------\n";
    }
} else {
    echo "Brak zamówień.";
}
?>
