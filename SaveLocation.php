<?php
header('Content-Type: application/json');

// Get the JSON data from the request body
$requestData = file_get_contents('php://input'); 

// Decode the JSON data
$locationData = json_decode($requestData, true);

// Check if the data is valid
if ($locationData === null) {
  http_response_code(400); // Bad Request
  echo json_encode(['error' => 'Invalid JSON data']);
  exit;
}

// File path (adjust as needed)
$filePath = 'locations.json'; 

try {
  // Check if the file exists
  if (file_exists($filePath)) {
    // Read existing data
    $existingData = file_get_contents($filePath);
    $existingData = json_decode($existingData, true); 
  } else {
    // Initialize an empty array if the file doesn't exist
    $existingData = [];
  }

  // Append new data
  $existingData[] = $locationData;

  // Write data to file
  file_put_contents($filePath, json_encode($existingData, JSON_PRETTY_PRINT)); 

  // Success response
  echo json_encode(['message' => 'Location saved successfully']);

} catch (Exception $e) {
  http_response_code(500); // Internal Server Error
  echo json_encode(['error' => 'Error saving location: ' . $e->getMessage()]);
}
?>
