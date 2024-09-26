<?php
// Include database connection
include('D:\GrsDatabase\htdocs\barangaymanagement\app\config\db.php');

// Decode JSON input from the fetch request
$input = json_decode(file_get_contents('php://input'), true);

// Check if the necessary data is set
if (isset($input['imageData']) && isset($input['resident_id'])) {
    $imageData = $input['imageData'];
    $residentID = $input['resident_id'];

    // Extract the image type and data from the base64 string
    if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
        $imageType = strtolower($type[1]); // e.g., jpg, png, etc.

        // Check if the image type is supported
        if (!in_array($imageType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo json_encode(['success' => false, 'error' => 'Unsupported image type.']);
            exit();
        }

        // Decode the base64 data
        $base64Data = substr($imageData, strpos($imageData, ',') + 1);
        $base64Data = base64_decode($base64Data);

        if ($base64Data === false) {
            echo json_encode(['success' => false, 'error' => 'Failed to decode base64 data.']);
            exit();
        }

        // Generate a unique filename
        $fileName = 'resident_' . $residentID . '.' . $imageType;
        $filePath = 'D:\GrsDatabase\htdocs\barangaymanagement\uploads\images\images' . $fileName;

        // Attempt to save the file to the server
        if (file_put_contents($filePath, $base64Data) !== false) {
            // Prepare the SQL query to update the profile image filename in the database
            $query = "UPDATE Residents SET ProfileImage = ? WHERE ID = ?";
            $stmt = $db->prepare($query);

            if ($stmt) {
                // Bind parameters and execute the query
                $stmt->bind_param("si", $fileName, $residentID);
                if ($stmt->execute()) {
                    if ($stmt->affected_rows > 0) {
                        // Success message when rows are updated
                        echo json_encode(['success' => true, 'message' => 'Image saved and filename updated in the database.']);
                    } else {
                        // Error if no rows were affected
                        echo json_encode(['success' => false, 'error' => 'No rows updated. The image may already be the same.']);
                    }
                } else {
                    // SQL execution error
                    echo json_encode(['success' => false, 'error' => 'Database update error: ' . $stmt->error]);
                }
                $stmt->close();
            } else {
                // SQL statement preparation error
                echo json_encode(['success' => false, 'error' => 'Database statement preparation error: ' . $db->error]);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to save the image file.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid image data.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Missing image data or resident ID.']);
}
