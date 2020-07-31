<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/db/connect.php';


//CREATE article;
$sql4='INSERT INTO grouplevel1 (name, description)VALUES
("Ward 23","This is ward 23 chaired by Mr. Simon Okoli, 08124117040")
,("Ward 24","This is ward 24 chaired by Mr. Jude Nnajiofo, 08066423302")
,("Ward 25 and 26","This is ward 25 and 26 chaired by Mr. Paul Nzokwe and Mr. Pius Mmaduekwe")
,("Ward 27 and 28","This is ward 27 and 28 chaired by Mr. Edozie Exeanya, 08033858758")
,("Ward 29","This is ward 29 chaired by Mr. Ikechukwu Okoye, 08054142115")
,("Ward 30 and 31","This is ward 30 and 31 chaired by Mr. Onyawue Dan, 08065431296")
,("Ward 31","This is ward 32 chaired by Nze Ezenwata Ijezie, 08033248845 ,Mr. Paulinus Okoli, 080664114466, Mr. Albert Okeke, 08034108104")
,("Ward 34","This is ward 35 chaired by Mr. Cyril Nwsikwu; 08027907927 and  Mr. Samuel Ubah; 08029694992")';

if(!mysqli_query($link,$sql4)){
    $error = mysqli_error($link).' unable to insert into grouplevel1';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}
//CREATED DONATION;

//CREATE article;
$sql4='INSERT INTO grouplevel2 (name, description,grouplevel1id)VALUES
("Umuagu Village / Kindred","This is about umuagu Village / kindred in ward 23 ihite igboukwu",1),
("Uhuana Village / Kindred","This is about uhuana Village / kindred in ward 24 ihite igboukwu",2),
("Enuana Dege Village / Kindred","This is about enuana Village / kindred in ward 25 and 26 ihite igboukwu",3),
("Ihuakaba Village / Kindred","This is about ihuakaba Village / kindred in ward 27 and 28 ihite igboukwu",4),
("Etitinabo Village / Kindred","This is about Etitinabo Village / kindred in ward 29 ihite igboukwu",5),
("Ihuekiri Village / Kindred","This is about Ihuekiri Village / kindred in ward 30 and 31 ihite igboukwu",6),
("Ezigbo Village / Kindred","This is about umuagu Village / kindred in ward 32,33,34 ihite igboukwu",7),
("Etiti Village / Kindred","This is about umuagu Village / kindred in ward 35 and 36 ihite igboukwu",8)
';

if(!mysqli_query($link,$sql4)){
    $error = mysqli_error($link).' unable to insert into grouplevel2';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}
//CREATED DONATION;

//CREATE article;
$sql4='INSERT INTO grouplevel3 (name, description,grouplevel1id,grouplevel2id)VALUES
("Umuogbuanu family","This is a family in ward 23 ihite igboukwu",1,1),
("Umuezebidonu  family","This is a family in ward 23 ihite igboukwu",1,1),
("Umuezeokelo family","This is a family in ward 23 ihite igboukwu",1,1),
("Umu umebokosi family","This is a family in ward 23 ihite igboukwu",1,1),
("Umuatunagwam family","This is a family in ward 23 ihite igboukwu",1,1),
("Umuoyiri ihe family","This is a family in ward 23 ihite igboukwu",1,1),
("Umuezeaghadusi family","This is a family in ward 23 ihite igboukwu",1,1),
("Umuaguluefo family","This is a family in ward 23 ihite igboukwu",1,1)
';

if(!mysqli_query($link,$sql4)){
    $error = mysqli_error($link).' unable to insert into grouplevel2';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}
//CREATED DONATION;

?>