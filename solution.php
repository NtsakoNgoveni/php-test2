<?php

require __DIR__ ."/vendor/autoload.php";

/**
 * Class Product
 *
 * Represents a product manager that interacts with Google Sheets.
 */

class Product {

    /**
     * @var array $products A multidimensional array where each element is an associtive array containing product  information.
     * @var string $spreadsheetId The ID of the Google Sheets spreadsheet.
     */

    private $products;
    private $spreadsheetId;

    public function __construct($spreadsheetId) {
        /**
        * Product constructor.
        * @param string $spreadsheetId The ID of the Google Sheets spreadsheet.
        */

        $this->spreadsheetId = $spreadsheetId;
        $this->products = $this->fetch_product_list($spreadsheetId);
    }

    public function fetch_product_list($spreadsheetId) {

         /**
         * Gets the list of products from a Google Sheets spreadsheet.
         *
         * @param string $spreadsheetId The ID of the Google Sheets spreadsheet.
         *
         * @return array A multidimensional array where each element is an associtive array containing product  information.
         */

        $client = new Google_Client();
        $client->setApplicationName("sheets_integration");
        $client->addScope(Google_Service_Sheets::SPREADSHEETS);
        $client->setAuthConfig(__DIR__ . "/credentials.json");
        $service = new Google_Service_Sheets($client);
    
    
        $sheetsMetadata = $service->spreadsheets->get($spreadsheetId)->getSheets();
        $products = [];
        foreach ($sheetsMetadata as $sheetMetadata) {
            $sheetName = $sheetMetadata->properties->title;
            $range = $sheetName;
            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
            $values = $response->getValues();
    
            if (empty($values)) {
                echo "No data found in sheet '$sheetName'.\n";
            } else {
                $keys = array_shift($values);
    
                foreach ($values as $row) {
                    array_push($products, array_combine($keys,$row));
                }
            }
        }
         return $products;
    }
    public function setProducts($spreadsheetId) {

        /**
         * Sets the products based on a new spreadsheet ID.
         *
         * @param string $spreadsheetId The ID of the new Google Sheets spreadsheet.
         */

        $this->products = $this->fetch_product_list($spreadsheetId);
    }
    public function get_product($productId){

        /**
         * Gets the details of a specific product by ID.
         *
         * @param int $productId The ID of the product to retrieve.
         *
         * @return array An array containing product details.
         */

        $productDetails = [];
        foreach ($this->products as $product) {
            if($product['id'] === $productId) {
                $productDetails = $product;
            }
        }
        return $productDetails;
    }
}

?>