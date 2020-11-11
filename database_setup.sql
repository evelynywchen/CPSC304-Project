create table Animals(
	aID     int not null,
    species char(40) not null,
	age     int,
	amount  int,
    PRIMARY KEY(aID));

create table Carnivores(
    aID int,
    cID int,
    PRIMARY KEY (aID),
	FOREIGN KEY (aID) REFERENCES Animals ON DELETE CASCADE);

create table Omnivores(
    aID int,
    oID int,
	PRIMARY KEY (aID),
	FOREIGN KEY (aID) REFERENCES Animals ON DELETE CASCADE);

create table Herbivores(
    aID int,
    hID int,
	PRIMARY KEY (aID),
	FOREIGN KEY (aID) REFERENCES Animals ON DELETE CASCADE);

create table Plants(
    plantID 		integer,
	species		    char(40),
    population		integer,
	PRIMARY KEY(plantID));

create table Eats_Animal_C(
	cID	        int,
	aID	        int,
	location_AC    char(40),
    PRIMARY KEY (aID),
    FOREIGN KEY(cID) REFERENCES Carnivores,
    FOREIGN KEY(aID) REFERENCES Animals);

create table Eats_Animal_O(
	oID	        int,
	aID	        int,
	location_AO	char(40),
    PRIMARY KEY (aID),
    FOREIGN KEY(oID) REFERENCES Omnivores,
    FOREIGN KEY(aID) REFERENCES Animals);

create table Eats_Plant(
	aID         int,
	plantID     int,
    PRIMARY KEY (plantID),
    FOREIGN KEY(aID) REFERENCES Animals,
    FOREIGN KEY(plantID) REFERENCES Plants);

create table Habitat(
    habID			integer,
    location_H		char(40),
    type_H			char(40),
	temperature	    integer,
	PRIMARY KEY(habID));

create table Lives_Plant(
	plantID		    integer,
    habID			integer,
    PRIMARY KEY(plantID),
	FOREIGN KEY(habID) REFERENCES Habitat ON DELETE CASCADE);  --ON DELETE NO ACTION ON UPDATE CASCADE

create table Lives_A(
    aID			integer,
    habID			integer,
    PRIMARY KEY(aID),
	FOREIGN KEY(habID) REFERENCES Habitat ON DELETE CASCADE);  -- ON DELETE NO ACTION ON UPDATE CASCADE

create table Organization(
    org_name        char(40),
    oID			    integer UNIQUE,
    funds     	 	integer,
    founded     	integer,
    size_org			integer,
    primary key (org_name));

create table Has_Subsidiary(
    org_name        char(40),
    sub_name        char(40),
	hsID			integer UNIQUE,
    funds     	 	integer,
    founded     	integer,
    size_sub		integer,
    primary key (sub_name),
    foreign key (org_name) REFERENCES Organization);

create table People(
    name_people 			char(40),
    pID				integer,
    age    	 	 	integer,
    primary key (pID));

create table ArtificialStructures(
    asID			integer,
    type_AS			char(40),
    size_AS			char(20),
    location_AS 	char(40),
    qty			    integer,
	PRIMARY KEY(asID));

create table Resources(
    resID			integer,
    type_R			char(40),
    location_R		char(40),
	PRIMARY KEY(resID));

create table Consume(
    aID 			integer,
    resID			integer,
    species		    char(40),
	qty			    integer,
    PRIMARY KEY(aID, resID),
    FOREIGN KEY(aID) REFERENCES Animals ON DELETE CASCADE,
	FOREIGN KEY(resID) REFERENCES Resources ON DELETE CASCADE);

create table Builds_AS(
    completionYear 	integer,
    cost_AS			integer,
    asID			integer,
	habID 		    integer,
    org_name		char(40),
    sub_name		char(40),
    PRIMARY KEY(asID),
    FOREIGN KEY(habID) REFERENCES Habitat ON DELETE CASCADE,
    FOREIGN KEY(sub_name) REFERENCES Has_Subsidiary ON DELETE CASCADE,
    FOREIGN KEY(org_name) REFERENCES Organization ON DELETE CASCADE);

create table Extracts(
	resID 		    integer,
    asID			integer,
	qty			    integer,
    PRIMARY KEY(resID,asID),
    FOREIGN KEY(resID) REFERENCES Resources ON DELETE CASCADE,
	FOREIGN KEY(asID) REFERENCES ArtificialStructures ON DELETE CASCADE);

create table Owns(
	pID			            char(40),
	org_name		        char(40),
	ownership_percentage    integer,
	PRIMARY KEY(pID, org_name),
    FOREIGN KEY(pID) REFERENCES People ON DELETE CASCADE,
	FOREIGN KEY(org_name) REFERENCES Organization ON DELETE CASCADE);

insert into Animals
values(0,'Ailuropoda melanoleuca', 6, 2070);

insert into Animals
values(1, 'Phascolarctos cinereus', 3, 6370);

insert into Animals
values(2, 'Brachiosaurus altithorax', 21, 459);

insert into Animals
values(3, 'Hydrochoerus hydrochaeris', 35, 2349);

insert into Animals
values(4, 'Erethizon dorsatum', 30, 2594);

insert into Animals
values(5, 'Notaden bennettii', 7, 1000);

insert into Animals
values(6, 'Otocolobus manul', 4, 8000);

insert into Animals
values(7, 'Ursus maritimus', 3, 500);

insert into Animals
values(8, 'atelopus zeteki', 3, 2000);

insert into Animals
values(9, 'Ambystoma mexicanum', 8, 100);

insert into Animals
values(10, 'mola mola', 3, 5000);

insert into Animals
values(11, 'gorilla gorilla gorilla', 21, 400);

insert into Animals
values(12, 'pica pica pica', 2, 1200);

insert into Animals
values(13, 'boops boops', 11, 200);

insert into Animals
values(14, 'Chlamyphorus truncatus', 4, 1204);

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

insert into Eats_Animal_C
values(0, 1, 'Vancouver');

insert into Eats_Animal_C
values(1, 2, 'Berlin');

insert into Eats_Animal_C
values(2, 3, 'Brussels');

insert into Eats_Animal_C
values(3, 4, 'Seoul');

insert into Eats_Animal_C
values(4, 0, 'Madagascar');

insert into Eats_Animal_O
values(0, 5, 'Kuala Lumpur');

insert into Eats_Animal_O
values(1, 6, 'Chicago');

insert into Eats_Animal_O
values(2, 7, 'St. Petersburg');

insert into Eats_Animal_O
values(3, 8, 'Saigon');

insert into Eats_Animal_O
values(4, 9, 'Manilla');

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

insert into Plants
values(0, 'strawberry', 1000);

insert into Plants
values(1, 'banana', 1000);

insert into Plants
values(2, 'blueberry', 5000);

insert into Plants
values(3, 'blackberry', 1020);

insert into Plants
values(4, 'raspberry', 88050);

insert into Lives_A
values(0, 0);

insert into Lives_A
values(1, 7);

insert into Lives_A
values(2, 3);

insert into Lives_A
values(3, 2);

insert into Lives_A
values(4, 8);

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

insert into ArtificialStructures
values(0, 'bulldozer', 'not very big', 2);

insert into ArtificialStructures
values(1, 'oil platform', 'very big', 100);

insert into ArtificialStructures
values(2, 'water purification plant', 'very big', 2);

insert into ArtificialStructures
values(3, 'mine', 'very very deep', 5);

insert into ArtificialStructures
values(4, 'utility pole', 'very tall', 2);

Insert into Extracts
values(3, 1, 1000);

Insert into Extracts
values(0, 2, 1000000);

Insert into Extracts
values(1, 2, 1000000);

Insert into Extracts
values(2, 3, 1000);

Insert into Extracts
values(4, 3, 100);

insert into Builds_AS
values(2000, 60000, 0, 0, 'kil kill killl ltd', 'mass extinction ltd');

insert into Builds_AS
values(2001, 100000, 1, 1, 'dino oil ltd');

insert into Builds_AS
values(2002, 100000, 2, 2, 'save the axolotls ltd');

insert into Builds_AS
values(2003, 100000, 3, 3, 'roasted pandas ltd', 'roasted axolotls ltd');

insert into Builds_AS
values(2004, 100000, 4, 4, 'save the pandas ltd', 'save the axolotls ltd');

insert into Organization
values('dino oil ltd', 0, 10000000, 1945,10000);

insert into Organization
values('death to pandas ltd', 1, 8000000, 1976,7000);

insert into Organization
values('roasted axolotls ltd', 2, 7000000, 1967,9000);

insert into Organization
values('save the axolotls ltd', 3, 4000, 1968,100);

insert into Organization
values('kil kill killl ltd', 4, 12000000, 1865,30000);

insert into Has_Subsidiary
values('save the axolotls ltd', 'save the pandas ltd', 5, 1000, 1982, 40);

insert into Has_Subsidiary
values('kil kill killl ltd', 'mass extinction ltd', 6, 20000, 1970, 2000);

insert into Has_Subsidiary
values('roasted axolotls ltd', 'roasted pandas ltd', 7, 30000, 1981, 1000);

insert into Has_Subsidiary
values('roasted axolotls ltd', 'roasted pandas ltd', 8, 30000, 1981, 1000);

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
values('Shaka kaSenzangakhona', 'dino oil ltd', 20);

insert into Owns
values('Mahatma Gandhi', 'dino oil ltd', 10);

insert into Owns
values('Mahatma Gandhi', 'kil kill killl ltd', 30);

insert into Owns
values('Ying Zheng', 'save the axolotls ltd', 30);

insert into Owns
values('Ying Zheng', 'roasted axolotls ltd', 30);

insert into Consume
values(13, 0, 'boops boops', 5);

insert into Consume
values(13, 1, 'boops boops', 2);

insert into Consume
values(2, 1, 'Brachiosaurus altithorax', 2);

insert into Consume
values(2, 0, 'Brachiosaurus altithorax', 10);

insert into Consume
values(9, 0, 'Ambystoma mexicanum', 3);

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

select table_name from user_tables;
