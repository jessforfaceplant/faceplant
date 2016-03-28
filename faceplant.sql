drop table favourites;
drop table has_colour;
drop table customers;
drop table plants;
drop table admins;
drop table colours;
drop table climates;
drop table locations;
drop table soils;

create table soils
  (soil_id int not null,
  moisture char(1) not null check (moisture = 'L' OR moisture = 'M' OR 
moisture = 'H'),
  n char(1) not null check (n = 'L' OR n = 'M' OR n = 'H'),
  p char(1) not null check (p = 'L' OR p = 'M' OR p = 'H'),
  k char(1) not null check (k = 'L' OR k = 'M' OR k = 'H'),
  humus char(1) not null check (humus = 'L' OR humus = 'M' OR humus = 
'H'),
  clay char(1) not null check (clay = 'L' OR clay = 'M' OR clay = 'H'),
  ph char(1) not null check (ph = 'L' OR ph = 'M' OR ph = 'H'),
  primary key (soil_id));

alter table soils
  add constraint uc_soil UNIQUE (moisture, n, p, k, humus, clay, ph);

create table locations
  (location_id int not null,
  city varchar(40) not null,
  province_state varchar(40) not null,
  country varchar(40) not null,
  primary key (location_id));

create table climates
  (climate_id int not null,
  light char(1) not null check (light = 'L' OR light = 'M' OR light = 
'H'),
  growthperiod_start varchar(9) not null check (growthperiod_start = 
'January' OR growthperiod_start = 'February' OR growthperiod_start = 
'March' OR growthperiod_start = 'April' OR growthperiod_start = 'May' OR 
growthperiod_start = 'June' OR growthperiod_start = 'July' OR 
growthperiod_start = 'August' OR growthperiod_start = 'September' OR 
growthperiod_start = 'October' OR growthperiod_start = 'November' OR 
growthperiod_start = 'December'),
  growthperiod_end varchar(9) not null check (growthperiod_end = 
'January' OR growthperiod_end = 'February' OR growthperiod_end = 'March' 
OR growthperiod_end = 'April' OR growthperiod_end = 'May' OR 
growthperiod_end = 'June' OR growthperiod_end = 'July' OR 
growthperiod_end = 'August' OR growthperiod_end = 'September' OR 
growthperiod_end = 'October' OR growthperiod_end = 'November' OR 
growthperiod_end = 'December'),
  temp_min int not null,
  temp_max int not null,
  primary key (climate_id));

alter table climates
  add constraint uc_climate UNIQUE (light, growthperiod_start, 
growthperiod_end, temp_min, temp_max);

create table colours
  (colour_name varchar(40) not null,
  primary key (colour_name));

create table admins
  (user_id varchar(40) not null,
  password varchar(40) not null,
  primary key (user_id));

create table plants
  (plant_id int not null,
  sci_name varchar(40) not null,
  com_name varchar(40) not null,
  cultivar varchar(40),
  edible char(1) not null check (edible = 'Y' OR edible = 'N'),
  medicinal char(1) not null check (medicinal = 'Y' OR medicinal = 'N'),
  petsafe char(1) not null check (petsafe = 'Y' OR petsafe = 'N'),
  description varchar(250),
  height char(1) not null check (height = 'L' OR height = 'M' OR height 
= 'H'),
  width char(1) not null check (width = 'L' OR width = 'M' OR width = 
'H'),
  climate_id int not null,
  soil_id int not null,
  primary key (plant_id),
  foreign key (climate_id) references climates,
  foreign key (soil_id) references soils);

alter table plants
  add constraint uc_plant UNIQUE (sci_name, com_name, cultivar);

create table customers
  (user_id varchar(40) not null,
  password varchar(40) not null,
  location_id int not null,
  primary key (user_id),
  foreign key (location_id) references locations);

create table has_colour
  (plant_id int not null,
  colour_name varchar(40) not null,
  primary key (plant_id, colour_name),
  foreign key (plant_id) references plants ON DELETE CASCADE,
  foreign key (colour_name) references colours);

create table favourites
  (user_id varchar(40) not null,
  plant_id int not null,
  date_added date not null,
  primary key (user_id, plant_id),
  foreign key (user_id) references customers ON DELETE CASCADE,
  foreign key (plant_id) references plants ON DELETE CASCADE);

insert into admins values ('admin', 'admin');

insert into colours values ('red');

insert into colours values ('orange');

insert into colours values ('yellow');

insert into colours values ('green');

insert into colours values ('blue');

insert into colours values ('indigo');

insert into colours values ('violet');

insert into colours values ('white');

insert into colours values ('black');

insert into locations values ('1', 'Vancouver', 'BC', 'Canada');

insert into locations values ('2', 'Burnaby', 'BC', 'Canada');

insert into locations values ('3', 'Coquitlam', 'BC', 'Canada');

insert into locations values ('4', 'Toronto', 'ON', 'Canada');

insert into locations values ('5', 'Ottawa', 'ON', 'Canada');

insert into locations values ('6', 'Seattle', 'WA', 'US');

insert into locations values ('7', 'Olympia', 'WA', 'US');

insert into locations values ('8', 'San Diego', 'CA', 'US');

insert into locations values ('9', 'Los Angeles', 'CA', 'US');

INSERT INTO CUSTOMERS VALUES ('jovy', 'jovy', '3');

INSERT INTO CUSTOMERS VALUES ('erik', 'erik', '1');

INSERT INTO CUSTOMERS VALUES ('sara', 'sara', '1');

INSERT INTO CUSTOMERS VALUES ('stephen', 'stephen', '2');

INSERT INTO CUSTOMERS VALUES ('user_to1', '1234', '4');

INSERT INTO CUSTOMERS VALUES ('user_to2', '1234', '4');

INSERT INTO CUSTOMERS VALUES ('user_ot', '1234', '5');

INSERT INTO CUSTOMERS VALUES ('user_sea', '1234', '6');

INSERT INTO CUSTOMERS VALUES ('user_oly', '1234', '7');

INSERT INTO CUSTOMERS VALUES ('user_sd1', '1234', '8');

INSERT INTO CUSTOMERS VALUES ('user_sd2', '1234', '8');

INSERT INTO CUSTOMERS VALUES ('user_la1', '1234', '9');

INSERT INTO CUSTOMERS VALUES ('user_la2', '1234', '9');

INSERT INTO CLIMATES VALUES ('1', 'H', 'April', 'September', '4', '40');

INSERT INTO CLIMATES VALUES ('2', 'H', 'March', 'October', '-4', '40');

INSERT INTO CLIMATES VALUES ('3', 'M', 'January', 'December', '12', 
'40');

INSERT INTO CLIMATES VALUES ('4', 'H', 'March', 'December', '-23', 
'40');

INSERT INTO CLIMATES VALUES ('5', 'M', 'January', 'December', '-23', 
'30');

INSERT INTO CLIMATES VALUES ('6', 'H', 'March', 'September', '-23', 
'30');

INSERT INTO CLIMATES VALUES ('7', 'H', 'January', 'December', '-12', 
'30');

INSERT INTO CLIMATES VALUES ('8', 'H', 'March', 'October', '-5', '35');

INSERT INTO CLIMATES VALUES ('9', 'H', 'May', 'November', '5', '40');

INSERT INTO CLIMATES VALUES ('10', 'H', 'April', 'October', '5', '40');

INSERT INTO CLIMATES VALUES ('11', 'M', 'January', 'December', '5', 
'35');

INSERT INTO CLIMATES VALUES ('12', 'H', 'January', 'December', '-1', 
'35');

INSERT INTO SOILS VALUES ('1', 'M', 'L', 'M', 'M', 'M', 'M', 'M');

INSERT INTO SOILS VALUES ('2', 'M', 'L', 'M', 'M', 'H', 'M', 'H');

INSERT INTO SOILS VALUES ('3', 'M', 'M', 'M', 'M', 'M', 'M', 'M');

INSERT INTO SOILS VALUES ('4', 'M', 'L', 'L', 'L', 'L', 'M', 'M');

INSERT INTO SOILS VALUES ('5', 'L', 'M', 'M', 'M', 'L', 'L', 'H');

INSERT INTO SOILS VALUES ('6', 'M', 'H', 'H', 'H', 'H', 'M', 'L');

INSERT INTO SOILS VALUES ('7', 'M', 'L', 'M', 'M', 'M', 'L', 'M');

INSERT INTO SOILS VALUES ('8', 'L', 'L', 'H', 'L', 'L', 'L', 'H');

INSERT INTO SOILS VALUES ('9', 'H', 'H', 'H', 'L', 'H', 'L', 'M');

INSERT INTO SOILS VALUES ('10', 'M', 'M', 'L', 'L', 'H', 'H', 'L');

INSERT INTO SOILS VALUES ('11', 'H', 'M', 'M', 'M', 'M', 'L', 'L');

INSERT INTO SOILS VALUES ('12', 'M', 'M', 'L', 'H', 'M', 'M', 'L');

INSERT INTO PLANTS (PLANT_ID, SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, 
MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) 
VALUES ('1', 'helianthus annus', 'sunflower', 'Italian White', 'Y', 'Y', 
'Y', 'A tall North American plant of the daisy family, with very large 
golden-rayed flowers. ', 'H', 'M', '1', '1');

INSERT INTO PLANTS (PLANT_ID, SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, 
MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) 
VALUES ('2', 'helianthus annus', 'sunflower', 'Velvet Queen', 'Y', 'Y', 
'Y', 'A tall North American plant of the daisy family, with very large 
golden-rayed flowers. ', 'H', 'M', '1', '1');

INSERT INTO PLANTS (PLANT_ID, SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, 
MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) 
VALUES ('3', 'helianthus annus', 'sunflower', 'Tohokujhae', 'Y', 'Y', 
'Y', 'A tall North American plant of the daisy family, with very large 
golden-rayed flowers. ', 'H', 'M', '1', '1');

INSERT INTO PLANTS (PLANT_ID, SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, 
MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) 
VALUES ('4', 'Lathyrus odoratus', 'sweet pea', 'Erewhon', 'N', 'N', 'N', 
'A climbing plant of the legume family having sweet-scented flowers. ', 
'H', 'M', '2', '2');

INSERT INTO PLANTS (PLANT_ID, SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, 
MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) 
VALUES ('5', 'Lathyrus odoratus', 'sweet pea', 'Jewels of Albion', 'N', 
'N', 'N', 'A climbing plant of the legume family having sweet-scented 
flowers. ', 'H', 'M', '2', '2');

INSERT INTO PLANTS (PLANT_ID, SCI_NAME, COM_NAME, EDIBLE, MEDICINAL, 
PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('6', 
'Nigella damascena', 'Love-In-A-Mist', 'Y', 'Y', 'N', 'An annual garden 
flowering plant, belonging to the buttercup family. The flower is 
nestled in a ring of multifid lacy bracts.', 'M', 'M', '3', '3');

INSERT INTO PLANTS (PLANT_ID, SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, 
MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) 
VALUES ('7', 'Calendula officinalis ', 'Pot Marigold', 'Pink Surprise', 
'Y', 'Y', 'Y', 'A plant of the daisy family, typically with yellow, 
orange, or copper-brown flowers, that is widely cultivated as an 
ornamental.', 'L', 'L', '4', '4');

INSERT INTO PLANTS (PLANT_ID, SCI_NAME, COM_NAME, EDIBLE, MEDICINAL, 
PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('8', 
'Abelia triflora', 'Indian Abelia', 'N', 'N', 'N', 'Large shrub from the 
Himalayas with deeply ridged bark and deciduous, ovate, dark green 
leaves and very fragrant small flowers.', 'H', 'H', '5', '5');

INSERT INTO PLANTS (PLANT_ID, SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, 
MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) 
VALUES ('9', 'Fuchsia magellanica', 'Fuchsia', 'Riccartonii', 'Y', 'N', 
'Y', 'A species of flowering plant in the family Evening Primrose, with 
many small and tubular pendent flowers.', 'H', 'M', '6', '6');

INSERT INTO PLANTS (PLANT_ID, SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, 
MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) 
VALUES ('10', 'Fuchsia coccinea', 'Ladies'' Eardrops', 'Dryander', 'Y', 
'N', 'Y', 'A species of flowering plant in the family Evening Primrose, 
erect or climbing shrub of Brazil with deep pink to red flowers', 'H', 
'M', '7', '6');

INSERT INTO PLANTS (PLANT_ID, SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, 
MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) 
VALUES ('11', 'Daucus carota sativus', 'Carrot', 'Guerand', 'Y', 'N', 
'Y', 'A root vegetable, commonly grown for its taproot.', 'L', 'M', '8', 
'7');

INSERT INTO PLANTS (PLANT_ID, SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, 
MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) 
VALUES ('12', 'Aloe vera', 'Aloe', 'Medicinal', 'Y', 'Y', 'N', 'A 
stemless or very short-stemmed succulent with fleshy thick leaves, that 
can be cut to obtain a medicinally useful sap.', 'H', 'H', '9', '8');

INSERT INTO PLANTS (PLANT_ID, SCI_NAME, COM_NAME, EDIBLE, MEDICINAL, 
PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('13', 
'Datura inoxia', 'Devil''s Trumpet', 'N', 'N', 'N', 'A species of the 
nightshade family with trumpet-shaped erect and spreading flowers. 
Extremely poisonous.', 'H', 'M', '10', '9');

INSERT INTO PLANTS (PLANT_ID, SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, 
MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) 
VALUES ('14', 'Rosa gallica', 'French Rose', 'Cardinal de Richelieu', 
'Y', 'Y', 'N', 'A species of the rose family, with pinnate blue-green 
leaves and clustered small flowers, single with 5 petals and very 
fragrant. Produces large rosehips.', 'L', 'H', '8', '10');

INSERT INTO PLANTS (PLANT_ID, SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, 
MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) 
VALUES ('15', 'Begonia', 'Begonia', 'Irene Nuss', 'Y', 'Y', 'N', 'A 
herbaceous succulent of warm climates, the bright flowers of which have 
brightly colored waxy sepals but no petals. ', 'H', 'M', '11', '11');

INSERT INTO PLANTS (PLANT_ID, SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, 
MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) 
VALUES ('16', 'Geranium riversleaianum', 'Cranesbill', 'Mavis Simpson', 
'Y', 'Y', 'Y', 'A spreading, semi-evergreen perennial, with downy, 
greyish-green leaves forming good ground cover, and rounded rose-pink 
flowers.', 'L', 'M', '12', '3');

INSERT INTO PLANTS (PLANT_ID, SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, 
MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) 
VALUES ('17', 'Viola tricolor var. hortensis', 'Pansy', 'Delta Pure Deep 
Orange', 'Y', 'Y', 'Y', 'A garden biennial plant with a flower that has 
two slightly overlapping upper petals, two side petals, and a single 
bottom petal with a slight beard emanating from the flower''s center.', 
'L', 'M', '6', '12');

INSERT INTO PLANTS (PLANT_ID, SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, 
MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) 
VALUES ('18', 'Viola tricolor var. hortensis', 'Pansy', 'Delta Premium 
Pure White', 'Y', 'Y', 'Y', 'A garden biennial plant with a flower that 
has two slightly overlapping upper petals, two side petals, and a single 
bottom petal with a slight beard emanating from the flower''s center.', 
'L', 'M', '6', '12');

INSERT INTO PLANTS (PLANT_ID, SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, 
MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) 
VALUES ('19', 'Viola tricolor var. hortensis', 'Pansy', 'Delta Pure 
Yellow', 'Y', 'Y', 'Y', 'A garden biennial plant with a flower that has 
two slightly overlapping upper petals, two side petals, and a single 
bottom petal with a slight beard emanating from the flower''s center.', 
'L', 'M', '6', '12');


INSERT INTO HAS_COLOUR VALUES ('1', 'white');

INSERT INTO HAS_COLOUR VALUES ('1', 'green');

INSERT INTO HAS_COLOUR VALUES ('2', 'red');

INSERT INTO HAS_COLOUR VALUES ('2', 'green');

INSERT INTO HAS_COLOUR VALUES ('3', 'yellow');

INSERT INTO HAS_COLOUR VALUES ('3', 'green');

INSERT INTO HAS_COLOUR VALUES ('4', 'red');

INSERT INTO HAS_COLOUR VALUES ('4', 'violet');

INSERT INTO HAS_COLOUR VALUES ('4', 'green');

INSERT INTO HAS_COLOUR VALUES ('5', 'blue');

INSERT INTO HAS_COLOUR VALUES ('5', 'indigo');

INSERT INTO HAS_COLOUR VALUES ('5', 'violet');

INSERT INTO HAS_COLOUR VALUES ('5', 'green');

INSERT INTO HAS_COLOUR VALUES ('6', 'red');

INSERT INTO HAS_COLOUR VALUES ('6', 'violet');

INSERT INTO HAS_COLOUR VALUES ('6', 'blue');

INSERT INTO HAS_COLOUR VALUES ('6', 'white');

INSERT INTO HAS_COLOUR VALUES ('6', 'green');

INSERT INTO HAS_COLOUR VALUES ('7', 'orange');

INSERT INTO HAS_COLOUR VALUES ('7', 'yellow');

INSERT INTO HAS_COLOUR VALUES ('7', 'green');

INSERT INTO HAS_COLOUR VALUES ('8', 'red');

INSERT INTO HAS_COLOUR VALUES ('8', 'white');

INSERT INTO HAS_COLOUR VALUES ('8', 'green');

INSERT INTO HAS_COLOUR VALUES ('9', 'red');

INSERT INTO HAS_COLOUR VALUES ('9', 'violet');

INSERT INTO HAS_COLOUR VALUES ('9', 'white');

INSERT INTO HAS_COLOUR VALUES ('9', 'green');

INSERT INTO HAS_COLOUR VALUES ('10', 'red');

INSERT INTO HAS_COLOUR VALUES ('10', 'green');

INSERT INTO HAS_COLOUR VALUES ('11', 'white');

INSERT INTO HAS_COLOUR VALUES ('11', 'green');

INSERT INTO HAS_COLOUR VALUES ('12', 'orange');

INSERT INTO HAS_COLOUR VALUES ('12', 'yellow');

INSERT INTO HAS_COLOUR VALUES ('12', 'green');

INSERT INTO HAS_COLOUR VALUES ('13', 'white');

INSERT INTO HAS_COLOUR VALUES ('13', 'green');

INSERT INTO HAS_COLOUR VALUES ('14', 'blue');

INSERT INTO HAS_COLOUR VALUES ('14', 'green');

INSERT INTO HAS_COLOUR VALUES ('15', 'red');

INSERT INTO HAS_COLOUR VALUES ('15', 'green');

INSERT INTO HAS_COLOUR VALUES ('16', 'red');

INSERT INTO HAS_COLOUR VALUES ('16', 'green');

INSERT INTO HAS_COLOUR VALUES ('17', 'orange');

INSERT INTO HAS_COLOUR VALUES ('17', 'green');

INSERT INTO HAS_COLOUR VALUES ('18', 'white');

INSERT INTO HAS_COLOUR VALUES ('18', 'green');

INSERT INTO HAS_COLOUR VALUES ('19', 'yellow');

INSERT INTO HAS_COLOUR VALUES ('19', 'green');



