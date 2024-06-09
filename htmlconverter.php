<?php
require_once 'models\HTMLConverter.php';

$converter = new HTMLConverter();
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['convert_text_to_html'])) {
        $text = $_POST['text'];
        $convertedHtml = $converter->textToHTML($text);
    } elseif (isset($_POST['convert_html_to_text'])) {
        $html = $_POST['html'];
        $convertedText = $converter->htmlToText($html);
    } elseif (isset($_POST['convert_text_file_to_html'])) {
        $inputFile = $_FILES['text_file']['tmp_name'];
        $outputFile = 'uploads/converted_text_to_html.html';
        $converter->textFileToHTMLFile($inputFile, $outputFile);
        $message = "Текстовий файл був перетворений в HTML-файл: <a href='$outputFile'>$outputFile</a>";
    } elseif (isset($_POST['convert_html_file_to_text'])) {
        $inputFile = $_FILES['html_file']['tmp_name'];
        $outputFile = 'uploads/converted_html_to_text.txt';
        $converter->htmlFileToTextFile($inputFile, $outputFile);
        $message = "HTML-файл був перетворений в текстовий файл: <a href='$outputFile'>$outputFile</a>";
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Перетворення тексту та HTML</title>
</head>
<body>
    <h1>Перетворення тексту та HTML</h1>

    <h2>Перетворення тексту в HTML</h2>
    <form method="POST">
        <textarea name="text" rows="5" cols="50" placeholder="Введіть текст тут..."></textarea><br>
        <button type="submit" name="convert_text_to_html">Перетворити в HTML</button>
    </form>
    <?php if (isset($convertedHtml)): ?>
        <h3>Результат:</h3>
        <div style="border:1px solid #000; padding:10px;">
            <?php echo $convertedHtml; ?>
        </div>
    <?php endif; ?>

    <h2>Перетворення HTML в текст</h2>
    <form method="POST">
        <textarea name="html" rows="5" cols="50" placeholder="Введіть HTML тут..."></textarea><br>
        <button type="submit" name="convert_html_to_text">Перетворити в текст</button>
    </form>
    <?php if (isset($convertedText)): ?>
        <h3>Результат:</h3>
        <div style="border:1px solid #000; padding:10px;">
            <?php echo $convertedText; ?>
        </div>
    <?php endif; ?>

    <h2>Перетворення текстового файлу в HTML-файл</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="text_file" accept=".txt"><br>
        <button type="submit" name="convert_text_file_to_html">Перетворити текстовий файл в HTML-файл</button>
    </form>

    <h2>Перетворення HTML-файлу в текстовий файл</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="html_file" accept=".html,.htm"><br>
        <button type="submit" name="convert_html_file_to_text">Перетворити HTML-файл в текстовий файл</button>
    </form>

    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
</body>
</html>
