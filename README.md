# Nelsius Pay for Laravel (V2)

[![Packagist Version](https://img.shields.io/packagist/v/nelsius/nelsius-pay-laravel.svg?style=flat-square)](https://packagist.org/packages/nelsius/nelsius-pay-laravel)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=flat-square)](https://opensource.org/licenses/MIT)

Package Laravel officiel pour intégrer en quelques lignes la passerelle de paiement **Nelsius Pay V2** (Mobile Money Orange & MTN, Carte bancaire).

---

## 📦 Installation

```bash
composer require nelsius/nelsius-pay-laravel
```

---

## ⚙️ Configuration

Ajoutez vos identifiants dans votre fichier `.env` :

```env
NELSIUS_PUBLIC_KEY=pk_live_xxxxxxxxxxxxxxxx
NELSIUS_SECRET_KEY=sk_live_xxxxxxxxxxxxxxxx
NELSIUS_WEBHOOK_SECRET=whsec_xxxxxxxxxxxx
```

Optionnel : Publiez le fichier de configuration :
```bash
php artisan vendor:publish --tag=nelsius-config
```

---

## 🚀 Utilisation

### Créer une session de paiement hébergée (Hosted Checkout)

```php
use Nelsius\Laravel\Facades\Nelsius;

$session = Nelsius::checkout()->createSession([
    'amount'            => 5000,
    'currency'          => 'XAF',
    'description'       => 'Paiement commande #1042',
    'customer_name'     => 'Alice Dupont',
    'customer_email'    => 'alice@example.com',
    'customer_phone'    => '+237699001122',
    'default_country'   => 'CM', // Cameroun pré-sélectionné
    'allowed_countries' => ['CM', 'CI', 'SN'],
    'return_url'        => route('order.success'),
    'cancel_url'        => route('order.cancel'),
    'metadata'          => [
        'order_id' => 1042,
    ],
]);

return redirect($session['payment_url']);
```

---

## 🔒 Vérifier les Webhooks

```php
use Nelsius\Utils\WebhookSignature;

public function handleWebhook(Request $request)
{
    $signature = $request->header('X-Nelsius-Signature');
    $secret    = config('nelsius.webhook_secret');

    if (!WebhookSignature::verify($request->getContent(), $signature, $secret)) {
        abort(401, 'Signature invalide');
    }

    $event = $request->json()->all();

    if ($event['event'] === 'payment.success') {
        // Valider la commande
    }

    return response()->json(['received' => true]);
}
```

---

## 📄 Licence

MIT © [Nelsius](https://nelsiuspay.com)
