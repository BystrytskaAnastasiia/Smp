<?php
session_start();

// Очищаємо всі дані сесії
session_unset();

// Знищуємо сесію
session_destroy();

// Перенаправляємо користувача на головну сторінку
header("Location: index.php");
exit();