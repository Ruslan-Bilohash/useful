<!-- Простой счётчик посещений (всего + уникальных) -->
<div class="simple-visitor-counter">
    <span class="icon">👁️</span>
    <span id="total">0</span> всего • 
    <span id="unique">0</span> уникальных
</div>

<style>
.simple-visitor-counter {
    font-family: system-ui, sans-serif;
    font-size: 15px;
    color: #ddd;
    background: rgba(0,0,0,0.6);
    padding: 10px 18px;
    border-radius: 30px;
    display: inline-block;
    margin: 15px auto;
    box-shadow: 0 3px 10px rgba(0,0,0,0.4);
}
.simple-visitor-counter .icon { margin-right: 6px; }
</style>

<?php
// === PHP часть - подсчёт и сохранение ===
$counter_file = 'counter.txt';   // всего посещений
$ips_file     = 'ips.txt';      // список уникальных IP

$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

// Инициализация файлов, если их нет
if (!file_exists($counter_file)) file_put_contents($counter_file, "0");
if (!file_exists($ips_file))     file_put_contents($ips_file, "");

// Увеличиваем общее количество посещений
$total = (int)file_get_contents($counter_file);
$total++;
file_put_contents($counter_file, $total);

// Проверяем уникальность IP
$ips = file_get_contents($ips_file);
$ip_list = $ips ? explode("\n", trim($ips)) : [];

$is_new = true;
foreach ($ip_list as $saved_ip) {
    if (trim($saved_ip) === $ip) {
        $is_new = false;
        break;
    }
}

if ($is_new) {
    $ip_list[] = $ip;
    file_put_contents($ips_file, implode("\n", $ip_list));
    $unique = count($ip_list);
} else {
    $unique = count($ip_list);
}
?>

<script>
// Передаём актуальные числа в JS и показываем
document.getElementById('total').textContent = <?php echo $total; ?>;
document.getElementById('unique').textContent = <?php echo $unique; ?>;
</script>
