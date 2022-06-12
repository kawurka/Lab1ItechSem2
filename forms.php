<!DOCTYPE HTML>
<html>
<head>
<title>ЛБ1</title>
</head>
<?php
include "connection.php";
if(isset($_GET['groups'])){
    $groups = $_GET['groups'];

    $sqlSelect = $dbh->prepare("SELECT * from $db.groups 
    INNER JOIN $db.lesson_groups 
    on $db.groups.ID_Groups = $db.lesson_groups.FID_Groups 
    INNER JOIN $db.lesson 
    on $db.lesson_groups.FID_Lesson2=$db.lesson.ID_Lesson 
    where $db.groups.title = :groups");
    $sqlSelect->execute(array('groups' => $groups));
    echo "<table border ='1'>";
    echo "<tr><th>Group</th><th>Day</th><th>Number</th><th>Auditorium</th><th>Disciple</th><th>Type</th></tr>";
    while($cell=$sqlSelect->fetch(PDO::FETCH_BOTH)){
        echo "<tr><td>$cell[1]</td><td>$cell[5]</td><td>$cell[6]</td><td>$cell[7]</td><td>$cell[8]</td><td>$cell[9]</td></tr>";
    }
    echo "</table>";
}

if(isset($_GET['teachers'])){
    $teachers = $_GET['teachers'];
    $sqlSelect = $dbh->prepare("SELECT * from $db.teacher 
    INNER JOIN $db.lesson_teacher 
    on $db.teacher.ID_teacher = $db.lesson_teacher.FID_teacher 
    INNER JOIN $db.lesson on $db.lesson_teacher.FID_Lesson1=$db.lesson.ID_Lesson 
    where $db.teacher.name = :teachers");
    $sqlSelect->execute(array('teachers' => $teachers));
    echo "<table border ='1'>";
    echo "<tr><th>Teacher</th><th>Day</th><th>Number</th><th>Auditorium</th><th>Disciple</th><th>Type</th></tr>";
    while ($cell = $sqlSelect->fetch(PDO::FETCH_BOTH)) {
    echo "<tr><td>$cell[1]</td><td>$cell[5]</td><td>$cell[6]</td><td>$cell[7]</td><td>$cell[8]</td><td>$cell[9]</td></tr>";
    }
}
if(isset($_GET['auditorium'])){
    $auditorium = $_GET['auditorium'];
    $sqlSelect = $dbh->prepare("SELECT * from $db.lesson 
    where $db.lesson.auditorium = :auditorium");
    $sqlSelect->execute(array('auditorium' => $auditorium));
    echo "<table border ='1'>";
    echo "<tr><th>Auditorium</th><th>Day</th><th>Number</th><th>Disciple</th><th>Type</th></tr>";
    while($cell=$sqlSelect->fetch(PDO::FETCH_BOTH)){
        echo "<tr><td>$cell[3]</td><td>$cell[1]</td><td>$cell[2]</td><td>$cell[4]</td><td>$cell[5]</td></tr>";
    }
    echo "</table>";
}

if( isset($_GET['week_day']) && isset($_GET['lesson_number']) && isset($_GET['auditorium']) && isset($_GET['disciple']) && isset($_GET['name']) && isset($_GET['title'])){

$week_day = $_GET['week_day'];
$lesson_number=$_GET['lesson_number'];
$auditorium=$_GET['auditorium'];
$disciple=$_GET['disciple'];
$type = 'Practical';
$name=$_GET['name'];
$title=$_GET['title'];

try {
    $dbh->exec("set names utf8");
    
    $st= $dbh->prepare(
        "ALTER TABLE $db.lesson 
        CHANGE lesson.ID_Lesson lesson.ID_Lesson INT(10)
        NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 1");
    $st->execute();

    $sql = "INSERT INTO $db.lesson 
        (week_day, lesson_number, auditorium, disciple, type) 
        values ( ?, ?, ?, ?, ?)";
    $stmt= $dbh->prepare($sql);
    $stmt->execute([$week_day, $lesson_number, $auditorium, $disciple, $type]);
    
    $sql = $dbh->prepare("SELECT * from $db.teacher 
        where $db.teacher.name = :name");
    $sql->execute(array('name' => $name));
    $sql=$sql->fetch(PDO::FETCH_BOTH);
    $teacher_id = $sql[0];
    
    $sql = $dbh->prepare("SELECT max(ID_Lesson) from $db.lesson");
    $sql->execute(array());
    $sql=$sql->fetch(PDO::FETCH_BOTH);
    
    $lesson_id = $sql[0];
    $sql = "INSERT INTO $db.lesson_teacher (FID_Teacher, FID_Lesson1) values ( ?, ?)";
    $st = $dbh->prepare($sql);
    $st->execute([$teacher_id, $lesson_id]);
    
    $sql = $dbh->prepare("SELECT * from $db.groups 
        where $db.groups.title = :title");
    $sql->execute(array('title' => $title));
    $sql=$sql->fetch(PDO::FETCH_BOTH);
    $group_id = $sql[0];
   
    $sql = $dbh->prepare("SELECT max(ID_Lesson) from $db.lesson");
    $sql->execute(array());
    $sql=$sql->fetch(PDO::FETCH_BOTH);
    $lesson_id = $sql[0];
    
    $sql = "INSERT INTO $db.lesson_groups (FID_Lesson2, FID_Groups) values ( ?, ?)";
    $st = $dbh->prepare($sql);
    $st->execute([$lesson_id, $group_id]);
    echo "Занесено";
} catch (PDOException $e) {
    print "Ошибка!: " . $e->getMessage() . "<br/>";
}
}
?>