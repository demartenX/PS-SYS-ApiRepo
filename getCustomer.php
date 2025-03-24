<?php

// Debugging output for checking the fetched data
echo "Teraz pobiorę dane z tabeli addresses\n";

// Assuming $customerID is defined somewhere earlier in your code
// Pobranie danych o adresie klienta
$customerAddresses = getFromPrestaShopAPIfilter("addresses/", "id_customer", $customerID);  

// Sprawdzenie, czy API zwróciło dane
if (!empty($customerAddresses['addresses'])) {
    echo "Not empty\n";  // Debugging output
     
    // Iteracja przez dane adresów
    foreach ($customerAddresses['addresses'] as $customerAddress) {
        echo " </br>NR adresu: " . $customerAddress['id'] . "\n";
        
        // Fetching additional customer data by address ID
        $customerData = getFromPrestaShopAPI("addresses/" .  $customerAddress['id']);
        
        if (!empty($customerData['address'])) {
            echo "Address data found:";  // Debugging output
			echo "  NIP :" .  $customerData['address']['vat_number'];
			echo "  Imie :" .  $customerData['address']['firstname'];
			echo "  Nazwisko :" .  $customerData['address']['lastname'];
			echo "  Firma :" .  $customerData['address']['company']; 
			
        }
         
        // Fetch additional details if needed
        //$customerDetails = getFromPrestaShopAPIfilter("addresses/", "id", $customerAddress['id']);
        
        // You can add more operations on $customerDetails, such as displaying extra information
    }
} else {
    echo "Nie znaleziono adresu dla ID klienta: 5  \n";
}
 
?>
