<?php
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


function getFromPrestaShopAPIfilter($endpoint, $by, $value) {
    global $api_url, $api_key;
	echo "endpoint" . $endpoint;
	echo "by" . $by;
	echo "value" . $value;
	
	
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url . $endpoint . "?ws_key=" . $api_key . "&filter[" . $by . "]=5" . "&output_format=JSON");
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

 function getSystimApiToken( $login, $password) {

$login = "superelectrix@gmail.com";
$password = "MV6CwXYW_^)4i]in)F6{_QCQS35*]Nl";


    // Inicjalizacja cURL
    $ch = curl_init();

    // Ustawienie URL z odpowiednim subdomeną
    $url = "https://kore02.systim.pl/jsonAPI.php";

    // Ustawienie opcji cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'act' => 'login',
        'login' => $login,
        'pass' => $password
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Wykonanie zapytania
    $response = curl_exec($ch);

    // Sprawdzenie kodu odpowiedzi HTTP
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Zamknięcie połączenia cURL
    curl_close($ch);

    // Sprawdzenie, czy odpowiedź była prawidłowa
    if ($http_code != 200) {
        die("Błąd podczas pobierania danych: HTTP " . $http_code);
    }

    // Dekodowanie odpowiedzi JSON
    $data = json_decode($response, true);

    // Sprawdzenie, czy wystąpił błąd
    if (isset($data['error']['code']) && $data['error']['code'] > 0) {
        die("Błąd: " . $data['error']['message']);
    }

    // Zwrócenie tokena
    return $data['result']['token'];
	//print_r($data);
}



function getSystimApi( $token, $filter,$value) {
 
    // Inicjalizacja cURL
    $ch = curl_init();

    // Ustawienie URL z odpowiednim subdomeną
    $url = "https://kore02.systim.pl/jsonAPI.php";

    // Ustawienie opcji cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'act' => 'listCompanies',
        'token' => $token,
		'nip' => "7281056940",
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Wykonanie zapytania
    $response = curl_exec($ch);

    // Sprawdzenie kodu odpowiedzi HTTP
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Zamknięcie połączenia cURL
    curl_close($ch);

    // Sprawdzenie, czy odpowiedź była prawidłowa
    if ($http_code != 200) {
        die("Błąd podczas pobierania danych: HTTP " . $http_code);
    }

    // Dekodowanie odpowiedzi JSON
    $data = json_decode($response, true);

    // Sprawdzenie, czy wystąpił błąd
    if (isset($data['error']['code']) && $data['error']['code'] > 0) {
        die("Błąd: " . $data['error']['message']);
    }
	 
	foreach ($data['result'] as $company) {
     
            $found = true;
            echo "</br></br>✅ Firma znaleziona:\n";
            echo "📌 Nazwa: " . ($company['nazwa'] ?? "Brak") . "</br>\n";
            echo "🏢 Miasto: " . ($company['miejscowosc'] ?? "Brak") . "</br>\n";
            echo "📍 Ulica: " . ($company['ulica'] ?? "Brak") . "</br>\n";
            echo "📧 Email: " . ($company['email'] ?? "Brak") . "</br>\n";
            echo "--------------------------------------</br></br>\n";
        
    }
	
	
    // Zwrócenie tokena
	//print_r($data);
	echo "<pre>" . print_r($data['result'], true) . "</pre>";
    return $data['result'];
}



?>