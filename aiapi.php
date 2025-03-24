<?php
include "zapytaniaAPI.php";

// PrestaShop API credentials
$api_url = "https://fx-electronics.pl/api/";
$api_key = "V78WQYIA4KDQB8461I2QZKFGSR1NV4QA";

// Systim API credentials
$systim_subdomain = "kore02.systim.pl";
$systim_login = "superelectrix@gmail.com";
$systim_password = "MV6CwXYW_^)4i]in)F6{_QCQS35*]Nl";

// Log errors to a file
function logError($message, $data = null) {
    $logFile = __DIR__ . "/error_log.txt";
    $logMessage = "[" . date("Y-m-d H:i:s") . "] " . $message;
    if ($data) {
        $logMessage .= " | Data: " . json_encode($data, JSON_PRETTY_PRINT);
    }
    file_put_contents($logFile, $logMessage . PHP_EOL, FILE_APPEND);
    echo "<p style='color: red;'>Error: $message</p>";
    if ($data) {
        echo "<pre style='color: red;'>" . htmlspecialchars(json_encode($data, JSON_PRETTY_PRINT)) . "</pre>";
    }
}

// Fetch the latest order from PrestaShop
function fetchLatestOrder() {
    global $api_url, $api_key;
    echo "<p>Fetching the latest order from PrestaShop...</p>";

    $url = $api_url . "orders?sort=[id_DESC]&limit=1"; // Pobierz ostatnie zamówienie
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Basic " . base64_encode($api_key . ":")]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code != 200) {
        logError("Failed to fetch the latest order: HTTP $http_code");
        return false;
    }

    $data = json_decode($response, true);
    return $data['orders'][0] ?? null; // Zwróć dane ostatniego zamówienia
}

// Fetch customer addresses by customer ID
function fetchCustomerAddresses($customerId) {
    global $api_url, $api_key;
    echo "<p>Fetching addresses for customer ID: $customerId...</p>";

    $url = $api_url . "addresses?filter[id_customer]=$customerId"; // Pobierz adresy klienta
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Basic " . base64_encode($api_key . ":")]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code != 200) {
        logError("Failed to fetch customer addresses: HTTP $http_code");
        return false;
    }

    $data = json_decode($response, true);
    return $data['addresses'] ?? [];
}

// Extract NIP from customer addresses
function extractNIPFromAddresses($addresses) {
    foreach ($addresses as $address) {
        if (!empty($address['vat_number'])) { // Sprawdź, czy adres zawiera numer NIP
            echo "<p>Found NIP in address: {$address['vat_number']}</p>";
            return $address['vat_number'];
        }
    }
    return null; // Jeśli nie znaleziono NIP-u
}

// Fetch customer by NIP from Systim
function fetchCustomerByNIP($nip) {
    global $systim_login, $systim_password;
    echo "<p>Checking customer in Systim by NIP: $nip...</p>";
    $token = getSystimApiToken($systim_login, $systim_password);
    return getSystimApi($token, "nip", $nip);
}

// Create a new customer in Systim
function createCustomerInSystim($customerData) {
    global $systim_login, $systim_password;
    echo "<p>Creating a new customer in Systim: " . htmlspecialchars(json_encode($customerData)) . "</p>";
    $token = getSystimApiToken($systim_login, $systim_password);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://kore02.systim.pl/jsonAPI.php");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array_merge($customerData, [
        'act' => 'addCompany',
        'token' => $token
    ])));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code != 200) {
        logError("Failed to create customer: HTTP $http_code");
        return false;
    }

    $data = json_decode($response, true);
    if (isset($data['error']['code']) && $data['error']['code'] > 0) {
        logError("Error creating customer: " . $data['error']['message']);
        return false;
    }

    echo "<p>Customer created successfully in Systim.</p>";
    return $data['result'];
}

// Create an invoice in Systim
function createInvoiceInSystim($invoiceData) {
    global $systim_login, $systim_password;
    echo "<p>Creating an invoice in Systim: " . htmlspecialchars(json_encode($invoiceData)) . "</p>";
    $token = getSystimApiToken($systim_login, $systim_password);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://kore02.systim.pl/jsonAPI.php");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array_merge($invoiceData, [
        'act' => 'addInvoice',
        'token' => $token
    ])));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code != 200) {
        logError("Failed to create invoice: HTTP $http_code");
        return false;
    }

    $data = json_decode($response, true);
    if (isset($data['error']['code']) && $data['error']['code'] > 0) {
        logError("Error creating invoice: " . $data['error']['message']);
        return false;
    }

    echo "<p>Invoice created successfully in Systim.</p>";
    return $data['result'];
}

// Main process
try {
    echo "<h1>Starting API Integration Process</h1>";

    // Step 1: Fetch the latest order
    $latestOrder = fetchLatestOrder();
    if (!$latestOrder) {
        logError("No orders found.");
        exit;
    }

    echo "<p>Latest Order ID: {$latestOrder['id']}</p>";

    // Step 2: Fetch customer addresses
    $customerId = $latestOrder['id_customer'];
    $addresses = fetchCustomerAddresses($customerId);

    if (empty($addresses)) {
        logError("No addresses found for customer ID: $customerId", $latestOrder);
        exit;
    }

    // Step 3: Extract NIP from addresses
    $nip = extractNIPFromAddresses($addresses);
    if (!$nip) {
        logError("No NIP found in customer addresses.", $addresses);
        exit;
    }

    echo "<p>Customer NIP: $nip</p>";

    // Step 4: Check customer in Systim
    $customer = fetchCustomerByNIP($nip);
    if (!$customer) {
        // Create a new customer if not found
        $customerData = [
            'nazwa' => $latestOrder['customer']['name'],
            'nip' => $nip,
            'miejscowosc' => $addresses[0]['city'],
            'ulica' => $addresses[0]['address1'],
            'email' => $latestOrder['customer']['email']
        ];
        $customer = createCustomerInSystim($customerData);
    }

    if (!$customer) {
        logError("Failed to process customer for order ID {$latestOrder['id']}.", $latestOrder);
        exit;
    }

    // Step 5: Create an invoice
    $invoiceData = [
        'customer_id' => $customer['id'],
        'products' => $latestOrder['products'], // Map products here
        'total' => $latestOrder['total_paid']
    ];
    $invoice = createInvoiceInSystim($invoiceData);

    if (!$invoice) {
        logError("Failed to create invoice for order ID {$latestOrder['id']}.", $latestOrder);
        exit;
    }

    echo "<h1>API Integration Process Completed Successfully</h1>";
} catch (Exception $e) {
    logError("Unexpected error: " . $e->getMessage());
}
?>