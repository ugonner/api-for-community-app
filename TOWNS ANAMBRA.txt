<?php
include $_SERVER['DOCUMENT_ROOT'].'/bona/includes/db/connect.php';

$sql = 'INSERT INTO state (name) VALUES
("Aguata"),("
Anambra East"),("
Anambra West"),("
Anaocha"),("
Awka North"),("
Awka South "),("
Ayamelum "),("
Dunukofia"),("
Ekwusigo"),("
Idemili North "),("
Idemili South "),("
Ihiala "),("
Njikoka "),("
Nnewi North"),("
Nnewi South "),("
Ogbaru "),("
Onitsha South"),("
Onitsha North"),("
Orumba North"),("
Orumba South"),("
Oyi"),("NA")';


if(!mysqli_query($link,$sql)){
    $error = mysqli_error($link).' unable INSERT LGAS';
    include $_SERVER['DOCUMENT_ROOT'].'/bona/includes/errors/error.html.php';
    exit();
}


$sql = 'INSERT INTO LGA (name,stateid) VALUES
("Achina",1),("Aguluezechukwu",1),("Akpo",1),("Amesi,",1),
("Ekwulobia-HQ",1),("Ezinifite",1),("igboukwu",1),("Ikenga,",1),("Isuofia",1),("Isuanaoma,",1),
("Nkpologuw",1),("Oraeri",1),("Uga",1),("Umuchu",1),("Umuona",1),

("Aguleri",2),("Enugwu-Aguleri",2),("EziAguluotu",2),("Igbariam",2),
("Mkpunando",2),("Nando",2),("Nsugbe",2),("Otuocha",2),("Umuleri",2),
("Umuoba Anam",2),

("Ezi-Anam",3),("Ifite Anam",3),("Nzam-HQ",3),("Olumbanasa",3),
("Orom-Etiti",3),("Umuenwelum Anam",3),("Umueze Anam",3),

("Adazi Ani",4),("Adazi Enu",4),("Adazi Nnukwu",4),
("Agulu",4),("Aguluzigbo",4),("Akweze",4),("Neni-HQ",4),("Obeledu",4),("Nri",4),

("Achalla-HQ",5),("Amansea",5),("Amanuke",5),("Ebenebe",5),("Isu-Aniocha",5),("Mgbakwu",5),
("Oba-Ofemili",5),("Ugbene",5),("Ugbenu",5),("Urum",5),

("Awka-HQ",6),("Amawbia",6),("Ezinato",6),("Isiagu",6),
("MbaUkwu",6),("Nibo",6),("Nise",6),("Okpuno",6),("Umuawulu",6),

("Anaku-HQ",7),("Ifite-Ogwari",7),("Igbakwu",7),("OMOR",7),("Omasi",7),("Umueje",7),
("Umuerum",7),("Umumbo",7),

("Ifite-Dunu",8),("Nawgu",8),("Ukpo-HQ",8),("Umudioka",8),("Umunachi",8),("Ukwulu",8),

("Ichi",9),("Ihembosi",9),("Oraifite",9),("Ozubulu-HQ",9),

("Abacha",10),("Abatete",10),("Eziowelle",10),("Ideani",10),
("Nkpor",10),("Obosi",10),("Ogidi-HQ",10),("Oraukwu",10),("Uke",10),("Umuoji",10),

("Akwaukwu",11),("Alor",11),("Awka-Etiti",11),("Nnobi",11),
("Nnokwa",11),("Oba",11),("Ojotoo",11),

("Amorka",12),("Azia",12),("Ihiala-HQ",12),("Iseke",12),("Mbosi",12),("Okija",12),
("Orsumoghu",12),("Ubuluzor",12),("Uli",12),

("Abagana-HQ",13),("Abba",13),("Enugwu-Agidi",13),("Enugwu-Ukwu",13),("Nawfia",13),("Nimo",13),


("Nnewi Town-HQ",14),

("Akwaihedi",15),("Amichi",15),("Azigbo",15),("Ebenator",15),
("Ekwulumili",15),("Ezinifite",15),("Ogbodi",15),("Osumenyi",15),("Unubi",15),
("Ukpor-HQ",15),("Utu",15),

("Akili-ogidi",16),("Akili-Ozizo",16),("Amiyi",16),("Atani-HQ",16),
("Mputu",16),("Obeagwo",16),("Ochuche",16),("Odekpe",16),("Ogbakuba",16),("Ogwu-Anocha",16),
("Ogwu-Ikpere",16),("Ohita",16),("Okpoko",16),("Ossomala",16),
("Umunamkwo",16),("Umuuodu",16),("Umuzu",16),

("Fegge-HQ",17),("Onitsha",17),

("Omitsha",18),

("Ajali-HQ",19),("Amaetiti",19),("Amaokpala",19),("Awa",19),("Awgbu",19),("Nanka",19),
("Ndikelionwu",19),("Ndiokpalaeke",19),("Ndiokpalaeze",19),("Ndiokolo",19),("Ndiowu",19),
("Ndiukwuenu",19),("Oko",19),("Okpeze",19),("Omogho",19),("Ufuma",19),

("Agbudu",20),("Akata",20),("Akpu",20),("akwaosa",20),("Alaohia",20),("Enugwu-Umuonyia",20),
("Eziagu",20),("Ezira",20),("Ihite",20),("Isulo",20),("Nawfija",20),("Nkerehi",20),
("Ogboji",20),("Ogbunka",20),("Obuluhu",20),("Onneh",20),("Owerre-Ezukala",20),
("Ubaha",20),("Uhuala",20),("Umunze-HQ",20),("Umuomaku",20),

("Awkuzu",21),("Nkwere-Ezunaka",21),("Nteje",21),("Ogbunike",21),("Umunya",21),

("NA",22)';

if(!mysqli_query($link,$sql)){
    $error = mysqli_error($link).' unable INSERT states';
    include $_SERVER['DOCUMENT_ROOT'].'/bona/includes/errors/error.html.php';
    exit();
}
?>