--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: area_de_trabajo; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE area_de_trabajo (
    cod_area_trabajo character varying(50) NOT NULL,
    nombre character varying(200)
);


ALTER TABLE public.area_de_trabajo OWNER TO root;

--
-- Name: cargo; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE cargo (
    id integer NOT NULL,
    id_fam integer,
    codigo character varying(50) NOT NULL,
    codtno character varying(50),
    codgra character varying(50),
    nombre character varying(50) NOT NULL,
    clave boolean,
    descripcion text,
    funciones text,
    cod_cargo_opsu character varying(50)
);


ALTER TABLE public.cargo OWNER TO root;

--
-- Name: TABLE cargo; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON TABLE cargo IS 'Tabla de cargos registrados en el sistema';


--
-- Name: cargo_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE cargo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cargo_id_seq OWNER TO root;

--
-- Name: cargo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE cargo_id_seq OWNED BY cargo.id;


--
-- Name: cargo_opsu; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE cargo_opsu (
    cod_cargo_opsu character varying(50) NOT NULL,
    nombre_opsu character varying(200)
);


ALTER TABLE public.cargo_opsu OWNER TO root;

--
-- Name: condiciones; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE condiciones (
    id character varying(50) NOT NULL,
    nombre character varying(200)
);


ALTER TABLE public.condiciones OWNER TO root;

--
-- Name: correo; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE correo (
    id_per integer,
    destino character varying(50) NOT NULL,
    asunto character varying(200) NOT NULL,
    mensaje text NOT NULL
);


ALTER TABLE public.correo OWNER TO root;

--
-- Name: TABLE correo; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON TABLE correo IS 'Tabla de correos-e enviados por el sistema';


--
-- Name: encuesta_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE encuesta_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.encuesta_id_seq OWNER TO root;

--
-- Name: encuesta; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE encuesta (
    id integer DEFAULT nextval('encuesta_id_seq'::regclass) NOT NULL,
    id_encuesta_ls integer NOT NULL,
    id_fam integer NOT NULL,
    id_unidad integer NOT NULL,
    estado boolean,
    actual boolean
);


ALTER TABLE public.encuesta OWNER TO root;

--
-- Name: TABLE encuesta; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON TABLE encuesta IS 'Tabla de encuestas registradas en el sistema';


--
-- Name: COLUMN encuesta.id; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON COLUMN encuesta.id IS 'Identificador de la encuesta en el sistema';


--
-- Name: COLUMN encuesta.id_encuesta_ls; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON COLUMN encuesta.id_encuesta_ls IS 'Identificador de la encuesta en Limesurvey';


--
-- Name: COLUMN encuesta.id_fam; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON COLUMN encuesta.id_fam IS 'Identificador de la familia de cargos asociada a la encuesta';


--
-- Name: COLUMN encuesta.id_unidad; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON COLUMN encuesta.id_unidad IS 'Identificador de la unidad asociada a la encuesta';


--
-- Name: COLUMN encuesta.estado; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON COLUMN encuesta.estado IS 'Estado actual de la encuesta';


--
-- Name: COLUMN encuesta.actual; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON COLUMN encuesta.actual IS 'Vigencia de la encuesta en el sistema';


--
-- Name: encuesta_ls; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE encuesta_ls (
    id_encuesta_ls integer NOT NULL,
    id_fam integer,
    actual boolean DEFAULT true
);


ALTER TABLE public.encuesta_ls OWNER TO root;

--
-- Name: TABLE encuesta_ls; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON TABLE encuesta_ls IS 'Tabla de encuestas de Limesurvey importadas al sistema';


--
-- Name: error; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE error (
    id_error integer NOT NULL,
    mensaje text NOT NULL
);


ALTER TABLE public.error OWNER TO root;

--
-- Name: error_id_error_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE error_id_error_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.error_id_error_seq OWNER TO root;

--
-- Name: error_id_error_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE error_id_error_seq OWNED BY error.id_error;


--
-- Name: evaluacion_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE evaluacion_id_seq
    START WITH 0
    INCREMENT BY 1
    MINVALUE 0
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.evaluacion_id_seq OWNER TO root;

--
-- Name: evaluacion; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE evaluacion (
    id integer DEFAULT nextval('evaluacion_id_seq'::regclass) NOT NULL,
    periodo text,
    fecha_ini character varying(10),
    fecha_fin character varying(10),
    actual boolean
);


ALTER TABLE public.evaluacion OWNER TO root;

--
-- Name: TABLE evaluacion; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON TABLE evaluacion IS 'Tabla de procesos de evaluación iniciados en el sistema';


--
-- Name: familia_cargo; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE familia_cargo (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL,
    descripcion text
);


ALTER TABLE public.familia_cargo OWNER TO root;

--
-- Name: TABLE familia_cargo; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON TABLE familia_cargo IS 'Tabla de familias de cargos registradas en el sistema';


--
-- Name: familia_cargo_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE familia_cargo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.familia_cargo_id_seq OWNER TO root;

--
-- Name: familia_cargo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE familia_cargo_id_seq OWNED BY familia_cargo.id;


--
-- Name: familia_rol; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE familia_rol (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL,
    descripcion text
);


ALTER TABLE public.familia_rol OWNER TO root;

--
-- Name: familia_rol_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE familia_rol_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.familia_rol_id_seq OWNER TO root;

--
-- Name: familia_rol_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE familia_rol_id_seq OWNED BY familia_rol.id;


--
-- Name: notificacion_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE notificacion_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.notificacion_id_seq OWNER TO root;

--
-- Name: notificacion; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE notificacion (
    id integer DEFAULT nextval('notificacion_id_seq'::regclass) NOT NULL,
    tipo integer NOT NULL,
    id_per integer NOT NULL,
    token_ls_per text NOT NULL,
    revisado boolean DEFAULT false NOT NULL,
    fecha character varying(16) NOT NULL,
    mensaje text
);


ALTER TABLE public.notificacion OWNER TO root;

--
-- Name: TABLE notificacion; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON TABLE notificacion IS 'Tabla de notificaciones al administrador del sistema';


--
-- Name: organizacion; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE organizacion (
    id integer NOT NULL,
    idsup integer,
    nombre character varying(500) NOT NULL,
    codigo character varying(50),
    descripcion text,
    observacion text,
    cod_autoridad character varying(50),
    autoridad character varying(200)
);


ALTER TABLE public.organizacion OWNER TO root;

--
-- Name: TABLE organizacion; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON TABLE organizacion IS 'Tabla de unidades universitarias registradas en el sistema';


--
-- Name: organizacion_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE organizacion_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.organizacion_id_seq OWNER TO root;

--
-- Name: organizacion_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE organizacion_id_seq OWNED BY organizacion.id;


--
-- Name: persona; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE persona (
    id integer NOT NULL,
    tipo integer,
    nombre character varying(50) NOT NULL,
    apellido character varying(50) NOT NULL,
    cedula character varying(50) NOT NULL,
    sexo character(1),
    fecha_nac character varying(10),
    unidad text,
    direccion text,
    telefono character varying(15),
    email character varying(50),
    activo boolean,
    seccion character varying(50),
    condicion character varying(50),
    rol integer,
    fecha_ing character varying(10)
);


ALTER TABLE public.persona OWNER TO root;

--
-- Name: TABLE persona; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON TABLE persona IS 'Tabla del personal registrado en el sistema';


--
-- Name: COLUMN persona.rol; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON COLUMN persona.rol IS 'Rol para el tipo de encuesta que se le va a aplicar';


--
-- Name: COLUMN persona.fecha_ing; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON COLUMN persona.fecha_ing IS 'Fecha de Ingreso a la Universidad Simón Bolívar';


--
-- Name: persona_cargo; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE persona_cargo (
    id_per integer,
    id_car integer,
    actual boolean,
    fecha_ini character varying(10),
    fecha_fin character varying(10),
    observacion text
);


ALTER TABLE public.persona_cargo OWNER TO root;

--
-- Name: TABLE persona_cargo; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON TABLE persona_cargo IS 'Tabla de cargos asignados al personal registrado en el sistema';


--
-- Name: persona_encuesta; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE persona_encuesta (
    id_encuesta integer NOT NULL,
    id_encuesta_ls integer NOT NULL,
    token_ls text NOT NULL,
    tid_ls integer,
    periodo integer,
    id_car integer,
    id_unidad integer,
    tipo text,
    id_encuestado integer,
    id_evaluado integer,
    estado text,
    actual boolean,
    fecha character varying(16),
    ip text,
    retroalimentacion text DEFAULT 'sin realizar'::text
);


ALTER TABLE public.persona_encuesta OWNER TO root;

--
-- Name: TABLE persona_encuesta; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON TABLE persona_encuesta IS 'Tabla de encuestas del personal evaluado';


--
-- Name: COLUMN persona_encuesta.retroalimentacion; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON COLUMN persona_encuesta.retroalimentacion IS 'Valor que indica si se realizaron compromisos y retroalimentación al final de la evaluación';


--
-- Name: persona_evaluador; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE persona_evaluador (
    id_per integer,
    id_eva integer,
    actual boolean,
    fecha_ini character varying(10),
    fecha_fin character varying(10),
    observacion text
);


ALTER TABLE public.persona_evaluador OWNER TO root;

--
-- Name: TABLE persona_evaluador; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON TABLE persona_evaluador IS 'Tabla de evaluadores (supervisores inmediatos) asignados al personal registrado en el sistema';


--
-- Name: persona_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE persona_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.persona_id_seq OWNER TO root;

--
-- Name: persona_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE persona_id_seq OWNED BY persona.id;


--
-- Name: persona_supervisor; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE persona_supervisor (
    id_per integer,
    id_sup integer,
    actual boolean,
    fecha_ini character varying(10),
    fecha_fin character varying(10),
    observacion text
);


ALTER TABLE public.persona_supervisor OWNER TO root;

--
-- Name: TABLE persona_supervisor; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON TABLE persona_supervisor IS 'Tabla de supervisores jerárquicos asignados al personal registrado en el sistema';


--
-- Name: pregunta_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE pregunta_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pregunta_id_seq OWNER TO root;

--
-- Name: pregunta; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE pregunta (
    id_pregunta integer DEFAULT nextval('pregunta_id_seq'::regclass) NOT NULL,
    id_pregunta_ls integer,
    id_encuesta_ls integer,
    seccion text,
    titulo text,
    id_pregunta_root_ls integer
);


ALTER TABLE public.pregunta OWNER TO root;

--
-- Name: TABLE pregunta; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON TABLE pregunta IS 'Tabla de preguntas de una encuesta';


--
-- Name: pregunta_peso; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE pregunta_peso (
    id_pregunta integer NOT NULL,
    id_encuesta integer NOT NULL,
    peso real DEFAULT 1
);


ALTER TABLE public.pregunta_peso OWNER TO root;

--
-- Name: TABLE pregunta_peso; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON TABLE pregunta_peso IS 'Tabla con los pesos asociados a la evaluación de factores';


--
-- Name: respuesta; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE respuesta (
    token_ls text,
    id_pregunta integer,
    respuesta text
);


ALTER TABLE public.respuesta OWNER TO root;

--
-- Name: TABLE respuesta; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON TABLE respuesta IS 'Tabla de respuestas de una evaluación registrada en el sistema';


--
-- Name: supervisor_encuesta; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE supervisor_encuesta (
    id_sup integer NOT NULL,
    token_ls_eva text NOT NULL,
    aprobado boolean,
    fecha character varying(16),
    ip text,
    retroalimentacion text
);


ALTER TABLE public.supervisor_encuesta OWNER TO root;

--
-- Name: TABLE supervisor_encuesta; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON TABLE supervisor_encuesta IS 'Tabla de evaluaciones supervisadas';


--
-- Name: COLUMN supervisor_encuesta.retroalimentacion; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON COLUMN supervisor_encuesta.retroalimentacion IS 'Valor que indica si se realizaron compromisos y retroalimentación al final de la evaluación';


--
-- Name: usuario; Type: TABLE; Schema: public; Owner: root; Tablespace: 
--

CREATE TABLE usuario (
    id integer NOT NULL,
    username character varying(50) NOT NULL
);


ALTER TABLE public.usuario OWNER TO root;

--
-- Name: usuario_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE usuario_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuario_id_seq OWNER TO root;

--
-- Name: usuario_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE usuario_id_seq OWNED BY usuario.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY cargo ALTER COLUMN id SET DEFAULT nextval('cargo_id_seq'::regclass);


--
-- Name: id_error; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY error ALTER COLUMN id_error SET DEFAULT nextval('error_id_error_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY familia_cargo ALTER COLUMN id SET DEFAULT nextval('familia_cargo_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY familia_rol ALTER COLUMN id SET DEFAULT nextval('familia_rol_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY organizacion ALTER COLUMN id SET DEFAULT nextval('organizacion_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY persona ALTER COLUMN id SET DEFAULT nextval('persona_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY usuario ALTER COLUMN id SET DEFAULT nextval('usuario_id_seq'::regclass);


--
-- Data for Name: area_de_trabajo; Type: TABLE DATA; Schema: public; Owner: root
--

COPY area_de_trabajo (cod_area_trabajo, nombre) FROM stdin;
01	Mi Area de Trabajo
\.


--
-- Data for Name: cargo; Type: TABLE DATA; Schema: public; Owner: root
--

COPY cargo (id, id_fam, codigo, codtno, codgra, nombre, clave, descripcion, funciones, cod_cargo_opsu) FROM stdin;
0	0				Sin asignar	f			\N
1	0	55555	0	1	INDEFINIDO	f			\N
2	4	8220	21	2	ESPECIALISTA DE INFORMACION III	f			\N
3	3	8600	19	2	GESTOR DE DESECHOS	f			\N
4	3	12111	13	2	ADMINISTRADOR I	f			\N
5	3	12112	15	2	ADMINISTRADOR II	f			\N
6	3	12113	17	2	ADMINISTRADOR III	f			\N
7	3	12114	19	2	ADMINISTRADOR IV	f			\N
8	3	12115	21	2	ADMINISTRADOR V	f			\N
9	2	12121	22	2	ADMINISTRADOR JEFE I	f			\N
10	1	12122	24	2	ADMINISTRADOR JEFE II	f			\N
11	3	12151	11	2	ASISTENTE ADMINISTRATIVO I	f			\N
12	3	12152	13	2	ASISTENTE ADMINISTRATIVO II	f			\N
13	3	12153	15	2	ASISTENTE ADMINISTRATIVO III	f			\N
14	3	12154	17	2	ASISTENTE ADMINISTRATIVO IV	f			\N
15	3	12155	19	2	ASISTENTE ADMINISTRATIVO V	f			\N
16	4	12157	13	2	ASIST. EN LOGISTICA DE ORG. EST. II	f			\N
17	4	12158	15	2	ASIST. EN LOGISTICA DE ORG. EST. III	f			\N
18	3	12159	18	2	ASISTENTE ADMTVO. BILINGUE	f			\N
19	3	12209	20	2	JEFE TECNICO ADMINISTRATIVO I	f			\N
20	3	12210	21	2	JEFE TECNICO ADMINISTRATIVO II	f			\N
21	3	12211	22	2	JEFE TECNICO ADMINISTRATIVO III	f			\N
22	3	12212	23	2	JEFE TECNICO ADMINISTRATIVO IV	f			\N
23	4	12250	16	2	ASIST. DE ADMINISTRACION DE RECURSOS	f			\N
24	3	12600	15	2	ANALISTA DE HIGIENE Y SEGURIDAD I	f			\N
25	3	12601	17	2	ANALISTA DE HIGIENE Y SEGURIDAD II	f			\N
26	3	12602	19	2	ANALISTA DE HIGIENE Y SEGURIDAD III	f			\N
27	3	12603	21	2	ANALISTA DE HIGIENE Y SEGURIDAD IV	f			\N
28	2	12610	23	2	SUPERVISOR DE HIGIENE Y SEGURIDAD	f			\N
29	4	13211	12	2	ASISTENTE DE ANALISTA I	f			\N
30	4	13212	14	2	ASISTENTE DE ANALISTA II	f			\N
31	3	13213	15	2	ASISTENTE DE ORG. Y SIST. I	f			\N
32	3	13221	15	2	ANALISTA DE ORGANIZACION Y SISTEMAS I	f			\N
33	3	13222	17	2	ANALISTA DE ORGANIZACION Y SISTEMAS II	f			\N
34	3	13223	19	2	ANALISTA DE ORGANIZACION Y SISTEMAS III	f			\N
35	3	13224	21	2	ANALISTA DE ORGANIZACION Y SISTEMAS IV	f			\N
36	2	13230	23	2	ANALISTA DE ORGANIZACION Y SISTEMAS JEFE	f			\N
37	2	13244	24	2	ANALISTA CENTRAL ORGANIZAC. Y SISTEMA IV	f			\N
38	4	13351	12	2	ASISTENTE DE PLANIFICACION I	f			\N
39	4	13352	14	2	ASISTENTE DE PLANIFICACION II	f			\N
40	4	13353	15	2	ASISTENTE DE PLANIFICACION III	f			\N
41	3	13354	16	2	ASISTENTE DE PLANIFICACION DE CURSOS	f			\N
42	3	13357	16	2	SUPERV. PLANIFIC.DE HORARIOS I	f			\N
43	3	13358	18	2	SUPERV.DE PLANIF.DE HORARIOS II	f			\N
44	3	13361	17	2	PLANIFICADOR I	f			\N
45	3	13362	19	2	PLANIFICADOR II	f			\N
46	3	13363	21	2	PLANIFICADOR III	f			\N
47	3	13364	22	2	PLANIFICADOR IV	f			\N
48	2	13365	23	2	PLANIFICADOR V	f			\N
49	1	13370	24	2	PLANIFICADOR JEFE	f			\N
50	1	13372	25	2	PLANIFICADOR JEFE II	f			\N
51	1	13373	25	2	PLANIFICADOR JEFE III	f			\N
52	1	13390	25	2	PLANIFICADOR CENTRAL JEFE	f			\N
53	3	13411	15	2	ANALISTA DE PRESUPUESTO I	f			\N
54	3	13412	17	2	ANALISTA DE PRESUPUESTO II	f			\N
55	3	13413	19	2	ANALISTA DE PRESUPUESTO III	f			\N
56	3	13414	21	2	ANALISTA DE PRESUPUESTO IV	f			\N
57	3	13420	23	2	ANALISTA DE PRESUPUESTO JEFE	f			\N
58	3	13431	18	2	ANALISTA CENTRAL PRESUPUESTO I	f			\N
59	3	13432	20	2	ANALISTA CENTRAL DE PRESUPUESTO II	f			\N
60	3	13433	22	2	ANALISTA CENTRAL PRESUPUESTO III	f			\N
61	3	13434	23	2	ANALISTA CENTRAL PRESUPUESTO IV	f			\N
62	1	13440	25	2	ANALISTA CENTRAL PRESUPUESTO JEFE	f			\N
63	4	14111	13	2	ASISTENTE DE ANALISTA FINANCIERO I	f			\N
64	4	14112	15	2	ASISTENTE ANALISTA FINANCIERO II	f			\N
65	3	14121	17	2	ANALISTA FINANCIERO I	f			\N
66	3	14122	19	2	ANALISTA FINANCIERO II	f			\N
67	3	14123	21	2	ANALISTA FINANCIERO III	f			\N
68	3	14124	22	2	ANALISTA FINANCIERO IV	f			\N
69	2	14125	23	2	ANALISTA FINANCIERO V	f			\N
70	1	14130	24	2	ANALISTA FINANCIERO JEFE	f			\N
71	1	14131	25	2	ANALISTA FINANCIERO JEFE II	f			\N
72	4	15415	16	2	ASISTENTE DE NOMINA III	f			\N
73	4	15511	10	2	ASISTENTE DE PERSONAL I	f			\N
74	4	15512	12	2	ASISTENTE DE PERSONAL II	f			\N
75	4	15513	14	2	ASISTENTE DE PERSONAL III	f			\N
76	4	15514	15	2	ASISTENTE DE PERSONAL IV	f			\N
77	4	15515	11	2	ASISTENTE DE NOMINA I	f			\N
78	4	15518	11	2	ASISTENTE DE PERSONAL EN SEGUROS I	f			\N
79	4	15519	13	2	ASISTENTE DE PERSONAL EN SEGUROS II	f			\N
80	3	15520	15	2	ASISTENTE DE SEGURO I	f			\N
81	3	15521	15	2	ASISTENTE DE PERSONAL EN SEGURO III	f			\N
82	2	15524	21	2	JEFE DE PERSONAL IV	f			\N
83	1	15525	23	2	JEFE DE PERSONAL V	f			\N
84	1	15526	24	2	JEFE DE PERSONAL VI	f			\N
85	1	15527	25	2	JEFE DE PERSONAL VII	f			\N
86	3	15611	15	2	ANALISTA DE PERSONAL I	f			\N
87	3	15612	17	2	ANALISTA DE PERSONAL II	f			\N
88	3	15613	19	2	ANALISTA DE PERSONAL III	f			\N
89	3	15614	21	2	ANALISTA DE PERSONAL IV	f			\N
90	3	15616	15	2	ANALISTA DE RECUR.HUMANOS EN NOMINA I	f			\N
91	3	15617	17	2	ANALISTA DE RECUR. HUMANOS EN NOMINA II	f			\N
92	3	15618	19	2	ANALISTA DE RECURS.HUMANOS EN NOMINA III	f			\N
93	3	15619	21	2	ANALISTA DE RECUR.HUMANOS EN NOMINA IV	f			\N
94	3	15620	15	2	ANALISTA DE NOMINA I	f			\N
95	3	15621	17	2	ANALISTA DE NOMINA II	f			\N
96	3	15622	19	2	ANALISTA DE NOMINA III	f			\N
97	3	15623	21	2	ANALISTA DE NOMINA IV	f			\N
98	1	15624	23	2	JEFE DE NOMINA I	f			\N
99	1	15625	25	2	JEFE DE NOMINA II	f			\N
100	3	15630	16	2	ANALISTA CENTRAL PERSONAL EN ADTMTO.	f			\N
101	1	15640	25	2	ANALISTA CENTRAL DE PERSONAL JEFE	f			\N
102	1	15810	25	2	JEFE CENTRAL DE RECURSOS HUMANOS	f			\N
103	1	15820	24	2	JEFE SECTORIAL DE RECURSOS HUMANOS	f			\N
104	3	16111	18	2	COORD. DE DESARROLLO RECURSOS HUMANOS I	f			\N
105	3	16112	20	2	COORDINADOR DESARROLLO R.H.II	f			\N
106	3	16114	18	2	ANALISTA DE DESARROLLO DE REC. HUM.II	f			\N
107	3	16115	19	2	ANALISTA DESARROLLO RECUR. HUMAN.III	f			\N
108	3	16120	17	2	ANALISTA DE PERSONAL EN ADIESTRAMIENTO I	f			\N
109	3	16121	19	2	ANALISTA DE PERS. EN ADIESTRAMIENTO II	f			\N
110	3	16122	21	2	ANALISTA DE PERS. EN ADIESTRAMIENTO III	f			\N
111	3	16232	23	2	COORDINADOR DE ADIESTRAMIENTO	f			\N
112	4	17110	12	2	PROMOTOR DE CURSOS	f			\N
113	3	17122	17	2	INSTRUCTOR FORMACION COMERCIAL II	f			\N
114	3	17123	18	2	INSTRUCTOR FORMACION INDUSTRIAL III	f			\N
115	3	17232	21	2	COORDINADOR FORMACION EMPRESARIAL II	f			\N
116	3	17413	18	2	INSTRUCTOR DE FORMACION INDUSTRIAL III	f			\N
117	4	21110	6	2	AUXILIAR DE CONTABILIDAD	f			\N
118	4	21111	8	2	CONTABILISTA I	f			\N
119	4	21112	11	2	CONTABILISTA II	f			\N
120	4	21113	13	2	CONTABILISTA JEFE I	f			\N
121	3	21122	15	2	CONTABILISTA JEFE II	f			\N
122	4	21131	13	2	CONTADOR I	f			\N
123	3	21132	15	2	CONTADOR II	f			\N
124	3	21133	17	2	CONTADOR III	f			\N
125	3	21141	19	2	CONTADOR JEFE I	f			\N
126	3	21142	21	2	CONTADOR JEFE II	f			\N
127	4	21211	13	2	AUDITOR I	f			\N
128	3	21212	15	2	AUDITOR II	f			\N
129	3	21213	17	2	AUDITOR III	f			\N
130	3	21214	19	2	AUDITOR IV	f			\N
131	3	21221	20	2	AUDITOR JEFE I	f			\N
132	3	21222	22	2	AUDITOR JEFE II	f			\N
133	2	21223	24	2	AUDITOR JEFE III	f			\N
134	1	21224	25	2	AUDITOR JEFE IV	f			\N
135	1	21310	25	2	CONTRALOR INTERNO	f			\N
136	3	21311	19	2	INSPECTOR DE RENTAS I	f			\N
137	3	21312	15	2	AUDITOR INTEGRAL I	f			\N
138	3	21313	17	2	AUDITOR INTEGRAL II	f			\N
139	3	21314	19	2	AUDITOR INTEGRAL III	f			\N
140	3	21315	21	2	AUDITOR INTEGRAL IV	f			\N
141	2	21316	23	2	AUDITOR INTEGRAL JEFE	f			\N
142	1	21317	25	2	AUDITOR INTERNO	f			\N
143	3	21421	21	2	INSPECTOR ADMINISTRATIVO JEFE I	f			\N
144	3	21422	22	2	INSPECTOR ADMINISTRATIVO JEFE II	f			\N
145	4	21511	6	2	CAJERO I	f			\N
146	4	21512	8	2	CAJERO II	f			\N
147	4	21513	10	2	CAJERO III	f			\N
148	4	21514	12	2	CAJERO IV	f			\N
149	4	21521	13	2	CAJERO JEFE I	f			\N
150	3	21522	15	2	CAJERO JEFE II	f			\N
151	3	21523	17	2	CAJERO JEFE III	f			\N
152	3	21524	15	2	ASISTENTE DE TESORERIA	f			\N
153	4	21530	6	2	AUXILIAR DE HABILITADO	f			\N
154	4	21531	9	2	ASISTENTE DE HABILITADO I	f			\N
155	4	21532	11	2	ASISTENTE DE HABILITADO II	f			\N
156	4	21533	13	2	ASISTENTE DE HABILITADO III	f			\N
157	3	21550	21	2	HABILITADO JEFE	f			\N
158	4	21560	14	2	CAJERO I	f			\N
159	4	21561	16	2	CAJERO II	f			\N
160	3	21570	19	2	CAJERO JEFE	f			\N
161	4	21611	11	2	COBRADOR JEFE I	f			\N
162	4	21612	13	2	COBRADOR JEFE II	f			\N
163	3	21613	15	2	COBRADOR JEFE III	f			\N
164	4	22110	9	2	AUXILIAR DE ARCHIVO	f			\N
165	4	22121	11	2	ASISTENTE DE ARCHIVO I	f			\N
166	4	22122	13	2	ASISTENTE DE ARCHIVO II	f			\N
167	3	22123	16	2	ASISTENTE DE ARCHIVO III	f			\N
168	3	22131	17	2	ARCHIVOLOGO I	f			\N
169	3	22132	19	2	ARCHIVOLOGO II	f			\N
170	3	22133	21	2	ARCHIVOLOGO III	f			\N
171	2	22134	23	2	ARCHIVOLOGO IV	f			\N
172	1	22135	25	2	ARCHIVOLOGO JEFE	f			\N
173	3	22140	22	2	ANALISTA DE INFORMACION Y DOCUMENTACION	f			\N
174	3	22141	23	2	ANALISTA DE INFORM. Y DOCUMENTACION II	f			\N
175	4	22211	2	2	OFICINISTA I	f			\N
176	4	22212	6	2	OFICINISTA II	f			\N
177	4	22213	8	2	OFICINISTA III	f			\N
178	4	22221	10	2	SUPERVISOR DE OFICINA I	f			\N
179	4	22222	12	2	SUPERVISOR DE OFICINA II	f			\N
180	4	22231	2	2	RECEPCIONISTA I	f			\N
181	4	22232	4	2	RECEPCIONISTA II	f			\N
182	4	22233	6	2	RECEPCIONISTA III	f			\N
183	4	22235	6	2	RECEPCIONISTA-TELEFONISTA	f			\N
184	3	22312	17	2	TRADUCTOR II	f			\N
185	4	22411	14	2	SUPERVISOR DE SERVICIOS GENERALES I	f			\N
186	3	22412	16	2	SUPERVISOR DE SERVICIOS GENERALES II	f			\N
187	3	22413	18	2	SUPERVISOR DE SERVICIOS GENERALES III	f			\N
188	3	22414	20	2	SUPERVISOR DE SERVICIOS GENERALES IV	f			\N
189	2	22415	23	2	JEFE DE SERVICIOS GENERALES	f			\N
190	5	23111	2	2	OPERADOR DE MAQUINA DE REPRODUCION I	f			\N
191	5	23112	5	2	OPERADOR DE MAQUINA DE REPRODUCCION II	f			\N
192	5	23113	7	2	OPERADOR DE MAQUINA REPROD.III	f			\N
193	5	23114	8	2	OPERERADOR DE MAQUINA DE REPRODUCCION IV	f			\N
194	4	23115	10	2	OPERADOR DE MAQUINA ELECTRONICA	f			\N
195	4	23117	14	2	OPERADOR MAQUINA ELECTRONICA III	f			\N
196	4	23121	10	2	SUPERVISOR REPRODUCCION I	f			\N
197	4	23122	12	2	SUPERVISOR REPRODUCCION II	f			\N
198	4	23311	5	2	TRANSCRIPTOR DE DATOS I	f			\N
199	4	23312	7	2	TRANSCRIPTOR DE DATOS II	f			\N
200	4	23313	9	2	TRANSCRIPTOR DE DATOS III	f			\N
201	4	23314	11	2	TRANSCRIPTOR DE DATOS IV	f			\N
202	4	23320	13	2	SUPERVISOR DE TRANSCRIPTOR DE DATOS	f			\N
203	4	23331	10	2	OPERADOR DE EQUIPO DE COMPUTACION I	f			\N
204	4	23332	12	2	OPERADOR DE EQUIPO DE COMPUTACION II	f			\N
205	4	23333	14	2	OPERADOR DE EQUIPO DE COMPUTACION III	f			\N
206	3	23334	16	2	OPERADOR DE EQUIPO DE COMPUTACION IV	f			\N
207	3	23400	15	2	ASISTENTE DE ANALISTA DE SOPORTE TECNOLO	f			\N
208	4	23410	12	2	ASISTENTE DE PROGRAMACION	f			\N
209	3	23411	17	2	ANALISTA DE SOPORTE TECNOLOGICO I	f			\N
210	3	23412	19	2	ANALISTA DE SOPORTE TECNOLOGICO II	f			\N
211	3	23413	20	2	ANALISTA DE SOPORTE TECNOLOGICO III	f			\N
212	4	23421	14	2	PROGRAMADOR I	f			\N
213	3	23422	16	2	PROGRAMADOR II	f			\N
214	3	23423	18	2	PROGRAMADOR III	f			\N
215	3	23424	20	2	PROGRAMADOR IV	f			\N
216	3	23430	22	2	SUPERVISOR DE PROGRAMACION	f			\N
217	3	23433	20	2	ANALISTA DE SOPORTE TECNOLOGICO III	f			\N
218	3	23440	17	2	ANALISTA PROGRAMADOR	f			\N
219	3	23441	17	2	ANALISTA PROGRAMADOR I	f			\N
220	3	23442	19	2	ANALISTA PROGRAMADOR II	f			\N
221	3	23451	18	2	ANALISTA PROCESOS DE DATOS I	f			\N
222	3	23452	20	2	ANALISTA PROCESOS DE DATOS II	f			\N
223	3	23453	22	2	ANALISTA PROCESOS DE DATOS III	f			\N
224	3	23457	21	2	ANALISTA DE RELACIONES INTERNACIONAL III	f			\N
225	3	23461	21	2	JEFE DE INFORMATICA I	f			\N
226	2	23462	23	2	JEFE DE INFORMATICA II	f			\N
227	1	23463	25	2	JEFE DE INFORMATICA III	f			\N
228	3	23471	23	2	ESPECIALISTA EN INFORMATICA I	f			\N
229	1	23472	25	2	ESPECIALISTA EN INFORMATICA II	f			\N
230	3	23481	22	2	JEFE DE SOPORTE TECNOLOGICO I	f			\N
231	2	23482	23	2	JEFE DE SOPORTE TECNOLOGICO II	f			\N
232	4	24111	3	2	MECANOGRAFO I	f			\N
233	4	24112	5	2	MECANOGRAFO II	f			\N
234	4	24113	7	2	MECANOGRAFO III	f			\N
235	4	24114	9	2	MECANOGRAFO IV	f			\N
236	4	24311	12	2	SECRETARIO I	f			\N
237	4	24312	14	2	SECRETARIO II	f			\N
238	4	24313	16	2	SECRETARIO III	f			\N
239	3	24321	16	2	SECRETARIO BILINGUE I	f			\N
240	3	24322	18	2	SECRETARIO BILINGUE II	f			\N
241	3	24341	18	2	SECRETARIO EJECUTIVO I	f			\N
242	3	24342	20	2	SECRETARIO EJECUTIVO II	f			\N
243	3	24343	22	2	SECRETARIO EJECUTIVO III	f			\N
244	3	24344	23	2	SECRETARIO GERENCIAL	f			\N
245	4	24345	13	2	SECRETARIO ADMINISTRATIVO I	f			\N
246	3	24346	15	2	SECRETARIO ADMINISTRATIVA II	f			\N
247	3	24347	17	2	SECRETARIO ADMINISTRATIVO III	f			\N
248	1	24633	25	2	INGENIERO MECANICO JEFE II	f			\N
249	2	24693	23	2	INGENIERO MECANICO JEFE II	f			\N
250	4	25110	7	2	REGIST. AUXI.DE B. Y MATERIAS	f			\N
251	4	25111	9	2	REGIST. DE B. Y MATERIAS I	f			\N
252	4	25112	11	2	REGIST. DE B. Y MATERIAS II	f			\N
253	4	25121	13	2	REGIST. DE B. Y MATE. JEFE I	f			\N
254	3	25122	15	2	REGIST. DE B. Y MATE. JEFE II	f			\N
255	3	25123	17	2	REGIST. DE B. Y MATE. JEFE III	f			\N
256	3	25124	19	2	REGIST.DE B. Y MATE.JEFE IV	f			\N
257	3	25125	21	2	REG. BIENES MATERIALES JEFE V	f			\N
258	4	25211	5	2	AUXILIAR DE ALMACEN I	f			\N
259	4	25212	8	2	AUXILIAR DE ALMACEN II	f			\N
260	4	25221	10	2	ALMACENISTA I	f			\N
261	4	25222	12	2	ALMACENISTA II	f			\N
262	4	25231	14	2	ALMACENISTA JEFE I	f			\N
263	3	25232	16	2	ALMACENISTA JEFE II	f			\N
264	4	25310	8	2	AUXILIAR DE COMPRAS	f			\N
265	4	25311	10	2	COMPRADOR I	f			\N
266	4	25312	12	2	COMPRADOR II	f			\N
267	3	25313	15	2	COMPRADOR III	f			\N
268	3	25321	17	2	COMPRADOR JEFE I	f			\N
269	3	25322	19	2	COMPRADOR JEFE II	f			\N
270	3	25323	21	2	COMPRADOR JEFE III	f			\N
271	3	26000	16	2	COORD. DE SEGURIDAD Y OPERACIONES	f			\N
272	4	29901	13	2	ASISTENTE DE CONTABILIDAD II	f			\N
273	4	29910	9	2	AUXILIAR DE TESORERIA	f			\N
274	3	31121	17	2	EDITOR DE NOTICIAS I	f			\N
275	4	31210	9	2	INFORMADOR	f			\N
276	4	31219	9	2	ASISTENTE DE INFORMACION I	f			\N
277	4	31220	11	2	ASISTENTE DE INFORMACION II	f			\N
278	4	31221	13	2	ASIST. ESPEC. INFORM. I	f			\N
279	3	31222	15	2	ASIST. DE ESPEC. INFORM. II	f			\N
280	3	31223	16	2	ASISTENTE ESPECIALISTA INFORMACION III	f			\N
281	4	31224	13	2	ASISTENTE DE INFORMACION III	f			\N
282	3	31231	17	2	ESPECIALISTA EN INFORMACION I	f			\N
283	3	31232	19	2	ESPECIALISTA EN INFORMACION II	f			\N
284	3	31233	21	2	ESPECIALISTA EN INFORMACION III	f			\N
285	3	31234	22	2	ESPECIALISTA E INFORMACION IV	f			\N
286	4	31311	13	2	ASISTENTE DE COMUNI/SOCIAL I	f			\N
287	3	31312	15	2	ASISTENTE DE COMUNI/SOCIAL II	f			\N
288	3	31321	17	2	COMUNICADOR SOCIAL I	f			\N
289	3	31322	19	2	COMUNICADOR SOCIAL II	f			\N
290	3	31323	21	2	COMUNICADOR SOCIAL III	f			\N
291	2	31324	23	2	COMUNICADOR SOCIAL JEFE I	f			\N
292	3	31325	23	2	EDITOR	f			\N
293	1	31326	24	2	COMUNICADOR SOCIAL JEFE II	f			\N
294	1	31327	25	2	COMUNICADOR SOCIAL JEFE III	f			\N
295	3	31330	15	2	ASISTENTE RELACIONES PUBLICAS	f			\N
296	3	31341	17	2	JEFE DE RELACIONES PUBLICAS I	f			\N
297	3	31342	19	2	JEFE DE RELACIONES PUBLICAS II	f			\N
298	3	31343	21	2	JEFE DE RELACIONES PUBLICAS III	f			\N
299	2	31344	23	2	JEFE DE RELACIONES PUBLICAS IV	f			\N
300	1	31370	25	2	EDITOR JEFE	f			\N
301	3	31410	15	2	CORRECTOR DE ESTILO I	f			\N
302	3	31411	17	2	CORRECTOR DE ESTILO II	f			\N
303	3	31430	19	2	COORDINADOR DE ASUNTOS LITERARIOS	f			\N
304	4	32120	12	2	REALIZADOR DE ESCENOGRAFIA	f			\N
305	3	32125	15	2	JEFE DE ESCENOGRAFIA	f			\N
306	4	32221	8	2	OPERADOR DE CAMARA DE T.V. I	f			\N
307	4	32222	10	2	OPERADOR DE CAMARA DE T.V. II	f			\N
308	4	32230	12	2	OPERADOR DE AUDIO	f			\N
309	4	32231	13	2	OPERADOR DE AUDIO II	f			\N
310	4	32240	10	2	OPERADOR DE VIDEO	f			\N
311	4	32241	13	2	OPERADOR DE VIDEO II	f			\N
312	4	32250	13	2	OPERADOR DE MASTER DE TELEVISION	f			\N
313	4	32261	6	2	OPERADOR DE EQUIPO DE GRABACION I	f			\N
314	4	32262	8	2	OPERADOR DE EQUIPO DE GRABACION II	f			\N
315	4	32263	10	2	OPERADOR DE EQUIPO DE GRABACION III	f			\N
316	4	32264	12	2	SUPERVISOR DE EQUIPOS DE GRABACION I	f			\N
317	4	32265	14	2	SUPERVISOR EQUIPOS GRAB.II	f			\N
318	4	32271	6	2	OPERADOR DE MAQUINA PROYECTORA I	f			\N
319	4	32272	8	2	OPERADOR DE MAQUINA PROYECTORA II	f			\N
320	4	32310	13	2	CAMAROGRAFO	f			\N
321	4	32330	12	2	TECNICO EN SONIDO	f			\N
322	3	32331	15	2	TECNICO DE SONIDO II	f			\N
323	3	32421	15	2	COORD. ASUNTOS CINEMATOGRAFICO I	f			\N
324	4	33121	11	2	ASISTENTE DE PROTOCOLO I	f			\N
325	4	33122	13	2	ASISTENTE DE PROTOCOLO II	f			\N
326	4	33211	14	2	ASISTENTE DE CEREMONIAL I	f			\N
327	3	33212	16	2	ASISTENTE DE CEREMONIAL II	f			\N
328	3	33313	20	2	CAPELLAN III	f			\N
329	3	33314	23	2	CAPELLAN IV	f			\N
330	3	34110	15	2	ANALISTA DE ASUNTOS AUDIOVISUALES	f			\N
331	3	34111	17	2	ANALISTA DE ASUNTOS AUDIOVISUALES II	f			\N
332	3	34120	17	2	JEFE DE CENTRO AUDIOVISUAL	f			\N
333	3	34121	19	2	JEFE CENTRO AUDIOVISUAL II	f			\N
334	3	34122	22	2	JEFE DE CENTRO AUDIOVISUAL III	f			\N
335	4	34231	10	2	ENTRENADOR DEPORTIVO I	f			\N
336	4	34232	13	2	ENTRENADOR DEPORTIVO II	f			\N
337	3	34233	15	2	ENTRENADOR DEPORTIVO III	f			\N
338	3	34234	17	2	ENTRENADOR DEPORTIVO IV	f			\N
339	3	34235	19	2	ENTRENADOR DEPORTIVO V	f			\N
340	3	34236	21	2	ENTRENADOR DEPORTIVO VI	f			\N
341	3	34237	23	2	ENTRENADOR DEPORTIVO VII	f			\N
342	1	34238	25	2	COORDINADOR DE DEPORTE	f			\N
343	3	35112	15	2	ASISTENTE ASUNTOS LEGALES I	f			\N
344	3	35113	16	2	ASISTENTE ASUNTOS LEGALES II	f			\N
345	3	35121	17	2	ABOGADO I	f			\N
346	3	35122	19	2	ABOGADO II	f			\N
347	3	35123	21	2	ABOGADO III	f			\N
348	2	35125	23	2	ABOGADO JEFE	f			\N
349	1	35126	25	2	ABOGADO JEFE I	f			\N
350	4	36022	9	2	AUXILIAR DE ESTADISTICA II	f			\N
351	4	36121	11	2	ASISTENTE DE ESTADISTICA I	f			\N
352	4	36122	13	2	ASISTENTE DE ESTADISTICA II	f			\N
353	3	36123	15	2	ASISTENTE DE ESTADISTICA III	f			\N
354	3	36131	17	2	ESTADISTICO I	f			\N
355	3	36132	19	2	ESTADISTICO II	f			\N
356	3	36133	21	2	ESTADISTICO III	f			\N
357	3	36141	23	2	ESTADISTICO JEFE I	f			\N
358	2	36142	24	2	ESTADISTICO JEFE II	f			\N
359	3	36221	17	2	ECONOMISTA I	f			\N
360	3	36222	19	2	ECONOMISTA II	f			\N
361	3	36223	20	2	ECONOMISTA III	f			\N
362	3	36231	22	2	ECONOMISTA JEFE I	f			\N
363	3	36232	23	2	ECONOMISTA JEFE II	f			\N
364	2	36233	24	2	ECONOMISTA JEFE III	f			\N
365	1	36234	25	2	ECONOMISTA JEFE IV	f			\N
366	3	36321	17	2	PSICOLOGO I	f			\N
367	3	36322	19	2	PSICOLOGO II	f			\N
368	3	36323	21	2	PSICOLOGO III	f			\N
369	3	36324	22	2	PSICOLOGO IV	f			\N
370	2	36325	23	2	PSICOLOGO JEFE I	f			\N
371	1	36326	24	2	PSICOLOGO JEFE II	f			\N
372	3	36331	17	2	BIBLIOTECOLOGO I	f			\N
373	3	36421	17	2	SOCIOLOGO I	f			\N
374	3	36422	19	2	SOCIOLOGO II	f			\N
375	3	36511	17	2	GEOGRAFO I	f			\N
376	4	36610	9	2	AUXILIAR DE BIBLIOTECA	f			\N
377	4	36621	11	2	ASISTENTE DE BIBLIOTECA I	f			\N
378	3	36622	13	2	ASISTENTE DE BIBLIOTECA II	f			\N
379	3	36623	15	2	ASISTENTE DE BIBLIOTECA III	f			\N
380	3	36631	17	2	BIBLIOTECOLOGO I	f			\N
381	3	36632	19	2	BIBLIOTECOLOGO II	f			\N
382	3	36633	21	2	BIBLIOTECOLOGO III	f			\N
383	2	36634	23	2	BIBLIOTECOLOGO IV	f			\N
384	2	36635	24	2	BIBLIOTECOLOGO JEFE I	f			\N
385	1	36636	25	2	BIBLIOTECOLOGO JEFE II	f			\N
386	3	36811	17	2	INVESTIGADOR SOCIAL I	f			\N
387	3	36820	23	2	INVESTIGADOR SOCIAL JEFE	f			\N
388	3	37210	15	2	ASISTENTE DE MUSEOGRAFIA	f			\N
389	3	37431	21	2	CURADOR DE OBRAS I	f			\N
390	3	37432	23	2	CURADOR DE OBRAS II	f			\N
391	1	37433	25	2	CURADOR DE OBRAS III	f			\N
392	4	37510	12	2	ALMACENISTA DE MUSEO	f			\N
393	3	37921	17	2	PROMOTOR CULTURAL	f			\N
394	4	41130	13	2	PRACTICO DE VIVERO	f			\N
395	3	41210	17	2	INVESTIGADOR EN ADIESTRAMIENTO	f			\N
396	3	41211	19	2	INVESTIGADOR I	f			\N
397	3	41212	20	2	INVESTIGADOR II	f			\N
398	3	41213	21	2	INVESTIGADOR III	f			\N
399	3	41214	23	2	INVESTIGADOR IV	f			\N
400	2	41215	24	2	INVESTIGADOR V	f			\N
401	1	41520	25	2	ZOOTECNISTA JEFE	f			\N
402	4	41612	6	2	AUXILIAR DE BOTANICA II	f			\N
403	4	42450	13	2	TAXIDERMISTA	f			\N
404	4	42460	9	2	CRIADOR DE ANIMALES	f			\N
405	4	42511	12	2	ASISTENTE DE BIOLOGIA I	f			\N
406	3	42512	15	2	ASISTENTE DE BIOLOGIA II	f			\N
407	3	42522	19	2	BIOLOGO II	f			\N
408	3	42612	19	2	BIOLOGO II	f			\N
409	3	43150	21	2	TOPOGRAFO CARTOGRAFICO JEFE	f			\N
410	4	43411	13	2	ASISTENTE DE INGENIERIA I	f			\N
411	4	43412	14	2	ASISTENTE DE INGENIERIA II	f			\N
412	3	43413	16	2	ASISTENTE DE INGENIERIA III	f			\N
413	3	43414	17	2	ASISTENTE DE INGENIERIA IV	f			\N
414	3	43421	18	2	INGENIERO CIVIL I	f			\N
415	3	43422	19	2	INGENIERO CIVIL II	f			\N
416	3	43423	21	2	INGENIERO CIVIL III	f			\N
417	3	43431	22	2	INGENIERO CIVIL JEFE I	f			\N
418	1	43432	24	2	INGENIERO CIVIL JEFE II	f			\N
419	1	43433	25	2	INGENIERO CIVIL JEFE III	f			\N
420	4	43461	13	2	INSPECTOR DE O.ING. CIVIL I	f			\N
421	4	43462	14	2	INSPECTOR DE O.ING. CIVIL II	f			\N
422	3	43463	15	2	INSPECTOR DE O.ING. CIVIL III	f			\N
423	3	43464	16	2	INSP. DE OBRAS DE ING.CIVIL IV	f			\N
424	3	43531	18	2	ARQUITECTO I	f			\N
425	3	43532	19	2	ARQUITECTO II	f			\N
426	3	43533	21	2	ARQUITECTO III	f			\N
427	1	43539	24	2	ARQUITECTO JEFE II	f			\N
428	3	43541	22	2	ARQUITECTO JEFE I	f			\N
429	2	43542	24	2	ARQUITECTO JEFE II	f			\N
430	1	43543	25	2	ARQUITECTO JEFE III	f			\N
431	4	43711	4	2	AUXILIAR DE DIBUJO I	f			\N
432	4	43712	6	2	AUXILIAR DE DIBUJO II	f			\N
433	4	43718	10	2	DIBUJANTE ARTISTICO	f			\N
434	4	43721	9	2	DIBUJANTE I	f			\N
435	4	43722	12	2	DIBUJANTE II	f			\N
436	4	43723	13	2	DIBUJANTE III	f			\N
437	3	43724	15	2	DIBUJANTE IV	f			\N
438	3	43731	16	2	DIBUJANTE JEFE I	f			\N
439	3	43732	17	2	DIBUJANTE JEFE II	f			\N
440	4	43770	13	2	DIAGRAMADOR	f			\N
441	3	43771	15	2	DIAGRAMADOR II	f			\N
442	3	43775	15	2	DISEÃADOR GRAFICO	f			\N
443	3	43776	17	2	DISEÃADOR GRAFICO II	f			\N
444	3	43777	19	2	DISEÃADOR GRAFICO III	f			\N
445	3	43781	15	2	DIBUJANTE ILUSTRADOR I	f			\N
446	3	43782	17	2	DIBUJANTE ILUSTRADOR II	f			\N
447	3	43783	19	2	DIBUJANTE ILUSTRADOR III	f			\N
448	3	43790	21	2	DIBUJANTE ILUSTRADOR JEFE	f			\N
449	3	43800	15	2	ANIMADOR GRAFICO I	f			\N
450	3	43801	16	2	ANIMADOR GRAFICO II	f			\N
451	3	43802	18	2	ANIMADOR GRAFICO III	f			\N
452	3	43803	20	2	ANIMADOR GRAFICO JEFE I	f			\N
453	3	43804	22	2	ANIMADOR GRAFICO JEFE II	f			\N
454	3	43811	18	2	URBANISTA I	f			\N
455	3	43812	19	2	URBANISTA II	f			\N
456	3	43820	23	2	URBANISTA JEFE	f			\N
457	3	44713	15	2	TECNICO QUIMICO III	f			\N
458	3	44721	17	2	QUIMICO I	f			\N
459	3	44722	19	2	QUIMICO II	f			\N
460	3	44723	21	2	QUIMICO III	f			\N
461	3	44731	22	2	QUIMICO JEFE I	f			\N
462	2	44732	23	2	QUIMICO JEFE II	f			\N
463	4	45000	12	2	FOTOLITOGRAFO	f			\N
464	4	45111	3	2	AUXILIAR DE LABORATORIO I	f			\N
465	4	45112	5	2	AUXILIAR DE LABORATORIO II	f			\N
466	4	45121	10	2	LABORATORISTA I	f			\N
467	4	45122	13	2	LABORATORISTA II	f			\N
468	4	45123	14	2	LABORATORISTA III	f			\N
469	4	45124	15	2	LABORATORISTA IV	f			\N
470	4	45131	13	2	ASIST. DE INV. Y DOC. I	f			\N
471	3	45132	16	2	ASISTENTE DE LAB. DE INV. Y DOC II	f			\N
472	3	45133	18	2	ASISTENTE DE LAB DE INV Y DOC III	f			\N
473	4	45240	4	2	AUXILIAR DE FOTOGRAFIA	f			\N
474	4	45251	8	2	FOTOGRAFO I	f			\N
475	4	45252	12	2	FOTOGRAFO II	f			\N
476	3	45253	15	2	FOTOGRAFO III	f			\N
477	3	45260	16	2	FOTOGRAFO JEFE	f			\N
478	3	45261	18	2	FOTOGRAFO JEFE II	f			\N
479	3	45262	20	2	FOTOGRAFO JEFE III	f			\N
480	4	45271	9	2	LABORATORISTA FOTOGRAFICO I	f			\N
481	4	45272	11	2	LABORATORISTA FOTOGRAFICO II	f			\N
482	4	45341	13	2	MICROFILMADOR I	f			\N
483	3	45361	15	2	FOTOGRAFO LABORATORISTA DE INV. I	f			\N
484	3	45362	17	2	FOTOGRAFO LABORATORISTA DE INV. II	f			\N
485	3	45363	19	2	FOTOGRAFO LABORATORISTA DE INV. III	f			\N
486	3	45370	21	2	FOTOGRAFO LAB. DE INV. JEFE	f			\N
487	3	45421	21	2	SOPLADOR DE VIDRIO	f			\N
488	3	45611	17	2	BIOLOGO I	f			\N
489	3	46000	15	2	TECNICO EN COMPUTACION	f			\N
490	3	46001	16	2	TECNICO COMPUTACION II	f			\N
491	3	46002	15	2	TECNICO EN INFORMATICA I	f			\N
492	4	46111	11	2	TECNICO MECANICO  I	f			\N
493	4	46112	13	2	TECNICO MECANICO II	f			\N
494	4	46113	14	2	TECNICO MECANICO III	f			\N
495	3	46114	15	2	TECNICO MECANICO IV	f			\N
496	3	46115	17	2	TECNICO MECANICO V	f			\N
497	4	46121	11	2	TECNICO ELECTRICISTA I	f			\N
498	4	46122	13	2	TECNICO ELECTRICISTA II	f			\N
499	4	46123	14	2	TECNICO ELECTRICISTA III	f			\N
500	3	46124	15	2	TECNICO ELECTRICISTA IV	f			\N
501	4	46133	14	2	TECNICO ELECTRONICO III	f			\N
502	4	46211	11	2	TECNICO ELECTRONICO I	f			\N
503	4	46212	13	2	TECNICO ELECTRONICO II	f			\N
504	4	46213	14	2	TECNICO ELECTRONICO III	f			\N
505	3	46214	15	2	TECNICO ELECTRONICO IV	f			\N
506	3	46215	17	2	TECNICO ELECTRONICO V	f			\N
507	3	46216	19	2	TECNICO ELECTRONICO VI	f			\N
508	3	46217	21	2	TECNICO ELECTRONICO JEFE	f			\N
509	3	46231	15	2	TECNICO DE MTTO. EQUIPOS ELECTRONICOS I	f			\N
510	3	46232	17	2	TECNICO DE MTTO. EQUIPOS ELECTRONICOS II	f			\N
511	3	46233	19	2	TECNICO DE MTTO. EQUIPOS ELECTRONICO III	f			\N
512	3	46262	20	2	FOTOGRAFO JEFE III	f			\N
513	3	46311	18	2	INGENIERO MECANICO I	f			\N
514	3	46312	19	2	INGENIERO MECANICO II	f			\N
515	3	46313	21	2	INGENIERO MECANICO III	f			\N
516	3	46320	22	2	INGENIERO MECANICO JEFE I	f			\N
517	3	46511	18	2	INGENIERO ELECTRICISTA I	f			\N
518	3	46512	19	2	INGENIERO ELECTRICISTA II	f			\N
519	3	46513	21	2	INGENIERO ELECTRICISTA III	f			\N
520	3	46520	22	2	INGENIERO ELECTRICISTA JEFE	f			\N
521	3	46524	21	2	INGENIERO ELECTRONICO III	f			\N
522	3	46530	22	2	INGENIERO ELECTRONICO JEFE I	f			\N
523	2	46531	23	2	INGENIERO ELECTRONICO JEFE II	f			\N
524	1	46532	25	2	INGENIERO ELECTRONICO JEFE III	f			\N
525	3	46612	19	2	INGENIERO INDUSTRIAL II	f			\N
526	3	46613	21	2	INGENIERO INDUSTRIAL III	f			\N
527	3	46614	22	2	INGENIERO INDUSTRIAL JEFE I	f			\N
528	3	46615	23	2	INGENIERO INDUSTRIAL JEFE II	f			\N
529	1	46616	24	2	INGENIERO INDUSTRIAL JEFE III	f			\N
530	1	46617	25	2	INGENIERO INDUSTRIAL JEFE IV	f			\N
531	2	46708	24	2	INGENIERO INDUSTRIAL JEFE	f			\N
532	4	51411	7	2	OPER DE TELECOMUNICACIONES I	f			\N
533	4	51412	9	2	OPERADOR DE TELECOMUNICACIONES I	f			\N
534	4	51413	11	2	OPERADOR DE TELECOMUNICACIONES III	f			\N
535	4	51414	13	2	OPERERADOR DE TELECOMUNICACIONES IV	f			\N
536	4	51481	4	2	TELEFONISTA I	f			\N
537	4	51482	6	2	TELEFONISTA II	f			\N
538	4	51483	8	2	TELEFONISTA III	f			\N
539	4	51485	10	2	TELEFONISTA JEFE I	f			\N
540	3	51514	15	2	TECNICO EN TELECOMUNICACIONES	f			\N
541	4	52110	8	2	DESPACHADOR DE VEHICULO	f			\N
542	4	52141	10	2	JEFE DE TRANSP. AUTOMOTOR I	f			\N
543	4	52142	12	2	JEFE DE TRANSP. AUTOMOTOR II	f			\N
544	4	52143	14	2	JEFE DE TRANSP. AUTOMOTOR III	f			\N
545	3	52144	17	2	JEFE DE TRANSP. AUTOMOTOR IV	f			\N
546	4	61140	12	2	SUPERVISOR DE CARPINTEROS	f			\N
547	4	61141	14	2	SUPERVISOR DE CARPINTERIA II	f			\N
548	3	61142	16	2	SUPERVISOR DE CARPINTERIA III	f			\N
549	4	62121	10	2	SUPERVISOR DE MANTENIMIENTOS DE EDF.I	f			\N
550	4	62122	12	2	SUPERVISOR DE MANTENIMIENTOS DE EDIF.II	f			\N
551	4	62123	14	2	SUPERVISOR DE MANTENIMIENTO DE EDIF.III	f			\N
552	3	62124	16	2	SUPERVISOR DE MANTENIMIENTO DE EDIF.IV	f			\N
553	3	62125	18	2	SUPERVISOR DE MANTENIMIENTO EDIFICIOS V	f			\N
554	3	62126	20	2	SUPERVISOR DE MANTENIMIENTO EDIFICIO VI	f			\N
555	4	63121	12	2	SUPERV. DE TALLER DE IMP. I	f			\N
556	4	63122	14	2	SUPERV.DE TALLER DE IMP. II	f			\N
557	3	63123	16	2	SUPERV. DE TALLER DE IMP. III	f			\N
558	3	63124	18	2	SUPERV. DE TALLER IMPRENTA IV	f			\N
559	3	66142	16	2	SUPERVISOR DE CARPINTERIA III	f			\N
560	2	71130	24	2	DITISTA JEFE	f			\N
561	4	71331	13	2	ENFERMERA I	f			\N
562	4	71332	14	2	ENFERMERA II	f			\N
563	3	71333	15	2	ENFERMERA III	f			\N
564	3	71340	17	2	ENFERMERA JEFE I	f			\N
565	3	71341	16	2	ENFERMERA JEFE I	f			\N
566	3	71342	18	2	ENFERMERA JEFE II	f			\N
567	3	71343	19	2	ENFERMERA JEFE III	f			\N
568	3	71344	21	2	ENFERMERA JEFE IV	f			\N
569	3	73211	17	2	ODONTOLOGO I	f			\N
570	3	73212	19	2	ODONTOLOGO II	f			\N
571	3	73213	21	2	ODONTOLOGO III	f			\N
572	3	75131	18	2	MEDICO I	f			\N
573	3	75141	21	2	MEDICO JEFE I	f			\N
574	3	75142	22	2	MEDICO JEFE II	f			\N
575	3	75143	23	2	MEDICO JEFE III	f			\N
576	2	75144	24	2	MEDICO JEFE IV	f			\N
577	3	75311	19	2	MEDICO ESPECIALISTA I	f			\N
578	3	75312	21	2	MEDICO ESPECIALISTA II	f			\N
579	3	76307	17	2	TECNICO DE ZONA SANEAMIENTO AMBIENTAL II	f			\N
580	3	76310	23	2	JEFE DE ZONA DE SANEAMIENTO AMBIENTAL	f			\N
581	3	77121	17	2	DIETISTA I	f			\N
582	3	77122	19	2	DIETISTA II	f			\N
583	3	77123	21	2	DIETISTA III	f			\N
584	3	77124	23	2	DIETISTA IV	f			\N
585	2	77130	24	2	DIETISTA JEFE	f			\N
586	1	77131	25	2	DIETISTA JEFE II	f			\N
587	3	78200	13	2	ASISTENTE DE VETERINARIA I	f			\N
588	3	78201	15	2	ASISTENTE DE VETERINARIA II	f			\N
589	3	78202	17	2	ASISTENTE DE VETERINARIA III	f			\N
590	3	78203	19	2	ASISTENTE DE VETERINARIO IV	f			\N
591	4	79341	13	2	TECNICO TRABAJADOR SOCIAL I	f			\N
592	3	79342	15	2	TECNICO TRABAJADOR SOCIAL II	f			\N
593	3	79343	16	2	TECNICO TRABAJADOR SOCIAL III	f			\N
594	3	79351	17	2	TRABAJADOR SOCIAL I	f			\N
595	3	79352	19	2	TRABAJADOR SOCIAL II	f			\N
596	3	79353	21	2	TRABAJADOR SOCIAL III	f			\N
597	3	79354	22	2	TRABAJADOR SOCIAL IV	f			\N
598	2	79355	23	2	TRABAJADOR SOCIAL JEFE	f			\N
599	4	85011	12	2	INSPECTOR DE CONTROL DE PERDIDAS	f			\N
600	4	85012	13	2	INSPECTOR DE CONTROL DE PERDIDAS II	f			\N
601	4	85113	13	2	SUPERV. DE PROTECCION Y SEGURIDAD CCD I	f			\N
602	3	85114	15	2	SUPERV. DE PROTECCION Y SEGURIDAD CDD II	f			\N
603	3	85115	17	2	INSPECTOR DE PROTECCION Y SEGURIDAD CIUD	f			\N
604	3	85116	19	2	INSPECTOR DE PROTEC. Y SEG. CIUDADANA	f			\N
605	3	85117	21	2	JEFE PLANES OPERATIVOS EN SEGURIDAD CDNA	f			\N
606	2	85118	23	2	JEFE PLANES OPERAT. SEG. CIUDADANA II	f			\N
607	1	85119	25	2	JEFE PLANES OPER. SEG. CIUDADANA III	f			\N
608	3	85120	15	2	INSPECTOR DE PROT. Y SEG. CIUDADANA I	f			\N
609	3	85123	15	2	INSPECTOR DE SEGURIDAD INDUSTRIAL III	f			\N
610	3	86000	19	2	GESTOR DE DESECHOS	f			\N
611	3	88000	15	2	COORDINADOR ASUNTO CINEMATOGRAFICOS I	f			\N
612	3	88002	24	2	ASISTENTE ASESORIA JURIDICA	f			\N
613	4	88888	1	2	AYUDANTE ADMINISTRATIVO	f			\N
614	3	90500	19	2	ANALISTA DE CONTROL ACADEMICO	f			\N
615	3	90800	20	2	ASISTENTE DE CAMPO	f			\N
616	4	91100	10	2	ASISTENTE PLANIFICACION HORARIOS I	f			\N
617	4	91101	12	2	ASISTENTE PLANIFICACION HORARIOS II	f			\N
618	4	91102	14	2	ASISTENTE PLANIFICACION HORARIOS III	f			\N
619	3	91103	16	2	SUPERVISOR PLANIFICADOR HORARIOS	f			\N
620	4	91203	14	2	ASISTENTE DE CONTROL DE ESTUDIO III	f			\N
621	3	91205	16	2	SUPERVISOR DE CONTROL DE ESTUDIOS I	f			\N
622	3	91206	18	2	SUPERVISOR DE CONTROL DE ESTUDIOS II	f			\N
623	3	91340	21	2	ASESOR ANALISIS PRESUPUESTO	f			\N
624	3	91621	21	2	COORDINADOR DE FORMACION Y MEJORA	f			\N
625	4	91711	13	2	ASISTENTE DE FORMACION EMPRES.	f			\N
626	3	91800	23	2	COORDINADOR ENTRENAMIENTO	f			\N
627	3	92200	23	2	COORDINADOR TECNICO DE CALIDAD	f			\N
628	3	92311	19	2	SUPERVISOR CONTROL DE CALIDAD SIS	f			\N
629	3	92330	19	2	INGENIERO DE SISTEMA II	f			\N
630	3	92331	21	2	INGENIERO DE SISTEMA III	f			\N
631	3	92361	18	2	INGENIERO DE COMPUTACION I	f			\N
632	3	92362	19	2	INGENIERO DE COMPUTACION II	f			\N
633	4	92511	12	2	ASISTENTE DE VENTA	f			\N
634	4	92531	11	2	ASISTENTE DE COMPRAS I	f			\N
635	3	93000	15	2	ASISTENTE DE PRODUCCION	f			\N
636	3	93211	17	2	PRODUCTOR AUDIOVISUAL I	f			\N
637	3	93212	18	2	JEFE SECCION DE SONIDO	f			\N
638	3	93213	21	2	PRODUCTOR AUDIOVISUAL	f			\N
639	3	93220	15	2	PRODUCTOR DE MULTIMEDIA	f			\N
640	3	93410	15	2	TECNICO RECURSOS APRENDIZAJE	f			\N
641	3	93415	17	2	ANALISTA PROG CENTRAL CURSOS	f			\N
642	3	93424	18	2	SUPERVISOR DE ACTIVIDADES DEPO	f			\N
643	3	93521	19	2	ANALISTA DE ASUNTOS LEGALES	f			\N
644	3	93700	18	2	ADMINISTRADOR DE SISTEMAS I	f			\N
645	3	93701	19	2	ADMINISTRADOR DE SISTEMAS II	f			\N
646	3	93702	21	2	ADMINISTRADOR DE SISTEMAS III	f			\N
647	3	93703	23	2	ADMINISTRADOR DE SISTEMAS IV	f			\N
648	3	93711	21	2	JEFE OFIC.PATRIMONIO ARTISTICO	f			\N
649	3	93712	23	2	ADMINISTRADOR PATRIMONIO ARTISTICO I	f			\N
650	3	94000	15	2	ASISTENTE DE ADMINISTRADOR DE SISTEMA I	f			\N
651	3	94010	15	2	ADMINISTRADOR DE TRANSPORTE I	f			\N
652	3	94011	17	2	ADMINISTRADOR DE TRANSPORTE II	f			\N
653	3	94012	19	2	ADMINISTRADOR DE TRANSPORTE III	f			\N
654	3	94013	21	2	ADMINISTRADOR DE TRANSPORTE IV	f			\N
655	2	94014	23	2	ADMINISTRADOR DE TRANSPORTE JEFE	f			\N
656	3	94015	15	2	ASIST. DE HIGIENE Y SEGURIDAD INDUSTRIAL	f			\N
657	3	94019	15	2	ANALISTA DE PRESTACIONES SOCIALES I	f			\N
658	3	94020	17	2	ANALISTA DE PRESTACIONES SOCIALES II	f			\N
659	3	94030	17	2	ASISTENTE DE DEPARTAMENTO ACADEMICO I	f			\N
660	3	94031	19	2	ASISTENTE DE DEPARTAMENTO ACADEMICO II	f			\N
661	3	94032	21	2	ASISTENTE DE DEPARTAMENTO ACADEMICO III	f			\N
662	3	94033	23	2	ASISTENTE DE DEPARTAMENTO ACADEMICO IV	f			\N
663	4	94351	14	2	INSPECTOR DE OPERACIONES	f			\N
664	1	94360	25	2	CONTRALOR INTERNO	f			\N
665	4	94361	14	2	CONTROLADOR RUTAS TRANSP. COLECTIVO	f			\N
666	4	94371	14	2	OPERADOR DE FOTOCOMPOSICION	f			\N
667	4	94511	11	2	TECNICO DE LABORATORIO I	f			\N
668	4	94512	14	2	TECNICO DE LABORATORIO II	f			\N
669	3	94513	17	2	TECNICO DE LABORATORIO III	f			\N
670	3	94514	20	2	TECNICO DE LABORATORIO IV	f			\N
671	3	94515	22	2	TECNICO DE LABORATORIO V	f			\N
672	3	94520	18	2	INGENIERO DE SONIDO	f			\N
673	3	94543	21	2	SOPLADOR DE VIDRIO	f			\N
674	3	94592	15	2	TECNICO DE LABORATORIO II	f			\N
675	4	94611	10	2	MECANICO MANTENIMIENTO CALDERA	f			\N
676	4	94613	13	2	MECANICO MANTENIMIENTO CALDERAS II	f			\N
677	3	95000	17	2	SUPERVISOR RELACIONES PROTOCOLARES I	f			\N
678	3	95001	18	2	SUPERVISOR DE RELACIONES PROTOCOLARES II	f			\N
679	4	95097	10	2	ASISTENTE TECNICO ADMINISTRATIVO I	f			\N
680	4	95098	12	2	ASISTENTE TECNICO ADMINISTRATIVO II	f			\N
681	4	95099	14	2	ASISTENTE TECNICO ADMINISTRATIVO III	f			\N
682	3	95100	16	2	ASISTENTE TECNICO ADMINISTRATIVO IV	f			\N
683	3	95101	18	2	ASISTENTE TECNICO ADMINISTRATIVO V	f			\N
684	3	95102	20	2	ASISTENTE TECNICO ADMINISTRATIVO VI	f			\N
685	4	95103	14	2	ASISTENTE EMERGENCIAS PREHOSPITALARIA I	f			\N
686	3	95104	16	2	ASISTENTE EMERGENCIAS PREHOSPITALARIA II	f			\N
687	4	95197	10	2	ASIST. TECNICO ADMNISTRATIVO I	f			\N
688	3	95200	15	2	ASISTENTE SERVICIO GENERAL III	f			\N
689	3	95201	16	2	ASISTENTE SERVICIO GENERAL IV	f			\N
690	3	95700	15	2	ASISTENTE TECNICO MUSEO	f			\N
691	2	96004	24	2	COORD. DE PROYEC. DE GESTION DE INFOR. V	f			\N
692	3	96006	22	2	JEFE PROYECTOS DE SIST. DE INFOR. II	f			\N
693	4	96010	6	2	INSPECTOR DE RUTAS DE TRANSPORTE I	f			\N
694	3	96200	15	2	ASIST. DE SERVICIOS DE MANTT. III	f			\N
695	4	96211	11	2	TECNICO DE MANTENIMIENTO I	f			\N
696	4	96212	14	2	TECNICO DE MANTENIMIENTO II	f			\N
697	3	96213	17	2	TECNICO DE MANTENIMIENTO III	f			\N
698	3	96214	20	2	TECNICO DE MANTENIMIENTO IV	f			\N
699	3	96215	21	2	TECNICO DE MANTENIMIENTO V	f			\N
700	4	96311	14	2	OPERADOR DE COMPOSICION I	f			\N
701	3	96312	16	2	OPERADOR DE COMPOSICION II	f			\N
702	3	96313	21	2	ESPECIALISTA DE ESTILO	f			\N
703	4	96331	9	2	MONTADOR EN FRIO I	f			\N
704	4	96332	11	2	MONTADOR EN FRIO II	f			\N
705	3	96500	22	2	ASIST.EJECUT.DEL CONSEJO DIRECT.UNIVERS.	f			\N
706	3	96501	23	2	ASIST. EJEC. DEL DIRECTIVO 11	f			\N
707	4	96800	12	2	COORD. DE SIST. DE MANT. DE EQUIPOS	f			\N
708	3	97000	18	2	INGENIERO ELECTRONICO I	f			\N
709	3	97001	19	2	INGENIERO ELECTRONICO II	f			\N
710	3	97002	21	2	INGENIERO ELECTRONICO III	f			\N
711	3	97011	19	2	ING. MANTENIMIENTO ELECTRONICO	f			\N
712	4	97200	13	2	ASIST. DE INVEST. EN ANALISIS AMBIENTAL	f			\N
713	3	97300	15	2	ASISTENTE DE INVEST. II	f			\N
714	4	97500	5	2	OPERADOR AUXILIAR DE COMPOSICION	f			\N
715	3	98000	21	2	JEFE TECN.DE PROMOCION INDUSTRIAL	f			\N
716	2	98100	23	2	TRABAJADOR SOCIAL JEFE I	f			\N
717	2	98101	25	2	TRABAJADOR SOCIAL JEFE II	f			\N
718	3	99100	21	2	COORDINADOR DE PRODUCCION EDITORIAL	f			\N
719	3	99111	17	2	DIRECTOR GRUPO INSTRUMENTAL	f			\N
720	3	99112	18	2	DIRECTOR TALLERES AUDI.MUSICAL	f			\N
721	3	99113	17	2	DIRECTOR DEL GRUPO VOCAL	f			\N
722	3	99191	19	2	DIRECTOR GRUPO INSTRUMENTAL	f			\N
723	3	99193	19	2	DIRECTOR DEL GRUPO VOCAL	f			\N
724	3	99211	17	2	DIRECTOR DE CORAL I	f			\N
725	3	99212	19	2	DIRECTOR DE CORAL II	f			\N
726	3	99213	22	2	DIRECTOR DE CORAL III	f			\N
727	3	99223	19	2	DIRECTOR GRUPO CRIOLLO	f			\N
728	3	99224	19	2	DIRECTOR AGRUPACION DE MUSICA DE CAMARA	f			\N
729	3	99225	19	2	DIRECTOR DE CANTO	f			\N
730	3	99233	20	2	MAESTRA DE VOCALIZACION	f			\N
731	3	99243	22	2	DIRECTOR DE LA CANTORIA	f			\N
732	4	99301	11	2	DIRECTOR DE DANZA	f			\N
733	3	99311	15	2	DIRECTOR CENTRO DE DANZAS	f			\N
734	3	99391	19	2	DIRECTOR DE DANZA	f			\N
735	3	99413	19	2	DIRECTOR DE TEATRO	f			\N
736	3	99420	17	2	DIRECTOR DE ESTUDIANTINA	f			\N
737	3	99430	20	2	ASISTENTE TECNICO A LA COORDINACION	f			\N
738	3	99431	17	2	ASISTENTE DE COORDINACION I	f			\N
739	3	99432	19	2	ASISTENTE DE COORDINACION II	f			\N
740	3	99433	21	2	ASISTENTE DE COORDINACION III	f			\N
741	3	99434	23	2	ASISTENTE DE COORDINACION IV	f			\N
742	4	99444	9	2	OPERADOR DE DIAGRAMACION I	f			\N
743	3	99452	15	2	ANALISTA ASUNTOS ADUANALES I	f			\N
744	3	99453	17	2	ANALISTA DE ASUNTOS ADUANALES II	f			\N
745	3	99454	19	2	ANALISTA  DE ASUNTOS ADUANALES III	f			\N
746	3	99455	22	2	COORD. DE ASUNTOS ADUANALES I	f			\N
747	4	99490	13	2	ASISTENTE DE PROMOTOR CULTURAL	f			\N
748	3	99500	17	2	PROMOTOR CULTURAL I	f			\N
749	3	99501	19	2	PROMOTOR CULTURAL II	f			\N
750	3	99502	21	2	PROMOTOR CULTURAL III	f			\N
751	1	99800	24	2	JEFE OFICINA DE PRENSA	f			\N
752	1	99850	25	2	JEFE ENCARGADO DEL DPTO. DE MANTENIMIENT	f			\N
753	1	99851	25	2	JEFE ENCARGADO DEL DPTO. DE PROYECTOS	f			\N
754	3	99852	25	2	ASIST. ENCARGADO DECANATO EST. GENERALES	f			\N
755	4	99900	14	2	ASIST. MEDIOS AUDIOVISUALES I	f			\N
756	4	99901	14	2	ASISTENTE MEDIOS AUDIOVISUALES II	f			\N
757	3	99902	17	2	ASISTENTE MEDIOS AUDIOVISUALES III	f			\N
758	3	99910	15	2	ASIST. ESPECIALISTA ASUNTOS AUDIO-VISUAL	f			\N
759	3	99911	17	2	ESPECIALISTA ASUNTO AUDIOVISUALES I	f			\N
760	3	99912	19	2	ESPECIALISTA ASUNTO AUDIOVISUALES II	f			\N
761	3	99913	21	2	ESPECIALISTA ASUNTOS AUDIOVISUALES III	f			\N
762	3	99920	19	2	DIRECTOR DE ESTUDIANTINA	f			\N
763	4	99970	6	2	OPERADOR DE EQUIPOS AUDIOVISUALES I	f			\N
764	4	99971	8	2	OPERADOR DE EQUIPOS AUDIOVISUALES II	f			\N
765	4	99972	10	2	OPERADOR DE EQUIPOS AUDIOVISUALES III	f			\N
766	4	99973	12	2	OPERADOR DE EQUIPOS AUDIOVISUALES IV	f			\N
767	4	99974	10	2	OPERADOR DE EQUIPOS MULTIMEDIA I	f			\N
768	4	99975	12	2	OPERADOR DE EQUIPOS MULTIMEDIA II	f			\N
769	4	99976	14	2	OPERADOR DE EQUIPOS MULTIMEDIA III	f			\N
770	3	99977	16	2	OPERADOR DE EQUIPOS MULTIMEDIA IV	f			\N
771	4	99979	13	2	ASIST. EDICION ASUNTOS AUDIOVISUALES	f			\N
772	3	99980	15	2	EDITOR DE ASUNTOS AUDIOVISUALES I	f			\N
773	3	99981	17	2	EDITOR DE ASUNTOS AUDIOVISUALES II	f			\N
774	3	99982	19	2	EDITOR DE ASUNTOS AUDIOVISUALES III	f			\N
775	1	99990	25	2	ASESOR	f			\N
776	3	99998	16	2	JEFE DE LA SECCION DE GRUPOS ESTABLES	f			\N
777	5	1031	4	3	AUXILIAR DE ZOOTECNIA	f			\N
778	5	1051	7	3	SUPERVISOR DE FINCAS	f			\N
779	5	2011	3	3	ALMACENISTA	f			\N
780	5	2021	7	3	SUPERVISOR DE ALMACEN	f			\N
781	5	3011	3	3	AYUDANTE DE MANTENIMIENTO	f			\N
782	5	3041	4	3	PINTOR	f			\N
783	5	3051	4	3	AUXILIAR DE MANTENIMIENTO	f			\N
784	5	3071	4	3	LAQUEADOR	f			\N
785	5	3091	5	3	ALBAÃIL	f			\N
786	5	3101	5	3	PLOMERO	f			\N
787	5	3111	5	3	CARPINTERO	f			\N
788	5	3121	5	3	AUXILIAR DE MTTO. EQ. SONIDO-AUDIOV.Y E	f			\N
789	5	3131	6	3	HERRERO SOLDADOR	f			\N
790	5	3141	6	3	AUXILIAR DE TELEFONIA	f			\N
791	5	3151	6	3	MECANICO DE REFRIGERACION	f			\N
792	5	3161	6	3	ELECTRICISTA	f			\N
793	5	3191	7	3	SUPERVISOR DE MANTENIMIENTO	f			\N
794	5	4011	2	3	OPERADOR DE EQUIPO REPRODUCION	f			\N
795	5	4021	2	3	OPERARIO GRAFICO	f			\N
796	5	4031	3	3	AUXILIAR GRAFICO	f			\N
797	5	4051	3	3	ENCUADERNADOR	f			\N
798	5	4121	7	3	SUPERVISOR DE TALLER DE IMPRENTA	f			\N
799	5	5031	4	3	AUXILIAR DE LABORATORIO	f			\N
800	5	6011	5	3	AUXILIAR DE ENFERMERA	f			\N
801	5	7011	2	3	AYUDANTE DE COCINA	f			\N
802	5	7041	5	3	COCINERO	f			\N
803	5	7051	7	3	SUPERVISOR DE COCINA	f			\N
804	5	8011	1	3	PORTERO	f			\N
805	5	8021	1	3	ASEADOR	f			\N
806	5	8031	1	3	RECEPTOR Y GUIA DE BIBLIOTECA	f			\N
807	5	8081	2	3	MENSAJERO INTERNO	f			\N
808	5	8101	2	3	AYUDANTE DE SERVICIOS	f			\N
809	5	8102	4	3	AUXILIAR DE SERVICIOS	f			\N
810	5	8111	3	3	MENSAJERO EXTERNO	f			\N
811	5	8131	3	3	RECEPTOR DE CORRESPONDENCIA	f			\N
812	5	8151	4	3	JARDINERO	f			\N
813	5	8171	7	3	SUPERVISOR DE SERVICIOS	f			\N
814	5	9031	3	3	DESPACHADOR DE VEHICULO	f			\N
815	5	9071	5	3	TRACTORISTA AGRICOLA	f			\N
816	5	9081	5	3	CHOFER	f			\N
817	5	9111	7	3	SUPERVISOR DE TRANSPORTE Y MECANICA AUTO	f			\N
818	5	9999	5	3	AYUDANTE DE OFICINA	f			\N
819	5	10011	4	3	VIGILANTE	f			\N
820	5	10021	7	3	SUPERVISOR DE VIGILANCIA	f			\N
821	5	10107	7	3	ALBAÃIL DE PRIMERA	f			\N
822	5	10205	5	3	ALBAÃIL DE SEGUNDA	f			\N
823	5	10302	2	3	ALBAÃIL DE TERCERA	f			\N
824	5	10405	5	3	ALMACENERO	f			\N
825	5	10501	2	3	AYUDANTE DE BIBLIOTECA	f			\N
826	5	10601	2	3	AYUDANTE DE CAVA	f			\N
828	5	10603	2	3	AYUDANTE DE CAMION O CARGA	f			\N
829	5	10701	2	3	AYUDANTE DE DEPOSITARIO	f			\N
830	5	10805	5	3	AYUDANTE DE DIAGRAMACION Y MONTAJE	f			\N
831	5	10901	2	3	AYUDANTE DE LABORATORIO	f			\N
832	5	10922	4	3	AYUDANTE LOGISTICA DE LABORATORIO II	f			\N
833	5	11001	1	3	AYUDANTE DE LOGISTICA I	f			\N
834	5	11002	2	3	AYUDANTE DE LOGISTICA	f			\N
835	5	11003	2	3	AYUDANTE DE LOGISTICA DE 2DA.	f			\N
836	5	11004	4	3	AYUDANTE DE LOGISTICA DE 1ERA.	f			\N
837	5	11103	3	3	AYUDANTE DE MANTENIMIENTO EN GENERAL	f			\N
838	5	11104	3	3	AYUDANTE DE MANTENIMIENTO	f			\N
839	5	11105	3	3	AYUDANTE DE TELEFONOS	f			\N
840	5	11106	4	3	AYUDANTE DE MANTENIMIENTO II	f			\N
841	5	11107	5	3	AYUDANTE DE MANTENIMIENTO III	f			\N
842	5	11112	4	3	AYUDANTE AGROPECUARIO II	f			\N
843	5	11201	2	3	CAMARERA	f			\N
844	5	11251	3	3	CAPATAZ DE VIGILANCIA	f			\N
845	5	11302	2	3	CARPINTERO DE TERCERA	f			\N
846	5	11405	5	3	CARPINTERO DE SEGUNDA	f			\N
847	5	11507	7	3	CARPINTERO DE PRIMERA	f			\N
848	5	11551	2	3	AYUD.CENTRO INF.Y COMP.	f			\N
849	5	11604	4	3	CHOFER DE SEGUNDA	f			\N
850	5	11705	5	3	CHOFER DE PRIMERA	f			\N
851	5	11803	3	3	COMPRADOR	f			\N
852	5	11851	3	3	COMPAGINADOR	f			\N
853	5	11901	2	3	COCINERO DE SEGUNDA	f			\N
854	5	12003	3	3	COCINERO DE PRIMERA	f			\N
855	5	12101	4	3	AYUDANTE DE ENFERMERIA	f			\N
856	5	12102	2	3	CUIDADOR DE ANIMALES	f			\N
857	5	12202	2	3	DEPOSITARIO	f			\N
858	5	12302	2	3	ELECTRICISTA DE TERCERA	f			\N
859	5	12405	5	3	ELECTRICISTA DE SEGUNDA	f			\N
860	5	12507	7	3	ELECTRICISTA DE PRIMERA	f			\N
861	5	20103	3	3	ENCUADERNADOR I	f			\N
862	5	20203	3	3	FOTOCOPIADOR	f			\N
863	5	20303	3	3	GUARDA TANQUE	f			\N
864	5	20402	2	3	HERRERO LATONERO DE SEGUNDA	f			\N
865	5	20504	4	3	HERRERO LATONERO DE PRIMERA	f			\N
866	5	20601	1	3	JARDINERO DE TERCERA	f			\N
867	5	20702	2	3	JARDINERO DE SEGUNDA	f			\N
868	5	20803	3	3	JARDINERO DE PRIMERA	f			\N
869	5	20901	2	3	MENSAJERO	f			\N
870	5	20902	2	3	MENSAJERO INTERNO	f			\N
871	5	20903	3	3	MENSAJERO MOTORIZADO	f			\N
872	5	21101	5	3	MONTADOR DE NEGATIVOS	f			\N
873	5	21102	6	3	MONTADOR DE NEGATIVOS I	f			\N
874	5	21203	1	3	OBRERO GENERAL	f			\N
875	5	21220	2	3	OBRERO DE LOGISTICA	f			\N
876	5	21304	3	3	OBRERO DE MANTENIMIENTO DE TELEFONOS	f			\N
877	5	21401	4	3	OPERARIO DE MAQUINA MULTILITH	f			\N
878	5	21402	4	3	OPERADOR DE MAQUINA MATRICERA	f			\N
879	5	21503	1	3	PINTOR DE TERCERA	f			\N
880	5	21602	3	3	PINTOR LAQUEADOR SEGUNDA	f			\N
881	5	21604	3	3	PINTOR DE SEGUNDA	f			\N
882	5	21701	7	3	PINTOR LAQUEADOR PRIMERA	f			\N
883	5	21702	4	3	PINTOR DE PRIMERA	f			\N
884	5	21804	2	3	PLOMERO DE TERCERA	f			\N
885	5	21907	4	3	PLOMERO DE SEGUNDA	f			\N
886	5	22003	7	3	PLOMERO DE PRIMERA	f			\N
887	5	22104	3	3	PORTERO	f			\N
888	5	22105	2	3	RECEPTOR DE BULTOS	f			\N
889	5	22205	4	3	RECEPTOR DE CORRESPONDENCIA	f			\N
890	5	22305	5	3	RECEPTOR DE OFICINA I	f			\N
891	5	22405	5	3	RESPONSABLE DE MANTENIMIENTO DE EDIFICIO	f			\N
892	5	22502	5	3	RETOCADOR PLANCHISTA	f			\N
893	5	22605	2	3	SOLDADOR DE TERCERA	f			\N
894	5	22707	5	3	SOLDADOR DE SEGUNDA	f			\N
895	5	22807	7	3	SOLDADOR DE PRIMERA	f			\N
896	5	22908	7	3	SUPERVISOR DE VIGILANCIA DE TERCERA	f			\N
897	5	23009	8	3	SUPERVISOR DE VIGILANCIA DE SEGUNDA	f			\N
898	2	23100	15	3	SUPERV.GENERAL DE SERV.	f			\N
899	5	23101	11	3	SUPERV.PTA.FISICA DE 1R.	f			\N
900	5	23102	10	3	SUPERVISOR DE SERVICIOS II	f			\N
901	5	23203	2	3	VIGILANTE DE SEGUNDA	f			\N
902	5	23204	3	3	VIGILANTE DE PRIMERA (CAPATAZ DE VIGIL.)	f			\N
903	5	30840	5	3	CHOFER I	f			\N
904	5	30841	6	3	CHOFER II	f			\N
905	5	30842	7	3	CHOFER III	f			\N
906	5	30942	5	3	OBRERO MANTENIMIENTO DE TELEFONOS III	f			\N
907	5	31813	7	3	PLOMERO III	f			\N
908	5	41121	4	3	VIGILANTE MOTORIZADO	f			\N
909	5	52801	7	3	RECEPTOR DE OFICINA II	f			\N
910	5	88888	3	3	OBRERO XXX	f			\N
911	5	9999	5	4	AYUDANTE DE OFICINA	f			\N
912	3	36322	19	4	PSICOLOGO II	f			\N
913	3	77121	17	4	DIETISTA I	f			\N
914	0	123	\N	\N	Cargo de Prueba 1	f	DescripciÃ³n para el cargo de prueba tipo 1	Funciones del cargo de prueba tipo 1	\N
915	0	124	\N	\N	Cargo de Prueba 2	f	DescripciÃ³n del cargo de prueba tipo 2	Funciones del cargo de prueba tipo 2	\N
916	0	200	\N	\N	Cargo de Prueba 3	f	DescripciÃ³n del cargo de prueba tipo 3	Funciones del cargo de prueba tipo 3	\N
917	0	11111	\N	\N	CARGO Saul	f	Prueba	Prueba	\N
918	3	811074	\N	\N	ADMINISTRADOR DE TECNOLOGÍA DE INFORMACIÓN	f	S/D	S/F	\N
919	3	811054	\N	\N	ANALISTA PROGRAMADOR DE SISTEMAS	f	S/D	S/F	\N
\.


--
-- Name: cargo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('cargo_id_seq', 919, true);


--
-- Data for Name: cargo_opsu; Type: TABLE DATA; Schema: public; Owner: root
--

COPY cargo_opsu (cod_cargo_opsu, nombre_opsu) FROM stdin;
\.


--
-- Data for Name: condiciones; Type: TABLE DATA; Schema: public; Owner: root
--

COPY condiciones (id, nombre) FROM stdin;
1	Reposo Medico
2	Permiso Pre y Post
3	Averiguaciones Administrativas
4	Proceso Disciplinario
5	Jubilado
6	Pensionado
7	Permiso No Remunerado
8	Permiso Remunerado
0	Ninguno
\.


--
-- Data for Name: correo; Type: TABLE DATA; Schema: public; Owner: root
--

COPY correo (id_per, destino, asunto, mensaje) FROM stdin;
\.


--
-- Data for Name: encuesta; Type: TABLE DATA; Schema: public; Owner: root
--

COPY encuesta (id, id_encuesta_ls, id_fam, id_unidad, estado, actual) FROM stdin;
50	143337	2	1	f	t
\.


--
-- Name: encuesta_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('encuesta_id_seq', 50, true);


--
-- Data for Name: encuesta_ls; Type: TABLE DATA; Schema: public; Owner: root
--

COPY encuesta_ls (id_encuesta_ls, id_fam, actual) FROM stdin;
143337	2	t
\.


--
-- Data for Name: error; Type: TABLE DATA; Schema: public; Owner: root
--

COPY error (id_error, mensaje) FROM stdin;
\.


--
-- Name: error_id_error_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('error_id_error_seq', 1, false);


--
-- Data for Name: evaluacion; Type: TABLE DATA; Schema: public; Owner: root
--

COPY evaluacion (id, periodo, fecha_ini, fecha_fin, actual) FROM stdin;
102	Abril 2015	15-04-2015	29-04-2015	f
103	Abril 2015	30-04-2015	14-05-2015	f
\.


--
-- Name: evaluacion_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('evaluacion_id_seq', 103, true);


--
-- Data for Name: familia_cargo; Type: TABLE DATA; Schema: public; Owner: root
--

COPY familia_cargo (id, nombre, descripcion) FROM stdin;
0	Sin asignar	
1	GERENCIAL	
2	SUPERVISORIO	
3	ADMINISTRATIVO PROFESIONAL	
4	ADMINISTRATIVO NO PROFESIONAL	
5	OBREROS	
\.


--
-- Name: familia_cargo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('familia_cargo_id_seq', 6, true);


--
-- Data for Name: familia_rol; Type: TABLE DATA; Schema: public; Owner: root
--

COPY familia_rol (id, nombre, descripcion) FROM stdin;
0	Sin asignar	
1	APOYO	Personas que van a realizar la encuesta para Funciones de Apoyo
2	OPERATIVAS	Personas que van a realizar la encuesta para Funciones Operativas
3	SUPERVISORIO ADMINISTRATIVO	Personas que van a realizar la encuesta para Supervisores Administrativos
4	OBRERO	Personas que van a realizar la encuesta para Obreros
5	SUPERVISORIO OBRERO	Personas que van a realizar la encuesta para Supervisores Obreros
\.


--
-- Name: familia_rol_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('familia_rol_id_seq', 5, true);


--
-- Data for Name: notificacion; Type: TABLE DATA; Schema: public; Owner: root
--

COPY notificacion (id, tipo, id_per, token_ls_per, revisado, fecha, mensaje) FROM stdin;
\.


--
-- Name: notificacion_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('notificacion_id_seq', 31, true);


--
-- Data for Name: organizacion; Type: TABLE DATA; Schema: public; Owner: root
--

COPY organizacion (id, idsup, nombre, codigo, descripcion, observacion, cod_autoridad, autoridad) FROM stdin;
0	0	Sin asignar	0			\N	\N
3000	0	 COMISION ELECTORAL	3000			\N	\N
4000	0	 Rectorado	4000			\N	\N
4001	4000	 Programas Especiales	4001			\N	\N
4010	4000	 Asesoria Juridica	4010			\N	\N
4020	4000	 Direccion Cooperacion y Relac. Interinstituc.	4020			\N	\N
4021	4000	 Unidad de Programas Especiales	4021			\N	\N
4022	4000	 Oficina de Relaciones Publicas	4022			\N	\N
4023	4000	 Oficina de Relaciones Internacionales	4023			\N	\N
4025	4000	 Oficina de Prensa	4025			\N	\N
4030	4000	 Comision de Planificacion	4030			\N	\N
4031	4000	 Oficina de Ingenieria	4031			\N	\N
4040	4000	 Programa de Educacion Continua	4040			\N	\N
4041	4000	 Programa PAYS	4041			\N	\N
4042	4000	 FUNINDES	4042			\N	\N
4043	4000	 ARTEVISION	4043			\N	\N
4050	4000	 Unidad de Auditoria Interna	4050			\N	\N
4060	4000	 Direccion De Desarrollo Estudiantil	4060			\N	\N
4061	4000	 Seccion de Deportes	4061			\N	\N
4070	4000	 Direccion de Relaciones Internacionales	4070			\N	\N
4072	4000	 Dpto. de Soporte Software	4072			\N	\N
4080	4000	 Direccion de Cultura	4080			\N	\N
4090	4000	 Comision Clasificadora	4090			\N	\N
5000	0	 Vice-Rectorado Administrativo	5000			\N	\N
5010	5000	 Direccion de Finanzas	5010			\N	\N
5011	5000	 Dpto. de Contabilidad	5011			\N	\N
5012	5000	 Oficina de Presupuesto	5012			\N	\N
5013	5000	 Dpto. de Tesoreria	5013			\N	\N
5014	5000	 Dpto. de Registro y Control Financiero	5014			\N	\N
5015	5000	 Dpto. de Bienes Nacionales	5015			\N	\N
5020	5000	 Direccion de Gestion de Capital Humano	5020			\N	\N
5021	5000	 Dpto. de Admon. y Desarrollo de Personal	5021			\N	\N
5022	5000	 Unidad de Informacion de RRHH	5022			\N	\N
5023	5000	 Dpto. de Registro y Ordenamiento de Pagos	5023			\N	\N
5024	5000	 Unidad de Enlace para Asuntos Academicos	5024			\N	\N
5025	5000	 Departamento de Relaciones Laborales	5025			\N	\N
5026	5000	 Unidad de Admon. de Recursos Presupuestarios	5026			\N	\N
5030	5000	 Direccion de Servicios	5030			\N	\N
5031	5000	 Dpto. de Compras y Suministros	5031			\N	\N
5032	5000	 Dpto. de Servicios Generales	5032			\N	\N
5033	5000	 Dpto. de Produccion de Impresos	5033			\N	\N
5034	5000	 Servicio de Comedores	5034			\N	\N
5039	5000	 Apoyo Logistico	5039			\N	\N
5040	5000	 Oficina de Organizacion y Sistemas	5040			\N	\N
5050	5000	 Nomina de Jubilados	5050			\N	\N
5060	5000	 Nomina de Pensionados	5060			\N	\N
5070	5000	 Direccion de Planta Fisica	5070			\N	\N
5071	5000	 Dpto. de Mantenimiento	5071			\N	\N
5072	5000	 Dpto. de Proyectos	5072			\N	\N
5073	5000	 Dpto. de Planeacion	5073			\N	\N
5080	5000	 Direccion de Seguridad Integral	5080			\N	\N
6000	0	 Vice-Rectorado Academico	6000			\N	\N
6100	6000	 Decanato de Estudios Generales	6100			\N	\N
6101	6100	 Coord. de Estudios Generales y 1er. AÃO	6101			\N	\N
6200	6000	 Decanato de Estudios Profesionales	6200			\N	\N
6201	6200	 Coord. de Arquitectura	6201			\N	\N
6202	6200	 Coord. de Biologia	6202			\N	\N
6204	6200	 Coord. de Estudios a Distancia en Lic. Docente	6204			\N	\N
6205	6200	 Coord. de Fisica	6205			\N	\N
6206	6200	 Coord. de Ingenieria de la Computacion	6206			\N	\N
6207	6200	 Coord. de Ingenieria de Materiales	6207			\N	\N
6208	6200	 Coord. de Ingenieria Electrica	6208			\N	\N
6209	6200	 Coord. de Ingenieria Electronica	6209			\N	\N
6210	6200	 Coord. de Ingenieria Mecanica	6210			\N	\N
6211	6200	 Coord. de Ingenieria Quimica	6211			\N	\N
6212	6200	 Coord. de Matematicas	6212			\N	\N
6213	6200	 Coord. de Quimica	6213			\N	\N
6214	6200	 Coord. de Urbanismo	6214			\N	\N
6215	6200	 Coord. de Ingenieria Geofisica	6215			\N	\N
6216	6200	 Coord. de Ingenieria de la Produccion	6216			\N	\N
6300	6000	 Decanato de Estudios de Postgrado	6300			\N	\N
6301	6300	 Coord. de Ciencias de Los Alimentos	6301			\N	\N
6302	6300	 Coord. de Ciencias Politicas	6302			\N	\N
6303	6300	 Coord. de Estudio de La Informacion	6303			\N	\N
6304	6300	 Coord. de Filosofia	6304			\N	\N
6305	6300	 Coord. de Gerencia de La Energia	6305			\N	\N
6306	6300	 Coord. de Ingenieria Civil	6306			\N	\N
6307	6300	 Coord. de Ingenieria Emp. y de Sistemas	6307			\N	\N
6308	6300	 Coord. de Literatura Latin y Contemp.	6308			\N	\N
6309	6300	 Coord. de Planif. e Ing. de Recursos Hidraulicos	6309			\N	\N
6310	6300	 Coord. de Psicologia	6310			\N	\N
6311	6300	 Coord. de Transporte Urbano	6311			\N	\N
6312	6300	 Coord. de Ingenieria de Sistemas	6312			\N	\N
6313	6300	 Coord. Desarrollo del Ambiente	6313			\N	\N
6314	6300	 Coord. Linguistica Aplicada	6314			\N	\N
6315	6300	 Coord. Ingenieria Mecanica	6315			\N	\N
6316	6300	 Coord. de Maestria en Musica	6316			\N	\N
6317	6300	 Coord. de Estudios Interdisciplinarios	6317			\N	\N
6400	6000	 Decanato de Investigaciones	6400			\N	\N
6401	6400	 Fondo del Decanato de Investigaciones	6401			\N	\N
6475	6400	 Secret. Tec. Admtva. de Inst. de Invest.	6475			\N	\N
6500	6000	 Division de Fisica y Matematicas	6500			\N	\N
6501	6500	 Dpto. de Matematicas Puras y Aplicadas	6501			\N	\N
6502	6500	 Dpto. de Fisica	6502			\N	\N
6503	6500	 Dpto. de Quimica	6503			\N	\N
6504	6500	 Dpto. de Mecanica	6504			\N	\N
6505	6500	 Dpto. de Termodinamica y Fenomenos de Transfe.	6505			\N	\N
6506	6500	 Dpto. de Electronica y Circuitos	6506			\N	\N
6507	6500	 Dpto. de Conversion y Transporte de Energia	6507			\N	\N
6508	6500	 Dpto. de Procesos y Sistemas	6508			\N	\N
6509	6500	 Dpto. de Ciencia de los Materiales	6509			\N	\N
6510	6500	 Dpto. Computacion y Tecnologia de la Inform.	6510			\N	\N
6511	6500	 Dpto. de Ciencias de la Tierra	6511			\N	\N
6512	6500	 Dpto. de Computo Cientifico y Estadistico	6512			\N	\N
6551	6500	 Instituto de Energia	6551			\N	\N
6552	6500	 Instituto de Estudios Regionales y Urbanos	6552			\N	\N
6553	6500	 Instituto de Investigacion y Desarrollo Industrial	6553			\N	\N
6554	6500	 Instituto de Metalurgia	6554			\N	\N
6600	6000	 Unidad de Laboratorios	6600			\N	\N
6601	6600	 Laboratorio de Mecanica    "A",	6601			\N	\N
6602	6600	 Laboratorio de Quimica     "B",	6602			\N	\N
6603	6600	 Laboratorio de Electronica "C",	6603			\N	\N
6604	6600	 Laboratorio de Fisica      "D",	6604			\N	\N
6605	6600	 Laboratorio de Procesos de Manufactura "E",	6605			\N	\N
6606	6600	 Laboratorio de Tecnologia de Informacion "F",	6606			\N	\N
6700	6000	 Division de Ciencias Sociales y Humanidades	6700			\N	\N
6701	6700	 Dpto. de Ciencias Sociales	6701			\N	\N
6702	6700	 Dpto. de Lengua y Literatura	6702			\N	\N
6703	6700	 Dpto. de Ciencias Economicas y Admtvas.	6703			\N	\N
6704	6700	 Dpto. de Filosofia	6704			\N	\N
6705	6700	 Dpto. de Idiomas	6705			\N	\N
6706	6700	 Dpto. de Ciencias y Tec. del Comportamiento	6706			\N	\N
6707	6700	 Dpto. de DiseÃ±o Arquitectura y Artes Plast.	6707			\N	\N
6708	6700	 Dpto. de Planificacion Urbana	6708			\N	\N
6751	6700	 Inst. de Altos Estudios de America Latina	6751			\N	\N
6752	6700	 Instituto de Estudios Regionales y Urbanos	6752			\N	\N
6753	6700	 Bolivarium	6753			\N	\N
6800	6000	 Division de Ciencias Biologicas	6800			\N	\N
6801	6800	 Dpto. de Biologia Celular	6801			\N	\N
6802	6800	 Dpto. de Estudios Ambientales	6802			\N	\N
6803	6800	 Dpto. de Tecnol. de Proc. Biolog. y Bioqui.	6803			\N	\N
6804	6800	 Dpto. de Biologia de Organismos	6804			\N	\N
6851	6800	 Instituto de Tecnol. y Ciencias Marinas	6851			\N	\N
6852	6800	 Instituto de Recursos Naturales Renovables	6852			\N	\N
6900	6000	 NO--EXISTE--En--El--Archivo	6900			\N	\N
6910	6900	 Centro de Investigaciones Educativas	6910			\N	\N
6920	6900	 Decanato de Extension	6920			\N	\N
6930	6900	 CAMBIO a la 7040 Dir. Servicios Multimedia	6930			\N	\N
6940	6900	 Biblioteca	6940			\N	\N
6950	6900	 Direccion de Desarrollo Profesoral	6950			\N	\N
6960	6900	 Direccion de Deportes	6960			\N	\N
7000	0	 Secretaria	7000			\N	\N
7010	7000	 Direccion de Admision y Control de Estudios (DACE)	7010			\N	\N
7020	7000	 Direccion de Ingenieria de la Informacion	7020			\N	\N
7030	7000	 Centro de Documentacion y Archivo (CENDA)	7030			\N	\N
7040	7000	 Direccion de Servicios Multimedia	7040			\N	\N
7044	7000	 Unidad de Edumatica	7044			\N	\N
7050	7000	 Direccion de Servicios Telematicos	7050			\N	\N
8000	0	 Nucleo Universitario del Litoral (DIR. GENERAL).	8000			\N	\N
8010	8000	 Ofic. de Informacion y Secretaria.	8010			\N	\N
8020	8000	 Ofic. de Relaciones Publicas.	8020			\N	\N
8090	8000	 Pensionados y Jubilados.	8090			\N	\N
8100	8000	 Direccion de Administracion.	8100			\N	\N
8110	8100	 Dpto. de Finanzas	8110			\N	\N
8120	8100	 Dpto. de Recursos Humanos	8120			\N	\N
8121	8100	 Unidad de Apoyo Administrativo	8121			\N	\N
8130	8100	 Dpto. de Registro y Control Admtvo.	8130			\N	\N
8140	8100	 Dpto. de Ingenieria y Mantenimiento	8140			\N	\N
8150	8100	 Dpto. de Adquisiciones y Reproduccion	8150			\N	\N
8160	8100	 Dpto. de Seguridad y Servicios	8160			\N	\N
8200	8000	 Direccion de Apoyo Infor. Academica	8200			\N	\N
8210	8200	 Dpto. de Admision y Control Estudios	8210			\N	\N
8220	8200	 Dpto. de Archivo y Estadistica	8220			\N	\N
8230	8200	 Coord. de Ingenieria de Informacion	8230			\N	\N
8240	8200	 Dpto. de Biblioteca	8240			\N	\N
8250	8200	 Departamento de Multimedia Sede Litoral	8250			\N	\N
8260	8200	 Dpto. de Operaciones de Servicios Telematicos	8260			\N	\N
8300	8000	 Coord. de Extension Universitaria	8300			\N	\N
8400	8000	 Dpto. de Desarrollo Estudiantil	8400			\N	\N
8410	8400	 Coord. de Tecnologia Industrial	8410			\N	\N
8420	8400	 Coord. de Tecnologia Administrativa	8420			\N	\N
8430	8400	 Deportes	8430			\N	\N
8440	8400	 Unidad de Apoyo Docente	8440			\N	\N
8500	8000	 Direccion de Programacion Docente	8500			\N	\N
8510	8500	 Coord. de Tecno. Elect. Electronica	8510			\N	\N
8520	8500	 Coord. de Formacion General	8520			\N	\N
8530	8500	 Coord. de Tecno. Mecanica y Mant. Aerona.	8530			\N	\N
8540	8500	 Coord. de Cursos en Coop. con la Empresa	8540			\N	\N
8550	8500	 Coord. de Admt. de Turismo y Hoteleria	8550			\N	\N
8560	8500	 Coord. de Educacion Permanente	8560			\N	\N
8570	8500	 Coord. de Tec. Adm. Gerenciales y Tribut.	8570			\N	\N
8600	8000	 Direccion de Admt. de Programas Academicos	8600			\N	\N
8610	8600	 Unidad de Laboratorios	8610			\N	\N
8620	8600	 Dpto. de Tecnologia Industrial	8620			\N	\N
8630	8600	 Dpto. de Tecnologia de Servicio	8630			\N	\N
8640	8600	 Dpto. Form. General y Ccias. Basicas	8640			\N	\N
8650	8600	 Centro de Inv. en Tec. Apropiadas	8650			\N	\N
8700	8000	 Direccion de Investigacion	8700			\N	\N
9000	0	 Consejo Superior	9000			\N	\N
6203	6200	 Coord. de Cursos en Cooperac. con la Industria	6203	La CoordinaciÃ³n de CooperaciÃ³n TÃ©cnica (CCT) es la unidad encargada de planificar, supervisar, asesorar y controlar el Programa de PasantÃ­as Empresariales que ofrece a sus estudiantes la Universidad SimÃ³n BolÃ­var.		\N	\N
1	0	USB	1	Todas las unidades de la Universidad Simón Bolívar.	Unidad creada para realizar encuestas de carácter global.	\N	\N
7025	7020	Coordinación de Ingeniería de Procesos Organizacionales 	7025	.	.	\N	\N
7021	7020	Coordinación de Soporte de Operaciones	7021	.	 .	\N	\N
7022	7020	Coordinación de Gestión Académica	7022	.	.	\N	\N
7024	7020	Coordinación de Gestión Administrativa	7024	.	.	\N	\N
7023	7020	Coordinación de Gestión de Logística y Servicios	7023	.	.	\N	\N
8231	8230	Sección de Sistemas de Información	8231	.	.	\N	\N
8232	8230	Sección de Organización y Sistemas	8232	.	.	\N	\N
8233	8230	Sección de Soporte de Operaciones	8233	.	.	\N	\N
\.


--
-- Name: organizacion_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('organizacion_id_seq', 13, true);


--
-- Data for Name: persona; Type: TABLE DATA; Schema: public; Owner: root
--

COPY persona (id, tipo, nombre, apellido, cedula, sexo, fecha_nac, unidad, direccion, telefono, email, activo, seccion, condicion, rol, fecha_ing) FROM stdin;
0	0	Sin asignar			 					\N	t	01	0	\N	\N
38	1	Kenyer	Dominguez	14197016	M		3000			kenyer@gmail.com	t	01	0	2	\N
40	2	OSWALDO JAVIER	RODRIGUEZ	10117322	 		7020			10117322@usb.ve	t	\N	0	3	15-07-1994
41	2	MARIA ISABEL	PITA BOENTE	3558297	 		7020			3558297@usb.ve	t	\N	0	2	01-10-1997
42	2	LIVIA	TORRE STELLA	6052318	 		7020			6052318@usb.ve	t	\N	0	1	27-05-1996
43	2	CARINA	FERREIRA  NASCIMENTO	15701386	 		7021			15701386@usb.ve	t	\N	0	3	04-01-2006
44	2	ROBERTO ENRIQUE	ARAUJO BENCOMO	15040541	 		7021			15040541@usb.ve	t	\N	0	2	03-07-2000
45	2	JUAN CARLOS	ABREU VALLE	12294762	 		7021			12294762@usb.ve	t	\N	0	2	14-01-1999
46	2	YRMA DORIS	HERNANDEZ MENDEZ	5507243	 		7021			5507243@usb.ve	t	\N	0	2	16-03-2000
47	2	SAMUEL ELI	DUARTE ARVELO	18094495	 		7021			18094495@usb.ve	t	\N	0	2	31-10-2011
48	2	MARIA LUISA	MORENO	5132892	 		7022			5132892@usb.ve	t	\N	0	3	01-08-1993
49	2	FRANCIS D CARME	CAMACHO MUJICA	17478343	 		7022			17478343@usb.ve	t	\N	0	2	07-01-2008
50	2	FRANCIS DELIS	FRANCHI PAREDES	11434239	 		7022			11434239@usb.ve	t	\N	0	2	25-10-2006
51	2	DARLING JOSEFIN	LUNA TOVAR	16369762	 		7022			16369762@usb.ve	t	\N	0	2	03-09-2009
52	2	CESAR MANUEL	MENDEZ BRAVO	15250222	 		7022			15250222@usb.ve	t	\N	0	2	01-12-2007
53	2	MARCEL JOSE	CASTRO GONZALEZ	11035937	 		7023			11035937@usb.ve	t	\N	0	3	01-03-1994
54	2	LUIS CESAR	RAMOS YEPEZ	12455485	 		7023			12455485@usb.ve	t	\N	0	2	06-11-2003
55	2	EUGENIO F.	OWKIN GONZALEZ	14405316	 		7023			14405316@usb.ve	t	\N	0	2	08-01-2007
56	2	ALEKSANDER	GONZALEZ KLIMKIEWICZ	16146816	 		7023			16146816@usb.ve	t	\N	0	2	25-10-2006
57	2	CARMEN BEATRIZ	CAñIZALEZ MONTILLA	15541276	 		7023			15541276@usb.ve	t	\N	0	2	03-10-2011
58	2	DEIVY GREGORY	VENTO LAEZ	12877043	 		7023			12877043@usb.ve	t	\N	0	2	04-01-2006
59	2	JUAN CARLOS	CALDERON COLINA	14427922	 		7023			14427922@usb.ve	t	\N	0	2	13-06-2006
60	2	ELISA ROSMAR	GONZALEZ LAYA	17488526	 		7023			17488526@usb.ve	t	\N	0	2	04-01-2006
61	2	LINFRED	BOLIVAR PEREZ	11412400	 		7024			11412400@usb.ve	t	\N	0	3	17-01-2000
62	2	HAULIN A.	FLORES MIRANDA	12482392	 		7024			12482392@usb.ve	t	\N	0	2	03-06-2002
63	2	TANIA ISABEL	DAVID CHIRINOS	6671415	 		7024			6671415@usb.ve	t	\N	0	2	16-03-2002
64	2	DENISE CAROLINA	GARANTON PEÑA	15613448	 		7024			15613448@usb.ve	t	\N	0	2	01-11-2006
65	2	YEXICA DEL C.	MENDEZ SALAZAR	12485804	 		7024			12485804@usb.ve	t	\N	0	2	03-06-2002
66	2	GUAYNER ENRIQUE	MEZA BRICEÑO	14789760	 		7024			14789760@usb.ve	t	\N	0	2	25-10-2006
67	2	TRINA YINESKA	SUAREZ COLMENARES	12304121	 		7024			12304121@usb.ve	t	\N	0	3	03-06-2002
68	2	NORAIDA C.	YRIARTE UGUETO	11063667	 		7025			11063667@usb.ve	t	\N	0	2	03-04-2000
69	2	LISETH MARGARIT	GONZALEZ BARRIOS	11406243	 		7025			11406243@usb.ve	t	\N	0	2	01-11-2002
70	2	VANESSA DEL V.	PAREDES NAVAS	14645291	 		7025			14645291@usb.ve	t	\N	0	2	08-09-2006
71	2	GUSMAIRA	MACHADO PADRON	13245234	 		7025			13245234@usb.ve	t	\N	0	2	04-01-2006
72	2	CARLOS AUGUSTO	MATOS MARRERO	15519114	 		7025			15519114@usb.ve	t	\N	0	2	20-05-2005
73	2	MARIBEL	SANCHEZ MENDOZA	10896927	 		7025			10896927@usb.ve	t	\N	0	2	09-10-1990
74	2	ALEXIS	ABREU CABELLO	7999998	 		8230			7999998@usb.ve	t	\N	0	3	15-09-1992
75	2	KAREN LEOISNEL	CURVELO SOSA	16105519	 		8230			16105519@usb.ve	t	\N	0	1	26-02-2008
76	2	ALAN HUMBERTO	CADENA PEREZ	17154311	 		8231			17154311@usb.ve	t	\N	0	2	23-07-2007
77	2	JAROLD ANIBAL	DELGADO CARPIO	17268021	 		8231			17268021@usb.ve	t	\N	0	2	11-06-2007
78	2	PEDRO LUIS	PEREZ MAY	18536234	 		8231			18536234@usb.ve	t	\N	0	2	09-02-2010
79	2	IBRAHIM ANTONIO	ZERPA ORTIZ	16970914	 		8231			16970914@usb.ve	t	\N	0	2	18-07-2011
80	2	MADYSNI J.	RAMOS RODRIGUEZ	11061826	 		8232			11061826@usb.ve	t	\N	0	2	01-01-1999
81	2	NAIROBI KAROL	MARIN VELIZ	10583671	 		8232			10583671@usb.ve	t	\N	0	2	21-02-2005
82	2	JHONATHAN DAVID	SOSA OVALLES	16310973	 		8233			16310973@usb.ve	t	\N	0	2	12-11-2007
83	2	MAILEN JANITZA	JIMENEZ FIGUEROA	6133051	 		5020			6133051@usb.ve	t	\N	0	3	19-01-1998
85	2	NELLY TERESA	CHACON HERNANDEZ	10898226	 		5020			10898226@usb.ve	t	\N	0	3	08-10-1992
87	2	HERNAN JAVIER	GODOY RODRIGUEZ	10718315	 		5020			10718315@usb.ve	t	\N	0	3	01-02-2000
88	2	GLADYS M.	PEREZ R.	10180604	 		5020			10180604@usb.ve	t	\N	0	2	18-04-1995
35	2	Carmen Alicia	Hernandez	3812692	F		5020	\N	\N	cahernan@usb.ve	t	\N	0	3	\N
36	2	Madeleine	Ustariz	12001223	F		5020	\N	\N	mustariz@usb.ve	t	\N	0	2	\N
34	2	Pablo	Hernandez	17972062	M		5020			pablo.hernandez.borges@gmail.com	t	01	0	2	\N
89	1	Cristian Carlos	Puig	13800416	M		7000	\N	\N	13800416@usb.ve	t	\N	0	3	\N
\.


--
-- Data for Name: persona_cargo; Type: TABLE DATA; Schema: public; Owner: root
--

COPY persona_cargo (id_per, id_car, actual, fecha_ini, fecha_fin, observacion) FROM stdin;
34	2	f	11-02-2015	26-02-2015	
34	2	t	02-02-2014	\N	
40	227	t	01-01-2015		
88	98	t	01-01-2015	\N	\N
81	683	t	01-01-2015	\N	\N
87	50	t	01-01-2015	\N	\N
73	35	t	01-01-2015	\N	\N
85	22	t	01-01-2015	\N	\N
53	227	t	01-01-2015	\N	\N
80	34	t	01-01-2015	\N	\N
68	37	t	01-01-2015	\N	\N
69	33	t	01-01-2015	\N	\N
61	227	t	01-01-2015	\N	\N
50	223	t	01-01-2015	\N	\N
36	88	t	01-01-2015	\N	\N
45	647	t	01-01-2015	\N	\N
67	226	t	01-01-2015	\N	\N
54	229	t	01-01-2015	\N	\N
62	226	t	01-01-2015	\N	\N
65	226	t	01-01-2015	\N	\N
58	223	t	01-01-2015	\N	\N
71	33	t	01-01-2015	\N	\N
55	222	t	01-01-2015	\N	\N
59	222	t	01-01-2015	\N	\N
70	33	t	01-01-2015	\N	\N
66	223	t	01-01-2015	\N	\N
44	226	t	01-01-2015	\N	\N
52	644	t	01-01-2015	\N	\N
72	34	t	01-01-2015	\N	\N
57	221	t	01-01-2015	\N	\N
64	222	t	01-01-2015	\N	\N
43	226	t	01-01-2015	\N	\N
75	236	t	01-01-2015	\N	\N
56	222	t	01-01-2015	\N	\N
82	646	t	01-01-2015	\N	\N
51	222	t	01-01-2015	\N	\N
79	222	t	01-01-2015	\N	\N
76	222	t	01-01-2015	\N	\N
77	222	t	01-01-2015	\N	\N
49	222	t	01-01-2015	\N	\N
60	221	t	01-01-2015	\N	\N
47	918	t	01-01-2015	\N	\N
78	919	t	01-01-2015	\N	\N
41	62	t	01-01-2015	\N	\N
35	51	t	01-01-2015	\N	\N
48	227	t	01-01-2015	\N	\N
46	646	t	01-01-2015	\N	\N
42	242	t	01-01-2015	\N	\N
83	50	t	01-01-2015	\N	\N
63	221	t	01-01-2015	\N	\N
74	227	t	01-01-2015	\N	\N
89	244	t	01-01-2015	\N	
\.


--
-- Data for Name: persona_encuesta; Type: TABLE DATA; Schema: public; Owner: root
--

COPY persona_encuesta (id_encuesta, id_encuesta_ls, token_ls, tid_ls, periodo, id_car, id_unidad, tipo, id_encuestado, id_evaluado, estado, actual, fecha, ip, retroalimentacion) FROM stdin;
50	143337	7hixireg5zckp5i	1	102	2	1	autoevaluacion	34	34	Pendiente	f	15/04/2015.15:13	127.0.0.1	sin realizar
50	143337	ipzzjyfqafjyp7c	2	102	2	1	evaluador	35	34	Pendiente	f	15/04/2015.15:13	127.0.0.1	sin realizar
50	143337	jrdkw5fxfxg7hat	3	102	4	1	autoevaluacion	36	36	Pendiente	f	15/04/2015.15:13	127.0.0.1	sin realizar
50	143337	cmyzhejntb3t9tf	4	102	4	1	evaluador	34	36	Pendiente	f	15/04/2015.15:13	127.0.0.1	sin realizar
50	143337	sfqiyq5egekh7bu	6	102	2	1	evaluador	35	34	Pendiente	f	15/04/2015.15:13	127.0.0.1	sin realizar
50	143337	2hsu3y6kghdfzrx	7	102	4	1	autoevaluacion	36	36	Pendiente	f	15/04/2015.15:13	127.0.0.1	sin realizar
50	143337	nrrfi5zh9iakm2f	8	102	4	1	evaluador	34	36	Pendiente	f	15/04/2015.15:13	127.0.0.1	sin realizar
50	143337	tnijm9nfj5wgh45	5	102	2	1	autoevaluacion	34	34	Finalizada	f	15/04/2015.15:22	127.0.0.1	sin realizar
\.


--
-- Data for Name: persona_evaluador; Type: TABLE DATA; Schema: public; Owner: root
--

COPY persona_evaluador (id_per, id_eva, actual, fecha_ini, fecha_fin, observacion) FROM stdin;
34	35	t	11-09-2014		
41	68	t	01-01-2015	\N	\N
42	68	t	01-01-2015	\N	\N
43	68	t	01-01-2015	\N	\N
44	43	t	01-01-2015	\N	\N
45	43	t	01-01-2015	\N	\N
46	43	t	01-01-2015	\N	\N
47	43	t	01-01-2015	\N	\N
48	68	t	01-01-2015	\N	\N
49	48	t	01-01-2015	\N	\N
50	48	t	01-01-2015	\N	\N
51	48	t	01-01-2015	\N	\N
52	48	t	01-01-2015	\N	\N
53	68	t	01-01-2015	\N	\N
54	53	t	01-01-2015	\N	\N
55	53	t	01-01-2015	\N	\N
56	53	t	01-01-2015	\N	\N
57	53	t	01-01-2015	\N	\N
58	53	t	01-01-2015	\N	\N
59	53	t	01-01-2015	\N	\N
60	53	t	01-01-2015	\N	\N
61	68	t	01-01-2015	\N	\N
62	61	t	01-01-2015	\N	\N
63	61	t	01-01-2015	\N	\N
64	61	t	01-01-2015	\N	\N
65	61	t	01-01-2015	\N	\N
66	61	t	01-01-2015	\N	\N
67	61	t	01-01-2015	\N	\N
68	68	t	01-01-2015	\N	\N
69	68	t	01-01-2015	\N	\N
70	68	t	01-01-2015	\N	\N
71	68	t	01-01-2015	\N	\N
72	68	t	01-01-2015	\N	\N
73	68	t	01-01-2015	\N	\N
74	68	t	01-01-2015	\N	\N
75	74	t	01-01-2015	\N	\N
76	74	t	01-01-2015	\N	\N
77	74	t	01-01-2015	\N	\N
78	74	t	01-01-2015	\N	\N
79	74	t	01-01-2015	\N	\N
80	74	t	01-01-2015	\N	\N
81	74	t	01-01-2015	\N	\N
82	74	t	01-01-2015	\N	\N
83	34	t	01-01-2015	\N	\N
35	83	t	01-01-2015	\N	\N
35	85	t	01-01-2015	\N	\N
85	83	t	01-01-2015	\N	\N
36	85	t	01-01-2015	\N	\N
36	87	t	01-01-2015	\N	\N
36	35	t	01-01-2015	\N	\N
87	83	t	01-01-2015	\N	\N
88	87	t	01-01-2015	\N	\N
36	34	t	24-09-2014	01-01-2015	
\.


--
-- Name: persona_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('persona_id_seq', 89, true);


--
-- Data for Name: persona_supervisor; Type: TABLE DATA; Schema: public; Owner: root
--

COPY persona_supervisor (id_per, id_sup, actual, fecha_ini, fecha_fin, observacion) FROM stdin;
34	35	t	11-02-2015	\N	
36	35	t	24-02-2015	\N	
40	89	t	01-01-2015	\N	\N
44	68	t	01-01-2015	\N	\N
45	68	t	01-01-2015	\N	\N
46	68	t	01-01-2015	\N	\N
47	68	t	01-01-2015	\N	\N
49	68	t	01-01-2015	\N	\N
50	68	t	01-01-2015	\N	\N
51	68	t	01-01-2015	\N	\N
52	68	t	01-01-2015	\N	\N
54	68	t	01-01-2015	\N	\N
55	68	t	01-01-2015	\N	\N
56	68	t	01-01-2015	\N	\N
57	68	t	01-01-2015	\N	\N
58	68	t	01-01-2015	\N	\N
59	68	t	01-01-2015	\N	\N
60	68	t	01-01-2015	\N	\N
62	68	t	01-01-2015	\N	\N
63	68	t	01-01-2015	\N	\N
64	68	t	01-01-2015	\N	\N
65	68	t	01-01-2015	\N	\N
66	68	t	01-01-2015	\N	\N
67	68	t	01-01-2015	\N	\N
69	68	t	01-01-2015	\N	\N
70	68	t	01-01-2015	\N	\N
71	68	t	01-01-2015	\N	\N
72	68	t	01-01-2015	\N	\N
73	68	t	01-01-2015	\N	\N
75	68	t	01-01-2015	\N	\N
76	68	t	01-01-2015	\N	\N
77	68	t	01-01-2015	\N	\N
78	68	t	01-01-2015	\N	\N
79	68	t	01-01-2015	\N	\N
80	68	t	01-01-2015	\N	\N
81	68	t	01-01-2015	\N	\N
82	68	t	01-01-2015	\N	\N
35	83	t	01-01-2015	\N	\N
85	83	t	01-01-2015	\N	\N
36	83	t	01-01-2015	\N	\N
87	83	t	01-01-2015	\N	\N
88	83	t	01-01-2015	\N	\N
\.


--
-- Data for Name: pregunta; Type: TABLE DATA; Schema: public; Owner: root
--

COPY pregunta (id_pregunta, id_pregunta_ls, id_encuesta_ls, seccion, titulo, id_pregunta_root_ls) FROM stdin;
1034	1	143337	competencia	Puntualidad	\N
1035	0	143337	competencia	Llega a tiempo a la oficina	1
1036	1	143337	competencia	Sale a tiempo de la oficina	1
1037	2	143337	competencia	Cumple su horario diario de 8 horas	1
1038	5	143337	competencia	Liderazgo	\N
1039	0	143337	competencia	Comunica sus ideas a sus compañeros efectivamente	5
1040	1	143337	competencia	Sus ideas se transforman en proyectos	5
1041	2	143337	competencia	Motiva a mejorar la productividad de su entorno	5
\.


--
-- Name: pregunta_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('pregunta_id_seq', 1041, true);


--
-- Data for Name: pregunta_peso; Type: TABLE DATA; Schema: public; Owner: root
--

COPY pregunta_peso (id_pregunta, id_encuesta, peso) FROM stdin;
\.


--
-- Data for Name: respuesta; Type: TABLE DATA; Schema: public; Owner: root
--

COPY respuesta (token_ls, id_pregunta, respuesta) FROM stdin;
tnijm9nfj5wgh45	1035	Nunca
tnijm9nfj5wgh45	1036	Raras veces
tnijm9nfj5wgh45	1037	A veces
tnijm9nfj5wgh45	1039	A veces
tnijm9nfj5wgh45	1040	Raras veces
tnijm9nfj5wgh45	1041	Nunca
\.


--
-- Data for Name: supervisor_encuesta; Type: TABLE DATA; Schema: public; Owner: root
--

COPY supervisor_encuesta (id_sup, token_ls_eva, aprobado, fecha, ip, retroalimentacion) FROM stdin;
\.


--
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: root
--

COPY usuario (id, username) FROM stdin;
\.


--
-- Name: usuario_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('usuario_id_seq', 1, false);


--
-- Name: Condicione_pkey; Type: CONSTRAINT; Schema: public; Owner: root; Tablespace: 
--

ALTER TABLE ONLY condiciones
    ADD CONSTRAINT "Condicione_pkey" PRIMARY KEY (id);


--
-- Name: area_de_trabajo_pkey; Type: CONSTRAINT; Schema: public; Owner: root; Tablespace: 
--

ALTER TABLE ONLY area_de_trabajo
    ADD CONSTRAINT area_de_trabajo_pkey PRIMARY KEY (cod_area_trabajo);


--
-- Name: cargo_opsu_pkey; Type: CONSTRAINT; Schema: public; Owner: root; Tablespace: 
--

ALTER TABLE ONLY cargo_opsu
    ADD CONSTRAINT cargo_opsu_pkey PRIMARY KEY (cod_cargo_opsu);


--
-- Name: cargo_pkey; Type: CONSTRAINT; Schema: public; Owner: root; Tablespace: 
--

ALTER TABLE ONLY cargo
    ADD CONSTRAINT cargo_pkey PRIMARY KEY (id);


--
-- Name: encuesta_ls_pkey; Type: CONSTRAINT; Schema: public; Owner: root; Tablespace: 
--

ALTER TABLE ONLY encuesta_ls
    ADD CONSTRAINT encuesta_ls_pkey PRIMARY KEY (id_encuesta_ls);


--
-- Name: encuesta_pkey; Type: CONSTRAINT; Schema: public; Owner: root; Tablespace: 
--

ALTER TABLE ONLY encuesta
    ADD CONSTRAINT encuesta_pkey PRIMARY KEY (id);


--
-- Name: error_pkey; Type: CONSTRAINT; Schema: public; Owner: root; Tablespace: 
--

ALTER TABLE ONLY error
    ADD CONSTRAINT error_pkey PRIMARY KEY (id_error);


--
-- Name: evaluacion_pkey; Type: CONSTRAINT; Schema: public; Owner: root; Tablespace: 
--

ALTER TABLE ONLY evaluacion
    ADD CONSTRAINT evaluacion_pkey PRIMARY KEY (id);


--
-- Name: familia_cargo_pkey; Type: CONSTRAINT; Schema: public; Owner: root; Tablespace: 
--

ALTER TABLE ONLY familia_cargo
    ADD CONSTRAINT familia_cargo_pkey PRIMARY KEY (id);


--
-- Name: familia_rol_pkey; Type: CONSTRAINT; Schema: public; Owner: root; Tablespace: 
--

ALTER TABLE ONLY familia_rol
    ADD CONSTRAINT familia_rol_pkey PRIMARY KEY (id);


--
-- Name: notificacion_pkey; Type: CONSTRAINT; Schema: public; Owner: root; Tablespace: 
--

ALTER TABLE ONLY notificacion
    ADD CONSTRAINT notificacion_pkey PRIMARY KEY (id);


--
-- Name: organizacion_pkey; Type: CONSTRAINT; Schema: public; Owner: root; Tablespace: 
--

ALTER TABLE ONLY organizacion
    ADD CONSTRAINT organizacion_pkey PRIMARY KEY (id);


--
-- Name: persona_encuesta_pkey; Type: CONSTRAINT; Schema: public; Owner: root; Tablespace: 
--

ALTER TABLE ONLY persona_encuesta
    ADD CONSTRAINT persona_encuesta_pkey PRIMARY KEY (token_ls);


--
-- Name: persona_pkey; Type: CONSTRAINT; Schema: public; Owner: root; Tablespace: 
--

ALTER TABLE ONLY persona
    ADD CONSTRAINT persona_pkey PRIMARY KEY (id);


--
-- Name: pregunta_pkey; Type: CONSTRAINT; Schema: public; Owner: root; Tablespace: 
--

ALTER TABLE ONLY pregunta
    ADD CONSTRAINT pregunta_pkey PRIMARY KEY (id_pregunta);


--
-- Name: usuario_pkey; Type: CONSTRAINT; Schema: public; Owner: root; Tablespace: 
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_pkey PRIMARY KEY (id);


--
-- Name: cargo_cod_cargo_opsu_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY cargo
    ADD CONSTRAINT cargo_cod_cargo_opsu_fkey FOREIGN KEY (cod_cargo_opsu) REFERENCES cargo_opsu(cod_cargo_opsu) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: cargo_id_fam_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY cargo
    ADD CONSTRAINT cargo_id_fam_fkey FOREIGN KEY (id_fam) REFERENCES familia_cargo(id) ON DELETE CASCADE;


--
-- Name: correo_id_per_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY correo
    ADD CONSTRAINT correo_id_per_fkey FOREIGN KEY (id_per) REFERENCES persona(id) ON DELETE CASCADE;


--
-- Name: encuesta_id_encuesta_ls_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY encuesta
    ADD CONSTRAINT encuesta_id_encuesta_ls_fkey FOREIGN KEY (id_encuesta_ls) REFERENCES encuesta_ls(id_encuesta_ls) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: encuesta_id_fam_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY encuesta
    ADD CONSTRAINT encuesta_id_fam_fkey FOREIGN KEY (id_fam) REFERENCES familia_rol(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: encuesta_id_unidad_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY encuesta
    ADD CONSTRAINT encuesta_id_unidad_fkey FOREIGN KEY (id_unidad) REFERENCES organizacion(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: encuesta_ls_id_fam_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY encuesta_ls
    ADD CONSTRAINT encuesta_ls_id_fam_fkey FOREIGN KEY (id_fam) REFERENCES familia_cargo(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: notificacion_id_per_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY notificacion
    ADD CONSTRAINT notificacion_id_per_fkey FOREIGN KEY (id_per) REFERENCES persona(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: notificacion_token_ls_per_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY notificacion
    ADD CONSTRAINT notificacion_token_ls_per_fkey FOREIGN KEY (token_ls_per) REFERENCES persona_encuesta(token_ls) ON DELETE CASCADE;


--
-- Name: organizacion_idsup_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY organizacion
    ADD CONSTRAINT organizacion_idsup_fkey FOREIGN KEY (idsup) REFERENCES organizacion(id) ON DELETE CASCADE;


--
-- Name: persona_cargo_id_per_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY persona_cargo
    ADD CONSTRAINT persona_cargo_id_per_fkey FOREIGN KEY (id_per) REFERENCES persona(id) ON DELETE CASCADE;


--
-- Name: persona_cod_area_trabajo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY persona
    ADD CONSTRAINT persona_cod_area_trabajo_fkey FOREIGN KEY (seccion) REFERENCES area_de_trabajo(cod_area_trabajo) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: persona_cod_condicion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY persona
    ADD CONSTRAINT persona_cod_condicion_fkey FOREIGN KEY (condicion) REFERENCES condiciones(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: persona_encuesta_id_car_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY persona_encuesta
    ADD CONSTRAINT persona_encuesta_id_car_fkey FOREIGN KEY (id_car) REFERENCES cargo(id) ON DELETE CASCADE;


--
-- Name: persona_encuesta_id_encuesta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY persona_encuesta
    ADD CONSTRAINT persona_encuesta_id_encuesta_fkey FOREIGN KEY (id_encuesta) REFERENCES encuesta(id) ON DELETE CASCADE;


--
-- Name: persona_encuesta_id_encuesta_ls_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY persona_encuesta
    ADD CONSTRAINT persona_encuesta_id_encuesta_ls_fkey FOREIGN KEY (id_encuesta_ls) REFERENCES encuesta_ls(id_encuesta_ls) ON DELETE CASCADE;


--
-- Name: persona_encuesta_id_encuestado_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY persona_encuesta
    ADD CONSTRAINT persona_encuesta_id_encuestado_fkey FOREIGN KEY (id_encuestado) REFERENCES persona(id) ON DELETE CASCADE;


--
-- Name: persona_encuesta_id_evaluado_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY persona_encuesta
    ADD CONSTRAINT persona_encuesta_id_evaluado_fkey FOREIGN KEY (id_evaluado) REFERENCES persona(id) ON DELETE CASCADE;


--
-- Name: persona_encuesta_id_unidad_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY persona_encuesta
    ADD CONSTRAINT persona_encuesta_id_unidad_fkey FOREIGN KEY (id_unidad) REFERENCES organizacion(id) ON DELETE CASCADE;


--
-- Name: persona_encuesta_periodo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY persona_encuesta
    ADD CONSTRAINT persona_encuesta_periodo_fkey FOREIGN KEY (periodo) REFERENCES evaluacion(id) ON DELETE CASCADE;


--
-- Name: persona_evaluador_id_eva_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY persona_evaluador
    ADD CONSTRAINT persona_evaluador_id_eva_fkey FOREIGN KEY (id_eva) REFERENCES persona(id);


--
-- Name: persona_evaluador_id_per_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY persona_evaluador
    ADD CONSTRAINT persona_evaluador_id_per_fkey FOREIGN KEY (id_per) REFERENCES persona(id) ON DELETE CASCADE;


--
-- Name: persona_supervisor_id_per_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY persona_supervisor
    ADD CONSTRAINT persona_supervisor_id_per_fkey FOREIGN KEY (id_per) REFERENCES persona(id) ON DELETE CASCADE;


--
-- Name: persona_supervisor_id_sup_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY persona_supervisor
    ADD CONSTRAINT persona_supervisor_id_sup_fkey FOREIGN KEY (id_sup) REFERENCES persona(id);


--
-- Name: pregunta_id_encuesta_ls_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY pregunta
    ADD CONSTRAINT pregunta_id_encuesta_ls_fkey FOREIGN KEY (id_encuesta_ls) REFERENCES encuesta_ls(id_encuesta_ls) ON DELETE CASCADE;


--
-- Name: pregunta_peso_id_encuesta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY pregunta_peso
    ADD CONSTRAINT pregunta_peso_id_encuesta_fkey FOREIGN KEY (id_encuesta) REFERENCES encuesta(id) ON DELETE CASCADE;


--
-- Name: pregunta_peso_id_pregunta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY pregunta_peso
    ADD CONSTRAINT pregunta_peso_id_pregunta_fkey FOREIGN KEY (id_pregunta) REFERENCES pregunta(id_pregunta) ON DELETE CASCADE;


--
-- Name: respuesta_id_pregunta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY respuesta
    ADD CONSTRAINT respuesta_id_pregunta_fkey FOREIGN KEY (id_pregunta) REFERENCES pregunta(id_pregunta) ON DELETE CASCADE;


--
-- Name: respuesta_token_ls_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY respuesta
    ADD CONSTRAINT respuesta_token_ls_fkey FOREIGN KEY (token_ls) REFERENCES persona_encuesta(token_ls) ON DELETE CASCADE;


--
-- Name: supervisor_encuesta_id_sup_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY supervisor_encuesta
    ADD CONSTRAINT supervisor_encuesta_id_sup_fkey FOREIGN KEY (id_sup) REFERENCES persona(id) ON DELETE CASCADE;


--
-- Name: supervisor_encuesta_token_ls_eva_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY supervisor_encuesta
    ADD CONSTRAINT supervisor_encuesta_token_ls_eva_fkey FOREIGN KEY (token_ls_eva) REFERENCES persona_encuesta(token_ls) ON DELETE CASCADE;


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

