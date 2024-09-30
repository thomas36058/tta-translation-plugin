<?php

/**
 * Translates an array of strings into the specified target language using the Weglot API.
 *
 * This function sends a request to the Weglot translation API with the provided
 * texts and retrieves the translated strings. It requires the API key to be set 
 * in the environment variables.
 *
 * @param array $texts Array of strings to be translated.
 * @param string $target_language The language code of the target language.
 * @return array Translated strings.
 * @throws Exception If the cURL request fails or the response format is unexpected.
 */
function tta_translate_strings($texts, $target_language) {
    $api_url = 'https://api.weglot.com/translate';
    $api_key = getenv('WEGLOT_API_KEY');

    $words = array_map(function($text) {
        return array('w' => $text, 't' => 1);
    }, $texts);

    // Body
    $data = [
        'l_from' => 'en',
        'l_to' => $target_language,
        'request_url' => 'http://localhost:8883/',
        'words' => $words
    ];

    // Initialize cURL
    $curl = curl_init();

    // cURL options
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.weglot.com/translate?api_key=wg_2fb37d56bdb5d97307b6a1d9bc1b53b45',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Cookie: BROWNIE=j8pj1i5lnr42m22g4e677occ7e'
        ],
    ]);

    // Get response
    $response = curl_exec($curl);

    if ($response === false) {
        $error = curl_error($curl);
        curl_close($curl);
        throw new Exception('Curl error: ' . $error);
    }

    // Close cURL
    curl_close($curl);

    $data = json_decode($response, true);

    if (isset($data['to_words']) && is_array($data['to_words'])) {
        return $data['to_words'];
    } else {
        throw new Exception('Unexpected response format: ' . json_encode($data));
    }
}
