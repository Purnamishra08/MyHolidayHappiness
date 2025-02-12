<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Csv {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    /**
     * Generate CSV file
     * @param array $config Configuration array with 'filename' and 'data' keys
     */
    public function create_csv($config = array()) {
        if (empty($config['filename']) || empty($config['data'])) {
            show_error('CSV filename or data is missing');
        }

        // Set CSV file headers
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $config['filename'] . '"');

        // Open file handle
        $output = fopen('php://output', 'w');

        // Write data to CSV
        foreach ($config['data'] as $row) {
            fputcsv($output, $row);
        }

        // Close file handle
        fclose($output);
		exit;
    }
}