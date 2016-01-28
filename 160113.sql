--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- Name: pgcrypto; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA public;


--
-- Name: EXTENSION pgcrypto; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON EXTENSION pgcrypto IS 'cryptographic functions';


SET search_path = public, pg_catalog;

--
-- Name: compute_last_year_forecast(integer, timestamp without time zone, numeric); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION compute_last_year_forecast(iid integer, ddate timestamp without time zone, dval numeric) RETURNS numeric
    LANGUAGE plpgsql
    AS $$
declare
	rerata numeric;
begin
	-- cari ada ga record atas indikator ini tahun lalu di bulan yang sama
	select avg(val) into rerata from data where data.indikator_id=iid and date_trunc('month',data.date)=(ddate- interval '1 year');
	-- kalau ada, cari rata-ratanya (YoY)
	if not found then
	-- kalau ga ada, ambil rata-rata dari bulan sebelumnya (MoM)
		begin
			select avg(val) into rerata from data where data.indikator_id=iid and date_trunc('month',data.date)=(ddate- interval '1 month');
			if not found then
				-- kalau ga ada juga, ambil rata-rata dari bulan berjalan
				begin
					select avg(val) into rerata from data where data.indikator_id=iid and date_trunc('month',data.date)=ddate;
					
				end;
			end if;
		end;	
	end if;
	if rerata is null then
						-- ga ada juga, assign default value
						rerata := dval;
					end if;	
	return rerata;
end;
$$;


--
-- Name: create_threshold(); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION create_threshold() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
declare
	fid integer;--frekuensi id
	data_month timestamp;	--latest date for inserted indikator (year and month)
	last_date date;			--latest date for inserted indicator's threshold
	fc numeric;	-- nilai yang diharapkan, kurang atau sama dengan ini masih baik. umumnya didapat dari rata2 data sebelumnya
begin
--pertama-tama cek tipenya apakah harian
--kalau harian, threshold dihitung dengan cara menghitung rata-rata 
--nilai indikator tersebut di bulan yang sama di tahun sebelumnya
--NEW di sini adalah new entry di table `data`
	select frekuensi into STRICT fid from indikator where indikator_id=NEW.indikator_id;
	-- fid == 1 artinya harian
	-- sementara kita handle yang harian dulu, yang lain bisa ditambahkan
	if fid = 1 then
		begin
			-- compute forecast value
			data_month := date_trunc('month',NEW.date);
			select compute_last_year_forecast(NEW.indikator_id, data_month,NEW.val) into fc;
			-- cek apakah data yang baru diinsert ini, sudah tercatat threshold nya di table threshold
			select last_data_date into last_date from triggered_threshold where indikator_id=NEW.indikator_id;
			if not found then
				begin 
					-- insert to triggered_threshold
					insert into triggered_threshold values(
						NEW.indikator_id, 		-- PK
						fc,				-- ideal forecast value
						array[fc*1.1],	-- any threshold
						now(),					-- it is triggered now
						NEW.date				-- new threshold, means it's defined and valid for NEW.date
					);
				end;
			else
				begin 
					-- sudah ada, bandingin bulannya. kalau sama hanya update
					-- last_data_date, kalau lebih baru, update threshold			
					if data_month > date_trunc('month',last_date) then
						--update
						update triggered_threshold set
							forecast=fc,
							threshold_vals=array[fc*1.1],
							time_triggered = now(),
							last_data_date = NEW.date
						where indikator_id=NEW.indikator_id;
					else
					update triggered_threshold set
							last_data_date = NEW.date
						where indikator_id=NEW.indikator_id;
					end if;
				end;
			end if;
		end;
	end if;
	return NEW;
end;
$$;


--
-- Name: mark_insert_data(); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION mark_insert_data() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.time_insert = now();
    RETURN NEW;	
END;
$$;


--
-- Name: mark_strategic(); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION mark_strategic() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
begin
	if NEW.is_strategic=true then
	
			--update anak2nya
			update indikator
			set is_strategic=NEW.is_strategic
			where parent_id=NEW.indikator_id;
	end if;
	return NEW;
end;
$$;


--
-- Name: mark_update_data(); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION mark_update_data() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.last_edit = now();
    RETURN NEW;	
END;
$$;


SET default_with_oids = false;

--
-- Name: ci_sessions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE ci_sessions (
    id character varying(40) NOT NULL,
    ip_address character varying(45) NOT NULL,
    "timestamp" bigint DEFAULT 0 NOT NULL,
    data text DEFAULT ''::text NOT NULL
);


--
-- Name: individu; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE individu (
    individu_id integer NOT NULL,
    name character varying(255),
    alias character varying(500),
    born_date date,
    born_place character varying(255),
    nationality character varying(255),
    detention_history text,
    detention_status text,
    education text,
    family_conn text,
    affiliation character varying(255)
);


--
-- Name: individu_individu_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE individu_individu_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: individu_individu_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE individu_individu_id_seq OWNED BY individu.individu_id;


--
-- Name: menus; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE menus (
    menu_id integer NOT NULL,
    display_name character varying(50),
    icon character varying(50),
    parent_menu integer,
    alias character varying(20)
);


--
-- Name: TABLE menus; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE menus IS 'available menus dan anak2nya';


--
-- Name: COLUMN menus.alias; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN menus.alias IS 'daripada alamatnya di url pakai id, bisa pakai alias';


--
-- Name: menus_menu_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE menus_menu_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: menus_menu_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE menus_menu_id_seq OWNED BY menus.menu_id;


--
-- Name: module; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE module (
    module_id integer NOT NULL,
    icon character varying(25),
    module_name character varying(25),
    hover_icon character varying(25)
);


--
-- Name: TABLE module; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE module IS 'dashboard adalah salah satu contoh module. Setiap module bisa diset privilege nya terhadap suatu role. Satu module diimplementasikan sebagai satu controller codeigniter.';


--
-- Name: COLUMN module.icon; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN module.icon IS 'sebuah module akan ditampilkan sebagai sebuah menu di topmenu. jika ada iconnya maka iconnya akan dipasang di menu tersebut.';


--
-- Name: COLUMN module.module_name; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN module.module_name IS 'ini juga merupakan nama controller nya. Misal <ip>/map/methodname itu berarti module_name = map. Dan nanti ada controller nya namanya map_controller.';


--
-- Name: COLUMN module.hover_icon; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN module.hover_icon IS 'kita bisa ngasih icon berbeda saat di hover';


--
-- Name: module_module_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE module_module_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: module_module_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE module_module_id_seq OWNED BY module.module_id;


--
-- Name: module_privilege; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE module_privilege (
    module_privilege_id integer NOT NULL,
    role_id integer NOT NULL,
    module_id integer NOT NULL,
    can_access boolean NOT NULL
);


--
-- Name: module_privilege_module_privilege_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE module_privilege_module_privilege_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: module_privilege_module_privilege_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE module_privilege_module_privilege_id_seq OWNED BY module_privilege.module_privilege_id;


--
-- Name: organization; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE organization (
    org_id integer NOT NULL,
    org_name character varying(255),
    address character varying(255),
    website character varying(255),
    email character varying(255),
    phone character varying(255),
    description text,
    source_id integer NOT NULL
);


--
-- Name: COLUMN organization.address; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN organization.address IS 'location / HQ location';


--
-- Name: COLUMN organization.website; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN organization.website IS 'website url address';


--
-- Name: COLUMN organization.description; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN organization.description IS 'any additional description as you see fit';


--
-- Name: organization_org_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE organization_org_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: organization_org_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE organization_org_id_seq OWNED BY organization.org_id;


--
-- Name: privilege; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE privilege (
    privilege_id integer NOT NULL,
    role_id integer NOT NULL,
    indikator_id integer NOT NULL,
    can_view boolean DEFAULT false NOT NULL
);


--
-- Name: TABLE privilege; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE privilege IS 'jadi by default semua role itu full access ke semua indikator. tapi terkadang mungkin ada indikator yang ingin di hide dsb, config nya di table ini.';


--
-- Name: privilege_privilege_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE privilege_privilege_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: privilege_privilege_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE privilege_privilege_id_seq OWNED BY privilege.privilege_id;


--
-- Name: role; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE role (
    role_id integer NOT NULL,
    name character(30),
    description character(40)
);


--
-- Name: role_role_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE role_role_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: role_role_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE role_role_id_seq OWNED BY role.role_id;


--
-- Name: source; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE source (
    source_id integer NOT NULL,
    source_name character varying(255)
);


--
-- Name: TABLE source; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE source IS 'yang ngasih data ke kita';


--
-- Name: source_source_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE source_source_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: source_source_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE source_source_id_seq OWNED BY source.source_id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE users (
    user_id integer NOT NULL,
    username character varying(50) NOT NULL,
    password character varying(100) NOT NULL,
    role_id integer NOT NULL,
    display_name character varying(50) NOT NULL
);


--
-- Name: users_user_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE users_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: users_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE users_user_id_seq OWNED BY users.user_id;


--
-- Name: individu_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY individu ALTER COLUMN individu_id SET DEFAULT nextval('individu_individu_id_seq'::regclass);


--
-- Name: menu_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY menus ALTER COLUMN menu_id SET DEFAULT nextval('menus_menu_id_seq'::regclass);


--
-- Name: module_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY module ALTER COLUMN module_id SET DEFAULT nextval('module_module_id_seq'::regclass);


--
-- Name: module_privilege_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY module_privilege ALTER COLUMN module_privilege_id SET DEFAULT nextval('module_privilege_module_privilege_id_seq'::regclass);


--
-- Name: org_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY organization ALTER COLUMN org_id SET DEFAULT nextval('organization_org_id_seq'::regclass);


--
-- Name: privilege_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY privilege ALTER COLUMN privilege_id SET DEFAULT nextval('privilege_privilege_id_seq'::regclass);


--
-- Name: role_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY role ALTER COLUMN role_id SET DEFAULT nextval('role_role_id_seq'::regclass);


--
-- Name: source_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY source ALTER COLUMN source_id SET DEFAULT nextval('source_source_id_seq'::regclass);


--
-- Name: user_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY users ALTER COLUMN user_id SET DEFAULT nextval('users_user_id_seq'::regclass);


--
-- Data for Name: ci_sessions; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO ci_sessions VALUES ('0478759a1003d04c4b81b8e86f566bcf461b0655', '::1', 1453897993, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUzODk3OTkwO3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('8981c5a025f7e862d60a69367e9aaf434cc1fb66', '::1', 1452657230, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUyNjU3MjIyO3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('e8c534dd75b2a6313599b12c881e870a57ff9a1b', '::1', 1453901065, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUzOTAxMDY0O3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('54b59df86e475be834acb65327a1fafe316c70d5', '::1', 1452655997, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUyNjU1OTE5O3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('aed929a44cfc7269f2e9d98dc1cfd9ed0a1e6bbf', '::1', 1453883401, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUzODgzMzc3O3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('8f83b02bae4977fe9f441f9cadef2a8a47caf298', '::1', 1453893861, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUzODkzODQ5O3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('e4ec85c2798fdebd2294c9e9839f6ab576b31d08', '::1', 1452649510, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUyNjQ4ODcxO3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('fb2663ca4a8baf19f1ccf094e66a2455d9cd48d7', '::1', 1452656522, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUyNjU2MjQ0O3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('dcdae0806ec0a1f3b966e44ee48e9fbe3c30d3ce', '::1', 1453898317, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUzODk4MzE2O3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('7012c0b5f292c43e7ec572cad881921071ea22eb', '::1', 1453901399, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUzOTAxMzk2O3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('03ebc826d517303a2692fa826411da469fa7ad5c', '::1', 1452653855, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUyNjUzNTY1O3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('72bdc15acaf84ec8f4253183794af42b9047c10a', '::1', 1453888004, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUzODg3NzI3O3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('842ca96548c4bce0b038e3def75d5a1283d180f4', '::1', 1453896300, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUzODk2MjAyO3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('d56fb55985c2542deeba8a726761600fa8f43858', '::1', 1452654413, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUyNjU0NDEzO3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('3cdefac08932983812c4e3c6d916076d0ed806a2', '::1', 1453891898, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUzODkxODk4O3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('6a6a759ee57f39b7cf6b1baa8f392f493ea89e1c', '::1', 1453896991, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUzODk2NzUxO3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('c16fc2fa6dbabb205a65c36fcb46a4d742ec3887', '::1', 1453900220, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUzODk5OTc2O3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('df9d386953f2a9659f128e35a0f9b7ecd22be9fc', '::1', 1453902386, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUzOTAyMTU2O3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('85e97a96ae6eefc5870ef3236a02ccc98aa48bfa', '::1', 1452655163, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUyNjU1MTM5O3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('108c03ce805a3e7ffc9f53b6299d3746bcf447eb', '::1', 1453900629, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUzOTAwMzg0O3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('c95955a41cf6af4a6e48b104e066a07146dff3c5', '::1', 1453893195, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUzODkzMDQxO3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('c08df54ebf550c35671a185cbd0907447b0db196', '::1', 1453902805, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUzOTAyNTc4O3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('30bbae4aea68753d1405759bfa81629a1c861518', '::1', 1452082692, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUyMDgyNDgyO3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('47d8ff00f690bc17e2e0dd977f9aed6f2d5a1278', '::1', 1453900709, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUzOTAwNzA3O3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('44b1387ace4ccc605ba49b1cf3bdd90af8b3cd99', '::1', 1452655787, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUyNjU1NjE0O3VzZXJfaWR8czoxOiIyIjs=');
INSERT INTO ci_sessions VALUES ('3d0aee67beed7e6e9071dd18e2559498a3f17075', '::1', 1453893736, 'X19jaV9sYXN0X3JlZ2VuZXJhdGV8aToxNDUzODkzNDQ0O3VzZXJfaWR8czoxOiIyIjs=');


--
-- Data for Name: individu; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO individu VALUES (1, 'Abdul Azis', 'Zaki, Eko', NULL, NULL, NULL, 'Arrested 24/5/2015 in Minasari, Rappocini, Makassar', 'On trial, in Kelapa Dua as of 12.2015', NULL, NULL, 'MIT');
INSERT INTO individu VALUES (2, 'Abdul Basit Tuzer', NULL, '1991-06-15', 'Kashgar, China', 'Uighur', 'Arrested 12 September 2014 in Parigi Mouton, Central Sulawesi en route to Santoso camp', '6 yrs as of  7/2015, in Kelapa Dua as of 1/15', NULL, NULL, NULL);
INSERT INTO individu VALUES (3, 'Abdul Gani Siregar', 'Gani, Regar, Gar', '1982-02-16', 'Belawan', 'Indonesian/Batak', 'ESCAPED LP Tanjung Gusta 11 July 2013, rearrested 27/8/2013 in Riau. Arrested on 3 October 2010 in connection with CIMB bank  robbery, Medan 8/2010 and assault on Hamparan Perak police station, 22//9/2010. Accused of terrorism and UU Darurat 12/1951, articles 340, 338, 365 of criminal code', '10 yrs, 4/8/2011
In LP Medan as of 11/2014
', 'Worked as construction coolie. From 2005, was in the pengajian of Pak Hasbi, the man killed in Cawang on 12 May 2010 with Ahmad Sayid Mauland who was unidentified for a month. Same pengajian as Robin Simanjuntak and several others who took part in CIMB robbery. Worked as volunteer with MER-C after Aceh tsunami together with Ridwan @Iwan (dec.)', NULL, 'Preman');


--
-- Name: individu_individu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('individu_individu_id_seq', 3, true);


--
-- Data for Name: menus; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO menus VALUES (1, 'Master data', 'masters.png', NULL, 'master');
INSERT INTO menus VALUES (2, 'Organisasi', 'org.png', 1, 'organisasi');
INSERT INTO menus VALUES (3, 'Individual', 'individu.png', 1, 'individu');
INSERT INTO menus VALUES (4, 'Catatan migrasi', 'migrasi.png', 1, 'migrasi');


--
-- Name: menus_menu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('menus_menu_id_seq', 4, true);


--
-- Data for Name: module; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO module VALUES (2, 'analisis.png', 'analysis', 'analisis-hover.png');
INSERT INTO module VALUES (3, 'compare.png', 'compare', 'compare-hover.png');
INSERT INTO module VALUES (5, 'live.png', 'live', 'live-hover.png');
INSERT INTO module VALUES (4, 'map2.png', 'map', 'map-hover2.png');
INSERT INTO module VALUES (0, NULL, 'admin', NULL);
INSERT INTO module VALUES (1, 'upload.png', 'upload', 'upload.png');


--
-- Name: module_module_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('module_module_id_seq', 5, true);


--
-- Data for Name: module_privilege; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO module_privilege VALUES (5, 1, 1, true);
INSERT INTO module_privilege VALUES (6, 1, 2, true);
INSERT INTO module_privilege VALUES (7, 1, 3, true);
INSERT INTO module_privilege VALUES (8, 1, 4, true);
INSERT INTO module_privilege VALUES (9, 1, 5, true);
INSERT INTO module_privilege VALUES (1, 2, 2, true);
INSERT INTO module_privilege VALUES (4, 2, 5, true);
INSERT INTO module_privilege VALUES (3, 2, 4, true);
INSERT INTO module_privilege VALUES (2, 2, 3, false);
INSERT INTO module_privilege VALUES (10, 4, 1, true);
INSERT INTO module_privilege VALUES (11, 1, 0, true);


--
-- Name: module_privilege_module_privilege_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('module_privilege_module_privilege_id_seq', 11, true);


--
-- Data for Name: organization; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO organization VALUES (10, 'Pondok Pesantren Islam al-Izzah', 'Tragal, Kedungpapar, Sumobito, Jombang 61483', '', '', '(0321) 6274845, 085235694660', '<p class="MsoNormal" style="text-align:justify"><span style="font-size:11.0pt;
mso-ansi-language:IN;mso-bidi-font-weight:bold">Ust. Zubad Dahry, Lc<o:p></o:p></span></p>

<p class="MsoNormal" style="text-align:justify"><span style="font-size:11.0pt;
mso-ansi-language:IN;mso-bidi-font-weight:bold">Ad in an-Najah, May 2010<o:p></o:p></span></p>', 1);
INSERT INTO organization VALUES (5, 'Pondok Pesantren al Furqan', 'Jl Joyo Utomo Blok F/5 Merjosari, Malang, East Java', '', '', '0341 557537', '<span lang="EN-US" style="font-size:11.0pt;font-family:
&quot;Times New Roman&quot;,&quot;serif&quot;;mso-fareast-font-family:&quot;Times New Roman&quot;;mso-ansi-language:
EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA;mso-bidi-font-weight:
bold">Pengasuh: Ust. H. SUmarsono, Ust. Abu Badurrahman Al Haidary (an-Najah
July 2010)</span>', 1);
INSERT INTO organization VALUES (7, 'Pondok Pesantren Ar-Rahmah', 'Madiun', '', '', '', '', 1);
INSERT INTO organization VALUES (8, 'Pondok Pesantren Darul Manar', 'Jl. Kepung no.99, Gadungan, Puncu, Kediri', 'http://darul-manar.blogspot.com', 'almanar_online@yahoo.com', '(0345) 398460', '<p class="MsoNormal"><span lang="EN-AU" style="font-size:11.0pt;mso-ansi-language:
EN-AU;mso-bidi-font-weight:bold">now center of JAT activity<o:p></o:p></span></p>

<p class="MsoNormal"><span lang="EN-AU" style="font-size:11.0pt;mso-ansi-language:
EN-AU;mso-bidi-font-weight:bold">Contact: Bpk. Suroso, Toko Sepatu Bintang Sembilan,
Jl. Piyungan, Prambanan (ruko barat Pasar Prambanan) Yogyakarta. Tel. (0274)
492055<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-size:11.0pt;mso-ansi-language:IN;
mso-bidi-font-weight:bold">Run by Ustadz Agus (from Umar Burhanuddin’s
testimony). Asep Jaya''s wife is from here.</span><span lang="EN-US" style="font-size:11.0pt;mso-bidi-font-weight:bold"><o:p></o:p></span></p>

<p class="MsoNormal"><span lang="EN-US" style="font-size:11.0pt;mso-bidi-font-weight:
bold">Baharudin Soleh alias Abdul Hadi, killed Wonosobo 2006, taught here.<o:p></o:p></span></p>

<p class="MsoNormal"><span lang="EN-AU" style="font-size:11.0pt;mso-ansi-language:
EN-AU;mso-bidi-font-weight:bold">Advert in <i>An-Najah</i>
June 2009.<o:p></o:p></span></p>', 1);
INSERT INTO organization VALUES (6, 'Pondok Pesantren Al Islam', 'Tenggulan, Lamongan', '', '', '', '<p class="MsoNormal"><span lang="ES" style="font-size:11.0pt;mso-ansi-language:
ES">Satellite school of Ngruki, home of executed Bali bombers Mukhlas and
Amrozi.<o:p></o:p></span></p>

<p class="MsoNormal"><span lang="ES" style="font-size:11.0pt;mso-ansi-language:
ES">Linked to publisher Khafilah Syuhadah Media Center which published books
written by the three Bali bombers.</span><span lang="EN-US" style="font-size:
11.0pt"><o:p></o:p></span></p>

<p class="MsoNormal"><span lang="ES" style="font-size:11.0pt;mso-ansi-language:
ES">Pengurus: Ustadz</span><span lang="EN-AU" style="font-size:11.0pt;mso-ansi-language:
EN-AU"> Chozin</span><span lang="ES" style="font-size:11.0pt;mso-ansi-language:
ES"> and Ustadz Jafar</span><span lang="EN-AU" style="font-size:11.0pt;
mso-ansi-language:EN-AU"> Shodiq</span><span lang="ES" style="font-size:11.0pt;
mso-ansi-language:ES">. Mudir: Ustadz Zakaria.<o:p></o:p></span></p>

<p class="MsoNormal"><span lang="ES" style="font-size:11.0pt;mso-ansi-language:
ES">[<span style="background:yellow;mso-highlight:yellow">for more on this
school, see IPAC report No.</span></span><span lang="EN-US" style="background:
yellow;mso-highlight:yellow"> 18 </span><span lang="ES" style="font-size:11.0pt;
background:yellow;mso-highlight:yellow;mso-ansi-language:ES">https://www.academia.edu/11967434/Indonesias_Lamongan_Network_How_East_Java_Poso_and_Syria_Are_Linked]</span><span lang="ES" style="font-size:11.0pt;mso-ansi-language:ES"><o:p></o:p></span></p>', 1);
INSERT INTO organization VALUES (3, 'Pondok Pesantren Al Ikhlash', 'Jl. Kamboja Gg. Al Ikhlash (P.O. Box 28), Sedayulawas, Brondong, Lamongan', 'http://ponpes-alikhlash.blogspot.com ', '', '0812 666172, 0852 35093851, 0852 30230600, (0322) 664184', '<p class="MsoNormal"><span lang="EN-US" style="font-size:11.0pt"><b>A school for girls.
Mudir: Ustadz Azhari Dipo Kusuma (same Ngruki class as Agus Supriyadi and
Zakaria).</b></span></p>

<span lang="EN-US" style="font-size:11.0pt;font-family:&quot;Times New Roman&quot;,&quot;serif&quot;;
mso-fareast-font-family:&quot;Times New Roman&quot;;mso-ansi-language:EN-US;mso-fareast-language:
EN-US;mso-bidi-language:AR-SA">Advert in <i>Ar-Risalah</i>
June 2007, June 2008, <i>An-Najah</i> June
2008.</span>', 1);
INSERT INTO organization VALUES (13, 'Pondok Pesantren Al-Uswah', 'Sumenep', '', '', '', '', 1);
INSERT INTO organization VALUES (15, 'Pondok Pesantren Modern Al Islamiyah', 'Kalitatak, Kangean', '', '', '', '<span lang="SV" style="font-size:11.0pt;font-family:
&quot;Times New Roman&quot;,&quot;serif&quot;;mso-fareast-font-family:&quot;Times New Roman&quot;;background:
yellow;mso-highlight:yellow;mso-ansi-language:SV;mso-fareast-language:EN-US;
mso-bidi-language:AR-SA">One of the directors is Ustadz Muhammad Hasan</span>', 1);
INSERT INTO organization VALUES (12, 'Pondok Pesantren Ma''had Aly Darul Wahyain (MADW)', 'Desa Sumberagung, Kecamatan Plaosan, Kabupaten Magetan', 'www.darulwahyain.wordpress.com ; www.darulwahyain-kontak.blogspot.com', '', '', '<p class="MsoNormal" style="text-align:justify"><span style="font-size:11.0pt;
mso-ansi-language:IN">Contacts:Ustadz Rosyid Ridlo Ba''asyir (eldest son of Abu
Bakar Ba''asyir) tel. 0817 9491 5962, <o:p></o:p></span></p>

<p class="MsoNormal" style="text-align:justify"><span style="font-size:11.0pt;
mso-ansi-language:IN">Ustadz Umar Burhanuddin Al-Hafdiz tel. 0813 5969 9462<o:p></o:p></span></p>

<p class="MsoNormal" style="text-align:justify"><span style="font-size:11.0pt;
mso-ansi-language:IN">Appears to be an offshoot of Pondok Pesantren Al Mukmin<o:p></o:p></span></p>', 1);
INSERT INTO organization VALUES (9, 'Pondok Pesantren Islam Baitul Amin', 'Jl. Sawunggaling no.6, Mojoanyar, Bareng, Jombang 61474', 'www.baitulamin.af-i.net', 'bayt_elamin@plasma.com', '(0321) 710544 - 7292066, 0813 3500 0820', '<p class="MsoNormal"><span lang="EN-US" style="font-size:11.0pt;mso-bidi-font-weight:
bold">Mudir: Ustadz Cecep Iwan Ridwan. Head of Yayasan: H. Ahmad Yulianto.<o:p></o:p></span></p>

<p class="MsoNormal"><span lang="EN-US" style="font-size:11.0pt;mso-bidi-font-weight:
bold">Cecep Iwan Ridwan is from Ngruki class of 1995.<o:p></o:p></span></p>

<span lang="EN-US" style="font-size:11.0pt;font-family:&quot;Times New Roman&quot;,&quot;serif&quot;;
mso-fareast-font-family:&quot;Times New Roman&quot;;mso-ansi-language:EN-US;mso-fareast-language:
EN-US;mso-bidi-language:AR-SA;mso-bidi-font-weight:bold">Advert in <i>Ar-Risalah</i> July 2007, <i>An-Najah</i> June 2008, May 2009.</span>', 1);
INSERT INTO organization VALUES (16, 'Pondok Pesantren Darul Hawariyin', 'Kangean', '', '', '', '', 1);
INSERT INTO organization VALUES (1, 'Pondok Pesantren Al Ihsan', 'Ds. Mojorejo. Kebonsari, Madiun', '', '', '0813 29304100, 0852 35547773 0813 35700983', '<p class="MsoNormal"><span lang="EN-US" style="font-size:11.0pt;mso-bidi-font-weight:
bold">Established by Ngruki alumni, a small pesantren at the back of Amrozi''s
in-laws'' house. Registration through Ustadz Habib Ngadiri, Ngruki (Ngruki
86-87); Edy Subianto in Surabaya; Azhari Dipo Kusumo of Pesantren al-Ikhlas in
Lamongan (Ngruki 91-92); Joyo Sugih Harto in Purwodadi; or Ustadz Seno in
Sumenep. Al-Ihsan men joined the JI rombongan to Mecca led by Abu Kholiq and
Abu Fatih that just returned.<o:p></o:p></span></p>

<p class="MsoNormal"><span lang="EN-US" style="font-size:11.0pt;mso-bidi-font-weight:
bold">Mudir: Joko Supriyanto (born in Boyolali, Ngruki class of 88-89, same
class as Faturrahman al-Ghozi, who was from Madiun). Supriyanto comes up in
some of the BAPs as administering the JI bai’at to new members (eg Masrizal
alias Tohir of the first Marriott bombing). Taught at Ngruki in the mid-1990s.<o:p></o:p></span></p>

<p class="MsoNormal"><span lang="EN-US" style="font-size:11.0pt;mso-bidi-font-weight:
bold">Advertises Depag curriculum but also has separate MTI (JI) program, not mentioned
in brochure.<o:p></o:p></span></p>

<p class="MsoNormal"><span lang="EN-US" style="font-size:11.0pt;mso-bidi-font-weight:
bold">Advert in <i>Ar-Risalah</i> May 2011.<o:p></o:p></span></p>', 1);
INSERT INTO organization VALUES (11, 'Pondok Pesantren al-Muslimun', 'Desa Sumberagung, Kecamatan Plaosan, Magetan', '', '', '', '<p class="MsoNormal"><span style="font-size:11.0pt;mso-ansi-language:IN;
mso-bidi-font-weight:bold">Run by Ubeid’s parents. His father, Bukhori, is head
of its yayasan.<o:p></o:p></span></p>

<p class="MsoNormal"><span lang="EN-US" style="font-size:11.0pt">"Ponpes khusus
putri pencetak penghafal Al-Qur’an ini, saat ini memiliki anak asuh sebanyak 81
santri. 41 anak diantaranya adalah dari kalangan kurang mampu secara ekonomi.
Biaya pendidikan, asrama, makan, dll adalah menjadi tanggungan panti. Padahal
untuk biaya per anak adalah sebesar Rp. 200.000 per bulan."</span><span style="font-size:11.0pt;mso-ansi-language:IN;mso-bidi-font-weight:bold"><o:p></o:p></span></p>

<p class="MsoNormal"><span lang="EN-US" style="font-size:11.0pt"><a href="http://yfa-magetan.blogspot.com/2009/03/santunan-pendidikan-yatim.html"><span lang="IN" style="color:#0000CC;mso-ansi-language:IN">http://yfa-magetan.blogspot.com/2009/03/santunan-pendidikan-yatim.html</span></a></span><span style="font-size:11.0pt;background:yellow;mso-highlight:yellow;mso-ansi-language:
IN"><o:p></o:p></span></p>', 1);
INSERT INTO organization VALUES (18, 'Pondok Pesantren Al-Muhibbin', 'Kangean', '', '', '', '', 1);
INSERT INTO organization VALUES (17, 'Pondok Pesantren Al-Hikmah', 'Kangean', '', '', '', '', 1);


--
-- Name: organization_org_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('organization_org_id_seq', 18, true);


--
-- Data for Name: privilege; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Name: privilege_privilege_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('privilege_privilege_id_seq', 1, false);


--
-- Data for Name: role; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO role VALUES (1, 'superadmin                    ', NULL);
INSERT INTO role VALUES (2, 'deputi                        ', NULL);
INSERT INTO role VALUES (3, 'staf                          ', NULL);
INSERT INTO role VALUES (4, 'uploader                      ', NULL);
INSERT INTO role VALUES (5, 'superviewer                   ', NULL);


--
-- Name: role_role_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('role_role_id_seq', 5, true);


--
-- Data for Name: source; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO source VALUES (1, 'Sidney Jones');


--
-- Name: source_source_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('source_source_id_seq', 1, true);


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO users VALUES (1, 'yun', '$2a$08$hLwrV9hYMjVnPRm/sTP2JOH71hWEVKCM7phON2ksHLEiOTOZLi7am', 1, 'Jun');
INSERT INTO users VALUES (2, 'dimas', '$2a$08$99zzBQVAHbram3Nqij7Pn.554CoZz22KeUZibyNXKzrSYXLEuwGJm', 1, 'Dimas');
INSERT INTO users VALUES (3, 'yudhi', '$2a$08$9qi/d8RTUCExeJwmGXVkveN8p9z5UP1vusbOwnWa6oS7QvHqfB4yG', 2, 'Yudhi');
INSERT INTO users VALUES (4, 'tester', '$2a$08$o/5DAFw.N46GQVhnXbsKj.egvo6QuPybO.B.DyzLVjDsb2oSmbAXO', 2, 'Tester');
INSERT INTO users VALUES (5, 'eddy', '$2a$08$FzcxUWbHznUTGVFfp3O//OGciUF9y5BEQotqTrIlb7hSYX8Kh2DTG', 2, 'Eddy');
INSERT INTO users VALUES (6, 'marsahala', '$2a$08$6byRcQ3T9zQBpN8kpgiixeqwEVdOokPrEUw3oTQUysPIG0yFNhq2C', 4, 'Shita');


--
-- Name: users_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('users_user_id_seq', 7, true);


--
-- Name: ci_sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY ci_sessions
    ADD CONSTRAINT ci_sessions_pkey PRIMARY KEY (id);


--
-- Name: individu_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY individu
    ADD CONSTRAINT individu_pkey PRIMARY KEY (individu_id);


--
-- Name: menus_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY menus
    ADD CONSTRAINT menus_pkey PRIMARY KEY (menu_id);


--
-- Name: module_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY module
    ADD CONSTRAINT module_pkey PRIMARY KEY (module_id);


--
-- Name: module_privilege_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY module_privilege
    ADD CONSTRAINT module_privilege_pkey PRIMARY KEY (module_privilege_id);


--
-- Name: organization_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY organization
    ADD CONSTRAINT organization_pkey PRIMARY KEY (org_id);


--
-- Name: privilege_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY privilege
    ADD CONSTRAINT privilege_pkey PRIMARY KEY (privilege_id);


--
-- Name: role_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY role
    ADD CONSTRAINT role_pkey PRIMARY KEY (role_id);


--
-- Name: source_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY source
    ADD CONSTRAINT source_pkey PRIMARY KEY (source_id);


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (user_id);


--
-- Name: ci_sessions_timestamp; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX ci_sessions_timestamp ON ci_sessions USING btree ("timestamp");


--
-- Name: fki_source; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX fki_source ON organization USING btree (source_id);


--
-- Name: module_privilege_module_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY module_privilege
    ADD CONSTRAINT module_privilege_module_id_fkey FOREIGN KEY (module_id) REFERENCES module(module_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: module_privilege_role_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY module_privilege
    ADD CONSTRAINT module_privilege_role_id_fkey FOREIGN KEY (role_id) REFERENCES role(role_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: privilege_role_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY privilege
    ADD CONSTRAINT privilege_role_id_fkey FOREIGN KEY (role_id) REFERENCES role(role_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: source; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY organization
    ADD CONSTRAINT source FOREIGN KEY (source_id) REFERENCES source(source_id);


--
-- Name: users_role_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_role_id_fkey FOREIGN KEY (role_id) REFERENCES role(role_id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- PostgreSQL database dump complete
--

