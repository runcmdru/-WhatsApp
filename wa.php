<?php
header('Content-Type: text/html; charset=UTF-8');

$error = '';
$phone = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Серверная фильтрация — только цифры
    $phone = preg_replace('/\D/', '', $_POST['phone'] ?? '');

    if ($phone === '') {
        $error = 'Введите номер телефона';
    } elseif (strlen($phone) > 10) {
        $error = 'Номер должен содержать не более 10 цифр';
    } elseif (strlen($phone) < 10) {
        $error = 'Номер слишком короткий — нужно 10 цифр';
    } else {
        header("Location: https://wa.me/7{$phone}");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Быстрый чат WhatsApp</title>
    <meta name="robots" content="index,follow">
    <meta name="theme-color" content="#ECE5DD">

    <meta name="description" content="Онлайн-сервис для быстрого открытия чата WhatsApp: введите номер без 8 / +7 / 7 — и мгновенно начните разговор.">
    <meta name="keywords" content="WhatsApp, чат без добавления, написать в WhatsApp, быстрый чат, открыть чат по номеру">
    <meta name="author" content="RUNCMD.RU">
    <link rel="canonical" href="<?= htmlspecialchars(((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || ($_SERVER['SERVER_PORT'] ?? '') == 443 ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'localhost') . strtok($_SERVER['REQUEST_URI'] ?? '/', '?'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">

    <meta property="og:type" content="website">
    <meta property="og:title" content="Быстрый чат WhatsApp">
    <meta property="og:description" content="Введите номер телефона и сразу откройте чат WhatsApp без добавления контакта.">
    <meta property="og:url" content="<?= htmlspecialchars(((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || ($_SERVER['SERVER_PORT'] ?? '') == 443 ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'localhost') . strtok($_SERVER['REQUEST_URI'] ?? '/', '?'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
    <meta property="og:site_name" content="Быстрый чат WhatsApp">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:image" content="https://<?= htmlspecialchars($_SERVER['HTTP_HOST'] ?? 'localhost', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>/og-preview.jpg">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Быстрый чат WhatsApp">
    <meta name="twitter:description" content="Введите номер телефона и сразу откройте чат WhatsApp без добавления контакта.">
    <meta name="twitter:image" content="https://<?= htmlspecialchars($_SERVER['HTTP_HOST'] ?? 'localhost', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>/og-preview.jpg">

    <style>
        :root {
            --wa-green: #25D366;
            --wa-dark: #075E54;
            --wa-light: #ECE5DD;
            --wa-text: #1C1E21;
            --danger: #C33;
            color-scheme: light dark;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --wa-green: #20BD5A;
                --wa-dark: #0B3F35;
                --wa-light: #0E1917;
                --wa-text: #EAEAEA;
            }
        }

        * {
            box-sizing: border-box
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden
        }

        body {
            -webkit-tap-highlight-color: transparent;
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100dvh;
            background: linear-gradient(180deg, var(--wa-light) 0%, var(--wa-green) 100%);
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            color: var(--wa-text);
        }

        .card {
            width: 100%;
            max-width: 380px;
            background: var(--wa-light);
            border-radius: 16px;
            padding: 20px 18px 22px;
            box-shadow: 0 6px 14px rgba(0, 0, 0, .25);
            animation: slideUp .5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 10px
        }

        .brand svg {
            width: 28px;
            height: 28px;
            flex: 0 0 28px
        }

        h1 {
            font-size: 1.25rem;
            margin: 0;
            text-align: center;
            color: #fff
        }

        p {
            margin: 8px 0 16px;
            font-size: .95rem;
            opacity: .85;
            text-align: center;
            line-height: 1.4
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 12px
        }

        input[type="tel"] {
            font-size: 1.1rem;
            padding: 12px 14px;
            border: 1px solid var(--wa-green);
            border-radius: 12px;
            width: 100%;
            outline: none;
            background: var(--wa-light);
            /* вернули фон */
            color: var(--wa-text);
            transition: border-color .15s, box-shadow .15s;
        }

        input[type="tel"]:focus {
            box-shadow: 0 0 0 2px var(--wa-green)
        }

        /* Когда длина > 10 — красный акцент */
        input[type="tel"].invalid {
            border-color: var(--danger)
        }

        input[type="tel"].invalid:focus {
            box-shadow: 0 0 0 2px var(--danger)
        }

        button {
            font-size: 1.05rem;
            padding: 12px 16px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            background: var(--wa-green);
            color: var(--wa-dark);
            font-weight: 600;
            transition: background .2s, transform .15s;
        }

        button:active {
            background: #1EB058;
            transform: scale(.98)
        }

        .hint {
            font-size: .85rem;
            opacity: .7;
            text-align: center;
            margin-top: 10px;
            line-height: 1.3
        }

        .error {
            color: #c33;
            text-align: center;
            margin-top: 8px;
            font-weight: 500;
            font-size: .95rem
        }

        /* Плавающая круглая кнопка очистки */
        .fab {
            position: fixed;
            right: 18px;
            bottom: 18px;
            z-index: 10;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: #fff;
            color: var(--wa-dark);
            border: 1px solid rgba(0, 0, 0, .08);
            box-shadow: 0 6px 14px rgba(0, 0, 0, .25);
            cursor: pointer;
            transition: transform .15s, box-shadow .2s, background .2s;
            user-select: none;
        }

        .fab:active {
            transform: scale(.96)
        }

        .fab svg {
            width: 26px;
            height: 26px;
            display: block
        }

        .fab:focus-visible {
            outline: 3px solid var(--wa-green);
            outline-offset: 3px
        }
    </style>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebApplication",
            "@id": "<?= htmlspecialchars(((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || ($_SERVER['SERVER_PORT'] ?? '') == 443 ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'localhost') . strtok($_SERVER['REQUEST_URI'] ?? '/', '?'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>",
            "url": "<?= htmlspecialchars(((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || ($_SERVER['SERVER_PORT'] ?? '') == 443 ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'localhost') . strtok($_SERVER['REQUEST_URI'] ?? '/', '?'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>",
            "name": "Быстрый чат WhatsApp",
            "description": "Онлайн-страница: введите 10 цифр номера (без 8/+7/7) — автоматически откроется чат WhatsApp с этим абонентом.",
            "inLanguage": "ru",
            "applicationCategory": "BusinessApplication",
            "operatingSystem": "Android/iOS/Web",
            "isAccessibleForFree": true,
            "offers": {
                "@type": "Offer",
                "price": "0",
                "priceCurrency": "RUB"
            },
            "publisher": {
                "@type": "Organization",
                "name": "<?= htmlspecialchars($_SERVER['HTTP_HOST'] ?? 'localhost', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>"
            },
            "potentialAction": {
                "@type": "CommunicateAction",
                "name": "Открыть чат в WhatsApp",
                "target": {
                    "@type": "EntryPoint",
                    "urlTemplate": "https://wa.me/7{phone}",
                    "httpMethod": "GET",
                    "actionPlatform": [
                        "http://schema.org/DesktopWebPlatform",
                        "http://schema.org/MobileWebPlatform",
                        "http://schema.org/AndroidPlatform",
                        "http://schema.org/IOSPlatform"
                    ]
                }
            }
        }
    </script>


</head>

<body>
    <div class="card" role="region" aria-label="Форма быстрого чата WhatsApp">
        <div class="brand">
            <!-- Инлайновый логотип WhatsApp -->
            <svg viewBox="0 0 32 32" aria-hidden="true">
                <defs>
                    <linearGradient id="g" x1="0" x2="0" y1="0" y2="1">
                        <stop offset="0" stop-color="#25D366" />
                        <stop offset="1" stop-color="#20BD5A" />
                    </linearGradient>
                </defs>
                <circle cx="16" cy="16" r="14" fill="url(#g)" />
                <path fill="#FFF" d="M21.9 18.5c-.3-.1-1.7-.8-2-.9-.3-.1-.5-.1-.7.1s-.8.9-1 .9c-.2 0-.4 0-.7-.2a8.3 8.3 0 0 1-2.5-1.6 9 9 0 0 1-1.6-2.5c-.1-.2 0-.5.1-.7 0-.1.9-.8.9-1 0-.2 0-.4-.1-.7-.1-.3-.8-1.7-.9-2s-.4-.4-.7-.4h-.6c-.2 0-.5.1-.7.3-.8.8-1.2 1.8-1.2 3 0 1 .3 2 .9 2.9a10.9 10.9 0 0 0 3.8 3.8c.9.6 1.9.9 2.9.9 1.2 0 2.2-.4 3-1.2.2-.2.3-.4.3-.7v-.6c0-.3-.1-.6-.3-.7z" />
            </svg>
            <h1>Открыть чат WhatsApp</h1>
        </div>

        <p id="hint">Введите номер без «8 / +7 / 7». Код страны подставится автоматически: <b>7</b>.</p>

        <form method="post" onsubmit="return validateInput()">
            <input
                id="phone"
                type="tel"
                name="phone"
                value="<?= htmlspecialchars($phone, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>"
                placeholder="например: 9250514151"
                maxlength="20"
                pattern="[0-9]{1,20}"
                inputmode="numeric"
                autocomplete="tel"
                aria-describedby="hint"
                autofocus
                required>
            <button type="submit" aria-label="Открыть чат в WhatsApp">Открыть</button>
        </form>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="hint">
            Работает без добавления контакта.<br>Формат: только цифры (идеально — 10).
        </div>
    </div>

    <!-- Плавающая кнопка очистки -->
    <button class="fab" type="button" id="clearBtn" aria-label="Очистить номер" title="Очистить">
        <!-- Иконка «обновить» -->
        <svg viewBox="0 0 24 24" aria-hidden="true">
            <path fill="currentColor" d="M17.65 6.35A7.95 7.95 0 0 0 12 4a8 8 0 1 0 7.75 10h-2.1A6 6 0 1 1 12 6a5.96 5.96 0 0 1 4.24 1.76L14 10h8V2l-4.35 4.35z" />
        </svg>
    </button>

    <script>
        const input = document.getElementById('phone');
        const clearBtn = document.getElementById('clearBtn');

        // Обновление состояния валидности (подсветка красным, если > 10)
        function updateValidityClass() {
            const len = (input.value || '').length;
            if (len > 10) input.classList.add('invalid');
            else input.classList.remove('invalid');
        }

        // Фильтрация: только цифры, до 20 символов максимум (можно редактировать сверх 10)
        input.addEventListener('input', () => {
            const start = input.selectionStart;
            const cleaned = input.value.replace(/[^0-9]/g, '').slice(0, 20);
            input.value = cleaned;
            const pos = Math.min(cleaned.length, start ?? cleaned.length);
            if (typeof input.setSelectionRange === 'function') input.setSelectionRange(pos, pos);
            updateValidityClass();
        });

        // Нормализуем вставку (без + * # и т.п.), до 20 символов
        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const text = (e.clipboardData || window.clipboardData).getData('text') || '';
            const clean = text.replace(/[^0-9]/g, '').slice(0, 20);
            if (typeof input.setRangeText === 'function') {
                const s = input.selectionStart,
                    r = input.selectionEnd;
                input.setRangeText(clean, s, r, 'end');
                input.dispatchEvent(new Event('input', {
                    bubbles: true
                }));
            } else {
                input.value = (input.value + clean).replace(/[^0-9]/g, '').slice(0, 20);
                updateValidityClass();
            }
        });

        // Запрет перетаскивания мусора
        input.addEventListener('drop', (e) => e.preventDefault());

        // Очистка по плавающей кнопке
        clearBtn.addEventListener('click', () => {
            input.value = '';
            if (navigator.vibrate) navigator.vibrate(15);
            input.classList.remove('invalid');
            input.focus();
        });

        // Дополнительная защита при отправке формы: строго 10 цифр
        function validateInput() {
            const val = (input.value || '').trim();
            if (!/^\d{10}$/.test(val)) {
                if (navigator.vibrate) navigator.vibrate([10, 40, 10]);
                alert('Нужно ровно 10 цифр. Сейчас: ' + val.length);
                return false;
            }
            return true;
        }

        // Инициализация статуса на загрузке (если value из PHP)
        updateValidityClass();
    </script>
</body>

</html>