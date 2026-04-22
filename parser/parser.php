<?php
/**
 * 🔥 МОЩНЫЙ СБОРЩИК EMAIL 
 * Красивый цветной вывод + прогресс + сохраняет ВСЁ
 */

echo "\033[1;36m"; // Cyan
echo "🚀 МОЩНЫЙ СБОРЩИК EMAIL — NAV Arbeidsplassen (IT)\n";
echo "\033[0m";
echo str_repeat("═", 90) . "\n\n";

$baseUrl   = "САЙТ КОТОРИЙ ПАРСИМ НА ЕМЕЙЛ";
$searchUrl = "С ТРАНИЦА КОТОРУЮ ПАРСИМ";

$allFindings = [];   // все найденные записи
$page        = 1;
$maxPages    = 50;   // поставь 0 — будет до конца
$totalEmails = 0;

$filenameTxt = "NAV_IT_Emails_" . date("Y-m-d_H-i-s") . ".txt";
$filenameJson = "NAV_IT_Emails_" . date("Y-m-d_H-i-s") . ".json";

// Заголовок файла
file_put_contents($filenameTxt, "=== NAV IT Email Collector — " . date("d.m.Y H:i:s") . " ===\n\n");
file_put_contents($filenameTxt, "Страница | Email                          | Вакансия\n", FILE_APPEND);
file_put_contents($filenameTxt, str_repeat("─", 110) . "\n", FILE_APPEND);

function color($text, $color) {
    $codes = [
        'red'    => "\033[1;31m",
        'green'  => "\033[1;32m",
        'yellow' => "\033[1;33m",
        'blue'   => "\033[1;34m",
        'cyan'   => "\033[1;36m",
        'reset'  => "\033[0m"
    ];
    return $codes[$color] . $text . $codes['reset'];
}

echo color("Начинаем парсинг...\n\n", 'cyan');

while ($maxPages === 0 || $page <= $maxPages) {

    $currentUrl = $searchUrl . "&page=" . $page;

    echo color("📄 Страница ", 'blue') . color($page, 'yellow') . color(" / " . ($maxPages ?: '∞'), 'blue') . "\n";
    echo color("🔗 ", 'cyan') . $currentUrl . "\n\n";

    $context = stream_context_create([
        'http' => [
            'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36\r\n" .
                        "Accept-Language: nb-NO,nb;q=0.9,en;q=0.8\r\n"
        ]
    ]);

    $html = @file_get_contents($currentUrl, false, $context);

    if (!$html) {
        echo color("❌ Не удалось загрузить страницу. Возможно, нужна headless версия.\n", 'red');
        break;
    }

    // Находим ссылки на вакансии
    preg_match_all('#href="(/stillinger/stilling/[^"]+)"#', $html, $matches);
    $jobLinks = array_unique($matches[1]);

    if (empty($jobLinks)) {
        echo color("✅ Страниц больше нет. Завершаем!\n", 'green');
        break;
    }

    $totalOnPage = count($jobLinks);
    echo color("   Найдено вакансий: ", 'cyan') . color($totalOnPage, 'yellow') . "\n\n";

    $processed = 0;

    foreach ($jobLinks as $link) {
        $jobUrl = $baseUrl . $link;
        $processed++;

        echo color("   [" . $processed . "/" . $totalOnPage . "] 🔍 ", 'blue') . $jobUrl . "\n";

        $jobHtml = @file_get_contents($jobUrl, false, $context);

        if (!$jobHtml) {
            echo "      " . color("⚠️  Не удалось открыть", 'yellow') . "\n\n";
            continue;
        }

        preg_match_all('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/i', $jobHtml, $matches);
        $emails = array_unique(array_map('strtolower', $matches[0]));

        if (!empty($emails)) {
            foreach ($emails as $email) {
                $totalEmails++;

                echo "      " . color("✅ НАЙДЕН", 'green') . " #" . $totalEmails . ": " . 
                     color($email, 'yellow') . "\n";

                // Сохраняем сразу
                $line = sprintf("%-6d | %-30s | %s\n", $page, $email, $jobUrl);
                file_put_contents($filenameTxt, $line, FILE_APPEND);

                $allFindings[] = [
                    'page'  => $page,
                    'email' => $email,
                    'url'   => $jobUrl,
                    'time'  => date('H:i:s')
                ];
            }
        } else {
            echo "      " . color("❌ Email не найдено", 'red') . "\n";
        }

        echo "\n";
        usleep(1200000); // ~1.2 секунды — комфортная пауза
    }

    $page++;
    echo str_repeat("─", 80) . "\n";
}

// ==================== КРАСИВЫЙ ИТОГ ====================

echo "\n" . str_repeat("═", 90) . "\n";
echo color("🎉 ПАРСИНГ УСПЕШНО ЗАВЕРШЁН!\n\n", 'green');

echo color("📊 Обработано страниц: ", 'cyan') . color(($page - 1), 'yellow') . "\n";
echo color("📧 Всего найдено email: ", 'cyan') . color($totalEmails, 'yellow') . "\n";
echo color("💾 Сохранено в файлы:\n", 'cyan');
echo "   • " . $filenameTxt . "\n";
echo "   • " . $filenameJson . "\n\n";

file_put_contents($filenameJson, json_encode($allFindings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

if ($totalEmails > 0) {
    echo color("📋 Последние 10 найденных email:\n", 'cyan');
    $last = array_slice($allFindings, -10);
    foreach ($last as $item) {
        echo "   " . color($item['email'], 'yellow') . "  ←  " . color("стр." . $item['page'], 'blue') . "\n";
    }
} else {
    echo color("😕 Email не найдены. Рекомендую мощную headless-версию.\n", 'red');
}

echo "\n" . color("Скрипт завершён. Спасибо, Руслан! 🔥\n", 'cyan');
