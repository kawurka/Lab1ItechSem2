<!DOCTYPE HTML>
<html>

<head>
    <title>ЛБ1</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<h2>Лабораторна робота №1, КІУКІ-19-6, Тарасов Микола, Варіант №1 </h2>
<form method="get" action="forms.php">
    <p><strong> Вывести расписание занятий группы </strong><select name='groups'>
            <option>Группа</option>
    </p>
        <?php
        include "connection.php";
        $sqlSelect = "SELECT * FROM iteh2lb1var2.groups";
        foreach ($dbh->query($sqlSelect) as $cell) {
            echo "<option>$cell[1]</option>";
        }
        ?>
    </select>
    <input type="submit" value="ok">
</form>

<form method="get" action="forms.php">
    <p><strong>Вывести расписание преподавателя</strong> <select name='teachers'>
            <option>Преподаватели</option>
    </p>

    <?php
    $sqlSelect = "SELECT * FROM iteh2lb1var2.teacher";

    foreach ($dbh->query($sqlSelect) as $cell) {
        echo "<option>$cell[1]</option>";
    } ?>

    </select>
    <input type="submit" value="ok">
</form>

<form method="get" action="forms.php">
    <p><strong>Вывести расписание для аудитории</strong> <select name='auditorium'>
            <option>Аудитория</option>
    </p>
    <?php
    $sqlSelect = "SELECT DISTINCT auditorium FROM iteh2lb1var2.lesson";


    foreach ($dbh->query($sqlSelect) as $cell) {
        echo "<option>$cell[0]</option>";
    }
    ?>
    </select>
    <input type="submit" value="ok">
</form>
<p><b>Добавление нового ПЗ</b></p>
<div id="div">
    <form method="get" action="forms.php" id="form">
        <p>Введите день недели</p>
        <input required name="week_day">
        <p>Введите номер пары</p>
        <input required name="lesson_number" type="number" value="1" min="1" max="6" step="1">
        <p>Введите номер аудитории</p>
        <input required name="auditorium">
        <p>Введите название дисциплины</p>
        <input required name="disciple">
        <p><b> Выберите преподавателя<select name="name">
            <?php
                $sqlSelect = "SELECT * FROM iteh2lb1var2.teacher";
                echo "<option>Преподаватель</option>";
                foreach($dbh->query($sqlSelect) as $cell)
                {   echo "<option>";
                    print_r($cell[1]);
                    echo "</option>";
                }
                echo "</select>" ?>
                Выберите группу<select name ="title" ><?php $sqlSelect = "SELECT * FROM iteh2lb1var2.groups";
                echo "<option>Группа</option>";
                foreach($dbh->query($sqlSelect) as $cell)
                {   echo "<option>";
                    print_r($cell[1]);
                    echo "</option>";
                }
                echo "</select></b></p>" 
                ?>
        <input type="submit" value="Добавить">
    </form>
</div>   
</body>
</html>
