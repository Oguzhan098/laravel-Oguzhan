<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidEmailDomain implements Rule
{
    /**
     * Geçerli domain listesi
     * Dilersen .env'den de çekebilirsin.
     */
    protected $allowedDomains = [
        'gmail.com',
        'outlook.com',
        'hotmail.com',
        'yahoo.com',
        'icloud.com',
        'proton.me',
        'protonmail.com',
        'edu.tr',      // üniversite e-postaları
        'gov.tr',      // resmi kurumlar
        'kendi-domainin.com', // örnek: kendi kurumsal domainin
    ];

    public function passes($attribute, $value)
    {
        $domain = strtolower(substr(strrchr($value, "@"), 1));

        // 🔹 1. Format kontrolü
        if (!preg_match('/^[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/', $domain)) {
            return false;
        }

        // 🔹 2. Doğrudan tam eşleşme kontrolü
        if (in_array($domain, $this->allowedDomains)) {
            return true;
        }

        // 🔹 3. “Alt domain” desteği (örnek: mail.uni.edu.tr)
        foreach ($this->allowedDomains as $allowed) {
            if (str_ends_with($domain, $allowed)) {
                return true;
            }
        }

        return false;
    }

    public function message()
    {
        return 'Bu e-posta alan adı kabul edilmiyor. Lütfen güvenilir bir e-posta sağlayıcısı kullanın.';
    }
}
