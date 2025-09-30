# Mpesa-Practise1.0

A simple demo project for practising M-Pesa integration with vanilla PHP.  API via Safaricom's sandbox environment.

---

## Features

- **Service Plan Selection**: Users can choose between Basic, Standard, and Premium web development service plans.
- **M-Pesa STK Push Integration**: Payments are processed via Safaricom's M-Pesa STK push API (sandbox).
- **Payment Status Polling**: Polls payment status and provides real-time feedback on transaction completion.

---

## Project Structure

```
Mpesa-Practise1.0/
├── public/
│   ├── index.php          # Main user interface and entry point
│   ├── JS/
│   │   └── payment.js     # Handles payment initiation and status polling
│   └── CSS/
│       └── style.css      # Custom styles for pricing cards and UI
├── src/
│   ├── config.php         # Configuration for M-Pesa API (keys, passkey, shortcode, etc)
│   └── mpesa.php          # MpesaIntegration class: handles API authentication and STK push requests
```

---

## How it Works

### 1. Frontend (`public/index.php`)

- Presents users with three pricing/service plans: **Basic (KSH 100)**, **Standard (KSH 200)**, and **Premium (KSH 300)**.
- Each plan displays a phone input and a "Buy Now" button.
- Users must enter a valid Kenyan phone number (format: `2547XXXXXXXX`) to initiate payment.

### 2. Payment Flow

- When "Buy Now" is clicked:
  - jQuery collects the phone, amount, and plan.
  - An AJAX POST request is sent to `index.php` with these details.
- Server-side, in `public/index.php`:
  - On POST, creates a new `MpesaIntegration` object.
  - Calls `initiateSTKPush($phone, $amount, $plan)`.
  - Returns JSON: `{success: true|false, message: ...}`.

### 3. Mpesa Integration (`src/mpesa.php`)

- **Authentication**: Uses credentials (consumer key/secret) from `src/config.php` to generate an OAuth access token via Safaricom's sandbox.
- **STK Push**: Sends a payment request (`STK Push`) to the user's phone.
  - Uses details like shortcode, passkey, timestamp, and amount.
  - Callback URL is set for payment notifications (replace with your own in production).
  - If successful, the user receives an M-Pesa prompt on their phone to complete payment.

### 4. Payment Status Polling (`public/JS/payment.js`)

- After initiating payment, the UI starts polling for payment completion by calling a backend endpoint (not fully shown in search results, but referenced as `/check-status.php`).
- Polling continues every 5 seconds or until 2 minutes auto-complete (for testing).
- Shows alerts for success/failure.

---

## Configuration

- Edit `src/config.php` to set your M-Pesa sandbox credentials:
  - `MPESA_CONSUMER_KEY`
  - `MPESA_CONSUMER_SECRET`
  - `MPESA_PASSKEY`
  - `MPESA_SHORTCODE`
  - `MPESA_BASE_URL` (default is sandbox)
- Set your callback URL in `src/mpesa.php` (replace sandbox callback with your own endpoint for production).

---

## Setup & Usage

1. **Clone the Repository**
   ```bash
   git clone https://github.com/PHPDEV-OPS/Mpesa-Practise1.0.git
   cd Mpesa-Practise1.0
   ```

2. **Configure Credentials**
   - Open `src/config.php` and insert your M-Pesa sandbox credentials.

3. **Run the Application**
   - Serve the `public/` folder with Apache, Nginx, or PHP's built-in server.
   - Example:
     ```bash
     php -S localhost:8000 -t public
     ```

4. **Test Payments**
   - Open `http://localhost:8000` in your browser.
   - Enter a test phone number (e.g. `2547XXXXXXXX`).
   - Click "Buy Now" on any plan.
   - Accept the payment prompt on your phone (sandbox).

---

## Notes

- **Sandbox Environment**: This project uses Safaricom's sandbox, which does not process real money. For production, update credentials and callback URLs accordingly.
- **Security**: Do not expose your credentials in public repositories. Use environment variables or secure storage in production.
- **Callback Handling**: For a full payment workflow, implement and expose the callback endpoint to receive M-Pesa payment status notifications.

---



This project is provided for learning/demo purposes.

---
