<?php

header('content-type:text/html;charset=utf-8');

// 建立数据库连接
$mysqli = new mysqli('localhost', 'root', '123456');
if ($mysqli->connect_errno)
    die($mysqli->connect_error);
echo '数据库连接成功<br>';

// 设置客户端编码方式
$mysqli->set_charset('utf8');

/**
 * SELECT/DESC/DESCRIBE/SHOW/EXPLAIN语句执行成功返回mysqli_result对象，执行失败返回false
 * 其它SQL语句执行成功返回true，否则返回false
 */

// 删除数据库test
$res = query($mysqli, 'drop database if exists test;');
echo '删除数据库test'.($res?'成功':'失败').'<br>';

// 创建数据库test
$res = query($mysqli, 'create database if not exists test;');
echo '创建数据库test'.($res?'成功':'失败').'<br>';

// 查看所有数据库
$res = query($mysqli, 'show databases;');
fetchRes($res, 'databases');

// 进入数据库test
$res = query($mysqli, 'use test;');
echo '进入数据库test'.($res?'成功':'失败').'<br>';

// 删除表users
$res = query($mysqli, 'drop table if exists users;');
echo '删除表users'.($res?'成功':'失败').'<br>';

// 创建表users
$sql = <<<EOF
    create table if not exists users(
        id tinyint unsigned auto_increment key,
        name varchar(20) not null unique,
        gender char(1) not null,
        age tinyint(3) unsigned not null,
        nationality varchar(50) default '汉族',
        money float(8,2) unsigned default 1000.00
    ) engine=myisam default charset=utf8;
EOF;
$res = query($mysqli, $sql);
echo '创建表users'.($res?'成功':'失败').'<br>';

// 查看创建表users的命令
$res = query($mysqli, 'show create table users;');
fetchRes($res, 'create users');

// 查看数据库test所有表
$res = query($mysqli, 'show tables;');
fetchRes($res, 'tables in test');

// 查看表users
$res = query($mysqli, 'desc users;');
fetchRes($res, 'users');

// 清空表内容
$res = query($mysqli, 'truncate table users');
echo '清空表users'.($res?'成功':'失败').'<br>';

// 插入数据
$sql = <<<EOF
    insert users(name, gender, age) values
    ('熊大爷', '男', 50),
    ('徐二爷', '男', 51),
    ('张三爷', '男', 52),
    ('李四爷', '男', 53),
    ('王五爷', '男', 54),
    ('赵六爷', '男', 55),
    ('钱七娘', '女', 54),
    ('孙八娘', '女', 53),
    ('周九娘', '女', 52),
    ('吴十娘', '女', 51),
    ('十八姨', '女', 18),
    ('十九姨', '女', 19);
EOF;
$res = query($mysqli, $sql);
if ($res) {
    echo '插入'.$mysqli->affected_rows.'条数据成功<br>';
} else {
    echo '插入数据失败 '.$mysqli->errno.':'.$mysqli->error.'<br>';
}

// 更新数据
$res = query($mysqli, 'update users set age=age+1');
echo '更新数据'.($res?'成功':'失败').'<br>';

// 删除数据
$res = query($mysqli, 'delete from users where age<=20;');
echo '删除数据'.($res?'成功':'失败').'<br>';

// 查询数据
$res = query($mysqli, 'select id,name,age from users where gender="男";');
fetchRes($res, 'read');

// 查询多条语句并返回多个结果集
$sql = 'insert users(name, gender, age) values("十八姨", "女", 18);';
$sql .= 'update users set age=age+1 where age<=20;';
$sql .= 'select * from users;';
$res = $mysqli->multi_query($sql);
if ($res) {
    do {
        if ($mysqli_result=$mysqli->store_result()) {
            $rows = $mysqli_result->fetch_all(MYSQLI_ASSOC);
            $mysqli_result->free();
        }
    } while ($mysqli->more_results() && $mysqli->next_result());
} else {
    echo $mysqli->errno.':'.$mysqli->error;
}

// 预处理语句-插入
$sql = 'insert users(name, gender, age) values(?,?,?)';
$mysqli_stmt = $mysqli->prepare($sql);
$name = '十九姨';
$gender = '女';
$age = 20;
$mysqli_stmt->bind_param('ssi',$name,$gender,$age);
if($mysqli_stmt->execute()){
    echo '插入'.$mysqli_stmt->affected_rows.'条记录<br>';
}else{
	echo $mysqli_stmt->errno.':'.$mysqli_stmt->error;
}
$mysqli_stmt->free_result();
$mysqli_stmt->close();

// 预处理语句-查询
$sql = 'select id,name,age from users where id>=?';
$mysqli_stmt = $mysqli->prepare($sql);
$id = 0;
$mysqli_stmt->bind_param('i', $id);
if ($mysqli_stmt->execute()) {
    $mysqli_stmt->bind_result($id, $name, $age);
    while ($mysqli_stmt->fetch()) {
        echo 'id:'.$id.' name:'.$name.' age:'.$age.'<br>';
    }
}
$mysqli_stmt->free_result();
$mysqli_stmt->close();

// 事务
$mysqli->autocommit(FALSE);
$sql1 = 'update users set money=money-520 where name="赵六爷";';
$res1 = $mysqli->query($sql1);
$rows_num1 = $mysqli->affected_rows;

$sql2 = 'update users set money=money+520 where name="钱七娘";';
$res2 = $mysqli->query($sql2);
$row_num2 = $mysqli->affected_rows;

if ($res1 && $rows_num1>0 && $res2 && $row_num2>0) {
    $mysqli->commit();
    echo '事务执行成功<br>';
    $mysqli->autocommit(TRUE);
} else {
    $mysqli->rollback();
    echo '事务执行失败<br>';
}

// 关闭数据库连接
$mysqli->close();
if ($mysqli->connect_errno)
    die($mysqli->connect_error);
echo '数据库关闭连接成功';

// 数据库查询，返回布尔值或者结果集
function query($mysqli, $sql) {
    return $mysqli->query($sql);
}

// 处理结果集
function fetchRes($res, $info) {
    if ($res && $res->num_rows>0) {
        $rows = $res->fetch_all(MYSQLI_ASSOC);
        echo showTable($rows, $info);
        $res->free();
    } else {
        echo '查询错误或没有记录';
    }
}

// 以table形式显示数据
function showTable($rows, $info) {
    if (!count($rows))
        return 'Empty set<br>';
    $thead = $tbody = '';
    $caption = '<caption>'.$info.'</caption>';
    foreach (array_keys($rows[0]) as $value) {
        $thead .= '<th>'.$value.'</th>';
    }
    $thead = '<thead><tr>'.$thead.'</tr></thead>';
    foreach ($rows as $row) {
        $tr = '';
        foreach ($row as $value) {
            $tr .= '<td>'.$value.'</td>';
        }
        $tbody .= '<tr>'.$tr.'</tr>';
    }
    $tbody = '<tbody align=center>'.$tbody.'</tbody>';
    return '<table border=1 style="border-collapse:collapse">'.$caption.$thead.$tbody.'</table>';
}
