<?php

require __DIR__ ."/vendor/autoload.php";
class Product {
    private $products;
    private $spreadsheetId;

    public function __construct($spreadsheetId) {
        $this->spreadsheetId = $spreadsheetId;
        $this->products = $this->fetch_product_list($spreadsheetId);
    }

    public function fetch_product_list($spreadsheetId) {
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
        $this->products = $this->fetch_product_list($spreadsheetId);
    }
    public function get_product($productId){
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