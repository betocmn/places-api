-- Table: auth

-- DROP TABLE auth;

CREATE TABLE auth
(
  id serial NOT NULL,
  name character varying(255) NOT NULL,
  username character varying(255) NOT NULL,
  email character varying(255) NOT NULL,
  password character varying(255) NOT NULL,
  is_active boolean NOT NULL,
  created_at timestamp with time zone,
  updated_at timestamp with time zone,
  CONSTRAINT user_pkey PRIMARY KEY (id),
  CONSTRAINT auth_user_username_key UNIQUE (username)
)
WITH (
OIDS=FALSE
);
ALTER TABLE auth
OWNER TO places;

-- Index: auth_username

-- DROP INDEX auth_username;

CREATE INDEX auth_username
ON auth
USING btree
(username);

INSERT INTO auth (id, name, email, username, password, is_active, created_at, updated_at) VALUES (1, 'Places Root', 'humberto.mn@gmail.com', 'root', '$2a$08$zwmGQjKFFgW83G5EbGWzmuL2662pi9gvR0w7DIBXR1TIpMETbItli', 't', NOW(), NOW());


-- Table: google_geocode

-- DROP TABLE google_geocode;

CREATE TABLE google_geocode
(
  id serial NOT NULL,
  place_id character varying(128) NOT NULL,
  result_type character varying(64) NOT NULL,
  formatted_address character varying(512) NOT NULL,
  lattitude numeric(10,6) NOT NULL,
  longitude numeric(10,6) NOT NULL,
  location_type character varying(64) NOT NULL,
  vp_sw_latitude numeric(10,6) NOT NULL,
  vp_sw_longitude numeric(10,6) NOT NULL,
  vp_ne_latitude numeric(10,6) NOT NULL,
  vp_ne_longitude numeric(10,6) NOT NULL,
  bounds_sw_latitude numeric(10,6) NOT NULL,
  bounds_sw_longitude numeric(10,6) NOT NULL,
  bounds_ne_latitude numeric(10,6) NOT NULL,
  bounds_ne_longitude numeric(10,6) NOT NULL,
  partial_match boolean NOT NULL,
  created_at timestamp with time zone NOT NULL,
  updated_at timestamp with time zone,
  CONSTRAINT google_geocode_pkey PRIMARY KEY (id)
)
WITH (
OIDS=FALSE
);
ALTER TABLE google_geocode
OWNER TO places;

-- Index: google_geocode_place_id

-- DROP INDEX google_geocode_place_id;

CREATE INDEX google_geocode_place_id
ON google_geocode
USING btree
(place_id);



-- Once user places has been created
ALTER ROLE places SET client_encoding TO 'utf8';
ALTER ROLE places SET default_transaction_isolation TO 'read committed';
ALTER ROLE places SET timezone TO 'UTC';
GRANT ALL PRIVILEGES ON DATABASE places TO places;