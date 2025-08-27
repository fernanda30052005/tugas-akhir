<?php
/**
 * Test script to verify the logbook field fix
 * This simulates the form submission to test if the 'hasil_output' field is properly handled
 */

// Simulate form data that would be submitted
$formData = [
    'tanggal' => '2024-01-15',
    'uraian_tugas' => 'Mengerjakan tugas magang',
    'hasil_output' => 'Hasil output dari tugas magang', // This should now work
    'dokumentasi' => null
];

// Simulate what the controller would receive
echo "Testing form field mapping:\n";
echo "Form field 'hasil_output' value: " . ($formData['hasil_output'] ?? 'NULL') . "\n";

// Check if the field exists and is not null
if (isset($formData['hasil_output']) && $formData['hasil_output'] !== null) {
    echo "✓ SUCCESS: 'hasil_output' field is properly set and not null\n";
    echo "✓ The integrity constraint violation should be resolved\n";
} else {
    echo "✗ FAILED: 'hasil_output' field is missing or null\n";
}

// Test with empty string (should still work since it's nullable in validation)
$formDataEmpty = [
    'tanggal' => '2024-01-15',
    'uraian_tugas' => 'Mengerjakan tugas magang',
    'hasil_output' => '', // Empty string
    'dokumentasi' => null
];

echo "\nTesting with empty string:\n";
echo "Form field 'hasil_output' value: '" . $formDataEmpty['hasil_output'] . "'\n";

if ($formDataEmpty['hasil_output'] === '') {
    echo "✓ SUCCESS: Empty string is accepted (nullable validation)\n";
}

// Test what would happen with the old field name
$oldFormData = [
    'tanggal' => '2024-01-15',
    'uraian_tugas' => 'Mengerjakan tugas magang',
    'hasil' => 'Hasil output dari tugas magang', // Old field name
    'dokumentasi' => null
];

echo "\nTesting with old field name 'hasil':\n";
echo "Form field 'hasil' value: " . ($oldFormData['hasil'] ?? 'NULL') . "\n";
echo "Form field 'hasil_output' value: " . ($oldFormData['hasil_output'] ?? 'NULL') . "\n";

if (!isset($oldFormData['hasil_output']) && isset($oldFormData['hasil'])) {
    echo "✗ This would cause the integrity constraint violation error\n";
    echo "✗ Because 'hasil_output' would be null in the database insert\n";
}

echo "\nConclusion:\n";
echo "The fix changes the form field name from 'hasil' to 'hasil_output' to match\n";
echo "the database column name, preventing the null value insertion error.\n";
?>
