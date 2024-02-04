# Product Manager Documentation

## Overview

The `Product` class represents a product manager that interacts with Google Sheets. It provides functionalities to fetch product lists, update products based on a new spreadsheet ID, and retrieve details of specific products by their ID.

## Class Structure

### Properties

- **`$products`**: A multidimensional array where each element is an associative array containing product information.
- **`$spreadsheetId`**: The ID of the Google Sheets spreadsheet.

### Constructor

#### `__construct($spreadsheetId: string)`

The constructor initializes the `Product` class with the specified Google Sheets spreadsheet ID. It fetches the product list from the spreadsheet and populates the `$products` property.

### Methods

#### `fetch_product_list($spreadsheetId: string): array`

This method retrieves the list of products from a Google Sheets spreadsheet.

- **Parameters:**
  - `$spreadsheetId` (string): The ID of the Google Sheets spreadsheet.
- **Returns:** An array representing a multidimensional array where each element is an associative array containing product information.

#### `setProducts($spreadsheetId: string): void`

This method sets the products based on a new spreadsheet ID.

- **Parameters:**
  - `$spreadsheetId` (string): The ID of the new Google Sheets spreadsheet.

#### `get_product($productId: int): array`

This method gets the details of a specific product by its ID.

- **Parameters:**
  - `$productId` (int): The ID of the product to retrieve.
- **Returns:** An array containing product details.

## Usage

```php
require __DIR__ . "/vendor/autoload.php";

// Create an instance of the Product class
$spreadsheetId = "your_spreadsheet_id";
$productManager = new Product($spreadsheetId);

// Fetch product list
$products = $productManager->fetch_product_list($spreadsheetId);

// Set products based on a new spreadsheet ID
$newSpreadsheetId = "new_spreadsheet_id";
$productManager->setProducts($newSpreadsheetId);

// Get product details by ID
$productId = 101;
$productDetails = $productManager->get_product($productId);
