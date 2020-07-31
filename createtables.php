<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/db/connect.php';


//create
$sql5='CREATE TABLE grouplevel1article(
	articleid INT(6),
	groupid INT(3),
	PRIMARY KEY (articleid,groupid)
	)DEFAULT CHARSET UTF8';

if(!mysqli_query($link,$sql5)){
    $error = mysqli_error($link).' unable create clusteruser';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}

//create
$sql5='CREATE TABLE grouplevel2article(
	articleid INT(6),
	groupid INT(3),
	PRIMARY KEY (articleid,groupid)
	)DEFAULT CHARSET UTF8';

if(!mysqli_query($link,$sql5)){
    $error = mysqli_error($link).' unable create clusteruser';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}

//create
$sql5='CREATE TABLE grouplevel3article(
	articleid INT(6),
	groupid INT(3),
	PRIMARY KEY (articleid,groupid)
	)DEFAULT CHARSET UTF8';

if(!mysqli_query($link,$sql5)){
    $error = mysqli_error($link).' unable create clusteruser';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}

//create
$sql5='CREATE TABLE grouplevel1(
	id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255),
	description TEXT,
	tableid INT(3) DEFAULT 1
	)DEFAULT CHARSET UTF8';

if(!mysqli_query($link,$sql5)){
    $error = mysqli_error($link).' unable create grouplevel1';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}

//create
$sql5='CREATE TABLE grouplevel2(
	id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255),
	description TEXT,
	grouplevel1id INT(3),
	tableid INT(3) DEFAULT 2
	)DEFAULT CHARSET UTF8';

if(!mysqli_query($link,$sql5)){
    $error = mysqli_error($link).' unable create grouplevel1';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}

//create
$sql5='CREATE TABLE grouplevel3(
	id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255),
	description TEXT,
	grouplevel1id INT(3),
	grouplevel2id INT(3),
	tableid INT(3) DEFAULT 3
	)DEFAULT CHARSET UTF8';

if(!mysqli_query($link,$sql5)){
    $error = mysqli_error($link).' unable create grouplevel1';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}

//create
$sql5='CREATE TABLE clusteruser(
	userid INT(6),
	clusterid INT(3),
	PRIMARY KEY (userid,clusterid)
	)DEFAULT CHARSET UTF8';

if(!mysqli_query($link,$sql5)){
    $error = mysqli_error($link).' unable create clusteruser';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}

//create gallery file;
$sql5='CREATE TABLE galleryfile(
	id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	title VARCHAR(255),
	filename VARCHAR(255),
	displayname VARCHAR(255),
	dateofpublication VARCHAR(255),
	articleid INT(6),
	userid INT(6),
	type VARCHAR(255),
	INDEX filearticleid (articleid),
	INDEX fileuserid (userid)
	)DEFAULT CHARSET UTF8 ENGINE INNODB';

if(!mysqli_query($link,$sql5)){
    $error = mysqli_error($link).' unable create galleryFiles';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit;
}


//create cluster
$sql = "CREATE TABLE cluster(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255),
        note TEXT )";

if(!mysqli_query($link,$sql)){
    $error = mysqli_error($link).' unable to CREATE cluster TABLE';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}
//create temporary user

$sql3='CREATE TABLE temporaryuser(
	id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	firstname VARCHAR(200),
	surname VARCHAR(200),
	email VARCHAR(255) UNIQUE,
	password CHAR(32),
	mobile VARCHAR(32),
	school VARCHAR(255),
	gender ENUM("M", "F"),
	dateofbirth DATE,
	dateofregistration DATE,
	about TEXT,
	profilepic VARCHAR(255),
	locationid INT(3),
	sublocationid INT(3),
	smscount INT(3),
	roleid INT(3),
	grouplevel1id INT(3),
	grouplevel2id INT(3),
	grouplevel3id INT(3),
	rolenote VARCHAR(255),
	public ENUM("Y", "N"),
	paid ENUM("Y", "N"),
	socialid VARCHAR(255),
	lastactivity VARCHAR(255),
	lastnotificationcount INT DEFAULT 0,
	lastdonationcount INT DEFAULT 0,
	lastadvertcount INT DEFAULT 0,
	lastuserpostnotificationcount INT DEFAULT 0,
	facebookid VARCHAR(255),
    INDEX tempuseremailpsaaword (email,password)
	)DEFAULT CHARSET UTF8 ENGINE INNODB';

if(!mysqli_query($link,$sql3)){
    $error = mysqli_error($link).' unable create temporary user';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}

//CREATE article;
$sql4='CREATE TABLE advert(
	id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	title VARCHAR(255),
	adverturl VARCHAR(255),
	detail TEXT,
	imagefile VARCHAR(255),
	advertimagedisplayname VARCHAR(255),
	dateofpublication VARCHAR(255),
	amount VARCHAR(255) DEFAULT 0,
	paid ENUM("Y","N") DEFAULT "N",
	userid INT(6),
	categoryid INT(3),
	placementid INT(3),
	duration INT(3),
	noofviews INT(6) DEFAULT 0,
	public ENUM("Y","N") DEFAULT "N",
	focalareaid INT(3),
	INDEX advertcategoryid (categoryid),
	INDEX advertfocalareaid (focalareaid),
	INDEX advertpublc (public),
	INDEX advertplacementid (placementid)
	)DEFAULT CHARSET UTF8 ENGINE INNODB';

if(!mysqli_query($link,$sql4)){
    $error = mysqli_error($link).' unable create Advert';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}


//CREATE article;
$sql4='CREATE TABLE placement(
	id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255),
	cost VARCHAR(255) DEFAULT 0
	)DEFAULT CHARSET UTF8 ENGINE INNODB';

if(!mysqli_query($link,$sql4)){
    $error = mysqli_error($link).' unable create placement table';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}


//CREATE article;
$sql4='INSERT INTO placement (name, cost)VALUES("Home Page Top","2,000"),
("Home Page side","1,500"),("other pages top","1,500"),("Other page side","1,000")';

if(!mysqli_query($link,$sql4)){
    $error = mysqli_error($link).' unable to insert into placement table';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}
//CREATED DONATION;

$sql = "CREATE TABLE donation(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        firstname VARCHAR(255),
        surname VARCHAR(255),
        email VARCHAR(255),
        profilepic VARCHAR(255),
        mobile VARCHAR(15),
        focalareaid INT(3),
        amount VARCHAR(32),
        dateofpledge DATE,
        note TEXT )";

if(!mysqli_query($link,$sql)){
    $error = mysqli_error($link).' unable to CREATE donation TABLE';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}


$sql = "CREATE TABLE focalarea(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255),
        note TEXT )";

if(!mysqli_query($link,$sql)){
    $error = mysqli_error($link).' unable to CREATE FOCAL areas TABLE';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}


$sql = "INSERT INTO focalarea (name, note) VALUES ('Rural Creativity', 'We are focused on this too'),
('Rural Publicity', 'We are focused on this too')";

if(!mysqli_query($link,$sql)){
    $error = mysqli_error($link).' unable to insert FOCAL areas TABLE';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}

/*
ADD totalsales TO PRODUCT TABLE
add suppliedprice to producttransaction table
add column facebookid,cashinflow,cashoutflow,totalsales,totalrequests to user; and index it for facebook logins;
add totalsales to product
add supplied_qty DECIMAL(6,4)  on producttransaction table;
add index on statusid on producttransaction table;
*/

//create NOTIFICATIONs TABLE FOR COMMENTS;
$sql4='CREATE TABLE level2commentnotification(
	id INT(6) NOT NULL AUTO_INCREMENT,
	dateofpublication VARCHAR(255),
	userid INT(6),
	postid INT(6),
	notificationtypeid INT(6),
	ownerid INT(6),
	marked ENUM("Y","N") DEFAULT "N",
	INDEX CNuserid (userid),
	INDEX CNownrid (ownerid),
	INDEX CNpostid (postid),
	PRIMARY KEY (id,ownerid)
	)	DEFAULT CHARSET UTF8 ENGINE INNODB';

if(!mysqli_query($link,$sql4)){
    $error = mysqli_error($link).' unable create COMMENT notifications';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}


$sql1='CREATE TABLE category(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(64),
	note TINYTEXT,
	parentcategoryid INT(3)
	)DEFAULT CHARSET UTF8';

if(!mysqli_query($link,$sql1)){
    $error = mysqli_error($link).' unable create articlecategory';
    $error2 = mysqli_error($link);
    include  $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}

//creae reply;

//create replies;
$sql4='CREATE TABLE reply(
	id INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	detail TEXT,
	commentimagedisplayname VARCHAR(255),
	dateofpublication VARCHAR(255),
	userid INT(6),
	articleid INT(6),
	commentid INT(6),
	replylevel INT(2),
	noofcomments INT(6) DEFAULT 0,
	nooffollows INT(6) DEFAULT 0,
	public ENUM("Y","N"),
	INDEX replycommentid(commentid),
	INDEX replylevel(replylevel),
	INDEX replyarticleid (articleid)
	)	DEFAULT CHARSET UTF8';

if(!mysqli_query($link,$sql4)){
    $error = mysqli_error($link).' unable create reply';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}


//create usermessage;

$sql1 = 'CREATE TABLE usermessage(
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                detail TINYTEXT,
                dateofpublication VARCHAR(255),
                senderid INT(6),
                receiverid INT(6),
                marked ENUM("Y","N") DEFAULT "N",
                edited ENUM("Y","N") DEFAULT "N",
                INDEX receiverid (receiverid),
                INDEX senderid (senderid),
                INDEX usermessagemarked (marked)
                )DEFAULT CHARSET UTF8 ENGINE INNODB';


if(!mysqli_query($link,$sql1)){
    $error = mysqli_error($link).' unable create USER MESSAGE';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}

//creat transaction stat



//NOTIFICATION;
//create NOTIFICATIONs TABLE FOR COMMENTS;
$sql4='CREATE TABLE notification(
	id INT(6) NOT NULL AUTO_INCREMENT,
	dateofpublication VARCHAR(255),
	userid INT(6),
	postid INT(6),
	notificationtypeid INT(6),
	ownerid INT(6),
	marked ENUM("Y","N") DEFAULT "N",
	INDEX notificationuserid (userid),
	INDEX notificationownerid (ownerid),
	PRIMARY KEY (id,ownerid)
	)	DEFAULT CHARSET UTF8 ENGINE INNODB';

if(!mysqli_query($link,$sql4)){
    $error = mysqli_error($link).' unable create COMMENT notifications';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}

//create NOTIFICATIONs TABLE FOR COMMENTS;
$sql4='CREATE TABLE commentnotification(
	id INT(6) NOT NULL AUTO_INCREMENT,
	dateofpublication VARCHAR(255),
	userid INT(6),
	postid INT(6),
	notificationtypeid INT(6),
	ownerid INT(6),
	marked ENUM("Y","N") DEFAULT "N",
	INDEX CNuserid (userid),
	INDEX CNownrid (ownerid),
	INDEX CNpostid (postid),
	PRIMARY KEY (id,ownerid)
	)	DEFAULT CHARSET UTF8 ENGINE INNODB';

if(!mysqli_query($link,$sql4)){
    $error = mysqli_error($link).' unable create COMMENT notifications';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}



//create NOTIFICATIONs TABLE FOR COMMENTS;
$sql4='CREATE TABLE customernotification(
	id INT(6) NOT NULL AUTO_INCREMENT,
	dateofpublication VARCHAR(255),
	userid INT(6),
	postid INT(6),
	notificationtypeid INT(6),
	ownerid INT(6),
	marked ENUM("Y","N") DEFAULT "N",
	INDEX customernotificationuserid (userid),
	PRIMARY KEY (id,ownerid)
	)	DEFAULT CHARSET UTF8 ENGINE INNODB';

if(!mysqli_query($link,$sql4)){
    $error = mysqli_error($link).' unable create customer notifications';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}



//create NOTIFICATIONs;
$sql4='CREATE TABLE notificationtype(
	id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255)
	)	DEFAULT CHARSET UTF8';

if(!mysqli_query($link,$sql4)){
    $error = mysqli_error($link).' unable create notification types';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}
//populate notification types;
$sql2='INSERT INTO notificationtype (name)
 VALUES ("comment"),("level2comment"),("level3comment"),("like article"),("like comment"),
 ("like level2comment"),("like level3comment"),("follow article")';

if(!mysqli_query($link,$sql2)){
    $error = mysqli_error($link).' unable insert notification type';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}



//cfreate action table;
$sql2='CREATE TABLE articleaction(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(32)
	)DEFAULT CHARSET UTF8';

if(!mysqli_query($link,$sql2)){
    $error = mysqli_error($link).' unable create articleaction';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}

//populate action;
$sql2='INSERT INTO articleaction (name)
 VALUES ("level1comment"),("level2comment"),("level3comment"),("follow-article"),
 ("follow-level1comment"),("follow-level2comment"),("follow-level3comment")';

if(!mysqli_query($link,$sql2)){
    $error = mysqli_error($link).' unable insert article actions';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}


$sql2='CREATE TABLE role(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(32)
	)DEFAULT CHARSET UTF8';

if(!mysqli_query($link,$sql2)){
    $error = mysqli_error($link).' unable create role';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}

$sql2='INSERT INTO role (name) VALUES
("Ihite Executive"),("Registered Member"),("Odu And Cabinet"),("Ward Executives"),("Village Executive"),("Kindred Executive"),("Staff")';

if(!mysqli_query($link,$sql2)){
    $error = mysqli_error($link).' unable populate role';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}


$sql5='CREATE TABLE location(
	id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255)
	)DEFAULT CHARSET UTF8';

if(!mysqli_query($link,$sql5)){
    $error = mysqli_error($link).' unable create location';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}

$sql5='CREATE TABLE sublocation(
	id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255),
	locationid INT(3),
	INDEX sublocationlocationid (locationid)
	)DEFAULT CHARSET UTF8 ENGINE INNODB';

if(!mysqli_query($link,$sql5)){
    $error = mysqli_error($link).' unable create sublocation';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}



//CREATE article;
$sql4='CREATE TABLE article(
	id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	title VARCHAR(255),
	detail TEXT,
	articleimagefile VARCHAR(255),
	articleimagedisplayname VARCHAR(255),
	dateofpublication VARCHAR(255),
	userid INT(6),
	categoryid INT(3),
	noofviews INT(6) DEFAULT 0,
	noofcomments INT(6) DEFAULT 0,
	nooffollows INT(6) DEFAULT 0,
	public ENUM("Y","N"),
	focalareaid INT(3),
	clusterid INT(3),
	INDEX articlecategoryid (categoryid),
	INDEX articlefocalareaid (focalareaid),
	INDEX articlepublc (public),
	INDEX articlenoofviews (noofviews),
	INDEX articlenoofcomments (noofcomments)
	)DEFAULT CHARSET UTF8 ENGINE INNODB';

if(!mysqli_query($link,$sql4)){
    $error = mysqli_error($link).' unable create Article';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}

//create wardadmin users;
$sql4='CREATE TABLE blockeduser(
	userid INT(3) PRIMARY KEY
	)DEFAULT CHARSET UTF8';

if(!mysqli_query($link,$sql4)){
    $error = mysqli_error($link).' unable create block user';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}
//end of wardadmin user;


//create wardadmin users;
$sql4='CREATE TABLE superadmin(
	userid INT(3) PRIMARY KEY
	)DEFAULT CHARSET UTF8';

if(!mysqli_query($link,$sql4)){
    $error = mysqli_error($link).' unable create superadmin';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}
//end of superadmin user;


//create wardadmin users;
$sql4='INSERT INTO superadmin (userid) VALUES (1)';

if(!mysqli_query($link,$sql4)){
    $error = mysqli_error($link).' unable INSERT superadmin';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}
//end of superadmin user;


$sql3='CREATE TABLE user(
	id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	firstname VARCHAR(200),
	surname VARCHAR(200),
	email VARCHAR(255) UNIQUE,
	password CHAR(32),
	mobile VARCHAR(32),
	school VARCHAR(255),
	gender ENUM("M", "F"),
	dateofbirth DATE,
	dateofregistration DATE,
	about TEXT,
	profilepic VARCHAR(255),
	locationid INT(3),
	sublocationid INT(3),
	smscount INT(3),
	roleid INT(3),
	grouplevel1id INT(3),
	grouplevel2id INT(3),
	grouplevel3id INT(3),
	rolenote VARCHAR(255),
	public ENUM("Y", "N"),
	paid ENUM("Y", "N"),
	socialid VARCHAR(255),
	lastactivity VARCHAR(255),
	lastarticlescount INT DEFAULT 0,
	lastnotificationcount INT DEFAULT 0,
	lastdonationcount INT DEFAULT 0,
	lastadvertcount INT DEFAULT 0,
	lastuserpostnotificationcount INT DEFAULT 0,
	facebookid VARCHAR(255),
    INDEX userroleid (roleid),
    INDEX usersublocationid (sublocationid),
    INDEX userlocationid (locationid),
    INDEX userlastactivity (lastactivity),
    INDEX useremailpsaaword (email,password)
	)DEFAULT CHARSET UTF8 ENGINE INNODB';

if(!mysqli_query($link,$sql3)){
    $error = mysqli_error($link).' unable create Person';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}



$sql5='CREATE TABLE file(
	id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	title VARCHAR(255),
	filename VARCHAR(255),
	displayname VARCHAR(255),
	articleid INT(6),
	userid INT(6),
	type VARCHAR(255),
	INDEX filearticleid (articleid),
	INDEX fileuserid (userid)
	)DEFAULT CHARSET UTF8 ENGINE INNODB';

if(!mysqli_query($link,$sql5)){
    $error = mysqli_error($link).' unable create Files';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}


$sql2='CREATE TABLE adminfunction(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(32)
	)DEFAULT CHARSET UTF8 ENGINE INNODB';

if(!mysqli_query($link,$sql2)){
    $error = mysqli_error($link).' unable create ADMIN FUNCTION TABLE';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}


$sql2='INSERT INTO category (name) VALUES
("News"),("Announcements"),("Investment Opportunities"),("Culture and Tourism"),("Projects"),("Crafts"),
("Culture"),("Folks"),("General")';

if(!mysqli_query($link,$sql2)){
    $error = mysqli_error($link).' unable to populate article category';
    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}





?>