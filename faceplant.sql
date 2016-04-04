drop index plant_fk1;
drop index plant_fk2;
drop index customers_fk;
drop index has_colour_fk1;
drop index has_colour_fk2;
drop index favourites_fk1;
drop index favourites_fk2;
drop table favourites;
drop table has_colour;
drop table customers;
drop table plants;
drop table admins;
drop table colours;
drop table temp_colours;
drop table climates;
drop table locations;
drop table soils;
drop sequence soil_id_seq;
drop sequence location_id_seq;
drop sequence climate_id_seq;
drop sequence plant_id_seq;

create table soils
  (soil_id int not null,
  moisture char(1) not null check (moisture = 'L' OR moisture = 'M' OR moisture = 'H'),
  n char(1) not null check (n = 'L' OR n = 'M' OR n = 'H'),
  p char(1) not null check (p = 'L' OR p = 'M' OR p = 'H'),
  k char(1) not null check (k = 'L' OR k = 'M' OR k = 'H'),
  humus char(1) not null check (humus = 'L' OR humus = 'M' OR humus = 'H'),
  clay char(1) not null check (clay = 'L' OR clay = 'M' OR clay = 'H'),
  ph char(1) not null check (ph = 'L' OR ph = 'M' OR ph = 'H'),
  primary key (soil_id));

alter table soils
  add constraint uc_soil UNIQUE (moisture, n, p, k, humus, clay, ph);

create sequence soil_id_seq;

create or replace trigger soil_bir
  before insert on soils
  for each row

begin
  select soil_id_seq.nextval
  into :new.soil_id
  from dual;
end;
/

create table locations
  (location_id int not null,
  city varchar(40) not null,
  province_state varchar(40) not null,
  country varchar(40) not null,
  primary key (location_id));

create sequence location_id_seq;

create or replace trigger location_bir
  before insert on locations
  for each row

begin
  select location_id_seq.nextval
  into :new.location_id
  from dual;
end;
/

create table climates
  (climate_id int not null,
  light char(1) not null check (light = 'L' OR light = 'M' OR light = 'H'),
  growthperiod_start varchar(9) not null check (growthperiod_start = 'January' OR growthperiod_start = 'February' OR growthperiod_start = 'March' OR growthperiod_start = 'April' OR growthperiod_start = 'May' OR growthperiod_start = 'June' OR growthperiod_start = 'July' OR growthperiod_start = 'August' OR growthperiod_start = 'September' OR growthperiod_start = 'October' OR growthperiod_start = 'November' OR growthperiod_start = 'December'),
  growthperiod_end varchar(9) not null check (growthperiod_end = 'January' OR growthperiod_end = 'February' OR growthperiod_end = 'March' OR growthperiod_end = 'April' OR growthperiod_end = 'May' OR growthperiod_end = 'June' OR growthperiod_end = 'July' OR growthperiod_end = 'August' OR growthperiod_end = 'September' OR growthperiod_end = 'October' OR growthperiod_end = 'November' OR growthperiod_end = 'December'),
  temp_min int not null,
  temp_max int not null,
  primary key (climate_id));

alter table climates
  add constraint uc_climate UNIQUE (light, growthperiod_start, growthperiod_end, temp_min, temp_max);

create sequence climate_id_seq;

create or replace trigger climate_bir
  before insert on climates
  for each row

begin
  select climate_id_seq.nextval
  into :new.climate_id
  from dual;
end;
/

create table colours
  (colour_name varchar(40) not null,
  primary key (colour_name));

create table temp_colours
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
  height char(1) not null check (height = 'L' OR height = 'M' OR height = 'H'),
  width char(1) not null check (width = 'L' OR width = 'M' OR width = 'H'),
  climate_id int not null,
  soil_id int not null,
  primary key (plant_id),
  foreign key (climate_id) references climates,
  foreign key (soil_id) references soils);

alter table plants
  add constraint uc_plant UNIQUE (sci_name, com_name, cultivar);

create index plant_fk1 on plants(climate_id);
create index plant_fk2 on plants(soil_id);

create sequence plant_id_seq;

create or replace trigger plant_bir
  before insert on plants
  for each row

begin
  select plant_id_seq.nextval
  into :new.plant_id
  from dual;
end;
/

create table customers
  (user_id varchar(40) not null,
  password varchar(40) not null,
  location_id int not null,
  primary key (user_id),
  foreign key (location_id) references locations);

create index customers_fk on customers(location_id);

create table has_colour
  (plant_id int not null,
  colour_name varchar(40) not null,
  primary key (plant_id, colour_name),
  foreign key (plant_id) references plants ON DELETE CASCADE,
  foreign key (colour_name) references colours);

create index has_colour_fk1 on has_colour(plant_id);
create index has_colour_fk2 on has_colour(colour_name);

create table favourites
  (user_id varchar(40) not null,
  plant_id int not null,
  date_added date not null,
  primary key (user_id, plant_id),
  foreign key (user_id) references customers ON DELETE CASCADE,
  foreign key (plant_id) references plants ON DELETE CASCADE);

create index favourites_fk1 on favourites(user_id);
create index favourites_fk2 on favourites(plant_id);

alter table plants
  add colour_count integer default 0;

create or replace trigger has_colour_bir
  after insert on has_colour
  for each row

begin
  update plants
  set colour_count = colour_count + 1
  where plant_id = :new.plant_id;
end;
/

alter table plants
  add constraint PLANT_CHK_HAS_COLOUR 
  check (colour_count > 0)
  DEFERRABLE INITIALLY DEFERRED;

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

insert into locations (CITY, PROVINCE_STATE, COUNTRY) values ('Vancouver', 'BC', 'Canada');

insert into locations (CITY, PROVINCE_STATE, COUNTRY) values ('Burnaby', 'BC', 'Canada');

insert into locations (CITY, PROVINCE_STATE, COUNTRY) values ('Coquitlam', 'BC', 'Canada');

insert into locations (CITY, PROVINCE_STATE, COUNTRY) values ('Toronto', 'ON', 'Canada');

insert into locations (CITY, PROVINCE_STATE, COUNTRY) values ('Ottawa', 'ON', 'Canada');

insert into locations (CITY, PROVINCE_STATE, COUNTRY) values ('Seattle', 'WA', 'US');

insert into locations (CITY, PROVINCE_STATE, COUNTRY) values ('Olympia', 'WA', 'US');

insert into locations (CITY, PROVINCE_STATE, COUNTRY) values ('San Diego', 'CA', 'US');

insert into locations (CITY, PROVINCE_STATE, COUNTRY) values ('Los Angeles', 'CA', 'US');

INSERT INTO CUSTOMERS (USER_ID, PASSWORD, LOCATION_ID) VALUES ('jovy', 'jovy', '3');

INSERT INTO CUSTOMERS (USER_ID, PASSWORD, LOCATION_ID) VALUES ('erik', 'erik', '1');

INSERT INTO CUSTOMERS (USER_ID, PASSWORD, LOCATION_ID) VALUES ('sara', 'sara', '1');

INSERT INTO CUSTOMERS (USER_ID, PASSWORD, LOCATION_ID) VALUES ('stephen', 'stephen', '2');

INSERT INTO CUSTOMERS (USER_ID, PASSWORD, LOCATION_ID) VALUES ('user_to1', '1234', '4');

INSERT INTO CUSTOMERS (USER_ID, PASSWORD, LOCATION_ID) VALUES ('user_to2', '1234', '4');

INSERT INTO CUSTOMERS (USER_ID, PASSWORD, LOCATION_ID) VALUES ('user_ot', '1234', '5');

INSERT INTO CUSTOMERS (USER_ID, PASSWORD, LOCATION_ID) VALUES ('user_sea', '1234', '6');

INSERT INTO CUSTOMERS (USER_ID, PASSWORD, LOCATION_ID) VALUES ('user_oly', '1234', '7');

INSERT INTO CUSTOMERS (USER_ID, PASSWORD, LOCATION_ID) VALUES ('user_sd1', '1234', '8');

INSERT INTO CUSTOMERS (USER_ID, PASSWORD, LOCATION_ID) VALUES ('user_sd2', '1234', '8');

INSERT INTO CUSTOMERS (USER_ID, PASSWORD, LOCATION_ID) VALUES ('user_la1', '1234', '9');

INSERT INTO CUSTOMERS (USER_ID, PASSWORD, LOCATION_ID) VALUES ('user_la2', '1234', '9');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('H', 'April', 'September', '4', '40');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('H', 'March', 'October', '-4', '40');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('M', 'January', 'December', '12', '40');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('H', 'March', 'December', '-23', '40');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('M', 'January', 'December', '-23', '30');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('H', 'March', 'September', '-23', '30');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('H', 'January', 'December', '-12', '30');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('H', 'March', 'October', '-5', '35');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('H', 'May', 'November', '5', '40');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('H', 'April', 'October', '5', '40');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('M', 'January', 'December', '-1', '35');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('H', 'January', 'December', '-10', '35');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('H', 'March', 'October', '-12', '40');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('H', 'January', 'December', '25', '40');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('H', 'January', 'December', '7', '40');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('M', 'March', 'October', '-29', '30');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('M', 'May', 'October', '-28', '40');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('H', 'March', 'September', '-23', '40');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('H', 'March', 'October', '21', '40');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('H', 'March', 'October', '10', '40');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('H', 'January', 'December', '10', '40');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('H', 'March', 'October', '-31', '40');

INSERT INTO CLIMATES (LIGHT, GROWTHPERIOD_START, GROWTHPERIOD_END, TEMP_MIN, TEMP_MAX) VALUES ('H', 'January', 'December', '5', '40');

INSERT INTO SOILS (MOISTURE, N, P, K, HUMUS, CLAY, PH) VALUES ('M', 'L', 'M', 'M', 'M', 'M', 'M');

INSERT INTO SOILS (MOISTURE, N, P, K, HUMUS, CLAY, PH) VALUES ('M', 'L', 'M', 'M', 'H', 'M', 'H');

INSERT INTO SOILS (MOISTURE, N, P, K, HUMUS, CLAY, PH) VALUES ('M', 'M', 'M', 'M', 'M', 'M', 'M');

INSERT INTO SOILS (MOISTURE, N, P, K, HUMUS, CLAY, PH) VALUES ('M', 'L', 'L', 'L', 'L', 'M', 'M');

INSERT INTO SOILS (MOISTURE, N, P, K, HUMUS, CLAY, PH) VALUES ('L', 'M', 'M', 'M', 'L', 'L', 'H');

INSERT INTO SOILS (MOISTURE, N, P, K, HUMUS, CLAY, PH) VALUES ('M', 'H', 'H', 'H', 'H', 'M', 'L');

INSERT INTO SOILS (MOISTURE, N, P, K, HUMUS, CLAY, PH) VALUES ('M', 'L', 'M', 'M', 'M', 'L', 'M');

INSERT INTO SOILS (MOISTURE, N, P, K, HUMUS, CLAY, PH) VALUES ('L', 'L', 'H', 'L', 'L', 'L', 'H');

INSERT INTO SOILS (MOISTURE, N, P, K, HUMUS, CLAY, PH) VALUES ('H', 'H', 'H', 'L', 'H', 'L', 'M');

INSERT INTO SOILS (MOISTURE, N, P, K, HUMUS, CLAY, PH) VALUES ('M', 'M', 'L', 'L', 'H', 'H', 'L');

INSERT INTO SOILS (MOISTURE, N, P, K, HUMUS, CLAY, PH) VALUES ('H', 'M', 'M', 'M', 'M', 'L', 'L');

INSERT INTO SOILS (MOISTURE, N, P, K, HUMUS, CLAY, PH) VALUES ('M', 'M', 'L', 'H', 'M', 'M', 'L');

INSERT INTO SOILS (MOISTURE, N, P, K, HUMUS, CLAY, PH) VALUES ('M', 'M', 'M', 'M', 'M', 'L', 'M');

INSERT INTO SOILS (MOISTURE, N, P, K, HUMUS, CLAY, PH) VALUES ('H', 'M', 'L', 'M', 'M', 'L', 'M');

INSERT INTO SOILS (MOISTURE, N, P, K, HUMUS, CLAY, PH) VALUES ('M', 'L', 'H', 'L', 'M', 'M', 'M');

INSERT INTO SOILS (MOISTURE, N, P, K, HUMUS, CLAY, PH) VALUES ('M', 'L', 'L', 'L', 'M', 'L', 'M');

INSERT INTO SOILS (MOISTURE, N, P, K, HUMUS, CLAY, PH) VALUES ('H', 'M', 'M', 'M', 'H', 'L', 'L');

INSERT INTO SOILS (MOISTURE, N, P, K, HUMUS, CLAY, PH) VALUES ('M', 'L', 'L', 'L', 'M', 'M', 'L');

INSERT INTO SOILS (MOISTURE, N, P, K, HUMUS, CLAY, PH) VALUES ('M', 'L', 'M', 'M', 'M', 'L', 'L');

INSERT INTO SOILS (MOISTURE, N, P, K, HUMUS, CLAY, PH) VALUES ('M', 'M', 'M', 'L', 'M', 'L', 'M');

INSERT INTO SOILS (MOISTURE, N, P, K, HUMUS, CLAY, PH) VALUES ('H', 'L', 'L', 'L', 'L', 'L', 'L');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Helianthus annus', 'Sunflower', 'Italian White', 'Y', 'Y', 'Y', 'A tall North American plant of the daisy family, with very large golden-rayed flowers. ', 'H', 'M', '1', '1');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Helianthus annus', 'Sunflower', 'Velvet Queen', 'Y', 'Y', 'Y', 'A tall North American plant of the daisy family, with very large golden-rayed flowers. ', 'H', 'M', '1', '1');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Helianthus annus', 'Sunflower', 'Tohokujhae', 'Y', 'Y', 'Y', 'A tall North American plant of the daisy family, with very large golden-rayed flowers. ', 'H', 'M', '1', '1');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Lathyrus odoratus', 'Sweet Pea', 'Erewhon', 'N', 'N', 'N', 'A climbing plant of the legume family having sweet-scented flowers. ', 'H', 'M', '2', '2');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Lathyrus odoratus', 'Sweet Pea', 'Jewels of Albion', 'N', 'N', 'N', 'A climbing plant of the legume family having sweet-scented flowers. ', 'H', 'M', '2', '2');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Nigella damascena', 'Love-In-A-Mist', 'Y', 'Y', 'N', 'An annual garden flowering plant, belonging to the buttercup family. The flower is nestled in a ring of multifid lacy bracts.', 'M', 'M', '3', '3');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Calendula officinalis ', 'Pot Marigold', 'Pink Surprise', 'Y', 'Y', 'Y', 'A plant of the daisy family, typically with yellow, orange, or copper-brown flowers, that is widely cultivated as an ornamental.', 'L', 'L', '4', '4');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Abelia triflora', 'Indian Abelia', 'N', 'N', 'N', 'Large shrub from the Himalayas with deeply ridged bark and deciduous, ovate, dark green leaves and very fragrant small flowers.', 'H', 'H', '5', '5');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Fuchsia magellanica', 'Fuchsia', 'Riccartonii', 'Y', 'N', 'Y', 'A species of flowering plant in the family Evening Primrose, with many small and tubular pendent flowers.', 'H', 'M', '6', '6');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Fuchsia coccinea', 'Ladies'' Eardrops', 'Dryander', 'Y', 'N', 'Y', 'A species of flowering plant in the family Evening Primrose, erect or climbing shrub of Brazil with deep pink to red flowers', 'H', 'M', '7', '6');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Daucus carota sativus', 'Carrot', 'Guerand', 'Y', 'N', 'Y', 'A root vegetable, commonly grown for its taproot.', 'L', 'M', '8', '7');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Aloe vera', 'Aloe', 'Medicinal', 'Y', 'Y', 'N', 'A stemless or very short-stemmed succulent with fleshy thick leaves, that can be cut to obtain a medicinally useful sap.', 'H', 'H', '9', '8');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Datura inoxia', 'Devil''s Trumpet', 'N', 'N', 'N', 'A species of the nightshade family with trumpet-shaped erect and spreading flowers. Extremely poisonous.', 'H', 'M', '10', '9');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Rosa gallica', 'French Rose', 'Cardinal de Richelieu', 'Y', 'Y', 'N', 'A species of the rose family, with pinnate blue-green leaves and clustered small flowers, single with 5 petals and very fragrant. Produces large rosehips.', 'L', 'H', '8', '10');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Begonia', 'Begonia', 'Irene Nuss', 'Y', 'Y', 'N', 'A herbaceous succulent of warm climates, the bright flowers of which have brightly colored waxy sepals but no petals. ', 'H', 'M', '11', '11');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Geranium riversleaianum', 'Cranesbill', 'Mavis Simpson', 'Y', 'Y', 'Y', 'A spreading, semi-evergreen perennial, with downy, greyish-green leaves forming good ground cover, and rounded rose-pink flowers.', 'L', 'M', '12', '3');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Viola tricolor var. hortensis', 'Pansy', 'Delta Pure Deep Orange', 'Y', 'Y', 'Y', 'A garden biennial plant with a flower that has two slightly overlapping upper petals, two side petals, and a single bottom petal with a slight beard emanating from the flower''s center.', 'L', 'M', '6', '12');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Viola tricolor var. hortensis', 'Pansy', 'Delta Premium Pure White', 'Y', 'Y', 'Y', 'A garden biennial plant with a flower that has two slightly overlapping upper petals, two side petals, and a single bottom petal with a slight beard emanating from the flower''s center.', 'L', 'M', '6', '12');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Viola tricolor var. hortensis', 'Pansy', 'Delta Pure Yellow', 'Y', 'Y', 'Y', 'A garden biennial plant with a flower that has two slightly overlapping upper petals, two side petals, and a single bottom petal with a slight beard emanating from the flower''s center.', 'L', 'M', '6', '12');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Salvia farinacea', 'Mealycup Sage', 'Strata', 'Y', 'Y', 'Y', 'An aromatic herbal plant with square stems and whorls of two-lipped blossoms.', 'M', 'M', '13', '13');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Salvia leucantha', 'Mexican Bush Sage', 'N', 'Y', 'Y', 'A bushy shrub with hairy white stems, gray-green leaves, and velvet-like violet flower spikes. Attracts hummingbirds.', 'H' , 'H', '14', '13');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Salvia horminum', 'Painted Sage', 'Claryssa Mixed', 'Y', 'Y', 'Y', 'An aromatic herbal plant with square stems and whorls of two-lipped blossoms, not to be mistaken for the noxious weed clary sage.', 'L', 'L', '13', '13');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Hibiscus rosa-sinensis', 'Hibiscus', 'Toucan', 'Y', 'Y', 'N', 'A popular tropical ornamental shrub with glossy leaves and solitary brilliantly coloured 5-petaled flowers with prominent anthers.', 'H', 'M', '15', '14');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Hibiscus rosa-sinensis', 'Hibiscus', 'Magic Crystal', 'Y', 'Y', 'N', 'A popular tropical ornamental shrub with glossy leaves and solitary brilliantly coloured 5-petaled flowers with prominent anthers.', 'H', 'M', '15', '14');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Hibiscus rosa-sinensis', 'Hibiscus', 'Missing You', 'Y', 'Y', 'N', 'A popular tropical ornamental shrub with glossy leaves and solitary brilliantly coloured 5-petaled flowers with prominent anthers.', 'H', 'M', '15', '14');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Hibiscus rosa-sinensis', 'Hibiscus', 'Butterscotch Bliss', 'Y', 'Y', 'N', 'A popular tropical ornamental shrub with glossy leaves and solitary brilliantly coloured 5-petaled flowers with prominent anthers.', 'H', 'M', '15', '14');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Hibiscus rosa-sinensis', 'Hibiscus', 'Lyrical', 'Y', 'Y', 'N', 'A popular tropical ornamental shrub with glossy leaves and solitary brilliantly coloured 5-petaled flowers with prominent anthers.', 'H', 'M', '15', '14');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Hydrangea macrophylla', 'Hydrangea', 'Endless Summer Original', 'N', 'N', 'N', 'A shrub or climbing plant with rounded or flattened flowering heads of small florets of the Hydrangea family, well known for their pH-dependent colour variation. This cultivar reblooms continually for a longer period in the year.', 'M', 'M', '16', '15');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Hydrangea macrophylla', 'Hydrangea', 'Endless Summer Blushing Bride', 'N', 'N', 'N', 'A shrub or climbing plant with rounded or flattened flowering heads of small florets of the Hydrangea family, well known for their pH-dependent colour variation. This cultivar reblooms continually for a longer period in the year.', 'M', 'M', '16', '15');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Hydrangea macrophylla Pia', 'French Hydrangea', 'Pink Elf', 'N', 'N', 'N', 'A shrub or climbing plant with rounded or flattened flowering heads of small florets of the Hydrangea family, well known for their pH-dependent colour variation. This cultivar is miniature.', 'L', 'L', '17', '15');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Matricaria recutita', 'Chamomile', 'Zloty Lan', 'Y', 'Y', 'N', 'A aromatic European plant of the daisy family, with white and yellow daisylike flowers. This cultivar is high in essential oils.', 'H', 'M', '1', '16');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Fragaria x ananassa', 'Strawberry', 'Aromel', 'Y', 'N', 'Y', 'A low-growing plant that produces a sweet soft red fruit with a seed-studded surface, having white flowers, lobed leaves, and runners, and found throughout north temperate regions. This cultivar has a late summer to autumn picking time.', 'M', 'H', '18', '17');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Fragaria x ananassa', 'Strawberry', 'Elsanta', 'Y', 'N', 'Y', 'A low-growing plant that produces a sweet soft red fruit with a seed-studded surface, having white flowers, lobed leaves, and runners, and found throughout north temperate regions. This cultivar has a mid June to July picking time.', 'M', 'H', '18', '17');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Fragaria x ananassa', 'Strawberry', 'Tenira', 'Y', 'N', 'Y', 'A low-growing plant that produces a sweet soft red fruit with a seed-studded surface, having white flowers, lobed leaves, and runners, and found throughout north temperate regions. This cultivar has a July picking time.', 'M', 'H', '18', '17');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Vaccinium corymbosum', 'Northern Highbush Blueberry', 'Bluetta', 'Y', 'N', 'Y', 'A hardy dwarf shrub of the heath family, with small, whitish drooping flowers and dark blue edible berries. This cultivar is medium yield but frost-hardy.', 'M', 'M', '5', '18');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Vaccinium corymbosum', 'Northern Highbush Blueberry', 'Huron', 'Y', 'N', 'Y', 'A hardy dwarf shrub of the heath family, with small, whitish drooping flowers and dark blue edible berries. This cultivar is medium yield but frost-hardy and grows vigorously.', 'M', 'M', '5', '18');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Vaccinium corymbosum', 'Northern Highbush Blueberry', 'Spartan', 'Y', 'N', 'Y', 'A hardy dwarf shrub of the heath family, with small, whitish drooping flowers and dark blue edible berries. This cultivar is high yield and vigorous but does not do well on heavy soils.', 'M', 'M', '5', '18');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Cucumis melo reticulatus', 'Muskmelon', 'Blenheim Orange', 'Y', 'N', 'Y', 'A plant of the gourd family bearing an edible melon of a type that has a raised network of markings on the skin. This cultivar is ready for picking in late August to early September. Well balanced flavour profile.', 'H', 'H', '19', '19');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Cucumis melo reticulatus', 'Muskmelon', 'Hero of Lockinge', 'Y', 'N', 'Y', 'A plant of the gourd family bearing an edible melon of a type that has a raised network of markings on the skin. This cultivar is ready for picking in late August to early September. Very sweet flesh!', 'H', 'H', '19', '19');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Cucumis melo reticulatus', 'Muskmelon', 'Superlative', 'Y', 'N', 'Y', 'A plant of the gourd family bearing an edible melon of a type that has a raised network of markings on the skin. This cultivar is ready for picking in late August to early September. Richly coloured and sweet, but not popular.', 'H', 'H', '19', '19');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Cucumis melo cantalupensis', 'Cantaloupe', 'Charentais', 'Y', 'N', 'Y', 'A plant of the gourd family bearing an edible melon of a type that has a hard scaly or warty rind. This cultivar has mid-season harvest fruit with richly-perfumed golden-red flesh but the flavour is highly variable.', 'H', 'H', '19', '19');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Cucumis melo cantalupensis', 'Cantaloupe', 'No Name', 'Y', 'N', 'Y', 'A plant of the gourd family bearing an edible melon of a type that has a hard scaly or warty rind. This cultivar has oval fruit with excellent flavour, but is late harvest.', 'H', 'H', '19', '19');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Cucumis melo cantalupensis', 'Cantaloupe', 'Sweetheart', 'Y', 'N', 'Y', 'A plant of the gourd family bearing an edible melon of a type that has a hard scaly or warty rind. This s a winter-hardy cultivar with early harvest fruit that is both attractive and delicious.', 'H', 'H', '20', '19');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Anthurium amnicola', 'Tulip Flamingo Flower', 'Sweetheart', 'N', 'N', 'N', 'A tropical plant with flowers of a pleasant, sweet-smelling fragrance and a large tulip-shaped petal wrapping a long coloured anther. Leaves are small, dark green and spade-shaped.', 'M', 'M', '21', '17');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Tulipa', 'Broken Tulip', 'Adonis', 'N', 'N', 'N', 'A bulbous spring-flowering plant of the lily family, with boldly colored cup-shaped flowers with variegated colouration.', 'M', 'L', '22', '20');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Tulipa', 'Broken Tulip', 'Royal Sovereign', 'N', 'N', 'N', 'A bulbous spring-flowering plant of the lily family, with boldly colored cup-shaped flowers with variegated colouration.', 'M', 'L', '22', '20');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Tulipa', 'Broken Tulip', 'Sam Barlow', 'N', 'N', 'N', 'A bulbous spring-flowering plant of the lily family, with boldly colored cup-shaped flowers with variegated colouration.', 'M', 'L', '22', '20');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Sarracenia leucophylla var. alba', 'White-topped Pitcher Plant', 'Bris', 'N', 'N', 'Y', 'A pitcher plant, with the top third or more of each pitcher in pigmented white and innervated with red veins. Produces yellow flowers.', 'M', 'L', '23', '21');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Sarracenia leucophylla var. alba', 'White-topped Pitcher Plant', 'Hurricane Creek White', 'N', 'N', 'Y', 'A pitcher plant, with the top third or more of each pitcher in pigmented white and innervated with green  veins. Produces yellow flowers.', 'M', 'L', '23', '21');

INSERT INTO PLANTS (SCI_NAME, COM_NAME, CULTIVAR, EDIBLE, MEDICINAL, PETSAFE, DESCRIPTION, HEIGHT, WIDTH, CLIMATE_ID, SOIL_ID) VALUES ('Sarracenia leucophylla, var. alba', 'White-topped Pitcher Plant', 'Tarnok', 'N', 'N', 'Y', 'A pitcher plant of the white-topped genera, this plant is peculiar in that its flowers have been completely replaced with sepal-like organs resembling Chrysanthemums.', 'M', 'L', '23', '21');

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

INSERT INTO HAS_COLOUR VALUES ('20', 'blue');

INSERT INTO HAS_COLOUR VALUES ('20', 'white');

INSERT INTO HAS_COLOUR VALUES ('20', 'green');

INSERT INTO HAS_COLOUR VALUES ('21', 'violet');

INSERT INTO HAS_COLOUR VALUES ('21', 'white');

INSERT INTO HAS_COLOUR VALUES ('21', 'blue');

INSERT INTO HAS_COLOUR VALUES ('21', 'green');

INSERT INTO HAS_COLOUR VALUES ('22', 'blue');

INSERT INTO HAS_COLOUR VALUES ('22', 'white');

INSERT INTO HAS_COLOUR VALUES ('22', 'red');

INSERT INTO HAS_COLOUR VALUES ('22', 'violet');

INSERT INTO HAS_COLOUR VALUES ('22', 'green');

INSERT INTO HAS_COLOUR VALUES ('23', 'orange');

INSERT INTO HAS_COLOUR VALUES ('23', 'yellow');

INSERT INTO HAS_COLOUR VALUES ('23', 'red');

INSERT INTO HAS_COLOUR VALUES ('23', 'green');

INSERT INTO HAS_COLOUR VALUES ('24', 'blue');

INSERT INTO HAS_COLOUR VALUES ('24', 'red');

INSERT INTO HAS_COLOUR VALUES ('24', 'white');

INSERT INTO HAS_COLOUR VALUES ('24', 'green');

INSERT INTO HAS_COLOUR VALUES ('25', 'blue');

INSERT INTO HAS_COLOUR VALUES ('25', 'red');

INSERT INTO HAS_COLOUR VALUES ('25', 'yellow');

INSERT INTO HAS_COLOUR VALUES ('25', 'green');

INSERT INTO HAS_COLOUR VALUES ('26', 'yellow');

INSERT INTO HAS_COLOUR VALUES ('26', 'orange');

INSERT INTO HAS_COLOUR VALUES ('26', 'violet');

INSERT INTO HAS_COLOUR VALUES ('26', 'white');

INSERT INTO HAS_COLOUR VALUES ('26', 'green');

INSERT INTO HAS_COLOUR VALUES ('27', 'orange');

INSERT INTO HAS_COLOUR VALUES ('27', 'yellow');

INSERT INTO HAS_COLOUR VALUES ('27', 'blue');

INSERT INTO HAS_COLOUR VALUES ('27', 'red');

INSERT INTO HAS_COLOUR VALUES ('27', 'green');

INSERT INTO HAS_COLOUR VALUES ('28', 'blue');

INSERT INTO HAS_COLOUR VALUES ('28', 'red');

INSERT INTO HAS_COLOUR VALUES ('28', 'violet');

INSERT INTO HAS_COLOUR VALUES ('28', 'green');

INSERT INTO HAS_COLOUR VALUES ('29', 'white');

INSERT INTO HAS_COLOUR VALUES ('29', 'red');

INSERT INTO HAS_COLOUR VALUES ('29', 'green');

INSERT INTO HAS_COLOUR VALUES ('30', 'red');

INSERT INTO HAS_COLOUR VALUES ('30', 'orange');

INSERT INTO HAS_COLOUR VALUES ('30', 'yellow');

INSERT INTO HAS_COLOUR VALUES ('30', 'green');

INSERT INTO HAS_COLOUR VALUES ('31', 'white');

INSERT INTO HAS_COLOUR VALUES ('31', 'yellow');

INSERT INTO HAS_COLOUR VALUES ('31', 'green');

INSERT INTO HAS_COLOUR VALUES ('32', 'red');

INSERT INTO HAS_COLOUR VALUES ('32', 'white');

INSERT INTO HAS_COLOUR VALUES ('32', 'green');

INSERT INTO HAS_COLOUR VALUES ('33', 'red');

INSERT INTO HAS_COLOUR VALUES ('33', 'white');

INSERT INTO HAS_COLOUR VALUES ('33', 'green');

INSERT INTO HAS_COLOUR VALUES ('34', 'red');

INSERT INTO HAS_COLOUR VALUES ('34', 'white');

INSERT INTO HAS_COLOUR VALUES ('34', 'green');

INSERT INTO HAS_COLOUR VALUES ('35', 'red');

INSERT INTO HAS_COLOUR VALUES ('35', 'white');

INSERT INTO HAS_COLOUR VALUES ('35', 'blue');

INSERT INTO HAS_COLOUR VALUES ('35', 'green');

INSERT INTO HAS_COLOUR VALUES ('36', 'red');

INSERT INTO HAS_COLOUR VALUES ('36', 'white');

INSERT INTO HAS_COLOUR VALUES ('36', 'blue');

INSERT INTO HAS_COLOUR VALUES ('36', 'green');

INSERT INTO HAS_COLOUR VALUES ('37', 'red');

INSERT INTO HAS_COLOUR VALUES ('37', 'white');

INSERT INTO HAS_COLOUR VALUES ('37', 'blue');

INSERT INTO HAS_COLOUR VALUES ('37', 'green');

INSERT INTO HAS_COLOUR VALUES ('38', 'yellow');

INSERT INTO HAS_COLOUR VALUES ('38', 'green');

INSERT INTO HAS_COLOUR VALUES ('39', 'yellow');

INSERT INTO HAS_COLOUR VALUES ('39', 'green');

INSERT INTO HAS_COLOUR VALUES ('39', 'orange');

INSERT INTO HAS_COLOUR VALUES ('40', 'yellow');

INSERT INTO HAS_COLOUR VALUES ('40', 'green');

INSERT INTO HAS_COLOUR VALUES ('40', 'white');

INSERT INTO HAS_COLOUR VALUES ('41', 'yellow');

INSERT INTO HAS_COLOUR VALUES ('41', 'green');

INSERT INTO HAS_COLOUR VALUES ('41', 'white');

INSERT INTO HAS_COLOUR VALUES ('42', 'yellow');

INSERT INTO HAS_COLOUR VALUES ('42', 'orange');

INSERT INTO HAS_COLOUR VALUES ('42', 'green');

INSERT INTO HAS_COLOUR VALUES ('43', 'yellow');

INSERT INTO HAS_COLOUR VALUES ('43', 'white');

INSERT INTO HAS_COLOUR VALUES ('43', 'green');

INSERT INTO HAS_COLOUR VALUES ('44', 'violet');

INSERT INTO HAS_COLOUR VALUES ('44', 'red');

INSERT INTO HAS_COLOUR VALUES ('44', 'white');

INSERT INTO HAS_COLOUR VALUES ('44', 'green');

INSERT INTO HAS_COLOUR VALUES ('45', 'violet');

INSERT INTO HAS_COLOUR VALUES ('45', 'black');

INSERT INTO HAS_COLOUR VALUES ('45', 'white');

INSERT INTO HAS_COLOUR VALUES ('45', 'green');

INSERT INTO HAS_COLOUR VALUES ('46', 'red');

INSERT INTO HAS_COLOUR VALUES ('46', 'yellow');

INSERT INTO HAS_COLOUR VALUES ('46', 'orange');

INSERT INTO HAS_COLOUR VALUES ('46', 'violet');

INSERT INTO HAS_COLOUR VALUES ('46', 'green');

INSERT INTO HAS_COLOUR VALUES ('47', 'red');

INSERT INTO HAS_COLOUR VALUES ('47', 'yellow');

INSERT INTO HAS_COLOUR VALUES ('47', 'orange');

INSERT INTO HAS_COLOUR VALUES ('47', 'green');

INSERT INTO HAS_COLOUR VALUES ('48', 'red');

INSERT INTO HAS_COLOUR VALUES ('48', 'yellow');

INSERT INTO HAS_COLOUR VALUES ('48', 'white');

INSERT INTO HAS_COLOUR VALUES ('48', 'green');

INSERT INTO HAS_COLOUR VALUES ('49', 'white');

INSERT INTO HAS_COLOUR VALUES ('49', 'yellow');

INSERT INTO HAS_COLOUR VALUES ('49', 'green');

INSERT INTO HAS_COLOUR VALUES ('50', 'red');

INSERT INTO HAS_COLOUR VALUES ('50', 'green');

INSERT INTO HAS_COLOUR VALUES ('50', 'white');

INSERT INTO FAVOURITES VALUES ('jovy', '11', to_date('20160103', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('erik', '11', to_date('20160104','YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('sara', '11', to_date('20160105', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('stephen', '11', to_date('20160103', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_to1', '11', to_date('20160104','YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_to2', '11', to_date('20160105', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_ot', '11', to_date('20160103', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sea', '11', to_date('20160104','YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_oly', '11', to_date('20160105', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd1', '11', to_date('20160103', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd2', '11', to_date('20160104','YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la1', '11', to_date('20160105', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la2', '11', to_date('20160103', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('jovy', '19', to_date('20160111', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('erik', '19', to_date('20160112', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('sara', '19', to_date('20160113', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('stephen', '19', to_date('20160111', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_to1', '19', to_date('20160112', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_to2', '19', to_date('20160113', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_ot', '19', to_date('20160111', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sea', '19', to_date('20160112', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_oly', '19', to_date('20160113', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd1', '19', to_date('20160111', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd2', '19', to_date('20160112', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la1', '19', to_date('20160113', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la2', '19', to_date('20160111', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('jovy', '37', to_date('20160116', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('erik', '37', to_date('20160116', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('sara', '37', to_date('20160116', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('stephen', '37', to_date('20160116', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_to1', '37', to_date('20160116', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_to2', '37', to_date('20160116', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_ot', '37', to_date('20160116', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sea', '37', to_date('20160116', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_oly', '37', to_date('20160116', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd1', '37', to_date('20160116', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd2', '37', to_date('20160116', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la1', '37', to_date('20160116', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la2', '37', to_date('20160116', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('jovy', '7', to_date('20160116', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('erik', '17', to_date('20160116', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('sara', '41', to_date('20160116', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('erik', '13', to_date('20160123', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('sara', '13', to_date('20160124', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('stephen', '13', to_date('20160123', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_to1', '13', to_date('20160124', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_to2', '13', to_date('20160123', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_ot', '13', to_date('20160124', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sea', '13', to_date('20160123', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_oly', '13', to_date('20160124', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd1', '13', to_date('20160123', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd2', '13', to_date('20160124', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la1', '13', to_date('20160123', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la2', '13', to_date('20160124', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('sara', '1', to_date('20160129', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('stephen', '1', to_date('20160129', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_to1', '1', to_date('20160129', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_to2', '1', to_date('20160129', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_ot', '1', to_date('20160129', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sea', '1', to_date('20160129', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_oly', '1', to_date('20160129', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd1', '1', to_date('20160129', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd2', '1', to_date('20160129', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la1', '1', to_date('20160129', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la2', '1', to_date('20160129', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('stephen', '21', to_date('20160201', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_to1', '21', to_date('20160201', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_to2', '21', to_date('20160201', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_ot', '21', to_date('20160201', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sea', '21', to_date('20160201', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_oly', '21', to_date('20160201', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd1', '21', to_date('20160201', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd2', '21', to_date('20160201', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la1', '21', to_date('20160201', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la2', '21', to_date('20160201', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_to1', '2', to_date('20160206', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_to2', '2', to_date('20160206', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_ot', '2', to_date('20160206', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sea', '2', to_date('20160206', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_oly', '2', to_date('20160206', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd1', '2', to_date('20160206', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd2', '2', to_date('20160206', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la1', '2', to_date('20160206', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la2', '2', to_date('20160206', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_to2', '34', to_date('20160217', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_ot', '34', to_date('20160217', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sea', '34', to_date('20160217', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_oly', '34', to_date('20160217', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd1', '34', to_date('20160217', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd2', '34', to_date('20160217', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la1', '34', to_date('20160217', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la2', '34', to_date('20160217', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_ot', '3', to_date('20160219', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sea', '3', to_date('20160219', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_oly', '3', to_date('20160219', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd1', '3', to_date('20160219', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd2', '3', to_date('20160219', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la1', '3', to_date('20160219', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la2', '3', to_date('20160219', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sea', '23', to_date('20160225', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_oly', '23', to_date('20160225', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd1', '23', to_date('20160225', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd2', '23', to_date('20160225', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la1', '23', to_date('20160225', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la2', '23', to_date('20160225', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_oly', '5', to_date('20160229', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd1', '5', to_date('20160229', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd2', '5', to_date('20160229', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la1', '5', to_date('20160229', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la2', '5', to_date('20160229', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd1', '29', to_date('20160307', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd2', '29', to_date('20160307', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la1', '29', to_date('20160307', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la2', '29', to_date('20160307', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_sd2', '8', to_date('20160312', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la1', '8', to_date('20160312', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la2', '8', to_date('20160312', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la1', '31', to_date('20160317', 'YYYYMMDD'));

INSERT INTO FAVOURITES VALUES ('user_la2', '31', to_date('20160317', 'YYYYMMDD'));

COMMIT;