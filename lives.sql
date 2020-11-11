create table Lives_Plant(
	plantID		    integer,
    habID			integer,
    PRIMARY KEY(plantID),
	FOREIGN KEY(plantID) REFERENCES Plants),
	FOREIGN KEY(habID) REFERENCES Habitat);  --ON DELETE NO ACTION ON UPDATE CASCADE

create table Lives_A(
    aID			integer,
    habID			integer,
    PRIMARY KEY(aID),
	FOREIGN KEY(aID) REFERENCES Animals)
	FOREIGN KEY(habID) REFERENCES Habitat);  -- ON DELETE NO ACTION ON UPDATE CASCADE