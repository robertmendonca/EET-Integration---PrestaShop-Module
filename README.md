# EET Integration - PrestaShop Module  

![PrestaShop](https://img.shields.io/badge/PrestaShop-8.x-blue.svg)  
🔄 Sync products from the EET API to PrestaShop automatically.  

---

## 📌 Features  

✅ **Automated Product Updates** – Sync stock, prices, and descriptions.  
✅ **Multi-Brand Support** – Sync products from multiple **Brand IDs** at once.  
✅ **Easy Configuration** – Enter your API credentials and start syncing.  
✅ **Manual & Automatic Sync** – Update products on demand or let the module handle it.  
✅ **Image Handling** – Automatically downloads and assigns product images.  
✅ **Seamless Integration** – Works within PrestaShop’s admin panel.  

---

## 🛠 Installation  

### 1. Upload the Module  
- Go to **Modules > Module Manager** in your PrestaShop admin panel.  
- Click **Upload a module** and select the `eetintegration.zip` file.  
- Wait for the installation to complete.  

### 2. Configure the API Settings  
- Navigate to **Advanced Parameters > EET Integration**.  
- Enter your **EET API Username, Password, and Brand IDs**.  
- Click **Save** to apply the settings.  

---

## ⚙️ Configuration  

### Required Settings:  
| Setting            | Description                                                 |
|--------------------|-------------------------------------------------------------|
| **API Username**   | Your EET API username.                                      |
| **API Password**   | Your EET API password.                                      |
| **Brand ID(s)**    | The brand(s) whose products you want to sync *(comma-separated for multiple brands)*. |

---

## 🔄 How It Works  

### 1. Fetch Product Data  
- The module connects to the **EET API** and retrieves products for the specified **Brand IDs**.  
- If multiple brands are set, it fetches products for each one.  

### 2. Validate Stock  
- Only products with **local stock ≥ 5** will be synchronized.  

### 3. Update or Create Products  
- **If the product exists in PrestaShop** (based on Item ID), it updates:  
  - Stock quantity  
  - Price  
  - Descriptions  

- **If the product does not exist**, it is created with default settings.  

### 4. Image Handling  
- If the API provides product images, they are automatically downloaded and assigned.  

### 5. Confirmation  
- A message will appear showing the number of updated and added products.  

---

## 📌 How to Manually Sync Products  

1. Go to **Advanced Parameters > EET Integration**.  
2. Click the **Sync Now** button.  
3. Wait for the synchronization to complete.  

A message will confirm the update status.  

---

## ❓ Troubleshooting  

### Why aren’t my products syncing?  
✔ Ensure your **API credentials** are correct.  
✔ Verify that the **Brand ID(s)** are valid.  
✔ Confirm that the **EET API** is returning product data.  

### Why aren’t images appearing?  
✔ Check if the **EET API provides image URLs**.  
✔ Make sure your server allows **external image downloads**.  

---

## 📜 License  
This module is licensed under the **MIT License** – feel free to modify and distribute.  

---

## 🤝 Contributing  
Pull requests are welcome! If you find an issue, open a GitHub issue or submit a fix.  

---

📧 **Need help?** Open an issue on GitHub or contact support. 🚀  

---
## Support my work ☕  
If this project helps you, consider buying me a coffee:  

[![Buy Me a Coffee](https://media.giphy.com/media/513lZvPf6khjIQFibF/giphy.gif)](https://www.buymeacoffee.com/robertmendonca)
