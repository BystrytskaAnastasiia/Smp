<?php



class HTMLConverter
{

    // Метод для перетворення тексту в HTML
    public function textToHTML($text)
    {
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
    public function htmlToText($html)
    {
        // Видаляємо всі HTML-теги
        $text = strip_tags($html);

        // Видаляємо зайві пробіли і нові рядки
        $text = preg_replace('/\s+/', ' ', $text);

        return $text;
    }

    // Метод для перетворення текстового файлу в HTML-файл
    public function textFileToHTMLFile($inputFilePath, $outputFilePath)
    {
        $text = file_get_contents($inputFilePath);
        $html = $this->textToHTML($text);
        if (!file_exists(dirname($outputFilePath))) {
            mkdir(dirname($outputFilePath), 0777, true);
        }
        file_put_contents($outputFilePath, $html);
    }

    // Метод для перетворення HTML-файлу в текстовий файл
    public function htmlFileToTextFile($inputFilePath, $outputFilePath)
    {
        $html = file_get_contents($inputFilePath);
        $text = $this->htmlToText($html);
        if (!file_exists(dirname($outputFilePath))) {
            mkdir(dirname($outputFilePath), 0777, true);
        }
        file_put_contents($outputFilePath, $text);
    }
}

class ConverterPage
{

    public function displayBodyContent(): void
    {
        $folderPath = __DIR__ . '/../classes';

        // Отримуємо список усіх файлів у вказаній папці
        $allFiles = scandir($folderPath);

        // Фільтруємо файли .txt та .html
        $txtFiles = preg_grep('/\.txt$/', $allFiles);
        $htmlFiles = preg_grep('/\.html$/', $allFiles);

        // Перетворення .txt файлів у .html
        if (count($txtFiles) > 0) {
            echo '<h3>Содержимое папки с файлами .txt:</h3>';

            foreach ($txtFiles as $txtFile) {
                $filePath = $folderPath . '/' . $txtFile;
                $htmlFilePath = preg_replace('/\.txt$/', '.html', $filePath);

                // Читаємо вміст .txt файлу
                $txtContent = file_get_contents($filePath);

                // Перетворюємо вміст у HTML
                $htmlContent = (new HTMLConverter())->textToHTML($txtContent);

                // Зберігаємо перетворений вміст у новий HTML файл
                file_put_contents($htmlFilePath, $htmlContent);

                echo $txtFile . " преобразован в " . basename($htmlFilePath) . "<br>";
            }
        } else {
            echo '<p>В указанной папке нет файлов .txt.</p>';
        }

        // Перетворення .html файлів у .txt
        if (count($htmlFiles) > 0) {
            echo '<h3>Содержимое папки с файлами .html:</h3>';

            foreach ($htmlFiles as $htmlFile) {
                $filePath = $folderPath . '/' . $htmlFile;
                $txtFilePath = preg_replace('/\.html$/', '.txt', $filePath);

                // Читаємо вміст .html файлу
                $htmlContent = file_get_contents($filePath);

                // Перетворюємо HTML вміст у текст для .txt файлу
                $txtContent = (new HTMLConverter())->htmlToText($htmlContent);

                // Зберігаємо перетворений вміст у новий .txt файл
                file_put_contents($txtFilePath, $txtContent);

                echo $htmlFile . " преобразован в " . basename($txtFilePath) . "<br>";
            }
        } else {
            echo '<p>В указанной папке нет файлов .html.</p>';
        }
    }
}

?>