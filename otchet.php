<?php 
	session_start();
	include 'db.php';
	require_once 'vendor/autoload.php';
	require_once 'PhpWord/PhpWord.php';

	$sql1 = "SELECT ID, dateZak, sumZakaza FROM zakazy where DATE_FORMAT(dateZak, '%m') = DATE_FORMAT(NOW(), '%m') - 1";
	$result1 = mysqli_query($connection, $sql1);

	$phpWord = new \PhpOffice\PhpWord\PhpWord();
	$section = $phpWord->addSection();
	$section->addText('Отчёт по прадажам за прошлый месяц', array('name' => 'Times New Roman', 'size' => 16, 'alignment' => 'middle'));
	$section->addText('Дата заказа - Сумма заказа', array('name' => 'Times New Roman', 'size' => 16));
	while($row1 = mysqli_fetch_array($result1)) 
	{
        $section->addText($row1["dateZak"].' - '.$row1["sumZakaza"].'руб.', array('name' => 'Times New Roman', 'size' => 14));
    }

    $sql1 = "SELECT sum(sumZakaza) as konSum FROM zakazy where DATE_FORMAT(dateZak, '%m') = DATE_FORMAT(NOW(), '%m') - 1";
	$result1 = mysqli_query($connection, $sql1);
	$row1 = mysqli_fetch_array($result1);
    $section->addText('Общая сумма заказов за прошлый месяц: '.round($row1["konSum"]).'руб.', array('name' => 'Times New Roman', 'size' => 16, 'bold' => true));

	$writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
	$writer->save('Otchet.docx');

	header("Content-Disposition: attachment; filename=Otchet.docx");
	readfile("Otchet.docx");
?>