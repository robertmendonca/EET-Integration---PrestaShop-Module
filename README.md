# EET-Integration---PrestaShop-Module

This module allows you to synchronize products from the EET API with your PrestaShop store. It fetches product data, updates stock levels, and manages pricing automatically to keep your catalog up to date.

🛠 Installation
To install the module in your PrestaShop store:

Access your Admin Panel:

Go to Modules > Module Manager in the PrestaShop admin panel.
Upload the Module:

Click on Upload a module.
Select the eetintegration.zip file.
Complete Installation:

Wait for the installation to finish.
The module will appear under Advanced Parameters > EET Integration.
Configure the API Settings:

Enter your EET API credentials and the Brand ID to begin synchronization.
⚙️ Configuration
Before using the module, you need to configure it with your EET API credentials:

Required Settings:
API Username & Password

Enter the credentials provided by EET Group to access their API.
Brand ID

Define the brand ID to specify which products should be synchronized.
How to Configure:
Go to Advanced Parameters > EET Integration in the PrestaShop admin panel.
Fill in the API details and Save the settings.
🔄 How It Works (Product Synchronization Process)
Once configured, the module automatically retrieves and updates product data using the EET API. You can also manually trigger synchronization from the admin panel.

Synchronization Process:
Fetch Product Data

The module connects to the EET API and fetches products associated with the given Brand ID.
Check Stock Levels

Only products with local stock ≥ 5 will be considered for synchronization.
Update Existing Products

If a product with the same reference (Item ID) exists in PrestaShop, the module updates:
Stock quantity
Product price
Descriptions
Create New Products (If Not Found)

If the product doesn’t exist in PrestaShop, it will be created automatically with default settings.
Image Handling

If the API provides product images, they will be downloaded and assigned to the product.
Completion

A confirmation message will appear after synchronization, showing the number of updated and added products.
📌 How to Manually Sync Products
Go to the Admin Panel

Navigate to Advanced Parameters > EET Integration.
Click the "Sync Now" Button

This will trigger a manual synchronization of products from the EET API.
Wait for the Process to Finish

You will see a status message with the result of the sync process.
❓ Troubleshooting
Why aren’t my products syncing?
✔ Ensure that your API credentials are correct.
✔ Check that the Brand ID is valid.
✔ Verify that the API returns product data.

Why aren’t images appearing?
✔ Confirm that the EET API provides image URLs.
✔ Check if your server allows external image downloads.

📌 Features & Benefits
✅ Automated product updates – Keep stock, prices, and descriptions updated.
✅ Easy configuration – Simply enter your API details and start syncing.
✅ Manual & Automatic Sync – Update products on demand or let the module handle it.
✅ PrestaShop Admin Integration – Fully integrated into the PrestaShop admin panel.

This module is designed to simplify EET product management in PrestaShop, ensuring your store always has the latest product information. 🚀

If you have any issues, feel free to open an issue on GitHub or contact support. 💬
