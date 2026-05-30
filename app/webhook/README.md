# Webhook Handlers

Place webhook endpoints here. Examples (not yet implemented):

- `promptpay.php` — PromptPay payment confirmation
- `line.php` — LINE Notify / message webhook
- `tracking.php` — shipment status updates

Route them in `routes/web.php` with `App\Webhook\<Handler>::class`.
