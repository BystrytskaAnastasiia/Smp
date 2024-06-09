<?php
class HTMLConverter {
    // Метод для перетворення тексту в HTML
    public function textToHTML($text) {
        // Перетворюємо нові рядки в <br> теги та захищаємо від XSS-атак
        $html = nl2br(htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
        
        // Перетворюємо текстові посилання в HTML посилання
        $html = preg_replace(
            '/(https?:\/\/[^\s]+)/',
            '<a href="$1" target="_blank">$1</a>',
            $html
        );
        
        return $html;
    }

    // Метод для видалення HTML-тегів з тексту
    public function htmlToText($html) {
        // Видаляємо всі HTML-теги
        $text = strip_tags($html);
        
        // Видаляємо зайві пробіли і нові рядки
        $text = preg_replace('/\s+/', ' ', $text);
        
        return $text;
    }

    // Метод для перетворення текстового файлу в HTML-файл
    public function textFileToHTMLFile($inputFilePath, $outputFilePath) {
        $text = file_get_contents($inputFilePath);
        $html = $this->textToHTML($text);
        if (!file_exists(dirname($outputFilePath))) {
            mkdir(dirname($outputFilePath), 0777, true);
        }
        file_put_contents($outputFilePath, $html);
    }

    // Метод для перетворення HTML-файлу в текстовий файл
    public function htmlFileToTextFile($inputFilePath, $outputFilePath) {
        $html = file_get_contents($inputFilePath);
        $text = $this->htmlToText($html);
        if (!file_exists(dirname($outputFilePath))) {
            mkdir(dirname($outputFilePath), 0777, true);
        }
        file_put_contents($outputFilePath, $text);
    }
}
?>
