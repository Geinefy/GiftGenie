<?php
// Gifts index - based on React `Gifts.tsx` and `GiftGrid`/`GiftCard`
$cards = '';
for ($i = 1; $i <= 6; $i++) {
    $cards .= "<div style=\"border:1px solid #e5e7eb;padding:12px;margin:8px;border-radius:8px;width:180px;\">\n";
    $cards .= "<h3>Gift #$i</h3>\n<p>Short description</p>\n";
    $cards .= "</div>\n";
}
$content = '<h1>Gifts</h1><div style="display:flex;flex-wrap:wrap;">' . $cards . '</div>';
require __DIR__ . '/layouts/app.blade.php';
