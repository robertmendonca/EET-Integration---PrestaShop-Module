<?php

/**
 * Class EetApi
 *
 * This class handles communication with the EET API, allowing authentication,
 * product retrieval, and stock/price updates in PrestaShop.
 */
class EetApi
{
    private $apiUrl = 'https://customerapi.eetgroup.com'; // API base URL
    private $username;
    private $password;
    private $brandId;
    private $token;

    /**
     * EetApi constructor.
     * Retrieves API credentials and settings from PrestaShop's configuration.
     *
     * @throws Exception If API credentials are missing.
     */
    public function __construct()
    {
        // Retrieve API credentials stored in PrestaShop
        $this->username = Configuration::get('EET_API_USERNAME');
        $this->password = Configuration::get('EET_API_PASSWORD');
        $this->brandId = Configuration::get('EET_API_BRAND_ID');

        // Ensure credentials are set
        if (empty($this->username) || empty($this->password)) {
            throw new Exception('⚠️ API credentials are not configured!');
        }
    }

    /**
     * Authenticates with the API and retrieves a token for subsequent requests.
     *
     * @return string The authentication token.
     * @throws Exception If authentication fails.
     */
    public function authenticate()
    {
        $endpoint = $this->apiUrl . '/login';
        $data = json_encode([
            'UserName' => $this->username,
            'Password' => $this->password
        ]);

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (isset($result['Token'])) {
            $this->token = $result['Token'];
        } else {
            throw new Exception('Authentication error: ' . json_encode($result));
        }

        return $this->token;
    }

    /**
     * Retrieves a list of products for the specified brand from the API.
     *
     * @return array|null The list of products or null if no products found.
     */
    public function getProducts()
    {
        if (!$this->token) {
            $this->authenticate();
        }

        $endpoint = $this->apiUrl . "/brand?brandId=" . $this->brandId;

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ""); // API requires an empty body
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->token,
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    /**
     * Updates product stock and prices in PrestaShop using API data.
     *
     * @return string A message indicating the update status.
     */
    public function updateStockAndPrices()
    {
        $products = $this->getProducts();

        if (!$products) {
            return 'No products found.';
        }

        foreach ($products as $product) {
            // 🔹 Extract local stock quantity
            $stockQuantity = 0;
            foreach ($product['Stock'] as $stock) {
                if (isset($stock['StockTypeName']) && $stock['StockTypeName'] === 'Local') {
                    $stockQuantity = (int) $stock['Quantity'];
                    break;
                }
            }

            // 🔹 Skip products with insufficient stock
            if ($stockQuantity < 5) {
                continue;
            }

            // 🔹 Check if product already exists in PrestaShop
            $id_product = (int) Product::getIdByReference($product['ItemId']);

            if ($id_product) {
                $prestashopProduct = new Product($id_product);
            } else {
                // 🔹 Create a new product in PrestaShop
                $prestashopProduct = new Product();
                $prestashopProduct->reference = $product['ItemId'];
                $prestashopProduct->id_category_default = 2; // Default category
                $prestashopProduct->id_tax_rules_group = 1;
                $prestashopProduct->active = 1;
            }

            // 🔹 Update product name, description, and price
            $shortDescription = trim(($product['Mpn'] ?? '') . ' - ' . ($product['Description'] ?? '') . ' ' . ($product['Description2'] ?? ''));

            $prestashopProduct->name = [Configuration::get('PS_LANG_DEFAULT') => $shortDescription];
            $prestashopProduct->description_short = [Configuration::get('PS_LANG_DEFAULT') => $shortDescription];
            $prestashopProduct->description = [Configuration::get('PS_LANG_DEFAULT') => $product['Description2']];
            $prestashopProduct->price = $product['Price']['Price'] / 100;
            $prestashopProduct->save();

            // 🔹 Update product stock
            StockAvailable::setQuantity($prestashopProduct->id, 0, $stockQuantity);
        }

        return 'Stock and prices updated successfully!';
    }
}
