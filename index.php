<?php

function drawTriangle($rows)
{
    // Validate input
    if ($rows <= 0) {
        return "Invalid input. Rows must be greater than 0.";
    }

    // Calculate columns based on rows
    $columns = $rows * 2 - 1;

    // Initialize output
    $output = "";

    // Iterate through rows
    for ($i = 0; $i < $rows; $i++) {
        // Calculate number of spaces and asterisks for the current row
        $spaces = $rows - $i - 1;
        $asterisks = $columns - $spaces * 2;

        // Add spaces
        for ($j = 0; $j < $spaces; $j++) {
            $output .= " ";
        }

        // Add asterisks
        for ($j = 0; $j < $asterisks; $j++) {
            $output .= "*";
        }

        // Add new line after each row
        $output .= "\n";
    }

    return $output;
}

// Example usage:
echo drawTriangle(9);

