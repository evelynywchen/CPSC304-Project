create table Animals(
    aID     int not null,
    species char(40) not null,
    age     int,
    PRIMARY KEY(aID));

create table Carnivores(
    aID int,
    cID int,
    PRIMARY KEY (cID),
    FOREIGN KEY (aID) REFERENCES Animals ON DELETE CASCADE);

create table Omnivores(
    aID int,
    oID int,
    PRIMARY KEY (oID),
    FOREIGN KEY (aID) REFERENCES Animals ON DELETE CASCADE);

create table Herbivores(
    aID int,
    hID int,
    PRIMARY KEY (hID),
    FOREIGN KEY (aID) REFERENCES Animals ON DELETE CASCADE);

create table Plants(
    plantID         integer,
    species         char(40),
    PRIMARY KEY(plantID));

create table Eats_Animal_C(
    cID         int,
    aID         int,
    location_AC    char(40),
    PRIMARY KEY (cID, aID),
    FOREIGN KEY(cID) REFERENCES Carnivores,
    FOREIGN KEY(aID) REFERENCES Animals);

create table Eats_Animal_O(
    oID         int,
    aID         int,
    location_AO char(40),
    PRIMARY KEY (oID, aID),
    FOREIGN KEY(oID) REFERENCES Omnivores,
    FOREIGN KEY(aID) REFERENCES Animals);

create table Eats_Plant(
    aID         int,
    plantID     int,
    PRIMARY KEY (aID, plantID),
    FOREIGN KEY(aID) REFERENCES Animals,
    FOREIGN KEY(plantID) REFERENCES Plants);

create table Habitat(
    habID           integer,
    location_H      char(40),
    type_H          char(40),
    temperature     integer,
    PRIMARY KEY(habID));

create table Organization(
    org_name        char(40),
    oID             integer UNIQUE,
    funds           integer,
    founded         integer,
    size_org            integer,
    primary key (org_name));

create table Has_Subsidiary(
    org_name        char(40),
    sub_name        char(40),
    hsID            integer UNIQUE,
    funds           integer,
    founded         integer,
    size_sub        integer,
    primary key (sub_name),
    foreign key (org_name) REFERENCES Organization);

create table People(
    name_people     char(40),
    pID             integer,
    age             integer,
    primary key (pID));

create table ArtificialStructures(
    asID            integer,
    type_AS         char(40),
    size_AS         char(20),
    location_AS     char(40),
    PRIMARY KEY(asID));

create table Resources(
    resID           integer,
    type_R          char(40),
    location_R      char(40),
    PRIMARY KEY(resID));

create table Consume(
    aID             integer,
    resID           integer,
    species         char(40),
    PRIMARY KEY(aID, resID),
    FOREIGN KEY(aID) REFERENCES Animals ON DELETE CASCADE,
    FOREIGN KEY(resID) REFERENCES Resources ON DELETE CASCADE);

create table Builds_AS(
    completionYear  integer,
    cost_AS         integer,
    asID            integer,
    habID           integer,
    org_name        char(40),
    sub_name        char(40),
    PRIMARY KEY(asID),
    FOREIGN KEY(habID) REFERENCES Habitat ON DELETE CASCADE,
    FOREIGN KEY(sub_name) REFERENCES Has_Subsidiary ON DELETE CASCADE,
    FOREIGN KEY(org_name) REFERENCES Organization ON DELETE CASCADE);

create table Extracts(
    resID           integer,
    asID            integer,
    PRIMARY KEY(resID, asID),
    FOREIGN KEY(resID) REFERENCES Resources ON DELETE CASCADE,
    FOREIGN KEY(asID) REFERENCES ArtificialStructures ON DELETE CASCADE);

create table Owns(
    pID                     integer,
    org_name                char(40),
    ownership_percentage    integer,
    PRIMARY KEY(pID, org_name),
    FOREIGN KEY(pID) REFERENCES People ON DELETE CASCADE,
    FOREIGN KEY(org_name) REFERENCES Organization ON DELETE CASCADE);

create table Lives_Plant(
    plantID         integer,
    habID           integer,
    PRIMARY KEY(plantID, habID),
    FOREIGN KEY(plantID) REFERENCES Plants,
    FOREIGN KEY(habID) REFERENCES Habitat);

create table Lives_A(
    aID             integer,
    habID           integer,
    PRIMARY KEY(aID, habID),
    FOREIGN KEY(aID) REFERENCES Animals,
    FOREIGN KEY(habID) REFERENCES Habitat);

insert into Animals
values(0,'Ailuropoda melanoleuca', 6);

insert into Animals
values(22,'Ailuropoda melanoleuca', 8);

insert into Animals
values(1, 'Phascolarctos cinereus', 3);

insert into Animals
values(2, 'Brachiosaurus altithorax', 21);

insert into Animals
values(20, 'Brachiosaurus altithorax', 1);

insert into Animals
values(3, 'Hydrochoerus hydrochaeris', 35);

insert into Animals
values(4, 'Erethizon dorsatum', 30);

insert into Animals
values(5, 'Notaden bennettii', 7);

insert into Animals
values(6, 'Otocolobus manul', 4);

insert into Animals
values(7, 'Ursus maritimus', 3);

insert into Animals
values(8, 'atelopus zeteki', 3);

insert into Animals
values(9, 'Ambystoma mexicanum', 8);

insert into Animals
values(10, 'mola mola', 3);

insert into Animals
values(11, 'gorilla gorilla gorilla', 21);

insert into Animals
values(12, 'pica pica pica', 2);

insert into Animals
values(15, 'pica pica pica', 3);

insert into Animals
values(16, 'pica pica pica', 1);

insert into Animals
values(17, 'pica pica pica', 3);

insert into Animals
values(13, 'boops boops', 11);

insert into Animals
values(18, 'boops boops', 5);

insert into Animals
values(19, 'boops boops', 9);

insert into Animals
values(14, 'Chlamyphorus truncatus', 4);

insert into Animals
values(21, 'Chlamyphorus truncatus', 8);

insert into Animals
values(24,'Ailuropoda melanoleuca', 6);

insert into Animals
values(25,'Ailuropoda melanoleuca', 8);

insert into Animals
values(26, 'Phascolarctos cinereus', 3);

insert into Animals
values(27, 'Brachiosaurus altithorax', 21);

insert into Animals
values(28, 'Brachiosaurus altithorax', 1);

insert into Animals
values(29, 'Hydrochoerus hydrochaeris', 35);

insert into Animals
values(30, 'Erethizon dorsatum', 30);

insert into Animals
values(31, 'Erethizon dorsatum', 7);

insert into Animals
values(32, 'Otocolobus manul', 4);

insert into Animals
values(33, 'Ursus maritimus', 3);

insert into Animals
values(34, 'Ursus maritimus', 3);

insert into Animals
values(35, 'Ursus maritimus', 8);

insert into Animals
values(37, 'gorilla gorilla gorilla', 21);

insert into Animals
values(38, 'pica pica pica', 2);

insert into Animals
values(39, 'pica pica pica', 3);

insert into Animals
values(40, 'pica pica pica', 1);

insert into Animals
values(41, 'pica pica pica', 3);

insert into Animals
values(42, 'boops boops', 11);

insert into Animals
values(43, 'boops boops', 5);

insert into Animals
values(44, 'boops boops', 9);

insert into Animals
values(45, 'Chlamyphorus truncatus', 4);

insert into Animals
values(46, 'Chlamyphorus truncatus', 8);

insert into Herbivores
values(0, 0);

insert into Herbivores
values(1, 1);

insert into Herbivores
values(2, 2);

insert into Herbivores
values(3, 3);

insert into Herbivores
values(4, 4);

insert into Carnivores
values(5, 0);

insert into Carnivores
values(6, 1);

insert into Carnivores
values(7, 2);

insert into Carnivores
values(8, 3);

insert into Carnivores
values(9, 4);

insert into Omnivores
values(10, 0);

insert into Omnivores
values(11, 1);

insert into Omnivores
values(12, 2);

insert into Omnivores
values(13, 3);

insert into Omnivores
values(14, 4);

insert into Plants
values(0, 'strawberry');

insert into Plants
values(1, 'banana');

insert into Plants
values(2, 'blueberry');

insert into Plants
values(3, 'blackberry');

insert into Plants
values(4, 'raspberry');

insert into Eats_Animal_C
values(0, 10, 'Vancouver');

insert into Eats_Animal_C
values(1, 11, 'Berlin');

insert into Eats_Animal_C
values(2, 12, 'Brussels');

insert into Eats_Animal_C
values(3, 13, 'Seoul');

insert into Eats_Animal_C
values(4, 14, 'Madagascar');

insert into Eats_Animal_O
values(0, 0, 'Kuala Lumpur');

insert into Eats_Animal_O
values(1, 1, 'Chicago');

insert into Eats_Animal_O
values(2, 2, 'St. Petersburg');

insert into Eats_Animal_O
values(3, 3, 'Ho Chi Minh City');

insert into Eats_Animal_O
values(4, 4, 'Manilla');

insert into Eats_Plant
values(0, 4);

insert into Eats_Plant
values(1, 3);

insert into Eats_Plant
values(2, 2);

insert into Eats_Plant
values(3, 1);

insert into Eats_Plant
values(4, 0);

insert into Eats_Plant
values(0, 0);

insert into Eats_Plant
values(0, 1);

insert into Eats_Plant
values(0, 2);

insert into Eats_Plant
values(0, 3);

insert into Eats_Plant
values(3, 0);

insert into Eats_Plant
values(3, 2);

insert into Eats_Plant
values(3, 3);

insert into Eats_Plant
values(3, 4);

insert into Eats_Plant
values(7, 0);

insert into Eats_Plant
values(7, 1);

insert into Eats_Plant
values(7, 2);

insert into Eats_Plant
values(7, 3);

insert into Eats_Plant
values(7, 4);

insert into Habitat
values(0, 'Vancouver', 'Temperate Rainforest', 10);

insert into Habitat
values(1, 'Iqaluit', 'Tundra', -10);

insert into Habitat
values(2, 'Phoenix', 'Desert', 40);

insert into Habitat
values(3, 'Calgary', 'Grassland', 17);

insert into Habitat
values(4, 'Kota Kinabalu', 'Tropical Rainforest', 30);

insert into Lives_A
values(0, 0);

insert into Lives_A
values(1, 1);

insert into Lives_A
values(2, 3);

insert into Lives_A
values(3, 2);

insert into Lives_A
values(4, 4);

insert into Lives_Plant
values(0, 1);

insert into Lives_Plant
values(1, 2);

insert into Lives_Plant
values(2, 3);

insert into Lives_Plant
values(3, 4);

insert into Lives_Plant
values(4, 0);

insert into ArtificialStructures
values(0, 'bulldozer', 'not very big', 'Kuala Lumpur');

insert into ArtificialStructures
values(1, 'oil platform', 'very big', 'Vancouver');

insert into ArtificialStructures
values(2, 'water purification plant', 'very big', 'Berlin');

insert into ArtificialStructures
values(3, 'mine', 'very very deep', 'Madagascar');

insert into ArtificialStructures
values(4, 'utility pole', 'very tall', 'Chicago');

insert into Organization
values('dino oil ltd', 0, 10000000, 1945,10000);

insert into Organization
values('death to pandas ltd', 1, 8000000, 1976,7000);

insert into Organization
values('roasted axolotls ltd', 2, 7000000, 1967,9000);

insert into Organization
values('save the axolotls ltd', 3, 4000, 1968,100);

insert into Organization
values('kil kill killl ltd', 4, 12000000, 1865, 30000);

insert into Organization
values('save save save ltd', 5, 2000000, 1999, 20000);

insert into Organization
values('we love plastics ltd', 6, 60000, 2000, 200);

insert into Organization
values('we dont love plastics ltd', 7, 40000, 2003, 300);

insert into Organization
values('we love money ltd', 8, 600000, 2000, 2000);

insert into Organization
values('we dont love money ltd', 9, 25000, 1700, 200);

insert into Has_Subsidiary
values('save the axolotls ltd', 'save the pandas ltd', 5, 1000, 1982, 40);

insert into Has_Subsidiary
values('kil kill killl ltd', 'mass extinction ltd', 6, 20000, 1970, 2000);

insert into Has_Subsidiary
values('roasted axolotls ltd', 'roasted pandas ltd', 7, 30000, 1981, 1000);

insert into Has_Subsidiary
values('roasted axolotls ltd', 'roasted zebras ltd', 8, 30000, 1981, 1000);

insert into Has_Subsidiary
values('dino oil ltd', 'dino plastics ltd', 9, 30000, 1952, 3000);

insert into People
values('John Doe', 0, 42);

insert into People
values('Li Shi Min', 1, 19);

insert into People
values('Ying Zheng', 2, 19);

insert into People
values('Mahatma Gandhi', 3, 19);

insert into People
values('Shaka kaSenzangakhona', 4, 37);

insert into Owns
values(4, 'dino oil ltd', 20);

insert into Owns
values(4, 'death to pandas ltd', 20);

insert into Owns
values(3, 'dino oil ltd', 10);

insert into Owns
values(3, 'kil kill killl ltd', 30);

insert into Owns
values(2, 'save the axolotls ltd', 30);

insert into Owns
values(2, 'roasted axolotls ltd', 30);

insert into Owns
values(1, 'roasted axolotls ltd', 30);

insert into Builds_AS
values(2000, 60000, 0, 0, 'kil kill killl ltd', 'mass extinction ltd');

insert into Builds_AS
values(2001, 100000, 1, 1, 'dino oil ltd', NULL);

insert into Builds_AS
values(2002, 100000, 2, 2, 'save the axolotls ltd', NULL);

insert into Builds_AS
values(2003, 100000, 3, 3, 'roasted axolotls ltd', 'roasted pandas ltd');

insert into Builds_AS
values(2004, 100000, 4, 4, 'save the axolotls ltd', 'save the pandas ltd');

insert into Resources
values(0, 'water', 'Deer Lake');

insert into Resources
values(1, 'water', 'Burnaby Lake');

insert into Resources
values(2, 'asbestos', 'Asbestos');

insert into Resources
values(3, 'oil', 'Ghawar Field');

insert into Resources
values(4, 'uranium', 'McArthur River');

insert into Consume
values(13, 0, 'boops boops');

insert into Consume
values(13, 1, 'boops boops');

insert into Consume
values(2, 1, 'Brachiosaurus altithorax');

insert into Consume
values(2, 0, 'Brachiosaurus altithorax');

insert into Consume
values(9, 0, 'Ambystoma mexicanum');

Insert into Extracts
values(3, 1);

Insert into Extracts
values(0, 2);

Insert into Extracts
values(1, 2);

Insert into Extracts
values(2, 3);

Insert into Extracts
values(4, 3);

select table_name from user_tables;
