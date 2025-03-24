<?php 
include "zapytaniaAPI.php";
// Przykładowe użycie funkcji


$tokenSYS = getSystimApiToken($subdomain, $login, $password);
echo "Uzyskany token: " . $tokenSYS;
 $pobierzklientow = getSystimApi($tokenSYS,"nip", "728156940");
 echo "tablica pobierz klientów</br>";
echo "<pre>" . print_r($pobierzklientow, true) . "</pre>";

 
 foreach ($pobierzklientow as $klient)
 {
	 echo "</br>📌 Nazwa: " . ($klient['nazwa'] ?? "Brak") . "</br>\n";
     echo "🏢 Miasto: " . ($klient['miejscowosc'] ?? "Brak") . "</br>\n";
     echo "📍 Ulica: " . ($klient['ulica'] ?? "Brak") . "</br>\n";
     echo "📧 Email: " . ($klient['email'] ?? "Brak") . "</br></br>\n";
 }

 /*
 foreach ($data['result'] as $company) {
     
            $found = true;
            echo "</br></br>✅ Firma znaleziona:\n";
            echo "📌 Nazwa: " . ($company['nazwa'] ?? "Brak") . "</br>\n";
            echo "🏢 Miasto: " . ($company['miejscowosc'] ?? "Brak") . "</br>\n";
            echo "📍 Ulica: " . ($company['ulica'] ?? "Brak") . "</br>\n";
            echo "📧 Email: " . ($company['email'] ?? "Brak") . "</br>\n";
            echo "--------------------------------------</br></br>\n";
        
    }
 */
?> 