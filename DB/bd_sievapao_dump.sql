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
    rol integer
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

INSERT INTO area_de_trabajo VALUES ('01', 'Mi Area de Trabajo');


--
-- Data for Name: cargo; Type: TABLE DATA; Schema: public; Owner: root
--

INSERT INTO cargo VALUES (0, 0, '', '', '', 'Sin asignar', false, '', '', NULL);
INSERT INTO cargo VALUES (1, 0, '55555', '0', '1', 'INDEFINIDO', false, '', '', NULL);
INSERT INTO cargo VALUES (2, 4, '8220', '21', '2', 'ESPECIALISTA DE INFORMACION III', false, '', '', NULL);
INSERT INTO cargo VALUES (3, 3, '8600', '19', '2', 'GESTOR DE DESECHOS', false, '', '', NULL);
INSERT INTO cargo VALUES (4, 3, '12111', '13', '2', 'ADMINISTRADOR I', false, '', '', NULL);
INSERT INTO cargo VALUES (5, 3, '12112', '15', '2', 'ADMINISTRADOR II', false, '', '', NULL);
INSERT INTO cargo VALUES (6, 3, '12113', '17', '2', 'ADMINISTRADOR III', false, '', '', NULL);
INSERT INTO cargo VALUES (7, 3, '12114', '19', '2', 'ADMINISTRADOR IV', false, '', '', NULL);
INSERT INTO cargo VALUES (8, 3, '12115', '21', '2', 'ADMINISTRADOR V', false, '', '', NULL);
INSERT INTO cargo VALUES (9, 2, '12121', '22', '2', 'ADMINISTRADOR JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (10, 1, '12122', '24', '2', 'ADMINISTRADOR JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (11, 3, '12151', '11', '2', 'ASISTENTE ADMINISTRATIVO I', false, '', '', NULL);
INSERT INTO cargo VALUES (12, 3, '12152', '13', '2', 'ASISTENTE ADMINISTRATIVO II', false, '', '', NULL);
INSERT INTO cargo VALUES (13, 3, '12153', '15', '2', 'ASISTENTE ADMINISTRATIVO III', false, '', '', NULL);
INSERT INTO cargo VALUES (14, 3, '12154', '17', '2', 'ASISTENTE ADMINISTRATIVO IV', false, '', '', NULL);
INSERT INTO cargo VALUES (15, 3, '12155', '19', '2', 'ASISTENTE ADMINISTRATIVO V', false, '', '', NULL);
INSERT INTO cargo VALUES (16, 4, '12157', '13', '2', 'ASIST. EN LOGISTICA DE ORG. EST. II', false, '', '', NULL);
INSERT INTO cargo VALUES (17, 4, '12158', '15', '2', 'ASIST. EN LOGISTICA DE ORG. EST. III', false, '', '', NULL);
INSERT INTO cargo VALUES (18, 3, '12159', '18', '2', 'ASISTENTE ADMTVO. BILINGUE', false, '', '', NULL);
INSERT INTO cargo VALUES (19, 3, '12209', '20', '2', 'JEFE TECNICO ADMINISTRATIVO I', false, '', '', NULL);
INSERT INTO cargo VALUES (20, 3, '12210', '21', '2', 'JEFE TECNICO ADMINISTRATIVO II', false, '', '', NULL);
INSERT INTO cargo VALUES (21, 3, '12211', '22', '2', 'JEFE TECNICO ADMINISTRATIVO III', false, '', '', NULL);
INSERT INTO cargo VALUES (22, 3, '12212', '23', '2', 'JEFE TECNICO ADMINISTRATIVO IV', false, '', '', NULL);
INSERT INTO cargo VALUES (23, 4, '12250', '16', '2', 'ASIST. DE ADMINISTRACION DE RECURSOS', false, '', '', NULL);
INSERT INTO cargo VALUES (24, 3, '12600', '15', '2', 'ANALISTA DE HIGIENE Y SEGURIDAD I', false, '', '', NULL);
INSERT INTO cargo VALUES (25, 3, '12601', '17', '2', 'ANALISTA DE HIGIENE Y SEGURIDAD II', false, '', '', NULL);
INSERT INTO cargo VALUES (26, 3, '12602', '19', '2', 'ANALISTA DE HIGIENE Y SEGURIDAD III', false, '', '', NULL);
INSERT INTO cargo VALUES (27, 3, '12603', '21', '2', 'ANALISTA DE HIGIENE Y SEGURIDAD IV', false, '', '', NULL);
INSERT INTO cargo VALUES (28, 2, '12610', '23', '2', 'SUPERVISOR DE HIGIENE Y SEGURIDAD', false, '', '', NULL);
INSERT INTO cargo VALUES (29, 4, '13211', '12', '2', 'ASISTENTE DE ANALISTA I', false, '', '', NULL);
INSERT INTO cargo VALUES (30, 4, '13212', '14', '2', 'ASISTENTE DE ANALISTA II', false, '', '', NULL);
INSERT INTO cargo VALUES (31, 3, '13213', '15', '2', 'ASISTENTE DE ORG. Y SIST. I', false, '', '', NULL);
INSERT INTO cargo VALUES (32, 3, '13221', '15', '2', 'ANALISTA DE ORGANIZACION Y SISTEMAS I', false, '', '', NULL);
INSERT INTO cargo VALUES (33, 3, '13222', '17', '2', 'ANALISTA DE ORGANIZACION Y SISTEMAS II', false, '', '', NULL);
INSERT INTO cargo VALUES (34, 3, '13223', '19', '2', 'ANALISTA DE ORGANIZACION Y SISTEMAS III', false, '', '', NULL);
INSERT INTO cargo VALUES (35, 3, '13224', '21', '2', 'ANALISTA DE ORGANIZACION Y SISTEMAS IV', false, '', '', NULL);
INSERT INTO cargo VALUES (36, 2, '13230', '23', '2', 'ANALISTA DE ORGANIZACION Y SISTEMAS JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (37, 2, '13244', '24', '2', 'ANALISTA CENTRAL ORGANIZAC. Y SISTEMA IV', false, '', '', NULL);
INSERT INTO cargo VALUES (38, 4, '13351', '12', '2', 'ASISTENTE DE PLANIFICACION I', false, '', '', NULL);
INSERT INTO cargo VALUES (39, 4, '13352', '14', '2', 'ASISTENTE DE PLANIFICACION II', false, '', '', NULL);
INSERT INTO cargo VALUES (40, 4, '13353', '15', '2', 'ASISTENTE DE PLANIFICACION III', false, '', '', NULL);
INSERT INTO cargo VALUES (41, 3, '13354', '16', '2', 'ASISTENTE DE PLANIFICACION DE CURSOS', false, '', '', NULL);
INSERT INTO cargo VALUES (42, 3, '13357', '16', '2', 'SUPERV. PLANIFIC.DE HORARIOS I', false, '', '', NULL);
INSERT INTO cargo VALUES (43, 3, '13358', '18', '2', 'SUPERV.DE PLANIF.DE HORARIOS II', false, '', '', NULL);
INSERT INTO cargo VALUES (44, 3, '13361', '17', '2', 'PLANIFICADOR I', false, '', '', NULL);
INSERT INTO cargo VALUES (45, 3, '13362', '19', '2', 'PLANIFICADOR II', false, '', '', NULL);
INSERT INTO cargo VALUES (46, 3, '13363', '21', '2', 'PLANIFICADOR III', false, '', '', NULL);
INSERT INTO cargo VALUES (47, 3, '13364', '22', '2', 'PLANIFICADOR IV', false, '', '', NULL);
INSERT INTO cargo VALUES (48, 2, '13365', '23', '2', 'PLANIFICADOR V', false, '', '', NULL);
INSERT INTO cargo VALUES (49, 1, '13370', '24', '2', 'PLANIFICADOR JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (50, 1, '13372', '25', '2', 'PLANIFICADOR JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (51, 1, '13373', '25', '2', 'PLANIFICADOR JEFE III', false, '', '', NULL);
INSERT INTO cargo VALUES (52, 1, '13390', '25', '2', 'PLANIFICADOR CENTRAL JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (53, 3, '13411', '15', '2', 'ANALISTA DE PRESUPUESTO I', false, '', '', NULL);
INSERT INTO cargo VALUES (54, 3, '13412', '17', '2', 'ANALISTA DE PRESUPUESTO II', false, '', '', NULL);
INSERT INTO cargo VALUES (55, 3, '13413', '19', '2', 'ANALISTA DE PRESUPUESTO III', false, '', '', NULL);
INSERT INTO cargo VALUES (56, 3, '13414', '21', '2', 'ANALISTA DE PRESUPUESTO IV', false, '', '', NULL);
INSERT INTO cargo VALUES (57, 3, '13420', '23', '2', 'ANALISTA DE PRESUPUESTO JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (58, 3, '13431', '18', '2', 'ANALISTA CENTRAL PRESUPUESTO I', false, '', '', NULL);
INSERT INTO cargo VALUES (59, 3, '13432', '20', '2', 'ANALISTA CENTRAL DE PRESUPUESTO II', false, '', '', NULL);
INSERT INTO cargo VALUES (60, 3, '13433', '22', '2', 'ANALISTA CENTRAL PRESUPUESTO III', false, '', '', NULL);
INSERT INTO cargo VALUES (61, 3, '13434', '23', '2', 'ANALISTA CENTRAL PRESUPUESTO IV', false, '', '', NULL);
INSERT INTO cargo VALUES (62, 1, '13440', '25', '2', 'ANALISTA CENTRAL PRESUPUESTO JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (63, 4, '14111', '13', '2', 'ASISTENTE DE ANALISTA FINANCIERO I', false, '', '', NULL);
INSERT INTO cargo VALUES (64, 4, '14112', '15', '2', 'ASISTENTE ANALISTA FINANCIERO II', false, '', '', NULL);
INSERT INTO cargo VALUES (65, 3, '14121', '17', '2', 'ANALISTA FINANCIERO I', false, '', '', NULL);
INSERT INTO cargo VALUES (66, 3, '14122', '19', '2', 'ANALISTA FINANCIERO II', false, '', '', NULL);
INSERT INTO cargo VALUES (67, 3, '14123', '21', '2', 'ANALISTA FINANCIERO III', false, '', '', NULL);
INSERT INTO cargo VALUES (68, 3, '14124', '22', '2', 'ANALISTA FINANCIERO IV', false, '', '', NULL);
INSERT INTO cargo VALUES (69, 2, '14125', '23', '2', 'ANALISTA FINANCIERO V', false, '', '', NULL);
INSERT INTO cargo VALUES (70, 1, '14130', '24', '2', 'ANALISTA FINANCIERO JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (71, 1, '14131', '25', '2', 'ANALISTA FINANCIERO JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (72, 4, '15415', '16', '2', 'ASISTENTE DE NOMINA III', false, '', '', NULL);
INSERT INTO cargo VALUES (73, 4, '15511', '10', '2', 'ASISTENTE DE PERSONAL I', false, '', '', NULL);
INSERT INTO cargo VALUES (74, 4, '15512', '12', '2', 'ASISTENTE DE PERSONAL II', false, '', '', NULL);
INSERT INTO cargo VALUES (75, 4, '15513', '14', '2', 'ASISTENTE DE PERSONAL III', false, '', '', NULL);
INSERT INTO cargo VALUES (76, 4, '15514', '15', '2', 'ASISTENTE DE PERSONAL IV', false, '', '', NULL);
INSERT INTO cargo VALUES (77, 4, '15515', '11', '2', 'ASISTENTE DE NOMINA I', false, '', '', NULL);
INSERT INTO cargo VALUES (78, 4, '15518', '11', '2', 'ASISTENTE DE PERSONAL EN SEGUROS I', false, '', '', NULL);
INSERT INTO cargo VALUES (79, 4, '15519', '13', '2', 'ASISTENTE DE PERSONAL EN SEGUROS II', false, '', '', NULL);
INSERT INTO cargo VALUES (80, 3, '15520', '15', '2', 'ASISTENTE DE SEGURO I', false, '', '', NULL);
INSERT INTO cargo VALUES (81, 3, '15521', '15', '2', 'ASISTENTE DE PERSONAL EN SEGURO III', false, '', '', NULL);
INSERT INTO cargo VALUES (82, 2, '15524', '21', '2', 'JEFE DE PERSONAL IV', false, '', '', NULL);
INSERT INTO cargo VALUES (83, 1, '15525', '23', '2', 'JEFE DE PERSONAL V', false, '', '', NULL);
INSERT INTO cargo VALUES (84, 1, '15526', '24', '2', 'JEFE DE PERSONAL VI', false, '', '', NULL);
INSERT INTO cargo VALUES (85, 1, '15527', '25', '2', 'JEFE DE PERSONAL VII', false, '', '', NULL);
INSERT INTO cargo VALUES (86, 3, '15611', '15', '2', 'ANALISTA DE PERSONAL I', false, '', '', NULL);
INSERT INTO cargo VALUES (87, 3, '15612', '17', '2', 'ANALISTA DE PERSONAL II', false, '', '', NULL);
INSERT INTO cargo VALUES (88, 3, '15613', '19', '2', 'ANALISTA DE PERSONAL III', false, '', '', NULL);
INSERT INTO cargo VALUES (89, 3, '15614', '21', '2', 'ANALISTA DE PERSONAL IV', false, '', '', NULL);
INSERT INTO cargo VALUES (90, 3, '15616', '15', '2', 'ANALISTA DE RECUR.HUMANOS EN NOMINA I', false, '', '', NULL);
INSERT INTO cargo VALUES (91, 3, '15617', '17', '2', 'ANALISTA DE RECUR. HUMANOS EN NOMINA II', false, '', '', NULL);
INSERT INTO cargo VALUES (92, 3, '15618', '19', '2', 'ANALISTA DE RECURS.HUMANOS EN NOMINA III', false, '', '', NULL);
INSERT INTO cargo VALUES (93, 3, '15619', '21', '2', 'ANALISTA DE RECUR.HUMANOS EN NOMINA IV', false, '', '', NULL);
INSERT INTO cargo VALUES (94, 3, '15620', '15', '2', 'ANALISTA DE NOMINA I', false, '', '', NULL);
INSERT INTO cargo VALUES (95, 3, '15621', '17', '2', 'ANALISTA DE NOMINA II', false, '', '', NULL);
INSERT INTO cargo VALUES (96, 3, '15622', '19', '2', 'ANALISTA DE NOMINA III', false, '', '', NULL);
INSERT INTO cargo VALUES (97, 3, '15623', '21', '2', 'ANALISTA DE NOMINA IV', false, '', '', NULL);
INSERT INTO cargo VALUES (98, 1, '15624', '23', '2', 'JEFE DE NOMINA I', false, '', '', NULL);
INSERT INTO cargo VALUES (99, 1, '15625', '25', '2', 'JEFE DE NOMINA II', false, '', '', NULL);
INSERT INTO cargo VALUES (100, 3, '15630', '16', '2', 'ANALISTA CENTRAL PERSONAL EN ADTMTO.', false, '', '', NULL);
INSERT INTO cargo VALUES (101, 1, '15640', '25', '2', 'ANALISTA CENTRAL DE PERSONAL JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (102, 1, '15810', '25', '2', 'JEFE CENTRAL DE RECURSOS HUMANOS', false, '', '', NULL);
INSERT INTO cargo VALUES (103, 1, '15820', '24', '2', 'JEFE SECTORIAL DE RECURSOS HUMANOS', false, '', '', NULL);
INSERT INTO cargo VALUES (104, 3, '16111', '18', '2', 'COORD. DE DESARROLLO RECURSOS HUMANOS I', false, '', '', NULL);
INSERT INTO cargo VALUES (105, 3, '16112', '20', '2', 'COORDINADOR DESARROLLO R.H.II', false, '', '', NULL);
INSERT INTO cargo VALUES (106, 3, '16114', '18', '2', 'ANALISTA DE DESARROLLO DE REC. HUM.II', false, '', '', NULL);
INSERT INTO cargo VALUES (107, 3, '16115', '19', '2', 'ANALISTA DESARROLLO RECUR. HUMAN.III', false, '', '', NULL);
INSERT INTO cargo VALUES (108, 3, '16120', '17', '2', 'ANALISTA DE PERSONAL EN ADIESTRAMIENTO I', false, '', '', NULL);
INSERT INTO cargo VALUES (109, 3, '16121', '19', '2', 'ANALISTA DE PERS. EN ADIESTRAMIENTO II', false, '', '', NULL);
INSERT INTO cargo VALUES (110, 3, '16122', '21', '2', 'ANALISTA DE PERS. EN ADIESTRAMIENTO III', false, '', '', NULL);
INSERT INTO cargo VALUES (111, 3, '16232', '23', '2', 'COORDINADOR DE ADIESTRAMIENTO', false, '', '', NULL);
INSERT INTO cargo VALUES (112, 4, '17110', '12', '2', 'PROMOTOR DE CURSOS', false, '', '', NULL);
INSERT INTO cargo VALUES (113, 3, '17122', '17', '2', 'INSTRUCTOR FORMACION COMERCIAL II', false, '', '', NULL);
INSERT INTO cargo VALUES (114, 3, '17123', '18', '2', 'INSTRUCTOR FORMACION INDUSTRIAL III', false, '', '', NULL);
INSERT INTO cargo VALUES (115, 3, '17232', '21', '2', 'COORDINADOR FORMACION EMPRESARIAL II', false, '', '', NULL);
INSERT INTO cargo VALUES (116, 3, '17413', '18', '2', 'INSTRUCTOR DE FORMACION INDUSTRIAL III', false, '', '', NULL);
INSERT INTO cargo VALUES (117, 4, '21110', '6', '2', 'AUXILIAR DE CONTABILIDAD', false, '', '', NULL);
INSERT INTO cargo VALUES (118, 4, '21111', '8', '2', 'CONTABILISTA I', false, '', '', NULL);
INSERT INTO cargo VALUES (119, 4, '21112', '11', '2', 'CONTABILISTA II', false, '', '', NULL);
INSERT INTO cargo VALUES (120, 4, '21113', '13', '2', 'CONTABILISTA JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (121, 3, '21122', '15', '2', 'CONTABILISTA JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (122, 4, '21131', '13', '2', 'CONTADOR I', false, '', '', NULL);
INSERT INTO cargo VALUES (123, 3, '21132', '15', '2', 'CONTADOR II', false, '', '', NULL);
INSERT INTO cargo VALUES (124, 3, '21133', '17', '2', 'CONTADOR III', false, '', '', NULL);
INSERT INTO cargo VALUES (125, 3, '21141', '19', '2', 'CONTADOR JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (126, 3, '21142', '21', '2', 'CONTADOR JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (127, 4, '21211', '13', '2', 'AUDITOR I', false, '', '', NULL);
INSERT INTO cargo VALUES (128, 3, '21212', '15', '2', 'AUDITOR II', false, '', '', NULL);
INSERT INTO cargo VALUES (129, 3, '21213', '17', '2', 'AUDITOR III', false, '', '', NULL);
INSERT INTO cargo VALUES (130, 3, '21214', '19', '2', 'AUDITOR IV', false, '', '', NULL);
INSERT INTO cargo VALUES (131, 3, '21221', '20', '2', 'AUDITOR JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (132, 3, '21222', '22', '2', 'AUDITOR JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (133, 2, '21223', '24', '2', 'AUDITOR JEFE III', false, '', '', NULL);
INSERT INTO cargo VALUES (134, 1, '21224', '25', '2', 'AUDITOR JEFE IV', false, '', '', NULL);
INSERT INTO cargo VALUES (135, 1, '21310', '25', '2', 'CONTRALOR INTERNO', false, '', '', NULL);
INSERT INTO cargo VALUES (136, 3, '21311', '19', '2', 'INSPECTOR DE RENTAS I', false, '', '', NULL);
INSERT INTO cargo VALUES (137, 3, '21312', '15', '2', 'AUDITOR INTEGRAL I', false, '', '', NULL);
INSERT INTO cargo VALUES (138, 3, '21313', '17', '2', 'AUDITOR INTEGRAL II', false, '', '', NULL);
INSERT INTO cargo VALUES (139, 3, '21314', '19', '2', 'AUDITOR INTEGRAL III', false, '', '', NULL);
INSERT INTO cargo VALUES (140, 3, '21315', '21', '2', 'AUDITOR INTEGRAL IV', false, '', '', NULL);
INSERT INTO cargo VALUES (141, 2, '21316', '23', '2', 'AUDITOR INTEGRAL JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (142, 1, '21317', '25', '2', 'AUDITOR INTERNO', false, '', '', NULL);
INSERT INTO cargo VALUES (143, 3, '21421', '21', '2', 'INSPECTOR ADMINISTRATIVO JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (144, 3, '21422', '22', '2', 'INSPECTOR ADMINISTRATIVO JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (145, 4, '21511', '6', '2', 'CAJERO I', false, '', '', NULL);
INSERT INTO cargo VALUES (146, 4, '21512', '8', '2', 'CAJERO II', false, '', '', NULL);
INSERT INTO cargo VALUES (147, 4, '21513', '10', '2', 'CAJERO III', false, '', '', NULL);
INSERT INTO cargo VALUES (148, 4, '21514', '12', '2', 'CAJERO IV', false, '', '', NULL);
INSERT INTO cargo VALUES (149, 4, '21521', '13', '2', 'CAJERO JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (150, 3, '21522', '15', '2', 'CAJERO JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (151, 3, '21523', '17', '2', 'CAJERO JEFE III', false, '', '', NULL);
INSERT INTO cargo VALUES (152, 3, '21524', '15', '2', 'ASISTENTE DE TESORERIA', false, '', '', NULL);
INSERT INTO cargo VALUES (153, 4, '21530', '6', '2', 'AUXILIAR DE HABILITADO', false, '', '', NULL);
INSERT INTO cargo VALUES (154, 4, '21531', '9', '2', 'ASISTENTE DE HABILITADO I', false, '', '', NULL);
INSERT INTO cargo VALUES (155, 4, '21532', '11', '2', 'ASISTENTE DE HABILITADO II', false, '', '', NULL);
INSERT INTO cargo VALUES (156, 4, '21533', '13', '2', 'ASISTENTE DE HABILITADO III', false, '', '', NULL);
INSERT INTO cargo VALUES (157, 3, '21550', '21', '2', 'HABILITADO JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (158, 4, '21560', '14', '2', 'CAJERO I', false, '', '', NULL);
INSERT INTO cargo VALUES (159, 4, '21561', '16', '2', 'CAJERO II', false, '', '', NULL);
INSERT INTO cargo VALUES (160, 3, '21570', '19', '2', 'CAJERO JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (161, 4, '21611', '11', '2', 'COBRADOR JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (162, 4, '21612', '13', '2', 'COBRADOR JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (163, 3, '21613', '15', '2', 'COBRADOR JEFE III', false, '', '', NULL);
INSERT INTO cargo VALUES (164, 4, '22110', '9', '2', 'AUXILIAR DE ARCHIVO', false, '', '', NULL);
INSERT INTO cargo VALUES (165, 4, '22121', '11', '2', 'ASISTENTE DE ARCHIVO I', false, '', '', NULL);
INSERT INTO cargo VALUES (166, 4, '22122', '13', '2', 'ASISTENTE DE ARCHIVO II', false, '', '', NULL);
INSERT INTO cargo VALUES (167, 3, '22123', '16', '2', 'ASISTENTE DE ARCHIVO III', false, '', '', NULL);
INSERT INTO cargo VALUES (168, 3, '22131', '17', '2', 'ARCHIVOLOGO I', false, '', '', NULL);
INSERT INTO cargo VALUES (169, 3, '22132', '19', '2', 'ARCHIVOLOGO II', false, '', '', NULL);
INSERT INTO cargo VALUES (170, 3, '22133', '21', '2', 'ARCHIVOLOGO III', false, '', '', NULL);
INSERT INTO cargo VALUES (171, 2, '22134', '23', '2', 'ARCHIVOLOGO IV', false, '', '', NULL);
INSERT INTO cargo VALUES (172, 1, '22135', '25', '2', 'ARCHIVOLOGO JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (173, 3, '22140', '22', '2', 'ANALISTA DE INFORMACION Y DOCUMENTACION', false, '', '', NULL);
INSERT INTO cargo VALUES (174, 3, '22141', '23', '2', 'ANALISTA DE INFORM. Y DOCUMENTACION II', false, '', '', NULL);
INSERT INTO cargo VALUES (175, 4, '22211', '2', '2', 'OFICINISTA I', false, '', '', NULL);
INSERT INTO cargo VALUES (176, 4, '22212', '6', '2', 'OFICINISTA II', false, '', '', NULL);
INSERT INTO cargo VALUES (177, 4, '22213', '8', '2', 'OFICINISTA III', false, '', '', NULL);
INSERT INTO cargo VALUES (178, 4, '22221', '10', '2', 'SUPERVISOR DE OFICINA I', false, '', '', NULL);
INSERT INTO cargo VALUES (179, 4, '22222', '12', '2', 'SUPERVISOR DE OFICINA II', false, '', '', NULL);
INSERT INTO cargo VALUES (180, 4, '22231', '2', '2', 'RECEPCIONISTA I', false, '', '', NULL);
INSERT INTO cargo VALUES (181, 4, '22232', '4', '2', 'RECEPCIONISTA II', false, '', '', NULL);
INSERT INTO cargo VALUES (182, 4, '22233', '6', '2', 'RECEPCIONISTA III', false, '', '', NULL);
INSERT INTO cargo VALUES (183, 4, '22235', '6', '2', 'RECEPCIONISTA-TELEFONISTA', false, '', '', NULL);
INSERT INTO cargo VALUES (184, 3, '22312', '17', '2', 'TRADUCTOR II', false, '', '', NULL);
INSERT INTO cargo VALUES (185, 4, '22411', '14', '2', 'SUPERVISOR DE SERVICIOS GENERALES I', false, '', '', NULL);
INSERT INTO cargo VALUES (186, 3, '22412', '16', '2', 'SUPERVISOR DE SERVICIOS GENERALES II', false, '', '', NULL);
INSERT INTO cargo VALUES (187, 3, '22413', '18', '2', 'SUPERVISOR DE SERVICIOS GENERALES III', false, '', '', NULL);
INSERT INTO cargo VALUES (188, 3, '22414', '20', '2', 'SUPERVISOR DE SERVICIOS GENERALES IV', false, '', '', NULL);
INSERT INTO cargo VALUES (189, 2, '22415', '23', '2', 'JEFE DE SERVICIOS GENERALES', false, '', '', NULL);
INSERT INTO cargo VALUES (190, 5, '23111', '2', '2', 'OPERADOR DE MAQUINA DE REPRODUCION I', false, '', '', NULL);
INSERT INTO cargo VALUES (191, 5, '23112', '5', '2', 'OPERADOR DE MAQUINA DE REPRODUCCION II', false, '', '', NULL);
INSERT INTO cargo VALUES (192, 5, '23113', '7', '2', 'OPERADOR DE MAQUINA REPROD.III', false, '', '', NULL);
INSERT INTO cargo VALUES (193, 5, '23114', '8', '2', 'OPERERADOR DE MAQUINA DE REPRODUCCION IV', false, '', '', NULL);
INSERT INTO cargo VALUES (194, 4, '23115', '10', '2', 'OPERADOR DE MAQUINA ELECTRONICA', false, '', '', NULL);
INSERT INTO cargo VALUES (195, 4, '23117', '14', '2', 'OPERADOR MAQUINA ELECTRONICA III', false, '', '', NULL);
INSERT INTO cargo VALUES (196, 4, '23121', '10', '2', 'SUPERVISOR REPRODUCCION I', false, '', '', NULL);
INSERT INTO cargo VALUES (197, 4, '23122', '12', '2', 'SUPERVISOR REPRODUCCION II', false, '', '', NULL);
INSERT INTO cargo VALUES (198, 4, '23311', '5', '2', 'TRANSCRIPTOR DE DATOS I', false, '', '', NULL);
INSERT INTO cargo VALUES (199, 4, '23312', '7', '2', 'TRANSCRIPTOR DE DATOS II', false, '', '', NULL);
INSERT INTO cargo VALUES (200, 4, '23313', '9', '2', 'TRANSCRIPTOR DE DATOS III', false, '', '', NULL);
INSERT INTO cargo VALUES (201, 4, '23314', '11', '2', 'TRANSCRIPTOR DE DATOS IV', false, '', '', NULL);
INSERT INTO cargo VALUES (202, 4, '23320', '13', '2', 'SUPERVISOR DE TRANSCRIPTOR DE DATOS', false, '', '', NULL);
INSERT INTO cargo VALUES (203, 4, '23331', '10', '2', 'OPERADOR DE EQUIPO DE COMPUTACION I', false, '', '', NULL);
INSERT INTO cargo VALUES (204, 4, '23332', '12', '2', 'OPERADOR DE EQUIPO DE COMPUTACION II', false, '', '', NULL);
INSERT INTO cargo VALUES (205, 4, '23333', '14', '2', 'OPERADOR DE EQUIPO DE COMPUTACION III', false, '', '', NULL);
INSERT INTO cargo VALUES (206, 3, '23334', '16', '2', 'OPERADOR DE EQUIPO DE COMPUTACION IV', false, '', '', NULL);
INSERT INTO cargo VALUES (207, 3, '23400', '15', '2', 'ASISTENTE DE ANALISTA DE SOPORTE TECNOLO', false, '', '', NULL);
INSERT INTO cargo VALUES (208, 4, '23410', '12', '2', 'ASISTENTE DE PROGRAMACION', false, '', '', NULL);
INSERT INTO cargo VALUES (209, 3, '23411', '17', '2', 'ANALISTA DE SOPORTE TECNOLOGICO I', false, '', '', NULL);
INSERT INTO cargo VALUES (210, 3, '23412', '19', '2', 'ANALISTA DE SOPORTE TECNOLOGICO II', false, '', '', NULL);
INSERT INTO cargo VALUES (211, 3, '23413', '20', '2', 'ANALISTA DE SOPORTE TECNOLOGICO III', false, '', '', NULL);
INSERT INTO cargo VALUES (212, 4, '23421', '14', '2', 'PROGRAMADOR I', false, '', '', NULL);
INSERT INTO cargo VALUES (213, 3, '23422', '16', '2', 'PROGRAMADOR II', false, '', '', NULL);
INSERT INTO cargo VALUES (214, 3, '23423', '18', '2', 'PROGRAMADOR III', false, '', '', NULL);
INSERT INTO cargo VALUES (215, 3, '23424', '20', '2', 'PROGRAMADOR IV', false, '', '', NULL);
INSERT INTO cargo VALUES (216, 3, '23430', '22', '2', 'SUPERVISOR DE PROGRAMACION', false, '', '', NULL);
INSERT INTO cargo VALUES (217, 3, '23433', '20', '2', 'ANALISTA DE SOPORTE TECNOLOGICO III', false, '', '', NULL);
INSERT INTO cargo VALUES (218, 3, '23440', '17', '2', 'ANALISTA PROGRAMADOR', false, '', '', NULL);
INSERT INTO cargo VALUES (219, 3, '23441', '17', '2', 'ANALISTA PROGRAMADOR I', false, '', '', NULL);
INSERT INTO cargo VALUES (220, 3, '23442', '19', '2', 'ANALISTA PROGRAMADOR II', false, '', '', NULL);
INSERT INTO cargo VALUES (221, 3, '23451', '18', '2', 'ANALISTA PROCESOS DE DATOS I', false, '', '', NULL);
INSERT INTO cargo VALUES (222, 3, '23452', '20', '2', 'ANALISTA PROCESOS DE DATOS II', false, '', '', NULL);
INSERT INTO cargo VALUES (223, 3, '23453', '22', '2', 'ANALISTA PROCESOS DE DATOS III', false, '', '', NULL);
INSERT INTO cargo VALUES (224, 3, '23457', '21', '2', 'ANALISTA DE RELACIONES INTERNACIONAL III', false, '', '', NULL);
INSERT INTO cargo VALUES (225, 3, '23461', '21', '2', 'JEFE DE INFORMATICA I', false, '', '', NULL);
INSERT INTO cargo VALUES (226, 2, '23462', '23', '2', 'JEFE DE INFORMATICA II', false, '', '', NULL);
INSERT INTO cargo VALUES (227, 1, '23463', '25', '2', 'JEFE DE INFORMATICA III', false, '', '', NULL);
INSERT INTO cargo VALUES (228, 3, '23471', '23', '2', 'ESPECIALISTA EN INFORMATICA I', false, '', '', NULL);
INSERT INTO cargo VALUES (229, 1, '23472', '25', '2', 'ESPECIALISTA EN INFORMATICA II', false, '', '', NULL);
INSERT INTO cargo VALUES (230, 3, '23481', '22', '2', 'JEFE DE SOPORTE TECNOLOGICO I', false, '', '', NULL);
INSERT INTO cargo VALUES (231, 2, '23482', '23', '2', 'JEFE DE SOPORTE TECNOLOGICO II', false, '', '', NULL);
INSERT INTO cargo VALUES (232, 4, '24111', '3', '2', 'MECANOGRAFO I', false, '', '', NULL);
INSERT INTO cargo VALUES (233, 4, '24112', '5', '2', 'MECANOGRAFO II', false, '', '', NULL);
INSERT INTO cargo VALUES (234, 4, '24113', '7', '2', 'MECANOGRAFO III', false, '', '', NULL);
INSERT INTO cargo VALUES (235, 4, '24114', '9', '2', 'MECANOGRAFO IV', false, '', '', NULL);
INSERT INTO cargo VALUES (236, 4, '24311', '12', '2', 'SECRETARIO I', false, '', '', NULL);
INSERT INTO cargo VALUES (237, 4, '24312', '14', '2', 'SECRETARIO II', false, '', '', NULL);
INSERT INTO cargo VALUES (238, 4, '24313', '16', '2', 'SECRETARIO III', false, '', '', NULL);
INSERT INTO cargo VALUES (239, 3, '24321', '16', '2', 'SECRETARIO BILINGUE I', false, '', '', NULL);
INSERT INTO cargo VALUES (240, 3, '24322', '18', '2', 'SECRETARIO BILINGUE II', false, '', '', NULL);
INSERT INTO cargo VALUES (241, 3, '24341', '18', '2', 'SECRETARIO EJECUTIVO I', false, '', '', NULL);
INSERT INTO cargo VALUES (242, 3, '24342', '20', '2', 'SECRETARIO EJECUTIVO II', false, '', '', NULL);
INSERT INTO cargo VALUES (243, 3, '24343', '22', '2', 'SECRETARIO EJECUTIVO III', false, '', '', NULL);
INSERT INTO cargo VALUES (244, 3, '24344', '23', '2', 'SECRETARIO GERENCIAL', false, '', '', NULL);
INSERT INTO cargo VALUES (245, 4, '24345', '13', '2', 'SECRETARIO ADMINISTRATIVO I', false, '', '', NULL);
INSERT INTO cargo VALUES (246, 3, '24346', '15', '2', 'SECRETARIO ADMINISTRATIVA II', false, '', '', NULL);
INSERT INTO cargo VALUES (247, 3, '24347', '17', '2', 'SECRETARIO ADMINISTRATIVO III', false, '', '', NULL);
INSERT INTO cargo VALUES (248, 1, '24633', '25', '2', 'INGENIERO MECANICO JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (249, 2, '24693', '23', '2', 'INGENIERO MECANICO JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (250, 4, '25110', '7', '2', 'REGIST. AUXI.DE B. Y MATERIAS', false, '', '', NULL);
INSERT INTO cargo VALUES (251, 4, '25111', '9', '2', 'REGIST. DE B. Y MATERIAS I', false, '', '', NULL);
INSERT INTO cargo VALUES (252, 4, '25112', '11', '2', 'REGIST. DE B. Y MATERIAS II', false, '', '', NULL);
INSERT INTO cargo VALUES (253, 4, '25121', '13', '2', 'REGIST. DE B. Y MATE. JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (254, 3, '25122', '15', '2', 'REGIST. DE B. Y MATE. JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (255, 3, '25123', '17', '2', 'REGIST. DE B. Y MATE. JEFE III', false, '', '', NULL);
INSERT INTO cargo VALUES (256, 3, '25124', '19', '2', 'REGIST.DE B. Y MATE.JEFE IV', false, '', '', NULL);
INSERT INTO cargo VALUES (257, 3, '25125', '21', '2', 'REG. BIENES MATERIALES JEFE V', false, '', '', NULL);
INSERT INTO cargo VALUES (258, 4, '25211', '5', '2', 'AUXILIAR DE ALMACEN I', false, '', '', NULL);
INSERT INTO cargo VALUES (259, 4, '25212', '8', '2', 'AUXILIAR DE ALMACEN II', false, '', '', NULL);
INSERT INTO cargo VALUES (260, 4, '25221', '10', '2', 'ALMACENISTA I', false, '', '', NULL);
INSERT INTO cargo VALUES (261, 4, '25222', '12', '2', 'ALMACENISTA II', false, '', '', NULL);
INSERT INTO cargo VALUES (262, 4, '25231', '14', '2', 'ALMACENISTA JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (263, 3, '25232', '16', '2', 'ALMACENISTA JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (264, 4, '25310', '8', '2', 'AUXILIAR DE COMPRAS', false, '', '', NULL);
INSERT INTO cargo VALUES (265, 4, '25311', '10', '2', 'COMPRADOR I', false, '', '', NULL);
INSERT INTO cargo VALUES (266, 4, '25312', '12', '2', 'COMPRADOR II', false, '', '', NULL);
INSERT INTO cargo VALUES (267, 3, '25313', '15', '2', 'COMPRADOR III', false, '', '', NULL);
INSERT INTO cargo VALUES (268, 3, '25321', '17', '2', 'COMPRADOR JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (269, 3, '25322', '19', '2', 'COMPRADOR JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (270, 3, '25323', '21', '2', 'COMPRADOR JEFE III', false, '', '', NULL);
INSERT INTO cargo VALUES (271, 3, '26000', '16', '2', 'COORD. DE SEGURIDAD Y OPERACIONES', false, '', '', NULL);
INSERT INTO cargo VALUES (272, 4, '29901', '13', '2', 'ASISTENTE DE CONTABILIDAD II', false, '', '', NULL);
INSERT INTO cargo VALUES (273, 4, '29910', '9', '2', 'AUXILIAR DE TESORERIA', false, '', '', NULL);
INSERT INTO cargo VALUES (274, 3, '31121', '17', '2', 'EDITOR DE NOTICIAS I', false, '', '', NULL);
INSERT INTO cargo VALUES (275, 4, '31210', '9', '2', 'INFORMADOR', false, '', '', NULL);
INSERT INTO cargo VALUES (276, 4, '31219', '9', '2', 'ASISTENTE DE INFORMACION I', false, '', '', NULL);
INSERT INTO cargo VALUES (277, 4, '31220', '11', '2', 'ASISTENTE DE INFORMACION II', false, '', '', NULL);
INSERT INTO cargo VALUES (278, 4, '31221', '13', '2', 'ASIST. ESPEC. INFORM. I', false, '', '', NULL);
INSERT INTO cargo VALUES (279, 3, '31222', '15', '2', 'ASIST. DE ESPEC. INFORM. II', false, '', '', NULL);
INSERT INTO cargo VALUES (280, 3, '31223', '16', '2', 'ASISTENTE ESPECIALISTA INFORMACION III', false, '', '', NULL);
INSERT INTO cargo VALUES (281, 4, '31224', '13', '2', 'ASISTENTE DE INFORMACION III', false, '', '', NULL);
INSERT INTO cargo VALUES (282, 3, '31231', '17', '2', 'ESPECIALISTA EN INFORMACION I', false, '', '', NULL);
INSERT INTO cargo VALUES (283, 3, '31232', '19', '2', 'ESPECIALISTA EN INFORMACION II', false, '', '', NULL);
INSERT INTO cargo VALUES (284, 3, '31233', '21', '2', 'ESPECIALISTA EN INFORMACION III', false, '', '', NULL);
INSERT INTO cargo VALUES (285, 3, '31234', '22', '2', 'ESPECIALISTA E INFORMACION IV', false, '', '', NULL);
INSERT INTO cargo VALUES (286, 4, '31311', '13', '2', 'ASISTENTE DE COMUNI/SOCIAL I', false, '', '', NULL);
INSERT INTO cargo VALUES (287, 3, '31312', '15', '2', 'ASISTENTE DE COMUNI/SOCIAL II', false, '', '', NULL);
INSERT INTO cargo VALUES (288, 3, '31321', '17', '2', 'COMUNICADOR SOCIAL I', false, '', '', NULL);
INSERT INTO cargo VALUES (289, 3, '31322', '19', '2', 'COMUNICADOR SOCIAL II', false, '', '', NULL);
INSERT INTO cargo VALUES (290, 3, '31323', '21', '2', 'COMUNICADOR SOCIAL III', false, '', '', NULL);
INSERT INTO cargo VALUES (291, 2, '31324', '23', '2', 'COMUNICADOR SOCIAL JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (292, 3, '31325', '23', '2', 'EDITOR', false, '', '', NULL);
INSERT INTO cargo VALUES (293, 1, '31326', '24', '2', 'COMUNICADOR SOCIAL JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (294, 1, '31327', '25', '2', 'COMUNICADOR SOCIAL JEFE III', false, '', '', NULL);
INSERT INTO cargo VALUES (295, 3, '31330', '15', '2', 'ASISTENTE RELACIONES PUBLICAS', false, '', '', NULL);
INSERT INTO cargo VALUES (296, 3, '31341', '17', '2', 'JEFE DE RELACIONES PUBLICAS I', false, '', '', NULL);
INSERT INTO cargo VALUES (297, 3, '31342', '19', '2', 'JEFE DE RELACIONES PUBLICAS II', false, '', '', NULL);
INSERT INTO cargo VALUES (298, 3, '31343', '21', '2', 'JEFE DE RELACIONES PUBLICAS III', false, '', '', NULL);
INSERT INTO cargo VALUES (299, 2, '31344', '23', '2', 'JEFE DE RELACIONES PUBLICAS IV', false, '', '', NULL);
INSERT INTO cargo VALUES (300, 1, '31370', '25', '2', 'EDITOR JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (301, 3, '31410', '15', '2', 'CORRECTOR DE ESTILO I', false, '', '', NULL);
INSERT INTO cargo VALUES (302, 3, '31411', '17', '2', 'CORRECTOR DE ESTILO II', false, '', '', NULL);
INSERT INTO cargo VALUES (303, 3, '31430', '19', '2', 'COORDINADOR DE ASUNTOS LITERARIOS', false, '', '', NULL);
INSERT INTO cargo VALUES (304, 4, '32120', '12', '2', 'REALIZADOR DE ESCENOGRAFIA', false, '', '', NULL);
INSERT INTO cargo VALUES (305, 3, '32125', '15', '2', 'JEFE DE ESCENOGRAFIA', false, '', '', NULL);
INSERT INTO cargo VALUES (306, 4, '32221', '8', '2', 'OPERADOR DE CAMARA DE T.V. I', false, '', '', NULL);
INSERT INTO cargo VALUES (307, 4, '32222', '10', '2', 'OPERADOR DE CAMARA DE T.V. II', false, '', '', NULL);
INSERT INTO cargo VALUES (308, 4, '32230', '12', '2', 'OPERADOR DE AUDIO', false, '', '', NULL);
INSERT INTO cargo VALUES (309, 4, '32231', '13', '2', 'OPERADOR DE AUDIO II', false, '', '', NULL);
INSERT INTO cargo VALUES (310, 4, '32240', '10', '2', 'OPERADOR DE VIDEO', false, '', '', NULL);
INSERT INTO cargo VALUES (311, 4, '32241', '13', '2', 'OPERADOR DE VIDEO II', false, '', '', NULL);
INSERT INTO cargo VALUES (312, 4, '32250', '13', '2', 'OPERADOR DE MASTER DE TELEVISION', false, '', '', NULL);
INSERT INTO cargo VALUES (313, 4, '32261', '6', '2', 'OPERADOR DE EQUIPO DE GRABACION I', false, '', '', NULL);
INSERT INTO cargo VALUES (314, 4, '32262', '8', '2', 'OPERADOR DE EQUIPO DE GRABACION II', false, '', '', NULL);
INSERT INTO cargo VALUES (315, 4, '32263', '10', '2', 'OPERADOR DE EQUIPO DE GRABACION III', false, '', '', NULL);
INSERT INTO cargo VALUES (316, 4, '32264', '12', '2', 'SUPERVISOR DE EQUIPOS DE GRABACION I', false, '', '', NULL);
INSERT INTO cargo VALUES (317, 4, '32265', '14', '2', 'SUPERVISOR EQUIPOS GRAB.II', false, '', '', NULL);
INSERT INTO cargo VALUES (318, 4, '32271', '6', '2', 'OPERADOR DE MAQUINA PROYECTORA I', false, '', '', NULL);
INSERT INTO cargo VALUES (319, 4, '32272', '8', '2', 'OPERADOR DE MAQUINA PROYECTORA II', false, '', '', NULL);
INSERT INTO cargo VALUES (320, 4, '32310', '13', '2', 'CAMAROGRAFO', false, '', '', NULL);
INSERT INTO cargo VALUES (321, 4, '32330', '12', '2', 'TECNICO EN SONIDO', false, '', '', NULL);
INSERT INTO cargo VALUES (322, 3, '32331', '15', '2', 'TECNICO DE SONIDO II', false, '', '', NULL);
INSERT INTO cargo VALUES (323, 3, '32421', '15', '2', 'COORD. ASUNTOS CINEMATOGRAFICO I', false, '', '', NULL);
INSERT INTO cargo VALUES (324, 4, '33121', '11', '2', 'ASISTENTE DE PROTOCOLO I', false, '', '', NULL);
INSERT INTO cargo VALUES (325, 4, '33122', '13', '2', 'ASISTENTE DE PROTOCOLO II', false, '', '', NULL);
INSERT INTO cargo VALUES (326, 4, '33211', '14', '2', 'ASISTENTE DE CEREMONIAL I', false, '', '', NULL);
INSERT INTO cargo VALUES (327, 3, '33212', '16', '2', 'ASISTENTE DE CEREMONIAL II', false, '', '', NULL);
INSERT INTO cargo VALUES (328, 3, '33313', '20', '2', 'CAPELLAN III', false, '', '', NULL);
INSERT INTO cargo VALUES (329, 3, '33314', '23', '2', 'CAPELLAN IV', false, '', '', NULL);
INSERT INTO cargo VALUES (330, 3, '34110', '15', '2', 'ANALISTA DE ASUNTOS AUDIOVISUALES', false, '', '', NULL);
INSERT INTO cargo VALUES (331, 3, '34111', '17', '2', 'ANALISTA DE ASUNTOS AUDIOVISUALES II', false, '', '', NULL);
INSERT INTO cargo VALUES (332, 3, '34120', '17', '2', 'JEFE DE CENTRO AUDIOVISUAL', false, '', '', NULL);
INSERT INTO cargo VALUES (333, 3, '34121', '19', '2', 'JEFE CENTRO AUDIOVISUAL II', false, '', '', NULL);
INSERT INTO cargo VALUES (334, 3, '34122', '22', '2', 'JEFE DE CENTRO AUDIOVISUAL III', false, '', '', NULL);
INSERT INTO cargo VALUES (335, 4, '34231', '10', '2', 'ENTRENADOR DEPORTIVO I', false, '', '', NULL);
INSERT INTO cargo VALUES (336, 4, '34232', '13', '2', 'ENTRENADOR DEPORTIVO II', false, '', '', NULL);
INSERT INTO cargo VALUES (337, 3, '34233', '15', '2', 'ENTRENADOR DEPORTIVO III', false, '', '', NULL);
INSERT INTO cargo VALUES (338, 3, '34234', '17', '2', 'ENTRENADOR DEPORTIVO IV', false, '', '', NULL);
INSERT INTO cargo VALUES (339, 3, '34235', '19', '2', 'ENTRENADOR DEPORTIVO V', false, '', '', NULL);
INSERT INTO cargo VALUES (340, 3, '34236', '21', '2', 'ENTRENADOR DEPORTIVO VI', false, '', '', NULL);
INSERT INTO cargo VALUES (341, 3, '34237', '23', '2', 'ENTRENADOR DEPORTIVO VII', false, '', '', NULL);
INSERT INTO cargo VALUES (342, 1, '34238', '25', '2', 'COORDINADOR DE DEPORTE', false, '', '', NULL);
INSERT INTO cargo VALUES (343, 3, '35112', '15', '2', 'ASISTENTE ASUNTOS LEGALES I', false, '', '', NULL);
INSERT INTO cargo VALUES (344, 3, '35113', '16', '2', 'ASISTENTE ASUNTOS LEGALES II', false, '', '', NULL);
INSERT INTO cargo VALUES (345, 3, '35121', '17', '2', 'ABOGADO I', false, '', '', NULL);
INSERT INTO cargo VALUES (346, 3, '35122', '19', '2', 'ABOGADO II', false, '', '', NULL);
INSERT INTO cargo VALUES (347, 3, '35123', '21', '2', 'ABOGADO III', false, '', '', NULL);
INSERT INTO cargo VALUES (348, 2, '35125', '23', '2', 'ABOGADO JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (349, 1, '35126', '25', '2', 'ABOGADO JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (350, 4, '36022', '9', '2', 'AUXILIAR DE ESTADISTICA II', false, '', '', NULL);
INSERT INTO cargo VALUES (351, 4, '36121', '11', '2', 'ASISTENTE DE ESTADISTICA I', false, '', '', NULL);
INSERT INTO cargo VALUES (352, 4, '36122', '13', '2', 'ASISTENTE DE ESTADISTICA II', false, '', '', NULL);
INSERT INTO cargo VALUES (353, 3, '36123', '15', '2', 'ASISTENTE DE ESTADISTICA III', false, '', '', NULL);
INSERT INTO cargo VALUES (354, 3, '36131', '17', '2', 'ESTADISTICO I', false, '', '', NULL);
INSERT INTO cargo VALUES (355, 3, '36132', '19', '2', 'ESTADISTICO II', false, '', '', NULL);
INSERT INTO cargo VALUES (356, 3, '36133', '21', '2', 'ESTADISTICO III', false, '', '', NULL);
INSERT INTO cargo VALUES (357, 3, '36141', '23', '2', 'ESTADISTICO JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (358, 2, '36142', '24', '2', 'ESTADISTICO JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (359, 3, '36221', '17', '2', 'ECONOMISTA I', false, '', '', NULL);
INSERT INTO cargo VALUES (360, 3, '36222', '19', '2', 'ECONOMISTA II', false, '', '', NULL);
INSERT INTO cargo VALUES (361, 3, '36223', '20', '2', 'ECONOMISTA III', false, '', '', NULL);
INSERT INTO cargo VALUES (362, 3, '36231', '22', '2', 'ECONOMISTA JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (363, 3, '36232', '23', '2', 'ECONOMISTA JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (364, 2, '36233', '24', '2', 'ECONOMISTA JEFE III', false, '', '', NULL);
INSERT INTO cargo VALUES (365, 1, '36234', '25', '2', 'ECONOMISTA JEFE IV', false, '', '', NULL);
INSERT INTO cargo VALUES (366, 3, '36321', '17', '2', 'PSICOLOGO I', false, '', '', NULL);
INSERT INTO cargo VALUES (367, 3, '36322', '19', '2', 'PSICOLOGO II', false, '', '', NULL);
INSERT INTO cargo VALUES (368, 3, '36323', '21', '2', 'PSICOLOGO III', false, '', '', NULL);
INSERT INTO cargo VALUES (369, 3, '36324', '22', '2', 'PSICOLOGO IV', false, '', '', NULL);
INSERT INTO cargo VALUES (370, 2, '36325', '23', '2', 'PSICOLOGO JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (371, 1, '36326', '24', '2', 'PSICOLOGO JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (372, 3, '36331', '17', '2', 'BIBLIOTECOLOGO I', false, '', '', NULL);
INSERT INTO cargo VALUES (373, 3, '36421', '17', '2', 'SOCIOLOGO I', false, '', '', NULL);
INSERT INTO cargo VALUES (374, 3, '36422', '19', '2', 'SOCIOLOGO II', false, '', '', NULL);
INSERT INTO cargo VALUES (375, 3, '36511', '17', '2', 'GEOGRAFO I', false, '', '', NULL);
INSERT INTO cargo VALUES (376, 4, '36610', '9', '2', 'AUXILIAR DE BIBLIOTECA', false, '', '', NULL);
INSERT INTO cargo VALUES (377, 4, '36621', '11', '2', 'ASISTENTE DE BIBLIOTECA I', false, '', '', NULL);
INSERT INTO cargo VALUES (378, 3, '36622', '13', '2', 'ASISTENTE DE BIBLIOTECA II', false, '', '', NULL);
INSERT INTO cargo VALUES (379, 3, '36623', '15', '2', 'ASISTENTE DE BIBLIOTECA III', false, '', '', NULL);
INSERT INTO cargo VALUES (380, 3, '36631', '17', '2', 'BIBLIOTECOLOGO I', false, '', '', NULL);
INSERT INTO cargo VALUES (381, 3, '36632', '19', '2', 'BIBLIOTECOLOGO II', false, '', '', NULL);
INSERT INTO cargo VALUES (382, 3, '36633', '21', '2', 'BIBLIOTECOLOGO III', false, '', '', NULL);
INSERT INTO cargo VALUES (383, 2, '36634', '23', '2', 'BIBLIOTECOLOGO IV', false, '', '', NULL);
INSERT INTO cargo VALUES (384, 2, '36635', '24', '2', 'BIBLIOTECOLOGO JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (385, 1, '36636', '25', '2', 'BIBLIOTECOLOGO JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (386, 3, '36811', '17', '2', 'INVESTIGADOR SOCIAL I', false, '', '', NULL);
INSERT INTO cargo VALUES (387, 3, '36820', '23', '2', 'INVESTIGADOR SOCIAL JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (388, 3, '37210', '15', '2', 'ASISTENTE DE MUSEOGRAFIA', false, '', '', NULL);
INSERT INTO cargo VALUES (389, 3, '37431', '21', '2', 'CURADOR DE OBRAS I', false, '', '', NULL);
INSERT INTO cargo VALUES (390, 3, '37432', '23', '2', 'CURADOR DE OBRAS II', false, '', '', NULL);
INSERT INTO cargo VALUES (391, 1, '37433', '25', '2', 'CURADOR DE OBRAS III', false, '', '', NULL);
INSERT INTO cargo VALUES (392, 4, '37510', '12', '2', 'ALMACENISTA DE MUSEO', false, '', '', NULL);
INSERT INTO cargo VALUES (393, 3, '37921', '17', '2', 'PROMOTOR CULTURAL', false, '', '', NULL);
INSERT INTO cargo VALUES (394, 4, '41130', '13', '2', 'PRACTICO DE VIVERO', false, '', '', NULL);
INSERT INTO cargo VALUES (395, 3, '41210', '17', '2', 'INVESTIGADOR EN ADIESTRAMIENTO', false, '', '', NULL);
INSERT INTO cargo VALUES (396, 3, '41211', '19', '2', 'INVESTIGADOR I', false, '', '', NULL);
INSERT INTO cargo VALUES (397, 3, '41212', '20', '2', 'INVESTIGADOR II', false, '', '', NULL);
INSERT INTO cargo VALUES (398, 3, '41213', '21', '2', 'INVESTIGADOR III', false, '', '', NULL);
INSERT INTO cargo VALUES (399, 3, '41214', '23', '2', 'INVESTIGADOR IV', false, '', '', NULL);
INSERT INTO cargo VALUES (400, 2, '41215', '24', '2', 'INVESTIGADOR V', false, '', '', NULL);
INSERT INTO cargo VALUES (401, 1, '41520', '25', '2', 'ZOOTECNISTA JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (402, 4, '41612', '6', '2', 'AUXILIAR DE BOTANICA II', false, '', '', NULL);
INSERT INTO cargo VALUES (403, 4, '42450', '13', '2', 'TAXIDERMISTA', false, '', '', NULL);
INSERT INTO cargo VALUES (404, 4, '42460', '9', '2', 'CRIADOR DE ANIMALES', false, '', '', NULL);
INSERT INTO cargo VALUES (405, 4, '42511', '12', '2', 'ASISTENTE DE BIOLOGIA I', false, '', '', NULL);
INSERT INTO cargo VALUES (406, 3, '42512', '15', '2', 'ASISTENTE DE BIOLOGIA II', false, '', '', NULL);
INSERT INTO cargo VALUES (407, 3, '42522', '19', '2', 'BIOLOGO II', false, '', '', NULL);
INSERT INTO cargo VALUES (408, 3, '42612', '19', '2', 'BIOLOGO II', false, '', '', NULL);
INSERT INTO cargo VALUES (409, 3, '43150', '21', '2', 'TOPOGRAFO CARTOGRAFICO JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (410, 4, '43411', '13', '2', 'ASISTENTE DE INGENIERIA I', false, '', '', NULL);
INSERT INTO cargo VALUES (411, 4, '43412', '14', '2', 'ASISTENTE DE INGENIERIA II', false, '', '', NULL);
INSERT INTO cargo VALUES (412, 3, '43413', '16', '2', 'ASISTENTE DE INGENIERIA III', false, '', '', NULL);
INSERT INTO cargo VALUES (413, 3, '43414', '17', '2', 'ASISTENTE DE INGENIERIA IV', false, '', '', NULL);
INSERT INTO cargo VALUES (414, 3, '43421', '18', '2', 'INGENIERO CIVIL I', false, '', '', NULL);
INSERT INTO cargo VALUES (415, 3, '43422', '19', '2', 'INGENIERO CIVIL II', false, '', '', NULL);
INSERT INTO cargo VALUES (416, 3, '43423', '21', '2', 'INGENIERO CIVIL III', false, '', '', NULL);
INSERT INTO cargo VALUES (417, 3, '43431', '22', '2', 'INGENIERO CIVIL JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (418, 1, '43432', '24', '2', 'INGENIERO CIVIL JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (419, 1, '43433', '25', '2', 'INGENIERO CIVIL JEFE III', false, '', '', NULL);
INSERT INTO cargo VALUES (420, 4, '43461', '13', '2', 'INSPECTOR DE O.ING. CIVIL I', false, '', '', NULL);
INSERT INTO cargo VALUES (421, 4, '43462', '14', '2', 'INSPECTOR DE O.ING. CIVIL II', false, '', '', NULL);
INSERT INTO cargo VALUES (422, 3, '43463', '15', '2', 'INSPECTOR DE O.ING. CIVIL III', false, '', '', NULL);
INSERT INTO cargo VALUES (423, 3, '43464', '16', '2', 'INSP. DE OBRAS DE ING.CIVIL IV', false, '', '', NULL);
INSERT INTO cargo VALUES (424, 3, '43531', '18', '2', 'ARQUITECTO I', false, '', '', NULL);
INSERT INTO cargo VALUES (425, 3, '43532', '19', '2', 'ARQUITECTO II', false, '', '', NULL);
INSERT INTO cargo VALUES (426, 3, '43533', '21', '2', 'ARQUITECTO III', false, '', '', NULL);
INSERT INTO cargo VALUES (427, 1, '43539', '24', '2', 'ARQUITECTO JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (428, 3, '43541', '22', '2', 'ARQUITECTO JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (429, 2, '43542', '24', '2', 'ARQUITECTO JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (430, 1, '43543', '25', '2', 'ARQUITECTO JEFE III', false, '', '', NULL);
INSERT INTO cargo VALUES (431, 4, '43711', '4', '2', 'AUXILIAR DE DIBUJO I', false, '', '', NULL);
INSERT INTO cargo VALUES (432, 4, '43712', '6', '2', 'AUXILIAR DE DIBUJO II', false, '', '', NULL);
INSERT INTO cargo VALUES (433, 4, '43718', '10', '2', 'DIBUJANTE ARTISTICO', false, '', '', NULL);
INSERT INTO cargo VALUES (434, 4, '43721', '9', '2', 'DIBUJANTE I', false, '', '', NULL);
INSERT INTO cargo VALUES (435, 4, '43722', '12', '2', 'DIBUJANTE II', false, '', '', NULL);
INSERT INTO cargo VALUES (436, 4, '43723', '13', '2', 'DIBUJANTE III', false, '', '', NULL);
INSERT INTO cargo VALUES (437, 3, '43724', '15', '2', 'DIBUJANTE IV', false, '', '', NULL);
INSERT INTO cargo VALUES (438, 3, '43731', '16', '2', 'DIBUJANTE JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (439, 3, '43732', '17', '2', 'DIBUJANTE JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (440, 4, '43770', '13', '2', 'DIAGRAMADOR', false, '', '', NULL);
INSERT INTO cargo VALUES (441, 3, '43771', '15', '2', 'DIAGRAMADOR II', false, '', '', NULL);
INSERT INTO cargo VALUES (442, 3, '43775', '15', '2', 'DISEÃADOR GRAFICO', false, '', '', NULL);
INSERT INTO cargo VALUES (443, 3, '43776', '17', '2', 'DISEÃADOR GRAFICO II', false, '', '', NULL);
INSERT INTO cargo VALUES (444, 3, '43777', '19', '2', 'DISEÃADOR GRAFICO III', false, '', '', NULL);
INSERT INTO cargo VALUES (445, 3, '43781', '15', '2', 'DIBUJANTE ILUSTRADOR I', false, '', '', NULL);
INSERT INTO cargo VALUES (446, 3, '43782', '17', '2', 'DIBUJANTE ILUSTRADOR II', false, '', '', NULL);
INSERT INTO cargo VALUES (447, 3, '43783', '19', '2', 'DIBUJANTE ILUSTRADOR III', false, '', '', NULL);
INSERT INTO cargo VALUES (448, 3, '43790', '21', '2', 'DIBUJANTE ILUSTRADOR JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (449, 3, '43800', '15', '2', 'ANIMADOR GRAFICO I', false, '', '', NULL);
INSERT INTO cargo VALUES (450, 3, '43801', '16', '2', 'ANIMADOR GRAFICO II', false, '', '', NULL);
INSERT INTO cargo VALUES (451, 3, '43802', '18', '2', 'ANIMADOR GRAFICO III', false, '', '', NULL);
INSERT INTO cargo VALUES (452, 3, '43803', '20', '2', 'ANIMADOR GRAFICO JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (453, 3, '43804', '22', '2', 'ANIMADOR GRAFICO JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (454, 3, '43811', '18', '2', 'URBANISTA I', false, '', '', NULL);
INSERT INTO cargo VALUES (455, 3, '43812', '19', '2', 'URBANISTA II', false, '', '', NULL);
INSERT INTO cargo VALUES (456, 3, '43820', '23', '2', 'URBANISTA JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (457, 3, '44713', '15', '2', 'TECNICO QUIMICO III', false, '', '', NULL);
INSERT INTO cargo VALUES (458, 3, '44721', '17', '2', 'QUIMICO I', false, '', '', NULL);
INSERT INTO cargo VALUES (459, 3, '44722', '19', '2', 'QUIMICO II', false, '', '', NULL);
INSERT INTO cargo VALUES (460, 3, '44723', '21', '2', 'QUIMICO III', false, '', '', NULL);
INSERT INTO cargo VALUES (461, 3, '44731', '22', '2', 'QUIMICO JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (462, 2, '44732', '23', '2', 'QUIMICO JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (463, 4, '45000', '12', '2', 'FOTOLITOGRAFO', false, '', '', NULL);
INSERT INTO cargo VALUES (464, 4, '45111', '3', '2', 'AUXILIAR DE LABORATORIO I', false, '', '', NULL);
INSERT INTO cargo VALUES (465, 4, '45112', '5', '2', 'AUXILIAR DE LABORATORIO II', false, '', '', NULL);
INSERT INTO cargo VALUES (466, 4, '45121', '10', '2', 'LABORATORISTA I', false, '', '', NULL);
INSERT INTO cargo VALUES (467, 4, '45122', '13', '2', 'LABORATORISTA II', false, '', '', NULL);
INSERT INTO cargo VALUES (468, 4, '45123', '14', '2', 'LABORATORISTA III', false, '', '', NULL);
INSERT INTO cargo VALUES (469, 4, '45124', '15', '2', 'LABORATORISTA IV', false, '', '', NULL);
INSERT INTO cargo VALUES (470, 4, '45131', '13', '2', 'ASIST. DE INV. Y DOC. I', false, '', '', NULL);
INSERT INTO cargo VALUES (471, 3, '45132', '16', '2', 'ASISTENTE DE LAB. DE INV. Y DOC II', false, '', '', NULL);
INSERT INTO cargo VALUES (472, 3, '45133', '18', '2', 'ASISTENTE DE LAB DE INV Y DOC III', false, '', '', NULL);
INSERT INTO cargo VALUES (473, 4, '45240', '4', '2', 'AUXILIAR DE FOTOGRAFIA', false, '', '', NULL);
INSERT INTO cargo VALUES (474, 4, '45251', '8', '2', 'FOTOGRAFO I', false, '', '', NULL);
INSERT INTO cargo VALUES (475, 4, '45252', '12', '2', 'FOTOGRAFO II', false, '', '', NULL);
INSERT INTO cargo VALUES (476, 3, '45253', '15', '2', 'FOTOGRAFO III', false, '', '', NULL);
INSERT INTO cargo VALUES (477, 3, '45260', '16', '2', 'FOTOGRAFO JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (478, 3, '45261', '18', '2', 'FOTOGRAFO JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (479, 3, '45262', '20', '2', 'FOTOGRAFO JEFE III', false, '', '', NULL);
INSERT INTO cargo VALUES (480, 4, '45271', '9', '2', 'LABORATORISTA FOTOGRAFICO I', false, '', '', NULL);
INSERT INTO cargo VALUES (481, 4, '45272', '11', '2', 'LABORATORISTA FOTOGRAFICO II', false, '', '', NULL);
INSERT INTO cargo VALUES (482, 4, '45341', '13', '2', 'MICROFILMADOR I', false, '', '', NULL);
INSERT INTO cargo VALUES (483, 3, '45361', '15', '2', 'FOTOGRAFO LABORATORISTA DE INV. I', false, '', '', NULL);
INSERT INTO cargo VALUES (484, 3, '45362', '17', '2', 'FOTOGRAFO LABORATORISTA DE INV. II', false, '', '', NULL);
INSERT INTO cargo VALUES (485, 3, '45363', '19', '2', 'FOTOGRAFO LABORATORISTA DE INV. III', false, '', '', NULL);
INSERT INTO cargo VALUES (486, 3, '45370', '21', '2', 'FOTOGRAFO LAB. DE INV. JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (487, 3, '45421', '21', '2', 'SOPLADOR DE VIDRIO', false, '', '', NULL);
INSERT INTO cargo VALUES (488, 3, '45611', '17', '2', 'BIOLOGO I', false, '', '', NULL);
INSERT INTO cargo VALUES (489, 3, '46000', '15', '2', 'TECNICO EN COMPUTACION', false, '', '', NULL);
INSERT INTO cargo VALUES (490, 3, '46001', '16', '2', 'TECNICO COMPUTACION II', false, '', '', NULL);
INSERT INTO cargo VALUES (491, 3, '46002', '15', '2', 'TECNICO EN INFORMATICA I', false, '', '', NULL);
INSERT INTO cargo VALUES (492, 4, '46111', '11', '2', 'TECNICO MECANICO  I', false, '', '', NULL);
INSERT INTO cargo VALUES (493, 4, '46112', '13', '2', 'TECNICO MECANICO II', false, '', '', NULL);
INSERT INTO cargo VALUES (494, 4, '46113', '14', '2', 'TECNICO MECANICO III', false, '', '', NULL);
INSERT INTO cargo VALUES (495, 3, '46114', '15', '2', 'TECNICO MECANICO IV', false, '', '', NULL);
INSERT INTO cargo VALUES (496, 3, '46115', '17', '2', 'TECNICO MECANICO V', false, '', '', NULL);
INSERT INTO cargo VALUES (497, 4, '46121', '11', '2', 'TECNICO ELECTRICISTA I', false, '', '', NULL);
INSERT INTO cargo VALUES (498, 4, '46122', '13', '2', 'TECNICO ELECTRICISTA II', false, '', '', NULL);
INSERT INTO cargo VALUES (499, 4, '46123', '14', '2', 'TECNICO ELECTRICISTA III', false, '', '', NULL);
INSERT INTO cargo VALUES (500, 3, '46124', '15', '2', 'TECNICO ELECTRICISTA IV', false, '', '', NULL);
INSERT INTO cargo VALUES (501, 4, '46133', '14', '2', 'TECNICO ELECTRONICO III', false, '', '', NULL);
INSERT INTO cargo VALUES (502, 4, '46211', '11', '2', 'TECNICO ELECTRONICO I', false, '', '', NULL);
INSERT INTO cargo VALUES (503, 4, '46212', '13', '2', 'TECNICO ELECTRONICO II', false, '', '', NULL);
INSERT INTO cargo VALUES (504, 4, '46213', '14', '2', 'TECNICO ELECTRONICO III', false, '', '', NULL);
INSERT INTO cargo VALUES (505, 3, '46214', '15', '2', 'TECNICO ELECTRONICO IV', false, '', '', NULL);
INSERT INTO cargo VALUES (506, 3, '46215', '17', '2', 'TECNICO ELECTRONICO V', false, '', '', NULL);
INSERT INTO cargo VALUES (507, 3, '46216', '19', '2', 'TECNICO ELECTRONICO VI', false, '', '', NULL);
INSERT INTO cargo VALUES (508, 3, '46217', '21', '2', 'TECNICO ELECTRONICO JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (509, 3, '46231', '15', '2', 'TECNICO DE MTTO. EQUIPOS ELECTRONICOS I', false, '', '', NULL);
INSERT INTO cargo VALUES (510, 3, '46232', '17', '2', 'TECNICO DE MTTO. EQUIPOS ELECTRONICOS II', false, '', '', NULL);
INSERT INTO cargo VALUES (511, 3, '46233', '19', '2', 'TECNICO DE MTTO. EQUIPOS ELECTRONICO III', false, '', '', NULL);
INSERT INTO cargo VALUES (512, 3, '46262', '20', '2', 'FOTOGRAFO JEFE III', false, '', '', NULL);
INSERT INTO cargo VALUES (513, 3, '46311', '18', '2', 'INGENIERO MECANICO I', false, '', '', NULL);
INSERT INTO cargo VALUES (514, 3, '46312', '19', '2', 'INGENIERO MECANICO II', false, '', '', NULL);
INSERT INTO cargo VALUES (515, 3, '46313', '21', '2', 'INGENIERO MECANICO III', false, '', '', NULL);
INSERT INTO cargo VALUES (516, 3, '46320', '22', '2', 'INGENIERO MECANICO JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (517, 3, '46511', '18', '2', 'INGENIERO ELECTRICISTA I', false, '', '', NULL);
INSERT INTO cargo VALUES (518, 3, '46512', '19', '2', 'INGENIERO ELECTRICISTA II', false, '', '', NULL);
INSERT INTO cargo VALUES (519, 3, '46513', '21', '2', 'INGENIERO ELECTRICISTA III', false, '', '', NULL);
INSERT INTO cargo VALUES (520, 3, '46520', '22', '2', 'INGENIERO ELECTRICISTA JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (521, 3, '46524', '21', '2', 'INGENIERO ELECTRONICO III', false, '', '', NULL);
INSERT INTO cargo VALUES (522, 3, '46530', '22', '2', 'INGENIERO ELECTRONICO JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (523, 2, '46531', '23', '2', 'INGENIERO ELECTRONICO JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (524, 1, '46532', '25', '2', 'INGENIERO ELECTRONICO JEFE III', false, '', '', NULL);
INSERT INTO cargo VALUES (525, 3, '46612', '19', '2', 'INGENIERO INDUSTRIAL II', false, '', '', NULL);
INSERT INTO cargo VALUES (526, 3, '46613', '21', '2', 'INGENIERO INDUSTRIAL III', false, '', '', NULL);
INSERT INTO cargo VALUES (527, 3, '46614', '22', '2', 'INGENIERO INDUSTRIAL JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (528, 3, '46615', '23', '2', 'INGENIERO INDUSTRIAL JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (529, 1, '46616', '24', '2', 'INGENIERO INDUSTRIAL JEFE III', false, '', '', NULL);
INSERT INTO cargo VALUES (530, 1, '46617', '25', '2', 'INGENIERO INDUSTRIAL JEFE IV', false, '', '', NULL);
INSERT INTO cargo VALUES (531, 2, '46708', '24', '2', 'INGENIERO INDUSTRIAL JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (532, 4, '51411', '7', '2', 'OPER DE TELECOMUNICACIONES I', false, '', '', NULL);
INSERT INTO cargo VALUES (533, 4, '51412', '9', '2', 'OPERADOR DE TELECOMUNICACIONES I', false, '', '', NULL);
INSERT INTO cargo VALUES (534, 4, '51413', '11', '2', 'OPERADOR DE TELECOMUNICACIONES III', false, '', '', NULL);
INSERT INTO cargo VALUES (535, 4, '51414', '13', '2', 'OPERERADOR DE TELECOMUNICACIONES IV', false, '', '', NULL);
INSERT INTO cargo VALUES (536, 4, '51481', '4', '2', 'TELEFONISTA I', false, '', '', NULL);
INSERT INTO cargo VALUES (537, 4, '51482', '6', '2', 'TELEFONISTA II', false, '', '', NULL);
INSERT INTO cargo VALUES (538, 4, '51483', '8', '2', 'TELEFONISTA III', false, '', '', NULL);
INSERT INTO cargo VALUES (539, 4, '51485', '10', '2', 'TELEFONISTA JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (540, 3, '51514', '15', '2', 'TECNICO EN TELECOMUNICACIONES', false, '', '', NULL);
INSERT INTO cargo VALUES (541, 4, '52110', '8', '2', 'DESPACHADOR DE VEHICULO', false, '', '', NULL);
INSERT INTO cargo VALUES (542, 4, '52141', '10', '2', 'JEFE DE TRANSP. AUTOMOTOR I', false, '', '', NULL);
INSERT INTO cargo VALUES (543, 4, '52142', '12', '2', 'JEFE DE TRANSP. AUTOMOTOR II', false, '', '', NULL);
INSERT INTO cargo VALUES (544, 4, '52143', '14', '2', 'JEFE DE TRANSP. AUTOMOTOR III', false, '', '', NULL);
INSERT INTO cargo VALUES (545, 3, '52144', '17', '2', 'JEFE DE TRANSP. AUTOMOTOR IV', false, '', '', NULL);
INSERT INTO cargo VALUES (546, 4, '61140', '12', '2', 'SUPERVISOR DE CARPINTEROS', false, '', '', NULL);
INSERT INTO cargo VALUES (547, 4, '61141', '14', '2', 'SUPERVISOR DE CARPINTERIA II', false, '', '', NULL);
INSERT INTO cargo VALUES (548, 3, '61142', '16', '2', 'SUPERVISOR DE CARPINTERIA III', false, '', '', NULL);
INSERT INTO cargo VALUES (549, 4, '62121', '10', '2', 'SUPERVISOR DE MANTENIMIENTOS DE EDF.I', false, '', '', NULL);
INSERT INTO cargo VALUES (550, 4, '62122', '12', '2', 'SUPERVISOR DE MANTENIMIENTOS DE EDIF.II', false, '', '', NULL);
INSERT INTO cargo VALUES (551, 4, '62123', '14', '2', 'SUPERVISOR DE MANTENIMIENTO DE EDIF.III', false, '', '', NULL);
INSERT INTO cargo VALUES (552, 3, '62124', '16', '2', 'SUPERVISOR DE MANTENIMIENTO DE EDIF.IV', false, '', '', NULL);
INSERT INTO cargo VALUES (553, 3, '62125', '18', '2', 'SUPERVISOR DE MANTENIMIENTO EDIFICIOS V', false, '', '', NULL);
INSERT INTO cargo VALUES (554, 3, '62126', '20', '2', 'SUPERVISOR DE MANTENIMIENTO EDIFICIO VI', false, '', '', NULL);
INSERT INTO cargo VALUES (555, 4, '63121', '12', '2', 'SUPERV. DE TALLER DE IMP. I', false, '', '', NULL);
INSERT INTO cargo VALUES (556, 4, '63122', '14', '2', 'SUPERV.DE TALLER DE IMP. II', false, '', '', NULL);
INSERT INTO cargo VALUES (557, 3, '63123', '16', '2', 'SUPERV. DE TALLER DE IMP. III', false, '', '', NULL);
INSERT INTO cargo VALUES (558, 3, '63124', '18', '2', 'SUPERV. DE TALLER IMPRENTA IV', false, '', '', NULL);
INSERT INTO cargo VALUES (559, 3, '66142', '16', '2', 'SUPERVISOR DE CARPINTERIA III', false, '', '', NULL);
INSERT INTO cargo VALUES (560, 2, '71130', '24', '2', 'DITISTA JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (561, 4, '71331', '13', '2', 'ENFERMERA I', false, '', '', NULL);
INSERT INTO cargo VALUES (562, 4, '71332', '14', '2', 'ENFERMERA II', false, '', '', NULL);
INSERT INTO cargo VALUES (563, 3, '71333', '15', '2', 'ENFERMERA III', false, '', '', NULL);
INSERT INTO cargo VALUES (564, 3, '71340', '17', '2', 'ENFERMERA JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (565, 3, '71341', '16', '2', 'ENFERMERA JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (566, 3, '71342', '18', '2', 'ENFERMERA JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (567, 3, '71343', '19', '2', 'ENFERMERA JEFE III', false, '', '', NULL);
INSERT INTO cargo VALUES (568, 3, '71344', '21', '2', 'ENFERMERA JEFE IV', false, '', '', NULL);
INSERT INTO cargo VALUES (569, 3, '73211', '17', '2', 'ODONTOLOGO I', false, '', '', NULL);
INSERT INTO cargo VALUES (570, 3, '73212', '19', '2', 'ODONTOLOGO II', false, '', '', NULL);
INSERT INTO cargo VALUES (571, 3, '73213', '21', '2', 'ODONTOLOGO III', false, '', '', NULL);
INSERT INTO cargo VALUES (572, 3, '75131', '18', '2', 'MEDICO I', false, '', '', NULL);
INSERT INTO cargo VALUES (573, 3, '75141', '21', '2', 'MEDICO JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (574, 3, '75142', '22', '2', 'MEDICO JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (575, 3, '75143', '23', '2', 'MEDICO JEFE III', false, '', '', NULL);
INSERT INTO cargo VALUES (576, 2, '75144', '24', '2', 'MEDICO JEFE IV', false, '', '', NULL);
INSERT INTO cargo VALUES (577, 3, '75311', '19', '2', 'MEDICO ESPECIALISTA I', false, '', '', NULL);
INSERT INTO cargo VALUES (578, 3, '75312', '21', '2', 'MEDICO ESPECIALISTA II', false, '', '', NULL);
INSERT INTO cargo VALUES (579, 3, '76307', '17', '2', 'TECNICO DE ZONA SANEAMIENTO AMBIENTAL II', false, '', '', NULL);
INSERT INTO cargo VALUES (580, 3, '76310', '23', '2', 'JEFE DE ZONA DE SANEAMIENTO AMBIENTAL', false, '', '', NULL);
INSERT INTO cargo VALUES (581, 3, '77121', '17', '2', 'DIETISTA I', false, '', '', NULL);
INSERT INTO cargo VALUES (582, 3, '77122', '19', '2', 'DIETISTA II', false, '', '', NULL);
INSERT INTO cargo VALUES (583, 3, '77123', '21', '2', 'DIETISTA III', false, '', '', NULL);
INSERT INTO cargo VALUES (584, 3, '77124', '23', '2', 'DIETISTA IV', false, '', '', NULL);
INSERT INTO cargo VALUES (585, 2, '77130', '24', '2', 'DIETISTA JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (586, 1, '77131', '25', '2', 'DIETISTA JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (587, 3, '78200', '13', '2', 'ASISTENTE DE VETERINARIA I', false, '', '', NULL);
INSERT INTO cargo VALUES (588, 3, '78201', '15', '2', 'ASISTENTE DE VETERINARIA II', false, '', '', NULL);
INSERT INTO cargo VALUES (589, 3, '78202', '17', '2', 'ASISTENTE DE VETERINARIA III', false, '', '', NULL);
INSERT INTO cargo VALUES (590, 3, '78203', '19', '2', 'ASISTENTE DE VETERINARIO IV', false, '', '', NULL);
INSERT INTO cargo VALUES (591, 4, '79341', '13', '2', 'TECNICO TRABAJADOR SOCIAL I', false, '', '', NULL);
INSERT INTO cargo VALUES (592, 3, '79342', '15', '2', 'TECNICO TRABAJADOR SOCIAL II', false, '', '', NULL);
INSERT INTO cargo VALUES (593, 3, '79343', '16', '2', 'TECNICO TRABAJADOR SOCIAL III', false, '', '', NULL);
INSERT INTO cargo VALUES (594, 3, '79351', '17', '2', 'TRABAJADOR SOCIAL I', false, '', '', NULL);
INSERT INTO cargo VALUES (595, 3, '79352', '19', '2', 'TRABAJADOR SOCIAL II', false, '', '', NULL);
INSERT INTO cargo VALUES (596, 3, '79353', '21', '2', 'TRABAJADOR SOCIAL III', false, '', '', NULL);
INSERT INTO cargo VALUES (597, 3, '79354', '22', '2', 'TRABAJADOR SOCIAL IV', false, '', '', NULL);
INSERT INTO cargo VALUES (598, 2, '79355', '23', '2', 'TRABAJADOR SOCIAL JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (599, 4, '85011', '12', '2', 'INSPECTOR DE CONTROL DE PERDIDAS', false, '', '', NULL);
INSERT INTO cargo VALUES (600, 4, '85012', '13', '2', 'INSPECTOR DE CONTROL DE PERDIDAS II', false, '', '', NULL);
INSERT INTO cargo VALUES (601, 4, '85113', '13', '2', 'SUPERV. DE PROTECCION Y SEGURIDAD CCD I', false, '', '', NULL);
INSERT INTO cargo VALUES (602, 3, '85114', '15', '2', 'SUPERV. DE PROTECCION Y SEGURIDAD CDD II', false, '', '', NULL);
INSERT INTO cargo VALUES (603, 3, '85115', '17', '2', 'INSPECTOR DE PROTECCION Y SEGURIDAD CIUD', false, '', '', NULL);
INSERT INTO cargo VALUES (604, 3, '85116', '19', '2', 'INSPECTOR DE PROTEC. Y SEG. CIUDADANA', false, '', '', NULL);
INSERT INTO cargo VALUES (605, 3, '85117', '21', '2', 'JEFE PLANES OPERATIVOS EN SEGURIDAD CDNA', false, '', '', NULL);
INSERT INTO cargo VALUES (606, 2, '85118', '23', '2', 'JEFE PLANES OPERAT. SEG. CIUDADANA II', false, '', '', NULL);
INSERT INTO cargo VALUES (607, 1, '85119', '25', '2', 'JEFE PLANES OPER. SEG. CIUDADANA III', false, '', '', NULL);
INSERT INTO cargo VALUES (608, 3, '85120', '15', '2', 'INSPECTOR DE PROT. Y SEG. CIUDADANA I', false, '', '', NULL);
INSERT INTO cargo VALUES (609, 3, '85123', '15', '2', 'INSPECTOR DE SEGURIDAD INDUSTRIAL III', false, '', '', NULL);
INSERT INTO cargo VALUES (610, 3, '86000', '19', '2', 'GESTOR DE DESECHOS', false, '', '', NULL);
INSERT INTO cargo VALUES (611, 3, '88000', '15', '2', 'COORDINADOR ASUNTO CINEMATOGRAFICOS I', false, '', '', NULL);
INSERT INTO cargo VALUES (612, 3, '88002', '24', '2', 'ASISTENTE ASESORIA JURIDICA', false, '', '', NULL);
INSERT INTO cargo VALUES (613, 4, '88888', '1', '2', 'AYUDANTE ADMINISTRATIVO', false, '', '', NULL);
INSERT INTO cargo VALUES (614, 3, '90500', '19', '2', 'ANALISTA DE CONTROL ACADEMICO', false, '', '', NULL);
INSERT INTO cargo VALUES (615, 3, '90800', '20', '2', 'ASISTENTE DE CAMPO', false, '', '', NULL);
INSERT INTO cargo VALUES (616, 4, '91100', '10', '2', 'ASISTENTE PLANIFICACION HORARIOS I', false, '', '', NULL);
INSERT INTO cargo VALUES (617, 4, '91101', '12', '2', 'ASISTENTE PLANIFICACION HORARIOS II', false, '', '', NULL);
INSERT INTO cargo VALUES (618, 4, '91102', '14', '2', 'ASISTENTE PLANIFICACION HORARIOS III', false, '', '', NULL);
INSERT INTO cargo VALUES (619, 3, '91103', '16', '2', 'SUPERVISOR PLANIFICADOR HORARIOS', false, '', '', NULL);
INSERT INTO cargo VALUES (620, 4, '91203', '14', '2', 'ASISTENTE DE CONTROL DE ESTUDIO III', false, '', '', NULL);
INSERT INTO cargo VALUES (621, 3, '91205', '16', '2', 'SUPERVISOR DE CONTROL DE ESTUDIOS I', false, '', '', NULL);
INSERT INTO cargo VALUES (622, 3, '91206', '18', '2', 'SUPERVISOR DE CONTROL DE ESTUDIOS II', false, '', '', NULL);
INSERT INTO cargo VALUES (623, 3, '91340', '21', '2', 'ASESOR ANALISIS PRESUPUESTO', false, '', '', NULL);
INSERT INTO cargo VALUES (624, 3, '91621', '21', '2', 'COORDINADOR DE FORMACION Y MEJORA', false, '', '', NULL);
INSERT INTO cargo VALUES (625, 4, '91711', '13', '2', 'ASISTENTE DE FORMACION EMPRES.', false, '', '', NULL);
INSERT INTO cargo VALUES (626, 3, '91800', '23', '2', 'COORDINADOR ENTRENAMIENTO', false, '', '', NULL);
INSERT INTO cargo VALUES (627, 3, '92200', '23', '2', 'COORDINADOR TECNICO DE CALIDAD', false, '', '', NULL);
INSERT INTO cargo VALUES (628, 3, '92311', '19', '2', 'SUPERVISOR CONTROL DE CALIDAD SIS', false, '', '', NULL);
INSERT INTO cargo VALUES (629, 3, '92330', '19', '2', 'INGENIERO DE SISTEMA II', false, '', '', NULL);
INSERT INTO cargo VALUES (630, 3, '92331', '21', '2', 'INGENIERO DE SISTEMA III', false, '', '', NULL);
INSERT INTO cargo VALUES (631, 3, '92361', '18', '2', 'INGENIERO DE COMPUTACION I', false, '', '', NULL);
INSERT INTO cargo VALUES (632, 3, '92362', '19', '2', 'INGENIERO DE COMPUTACION II', false, '', '', NULL);
INSERT INTO cargo VALUES (633, 4, '92511', '12', '2', 'ASISTENTE DE VENTA', false, '', '', NULL);
INSERT INTO cargo VALUES (634, 4, '92531', '11', '2', 'ASISTENTE DE COMPRAS I', false, '', '', NULL);
INSERT INTO cargo VALUES (635, 3, '93000', '15', '2', 'ASISTENTE DE PRODUCCION', false, '', '', NULL);
INSERT INTO cargo VALUES (636, 3, '93211', '17', '2', 'PRODUCTOR AUDIOVISUAL I', false, '', '', NULL);
INSERT INTO cargo VALUES (637, 3, '93212', '18', '2', 'JEFE SECCION DE SONIDO', false, '', '', NULL);
INSERT INTO cargo VALUES (638, 3, '93213', '21', '2', 'PRODUCTOR AUDIOVISUAL', false, '', '', NULL);
INSERT INTO cargo VALUES (639, 3, '93220', '15', '2', 'PRODUCTOR DE MULTIMEDIA', false, '', '', NULL);
INSERT INTO cargo VALUES (640, 3, '93410', '15', '2', 'TECNICO RECURSOS APRENDIZAJE', false, '', '', NULL);
INSERT INTO cargo VALUES (641, 3, '93415', '17', '2', 'ANALISTA PROG CENTRAL CURSOS', false, '', '', NULL);
INSERT INTO cargo VALUES (642, 3, '93424', '18', '2', 'SUPERVISOR DE ACTIVIDADES DEPO', false, '', '', NULL);
INSERT INTO cargo VALUES (643, 3, '93521', '19', '2', 'ANALISTA DE ASUNTOS LEGALES', false, '', '', NULL);
INSERT INTO cargo VALUES (644, 3, '93700', '18', '2', 'ADMINISTRADOR DE SISTEMAS I', false, '', '', NULL);
INSERT INTO cargo VALUES (645, 3, '93701', '19', '2', 'ADMINISTRADOR DE SISTEMAS II', false, '', '', NULL);
INSERT INTO cargo VALUES (646, 3, '93702', '21', '2', 'ADMINISTRADOR DE SISTEMAS III', false, '', '', NULL);
INSERT INTO cargo VALUES (647, 3, '93703', '23', '2', 'ADMINISTRADOR DE SISTEMAS IV', false, '', '', NULL);
INSERT INTO cargo VALUES (648, 3, '93711', '21', '2', 'JEFE OFIC.PATRIMONIO ARTISTICO', false, '', '', NULL);
INSERT INTO cargo VALUES (649, 3, '93712', '23', '2', 'ADMINISTRADOR PATRIMONIO ARTISTICO I', false, '', '', NULL);
INSERT INTO cargo VALUES (650, 3, '94000', '15', '2', 'ASISTENTE DE ADMINISTRADOR DE SISTEMA I', false, '', '', NULL);
INSERT INTO cargo VALUES (651, 3, '94010', '15', '2', 'ADMINISTRADOR DE TRANSPORTE I', false, '', '', NULL);
INSERT INTO cargo VALUES (652, 3, '94011', '17', '2', 'ADMINISTRADOR DE TRANSPORTE II', false, '', '', NULL);
INSERT INTO cargo VALUES (653, 3, '94012', '19', '2', 'ADMINISTRADOR DE TRANSPORTE III', false, '', '', NULL);
INSERT INTO cargo VALUES (654, 3, '94013', '21', '2', 'ADMINISTRADOR DE TRANSPORTE IV', false, '', '', NULL);
INSERT INTO cargo VALUES (655, 2, '94014', '23', '2', 'ADMINISTRADOR DE TRANSPORTE JEFE', false, '', '', NULL);
INSERT INTO cargo VALUES (656, 3, '94015', '15', '2', 'ASIST. DE HIGIENE Y SEGURIDAD INDUSTRIAL', false, '', '', NULL);
INSERT INTO cargo VALUES (657, 3, '94019', '15', '2', 'ANALISTA DE PRESTACIONES SOCIALES I', false, '', '', NULL);
INSERT INTO cargo VALUES (658, 3, '94020', '17', '2', 'ANALISTA DE PRESTACIONES SOCIALES II', false, '', '', NULL);
INSERT INTO cargo VALUES (659, 3, '94030', '17', '2', 'ASISTENTE DE DEPARTAMENTO ACADEMICO I', false, '', '', NULL);
INSERT INTO cargo VALUES (660, 3, '94031', '19', '2', 'ASISTENTE DE DEPARTAMENTO ACADEMICO II', false, '', '', NULL);
INSERT INTO cargo VALUES (661, 3, '94032', '21', '2', 'ASISTENTE DE DEPARTAMENTO ACADEMICO III', false, '', '', NULL);
INSERT INTO cargo VALUES (662, 3, '94033', '23', '2', 'ASISTENTE DE DEPARTAMENTO ACADEMICO IV', false, '', '', NULL);
INSERT INTO cargo VALUES (663, 4, '94351', '14', '2', 'INSPECTOR DE OPERACIONES', false, '', '', NULL);
INSERT INTO cargo VALUES (664, 1, '94360', '25', '2', 'CONTRALOR INTERNO', false, '', '', NULL);
INSERT INTO cargo VALUES (665, 4, '94361', '14', '2', 'CONTROLADOR RUTAS TRANSP. COLECTIVO', false, '', '', NULL);
INSERT INTO cargo VALUES (666, 4, '94371', '14', '2', 'OPERADOR DE FOTOCOMPOSICION', false, '', '', NULL);
INSERT INTO cargo VALUES (667, 4, '94511', '11', '2', 'TECNICO DE LABORATORIO I', false, '', '', NULL);
INSERT INTO cargo VALUES (668, 4, '94512', '14', '2', 'TECNICO DE LABORATORIO II', false, '', '', NULL);
INSERT INTO cargo VALUES (669, 3, '94513', '17', '2', 'TECNICO DE LABORATORIO III', false, '', '', NULL);
INSERT INTO cargo VALUES (670, 3, '94514', '20', '2', 'TECNICO DE LABORATORIO IV', false, '', '', NULL);
INSERT INTO cargo VALUES (671, 3, '94515', '22', '2', 'TECNICO DE LABORATORIO V', false, '', '', NULL);
INSERT INTO cargo VALUES (672, 3, '94520', '18', '2', 'INGENIERO DE SONIDO', false, '', '', NULL);
INSERT INTO cargo VALUES (673, 3, '94543', '21', '2', 'SOPLADOR DE VIDRIO', false, '', '', NULL);
INSERT INTO cargo VALUES (674, 3, '94592', '15', '2', 'TECNICO DE LABORATORIO II', false, '', '', NULL);
INSERT INTO cargo VALUES (675, 4, '94611', '10', '2', 'MECANICO MANTENIMIENTO CALDERA', false, '', '', NULL);
INSERT INTO cargo VALUES (676, 4, '94613', '13', '2', 'MECANICO MANTENIMIENTO CALDERAS II', false, '', '', NULL);
INSERT INTO cargo VALUES (677, 3, '95000', '17', '2', 'SUPERVISOR RELACIONES PROTOCOLARES I', false, '', '', NULL);
INSERT INTO cargo VALUES (678, 3, '95001', '18', '2', 'SUPERVISOR DE RELACIONES PROTOCOLARES II', false, '', '', NULL);
INSERT INTO cargo VALUES (679, 4, '95097', '10', '2', 'ASISTENTE TECNICO ADMINISTRATIVO I', false, '', '', NULL);
INSERT INTO cargo VALUES (680, 4, '95098', '12', '2', 'ASISTENTE TECNICO ADMINISTRATIVO II', false, '', '', NULL);
INSERT INTO cargo VALUES (681, 4, '95099', '14', '2', 'ASISTENTE TECNICO ADMINISTRATIVO III', false, '', '', NULL);
INSERT INTO cargo VALUES (682, 3, '95100', '16', '2', 'ASISTENTE TECNICO ADMINISTRATIVO IV', false, '', '', NULL);
INSERT INTO cargo VALUES (683, 3, '95101', '18', '2', 'ASISTENTE TECNICO ADMINISTRATIVO V', false, '', '', NULL);
INSERT INTO cargo VALUES (684, 3, '95102', '20', '2', 'ASISTENTE TECNICO ADMINISTRATIVO VI', false, '', '', NULL);
INSERT INTO cargo VALUES (685, 4, '95103', '14', '2', 'ASISTENTE EMERGENCIAS PREHOSPITALARIA I', false, '', '', NULL);
INSERT INTO cargo VALUES (686, 3, '95104', '16', '2', 'ASISTENTE EMERGENCIAS PREHOSPITALARIA II', false, '', '', NULL);
INSERT INTO cargo VALUES (687, 4, '95197', '10', '2', 'ASIST. TECNICO ADMNISTRATIVO I', false, '', '', NULL);
INSERT INTO cargo VALUES (688, 3, '95200', '15', '2', 'ASISTENTE SERVICIO GENERAL III', false, '', '', NULL);
INSERT INTO cargo VALUES (689, 3, '95201', '16', '2', 'ASISTENTE SERVICIO GENERAL IV', false, '', '', NULL);
INSERT INTO cargo VALUES (690, 3, '95700', '15', '2', 'ASISTENTE TECNICO MUSEO', false, '', '', NULL);
INSERT INTO cargo VALUES (691, 2, '96004', '24', '2', 'COORD. DE PROYEC. DE GESTION DE INFOR. V', false, '', '', NULL);
INSERT INTO cargo VALUES (692, 3, '96006', '22', '2', 'JEFE PROYECTOS DE SIST. DE INFOR. II', false, '', '', NULL);
INSERT INTO cargo VALUES (693, 4, '96010', '6', '2', 'INSPECTOR DE RUTAS DE TRANSPORTE I', false, '', '', NULL);
INSERT INTO cargo VALUES (694, 3, '96200', '15', '2', 'ASIST. DE SERVICIOS DE MANTT. III', false, '', '', NULL);
INSERT INTO cargo VALUES (695, 4, '96211', '11', '2', 'TECNICO DE MANTENIMIENTO I', false, '', '', NULL);
INSERT INTO cargo VALUES (696, 4, '96212', '14', '2', 'TECNICO DE MANTENIMIENTO II', false, '', '', NULL);
INSERT INTO cargo VALUES (697, 3, '96213', '17', '2', 'TECNICO DE MANTENIMIENTO III', false, '', '', NULL);
INSERT INTO cargo VALUES (698, 3, '96214', '20', '2', 'TECNICO DE MANTENIMIENTO IV', false, '', '', NULL);
INSERT INTO cargo VALUES (699, 3, '96215', '21', '2', 'TECNICO DE MANTENIMIENTO V', false, '', '', NULL);
INSERT INTO cargo VALUES (700, 4, '96311', '14', '2', 'OPERADOR DE COMPOSICION I', false, '', '', NULL);
INSERT INTO cargo VALUES (701, 3, '96312', '16', '2', 'OPERADOR DE COMPOSICION II', false, '', '', NULL);
INSERT INTO cargo VALUES (702, 3, '96313', '21', '2', 'ESPECIALISTA DE ESTILO', false, '', '', NULL);
INSERT INTO cargo VALUES (703, 4, '96331', '9', '2', 'MONTADOR EN FRIO I', false, '', '', NULL);
INSERT INTO cargo VALUES (704, 4, '96332', '11', '2', 'MONTADOR EN FRIO II', false, '', '', NULL);
INSERT INTO cargo VALUES (705, 3, '96500', '22', '2', 'ASIST.EJECUT.DEL CONSEJO DIRECT.UNIVERS.', false, '', '', NULL);
INSERT INTO cargo VALUES (706, 3, '96501', '23', '2', 'ASIST. EJEC. DEL DIRECTIVO 11', false, '', '', NULL);
INSERT INTO cargo VALUES (707, 4, '96800', '12', '2', 'COORD. DE SIST. DE MANT. DE EQUIPOS', false, '', '', NULL);
INSERT INTO cargo VALUES (708, 3, '97000', '18', '2', 'INGENIERO ELECTRONICO I', false, '', '', NULL);
INSERT INTO cargo VALUES (709, 3, '97001', '19', '2', 'INGENIERO ELECTRONICO II', false, '', '', NULL);
INSERT INTO cargo VALUES (710, 3, '97002', '21', '2', 'INGENIERO ELECTRONICO III', false, '', '', NULL);
INSERT INTO cargo VALUES (711, 3, '97011', '19', '2', 'ING. MANTENIMIENTO ELECTRONICO', false, '', '', NULL);
INSERT INTO cargo VALUES (712, 4, '97200', '13', '2', 'ASIST. DE INVEST. EN ANALISIS AMBIENTAL', false, '', '', NULL);
INSERT INTO cargo VALUES (713, 3, '97300', '15', '2', 'ASISTENTE DE INVEST. II', false, '', '', NULL);
INSERT INTO cargo VALUES (714, 4, '97500', '5', '2', 'OPERADOR AUXILIAR DE COMPOSICION', false, '', '', NULL);
INSERT INTO cargo VALUES (715, 3, '98000', '21', '2', 'JEFE TECN.DE PROMOCION INDUSTRIAL', false, '', '', NULL);
INSERT INTO cargo VALUES (716, 2, '98100', '23', '2', 'TRABAJADOR SOCIAL JEFE I', false, '', '', NULL);
INSERT INTO cargo VALUES (717, 2, '98101', '25', '2', 'TRABAJADOR SOCIAL JEFE II', false, '', '', NULL);
INSERT INTO cargo VALUES (718, 3, '99100', '21', '2', 'COORDINADOR DE PRODUCCION EDITORIAL', false, '', '', NULL);
INSERT INTO cargo VALUES (719, 3, '99111', '17', '2', 'DIRECTOR GRUPO INSTRUMENTAL', false, '', '', NULL);
INSERT INTO cargo VALUES (720, 3, '99112', '18', '2', 'DIRECTOR TALLERES AUDI.MUSICAL', false, '', '', NULL);
INSERT INTO cargo VALUES (721, 3, '99113', '17', '2', 'DIRECTOR DEL GRUPO VOCAL', false, '', '', NULL);
INSERT INTO cargo VALUES (722, 3, '99191', '19', '2', 'DIRECTOR GRUPO INSTRUMENTAL', false, '', '', NULL);
INSERT INTO cargo VALUES (723, 3, '99193', '19', '2', 'DIRECTOR DEL GRUPO VOCAL', false, '', '', NULL);
INSERT INTO cargo VALUES (724, 3, '99211', '17', '2', 'DIRECTOR DE CORAL I', false, '', '', NULL);
INSERT INTO cargo VALUES (725, 3, '99212', '19', '2', 'DIRECTOR DE CORAL II', false, '', '', NULL);
INSERT INTO cargo VALUES (726, 3, '99213', '22', '2', 'DIRECTOR DE CORAL III', false, '', '', NULL);
INSERT INTO cargo VALUES (727, 3, '99223', '19', '2', 'DIRECTOR GRUPO CRIOLLO', false, '', '', NULL);
INSERT INTO cargo VALUES (728, 3, '99224', '19', '2', 'DIRECTOR AGRUPACION DE MUSICA DE CAMARA', false, '', '', NULL);
INSERT INTO cargo VALUES (729, 3, '99225', '19', '2', 'DIRECTOR DE CANTO', false, '', '', NULL);
INSERT INTO cargo VALUES (730, 3, '99233', '20', '2', 'MAESTRA DE VOCALIZACION', false, '', '', NULL);
INSERT INTO cargo VALUES (731, 3, '99243', '22', '2', 'DIRECTOR DE LA CANTORIA', false, '', '', NULL);
INSERT INTO cargo VALUES (732, 4, '99301', '11', '2', 'DIRECTOR DE DANZA', false, '', '', NULL);
INSERT INTO cargo VALUES (733, 3, '99311', '15', '2', 'DIRECTOR CENTRO DE DANZAS', false, '', '', NULL);
INSERT INTO cargo VALUES (734, 3, '99391', '19', '2', 'DIRECTOR DE DANZA', false, '', '', NULL);
INSERT INTO cargo VALUES (735, 3, '99413', '19', '2', 'DIRECTOR DE TEATRO', false, '', '', NULL);
INSERT INTO cargo VALUES (736, 3, '99420', '17', '2', 'DIRECTOR DE ESTUDIANTINA', false, '', '', NULL);
INSERT INTO cargo VALUES (737, 3, '99430', '20', '2', 'ASISTENTE TECNICO A LA COORDINACION', false, '', '', NULL);
INSERT INTO cargo VALUES (738, 3, '99431', '17', '2', 'ASISTENTE DE COORDINACION I', false, '', '', NULL);
INSERT INTO cargo VALUES (739, 3, '99432', '19', '2', 'ASISTENTE DE COORDINACION II', false, '', '', NULL);
INSERT INTO cargo VALUES (740, 3, '99433', '21', '2', 'ASISTENTE DE COORDINACION III', false, '', '', NULL);
INSERT INTO cargo VALUES (741, 3, '99434', '23', '2', 'ASISTENTE DE COORDINACION IV', false, '', '', NULL);
INSERT INTO cargo VALUES (742, 4, '99444', '9', '2', 'OPERADOR DE DIAGRAMACION I', false, '', '', NULL);
INSERT INTO cargo VALUES (743, 3, '99452', '15', '2', 'ANALISTA ASUNTOS ADUANALES I', false, '', '', NULL);
INSERT INTO cargo VALUES (744, 3, '99453', '17', '2', 'ANALISTA DE ASUNTOS ADUANALES II', false, '', '', NULL);
INSERT INTO cargo VALUES (745, 3, '99454', '19', '2', 'ANALISTA  DE ASUNTOS ADUANALES III', false, '', '', NULL);
INSERT INTO cargo VALUES (746, 3, '99455', '22', '2', 'COORD. DE ASUNTOS ADUANALES I', false, '', '', NULL);
INSERT INTO cargo VALUES (747, 4, '99490', '13', '2', 'ASISTENTE DE PROMOTOR CULTURAL', false, '', '', NULL);
INSERT INTO cargo VALUES (748, 3, '99500', '17', '2', 'PROMOTOR CULTURAL I', false, '', '', NULL);
INSERT INTO cargo VALUES (749, 3, '99501', '19', '2', 'PROMOTOR CULTURAL II', false, '', '', NULL);
INSERT INTO cargo VALUES (750, 3, '99502', '21', '2', 'PROMOTOR CULTURAL III', false, '', '', NULL);
INSERT INTO cargo VALUES (751, 1, '99800', '24', '2', 'JEFE OFICINA DE PRENSA', false, '', '', NULL);
INSERT INTO cargo VALUES (752, 1, '99850', '25', '2', 'JEFE ENCARGADO DEL DPTO. DE MANTENIMIENT', false, '', '', NULL);
INSERT INTO cargo VALUES (753, 1, '99851', '25', '2', 'JEFE ENCARGADO DEL DPTO. DE PROYECTOS', false, '', '', NULL);
INSERT INTO cargo VALUES (754, 3, '99852', '25', '2', 'ASIST. ENCARGADO DECANATO EST. GENERALES', false, '', '', NULL);
INSERT INTO cargo VALUES (755, 4, '99900', '14', '2', 'ASIST. MEDIOS AUDIOVISUALES I', false, '', '', NULL);
INSERT INTO cargo VALUES (756, 4, '99901', '14', '2', 'ASISTENTE MEDIOS AUDIOVISUALES II', false, '', '', NULL);
INSERT INTO cargo VALUES (757, 3, '99902', '17', '2', 'ASISTENTE MEDIOS AUDIOVISUALES III', false, '', '', NULL);
INSERT INTO cargo VALUES (758, 3, '99910', '15', '2', 'ASIST. ESPECIALISTA ASUNTOS AUDIO-VISUAL', false, '', '', NULL);
INSERT INTO cargo VALUES (759, 3, '99911', '17', '2', 'ESPECIALISTA ASUNTO AUDIOVISUALES I', false, '', '', NULL);
INSERT INTO cargo VALUES (760, 3, '99912', '19', '2', 'ESPECIALISTA ASUNTO AUDIOVISUALES II', false, '', '', NULL);
INSERT INTO cargo VALUES (761, 3, '99913', '21', '2', 'ESPECIALISTA ASUNTOS AUDIOVISUALES III', false, '', '', NULL);
INSERT INTO cargo VALUES (762, 3, '99920', '19', '2', 'DIRECTOR DE ESTUDIANTINA', false, '', '', NULL);
INSERT INTO cargo VALUES (763, 4, '99970', '6', '2', 'OPERADOR DE EQUIPOS AUDIOVISUALES I', false, '', '', NULL);
INSERT INTO cargo VALUES (764, 4, '99971', '8', '2', 'OPERADOR DE EQUIPOS AUDIOVISUALES II', false, '', '', NULL);
INSERT INTO cargo VALUES (765, 4, '99972', '10', '2', 'OPERADOR DE EQUIPOS AUDIOVISUALES III', false, '', '', NULL);
INSERT INTO cargo VALUES (766, 4, '99973', '12', '2', 'OPERADOR DE EQUIPOS AUDIOVISUALES IV', false, '', '', NULL);
INSERT INTO cargo VALUES (767, 4, '99974', '10', '2', 'OPERADOR DE EQUIPOS MULTIMEDIA I', false, '', '', NULL);
INSERT INTO cargo VALUES (768, 4, '99975', '12', '2', 'OPERADOR DE EQUIPOS MULTIMEDIA II', false, '', '', NULL);
INSERT INTO cargo VALUES (769, 4, '99976', '14', '2', 'OPERADOR DE EQUIPOS MULTIMEDIA III', false, '', '', NULL);
INSERT INTO cargo VALUES (770, 3, '99977', '16', '2', 'OPERADOR DE EQUIPOS MULTIMEDIA IV', false, '', '', NULL);
INSERT INTO cargo VALUES (771, 4, '99979', '13', '2', 'ASIST. EDICION ASUNTOS AUDIOVISUALES', false, '', '', NULL);
INSERT INTO cargo VALUES (772, 3, '99980', '15', '2', 'EDITOR DE ASUNTOS AUDIOVISUALES I', false, '', '', NULL);
INSERT INTO cargo VALUES (773, 3, '99981', '17', '2', 'EDITOR DE ASUNTOS AUDIOVISUALES II', false, '', '', NULL);
INSERT INTO cargo VALUES (774, 3, '99982', '19', '2', 'EDITOR DE ASUNTOS AUDIOVISUALES III', false, '', '', NULL);
INSERT INTO cargo VALUES (775, 1, '99990', '25', '2', 'ASESOR', false, '', '', NULL);
INSERT INTO cargo VALUES (776, 3, '99998', '16', '2', 'JEFE DE LA SECCION DE GRUPOS ESTABLES', false, '', '', NULL);
INSERT INTO cargo VALUES (777, 5, '1031', '4', '3', 'AUXILIAR DE ZOOTECNIA', false, '', '', NULL);
INSERT INTO cargo VALUES (778, 5, '1051', '7', '3', 'SUPERVISOR DE FINCAS', false, '', '', NULL);
INSERT INTO cargo VALUES (779, 5, '2011', '3', '3', 'ALMACENISTA', false, '', '', NULL);
INSERT INTO cargo VALUES (780, 5, '2021', '7', '3', 'SUPERVISOR DE ALMACEN', false, '', '', NULL);
INSERT INTO cargo VALUES (781, 5, '3011', '3', '3', 'AYUDANTE DE MANTENIMIENTO', false, '', '', NULL);
INSERT INTO cargo VALUES (782, 5, '3041', '4', '3', 'PINTOR', false, '', '', NULL);
INSERT INTO cargo VALUES (783, 5, '3051', '4', '3', 'AUXILIAR DE MANTENIMIENTO', false, '', '', NULL);
INSERT INTO cargo VALUES (784, 5, '3071', '4', '3', 'LAQUEADOR', false, '', '', NULL);
INSERT INTO cargo VALUES (785, 5, '3091', '5', '3', 'ALBAÃIL', false, '', '', NULL);
INSERT INTO cargo VALUES (786, 5, '3101', '5', '3', 'PLOMERO', false, '', '', NULL);
INSERT INTO cargo VALUES (787, 5, '3111', '5', '3', 'CARPINTERO', false, '', '', NULL);
INSERT INTO cargo VALUES (788, 5, '3121', '5', '3', 'AUXILIAR DE MTTO. EQ. SONIDO-AUDIOV.Y E', false, '', '', NULL);
INSERT INTO cargo VALUES (789, 5, '3131', '6', '3', 'HERRERO SOLDADOR', false, '', '', NULL);
INSERT INTO cargo VALUES (790, 5, '3141', '6', '3', 'AUXILIAR DE TELEFONIA', false, '', '', NULL);
INSERT INTO cargo VALUES (791, 5, '3151', '6', '3', 'MECANICO DE REFRIGERACION', false, '', '', NULL);
INSERT INTO cargo VALUES (792, 5, '3161', '6', '3', 'ELECTRICISTA', false, '', '', NULL);
INSERT INTO cargo VALUES (793, 5, '3191', '7', '3', 'SUPERVISOR DE MANTENIMIENTO', false, '', '', NULL);
INSERT INTO cargo VALUES (794, 5, '4011', '2', '3', 'OPERADOR DE EQUIPO REPRODUCION', false, '', '', NULL);
INSERT INTO cargo VALUES (795, 5, '4021', '2', '3', 'OPERARIO GRAFICO', false, '', '', NULL);
INSERT INTO cargo VALUES (796, 5, '4031', '3', '3', 'AUXILIAR GRAFICO', false, '', '', NULL);
INSERT INTO cargo VALUES (797, 5, '4051', '3', '3', 'ENCUADERNADOR', false, '', '', NULL);
INSERT INTO cargo VALUES (798, 5, '4121', '7', '3', 'SUPERVISOR DE TALLER DE IMPRENTA', false, '', '', NULL);
INSERT INTO cargo VALUES (799, 5, '5031', '4', '3', 'AUXILIAR DE LABORATORIO', false, '', '', NULL);
INSERT INTO cargo VALUES (800, 5, '6011', '5', '3', 'AUXILIAR DE ENFERMERA', false, '', '', NULL);
INSERT INTO cargo VALUES (801, 5, '7011', '2', '3', 'AYUDANTE DE COCINA', false, '', '', NULL);
INSERT INTO cargo VALUES (802, 5, '7041', '5', '3', 'COCINERO', false, '', '', NULL);
INSERT INTO cargo VALUES (803, 5, '7051', '7', '3', 'SUPERVISOR DE COCINA', false, '', '', NULL);
INSERT INTO cargo VALUES (804, 5, '8011', '1', '3', 'PORTERO', false, '', '', NULL);
INSERT INTO cargo VALUES (805, 5, '8021', '1', '3', 'ASEADOR', false, '', '', NULL);
INSERT INTO cargo VALUES (806, 5, '8031', '1', '3', 'RECEPTOR Y GUIA DE BIBLIOTECA', false, '', '', NULL);
INSERT INTO cargo VALUES (807, 5, '8081', '2', '3', 'MENSAJERO INTERNO', false, '', '', NULL);
INSERT INTO cargo VALUES (808, 5, '8101', '2', '3', 'AYUDANTE DE SERVICIOS', false, '', '', NULL);
INSERT INTO cargo VALUES (809, 5, '8102', '4', '3', 'AUXILIAR DE SERVICIOS', false, '', '', NULL);
INSERT INTO cargo VALUES (810, 5, '8111', '3', '3', 'MENSAJERO EXTERNO', false, '', '', NULL);
INSERT INTO cargo VALUES (811, 5, '8131', '3', '3', 'RECEPTOR DE CORRESPONDENCIA', false, '', '', NULL);
INSERT INTO cargo VALUES (812, 5, '8151', '4', '3', 'JARDINERO', false, '', '', NULL);
INSERT INTO cargo VALUES (813, 5, '8171', '7', '3', 'SUPERVISOR DE SERVICIOS', false, '', '', NULL);
INSERT INTO cargo VALUES (814, 5, '9031', '3', '3', 'DESPACHADOR DE VEHICULO', false, '', '', NULL);
INSERT INTO cargo VALUES (815, 5, '9071', '5', '3', 'TRACTORISTA AGRICOLA', false, '', '', NULL);
INSERT INTO cargo VALUES (816, 5, '9081', '5', '3', 'CHOFER', false, '', '', NULL);
INSERT INTO cargo VALUES (817, 5, '9111', '7', '3', 'SUPERVISOR DE TRANSPORTE Y MECANICA AUTO', false, '', '', NULL);
INSERT INTO cargo VALUES (818, 5, '9999', '5', '3', 'AYUDANTE DE OFICINA', false, '', '', NULL);
INSERT INTO cargo VALUES (819, 5, '10011', '4', '3', 'VIGILANTE', false, '', '', NULL);
INSERT INTO cargo VALUES (820, 5, '10021', '7', '3', 'SUPERVISOR DE VIGILANCIA', false, '', '', NULL);
INSERT INTO cargo VALUES (821, 5, '10107', '7', '3', 'ALBAÃIL DE PRIMERA', false, '', '', NULL);
INSERT INTO cargo VALUES (822, 5, '10205', '5', '3', 'ALBAÃIL DE SEGUNDA', false, '', '', NULL);
INSERT INTO cargo VALUES (823, 5, '10302', '2', '3', 'ALBAÃIL DE TERCERA', false, '', '', NULL);
INSERT INTO cargo VALUES (824, 5, '10405', '5', '3', 'ALMACENERO', false, '', '', NULL);
INSERT INTO cargo VALUES (825, 5, '10501', '2', '3', 'AYUDANTE DE BIBLIOTECA', false, '', '', NULL);
INSERT INTO cargo VALUES (826, 5, '10601', '2', '3', 'AYUDANTE DE CAVA', false, '', '', NULL);
INSERT INTO cargo VALUES (828, 5, '10603', '2', '3', 'AYUDANTE DE CAMION O CARGA', false, '', '', NULL);
INSERT INTO cargo VALUES (829, 5, '10701', '2', '3', 'AYUDANTE DE DEPOSITARIO', false, '', '', NULL);
INSERT INTO cargo VALUES (830, 5, '10805', '5', '3', 'AYUDANTE DE DIAGRAMACION Y MONTAJE', false, '', '', NULL);
INSERT INTO cargo VALUES (831, 5, '10901', '2', '3', 'AYUDANTE DE LABORATORIO', false, '', '', NULL);
INSERT INTO cargo VALUES (832, 5, '10922', '4', '3', 'AYUDANTE LOGISTICA DE LABORATORIO II', false, '', '', NULL);
INSERT INTO cargo VALUES (833, 5, '11001', '1', '3', 'AYUDANTE DE LOGISTICA I', false, '', '', NULL);
INSERT INTO cargo VALUES (834, 5, '11002', '2', '3', 'AYUDANTE DE LOGISTICA', false, '', '', NULL);
INSERT INTO cargo VALUES (835, 5, '11003', '2', '3', 'AYUDANTE DE LOGISTICA DE 2DA.', false, '', '', NULL);
INSERT INTO cargo VALUES (836, 5, '11004', '4', '3', 'AYUDANTE DE LOGISTICA DE 1ERA.', false, '', '', NULL);
INSERT INTO cargo VALUES (837, 5, '11103', '3', '3', 'AYUDANTE DE MANTENIMIENTO EN GENERAL', false, '', '', NULL);
INSERT INTO cargo VALUES (838, 5, '11104', '3', '3', 'AYUDANTE DE MANTENIMIENTO', false, '', '', NULL);
INSERT INTO cargo VALUES (839, 5, '11105', '3', '3', 'AYUDANTE DE TELEFONOS', false, '', '', NULL);
INSERT INTO cargo VALUES (840, 5, '11106', '4', '3', 'AYUDANTE DE MANTENIMIENTO II', false, '', '', NULL);
INSERT INTO cargo VALUES (841, 5, '11107', '5', '3', 'AYUDANTE DE MANTENIMIENTO III', false, '', '', NULL);
INSERT INTO cargo VALUES (842, 5, '11112', '4', '3', 'AYUDANTE AGROPECUARIO II', false, '', '', NULL);
INSERT INTO cargo VALUES (843, 5, '11201', '2', '3', 'CAMARERA', false, '', '', NULL);
INSERT INTO cargo VALUES (844, 5, '11251', '3', '3', 'CAPATAZ DE VIGILANCIA', false, '', '', NULL);
INSERT INTO cargo VALUES (845, 5, '11302', '2', '3', 'CARPINTERO DE TERCERA', false, '', '', NULL);
INSERT INTO cargo VALUES (846, 5, '11405', '5', '3', 'CARPINTERO DE SEGUNDA', false, '', '', NULL);
INSERT INTO cargo VALUES (847, 5, '11507', '7', '3', 'CARPINTERO DE PRIMERA', false, '', '', NULL);
INSERT INTO cargo VALUES (848, 5, '11551', '2', '3', 'AYUD.CENTRO INF.Y COMP.', false, '', '', NULL);
INSERT INTO cargo VALUES (849, 5, '11604', '4', '3', 'CHOFER DE SEGUNDA', false, '', '', NULL);
INSERT INTO cargo VALUES (850, 5, '11705', '5', '3', 'CHOFER DE PRIMERA', false, '', '', NULL);
INSERT INTO cargo VALUES (851, 5, '11803', '3', '3', 'COMPRADOR', false, '', '', NULL);
INSERT INTO cargo VALUES (852, 5, '11851', '3', '3', 'COMPAGINADOR', false, '', '', NULL);
INSERT INTO cargo VALUES (853, 5, '11901', '2', '3', 'COCINERO DE SEGUNDA', false, '', '', NULL);
INSERT INTO cargo VALUES (854, 5, '12003', '3', '3', 'COCINERO DE PRIMERA', false, '', '', NULL);
INSERT INTO cargo VALUES (855, 5, '12101', '4', '3', 'AYUDANTE DE ENFERMERIA', false, '', '', NULL);
INSERT INTO cargo VALUES (856, 5, '12102', '2', '3', 'CUIDADOR DE ANIMALES', false, '', '', NULL);
INSERT INTO cargo VALUES (857, 5, '12202', '2', '3', 'DEPOSITARIO', false, '', '', NULL);
INSERT INTO cargo VALUES (858, 5, '12302', '2', '3', 'ELECTRICISTA DE TERCERA', false, '', '', NULL);
INSERT INTO cargo VALUES (859, 5, '12405', '5', '3', 'ELECTRICISTA DE SEGUNDA', false, '', '', NULL);
INSERT INTO cargo VALUES (860, 5, '12507', '7', '3', 'ELECTRICISTA DE PRIMERA', false, '', '', NULL);
INSERT INTO cargo VALUES (861, 5, '20103', '3', '3', 'ENCUADERNADOR I', false, '', '', NULL);
INSERT INTO cargo VALUES (862, 5, '20203', '3', '3', 'FOTOCOPIADOR', false, '', '', NULL);
INSERT INTO cargo VALUES (863, 5, '20303', '3', '3', 'GUARDA TANQUE', false, '', '', NULL);
INSERT INTO cargo VALUES (864, 5, '20402', '2', '3', 'HERRERO LATONERO DE SEGUNDA', false, '', '', NULL);
INSERT INTO cargo VALUES (865, 5, '20504', '4', '3', 'HERRERO LATONERO DE PRIMERA', false, '', '', NULL);
INSERT INTO cargo VALUES (866, 5, '20601', '1', '3', 'JARDINERO DE TERCERA', false, '', '', NULL);
INSERT INTO cargo VALUES (867, 5, '20702', '2', '3', 'JARDINERO DE SEGUNDA', false, '', '', NULL);
INSERT INTO cargo VALUES (868, 5, '20803', '3', '3', 'JARDINERO DE PRIMERA', false, '', '', NULL);
INSERT INTO cargo VALUES (869, 5, '20901', '2', '3', 'MENSAJERO', false, '', '', NULL);
INSERT INTO cargo VALUES (870, 5, '20902', '2', '3', 'MENSAJERO INTERNO', false, '', '', NULL);
INSERT INTO cargo VALUES (871, 5, '20903', '3', '3', 'MENSAJERO MOTORIZADO', false, '', '', NULL);
INSERT INTO cargo VALUES (872, 5, '21101', '5', '3', 'MONTADOR DE NEGATIVOS', false, '', '', NULL);
INSERT INTO cargo VALUES (873, 5, '21102', '6', '3', 'MONTADOR DE NEGATIVOS I', false, '', '', NULL);
INSERT INTO cargo VALUES (874, 5, '21203', '1', '3', 'OBRERO GENERAL', false, '', '', NULL);
INSERT INTO cargo VALUES (875, 5, '21220', '2', '3', 'OBRERO DE LOGISTICA', false, '', '', NULL);
INSERT INTO cargo VALUES (876, 5, '21304', '3', '3', 'OBRERO DE MANTENIMIENTO DE TELEFONOS', false, '', '', NULL);
INSERT INTO cargo VALUES (877, 5, '21401', '4', '3', 'OPERARIO DE MAQUINA MULTILITH', false, '', '', NULL);
INSERT INTO cargo VALUES (878, 5, '21402', '4', '3', 'OPERADOR DE MAQUINA MATRICERA', false, '', '', NULL);
INSERT INTO cargo VALUES (879, 5, '21503', '1', '3', 'PINTOR DE TERCERA', false, '', '', NULL);
INSERT INTO cargo VALUES (880, 5, '21602', '3', '3', 'PINTOR LAQUEADOR SEGUNDA', false, '', '', NULL);
INSERT INTO cargo VALUES (881, 5, '21604', '3', '3', 'PINTOR DE SEGUNDA', false, '', '', NULL);
INSERT INTO cargo VALUES (882, 5, '21701', '7', '3', 'PINTOR LAQUEADOR PRIMERA', false, '', '', NULL);
INSERT INTO cargo VALUES (883, 5, '21702', '4', '3', 'PINTOR DE PRIMERA', false, '', '', NULL);
INSERT INTO cargo VALUES (884, 5, '21804', '2', '3', 'PLOMERO DE TERCERA', false, '', '', NULL);
INSERT INTO cargo VALUES (885, 5, '21907', '4', '3', 'PLOMERO DE SEGUNDA', false, '', '', NULL);
INSERT INTO cargo VALUES (886, 5, '22003', '7', '3', 'PLOMERO DE PRIMERA', false, '', '', NULL);
INSERT INTO cargo VALUES (887, 5, '22104', '3', '3', 'PORTERO', false, '', '', NULL);
INSERT INTO cargo VALUES (888, 5, '22105', '2', '3', 'RECEPTOR DE BULTOS', false, '', '', NULL);
INSERT INTO cargo VALUES (889, 5, '22205', '4', '3', 'RECEPTOR DE CORRESPONDENCIA', false, '', '', NULL);
INSERT INTO cargo VALUES (890, 5, '22305', '5', '3', 'RECEPTOR DE OFICINA I', false, '', '', NULL);
INSERT INTO cargo VALUES (891, 5, '22405', '5', '3', 'RESPONSABLE DE MANTENIMIENTO DE EDIFICIO', false, '', '', NULL);
INSERT INTO cargo VALUES (892, 5, '22502', '5', '3', 'RETOCADOR PLANCHISTA', false, '', '', NULL);
INSERT INTO cargo VALUES (893, 5, '22605', '2', '3', 'SOLDADOR DE TERCERA', false, '', '', NULL);
INSERT INTO cargo VALUES (894, 5, '22707', '5', '3', 'SOLDADOR DE SEGUNDA', false, '', '', NULL);
INSERT INTO cargo VALUES (895, 5, '22807', '7', '3', 'SOLDADOR DE PRIMERA', false, '', '', NULL);
INSERT INTO cargo VALUES (896, 5, '22908', '7', '3', 'SUPERVISOR DE VIGILANCIA DE TERCERA', false, '', '', NULL);
INSERT INTO cargo VALUES (897, 5, '23009', '8', '3', 'SUPERVISOR DE VIGILANCIA DE SEGUNDA', false, '', '', NULL);
INSERT INTO cargo VALUES (898, 2, '23100', '15', '3', 'SUPERV.GENERAL DE SERV.', false, '', '', NULL);
INSERT INTO cargo VALUES (899, 5, '23101', '11', '3', 'SUPERV.PTA.FISICA DE 1R.', false, '', '', NULL);
INSERT INTO cargo VALUES (900, 5, '23102', '10', '3', 'SUPERVISOR DE SERVICIOS II', false, '', '', NULL);
INSERT INTO cargo VALUES (901, 5, '23203', '2', '3', 'VIGILANTE DE SEGUNDA', false, '', '', NULL);
INSERT INTO cargo VALUES (902, 5, '23204', '3', '3', 'VIGILANTE DE PRIMERA (CAPATAZ DE VIGIL.)', false, '', '', NULL);
INSERT INTO cargo VALUES (903, 5, '30840', '5', '3', 'CHOFER I', false, '', '', NULL);
INSERT INTO cargo VALUES (904, 5, '30841', '6', '3', 'CHOFER II', false, '', '', NULL);
INSERT INTO cargo VALUES (905, 5, '30842', '7', '3', 'CHOFER III', false, '', '', NULL);
INSERT INTO cargo VALUES (906, 5, '30942', '5', '3', 'OBRERO MANTENIMIENTO DE TELEFONOS III', false, '', '', NULL);
INSERT INTO cargo VALUES (907, 5, '31813', '7', '3', 'PLOMERO III', false, '', '', NULL);
INSERT INTO cargo VALUES (908, 5, '41121', '4', '3', 'VIGILANTE MOTORIZADO', false, '', '', NULL);
INSERT INTO cargo VALUES (909, 5, '52801', '7', '3', 'RECEPTOR DE OFICINA II', false, '', '', NULL);
INSERT INTO cargo VALUES (910, 5, '88888', '3', '3', 'OBRERO XXX', false, '', '', NULL);
INSERT INTO cargo VALUES (911, 5, '9999', '5', '4', 'AYUDANTE DE OFICINA', false, '', '', NULL);
INSERT INTO cargo VALUES (912, 3, '36322', '19', '4', 'PSICOLOGO II', false, '', '', NULL);
INSERT INTO cargo VALUES (913, 3, '77121', '17', '4', 'DIETISTA I', false, '', '', NULL);
INSERT INTO cargo VALUES (914, 0, '123', NULL, NULL, 'Cargo de Prueba 1', false, 'DescripciÃ³n para el cargo de prueba tipo 1', 'Funciones del cargo de prueba tipo 1', NULL);
INSERT INTO cargo VALUES (915, 0, '124', NULL, NULL, 'Cargo de Prueba 2', false, 'DescripciÃ³n del cargo de prueba tipo 2', 'Funciones del cargo de prueba tipo 2', NULL);
INSERT INTO cargo VALUES (916, 0, '200', NULL, NULL, 'Cargo de Prueba 3', false, 'DescripciÃ³n del cargo de prueba tipo 3', 'Funciones del cargo de prueba tipo 3', NULL);
INSERT INTO cargo VALUES (917, 0, '11111', NULL, NULL, 'CARGO Saul', false, 'Prueba', 'Prueba', NULL);


--
-- Name: cargo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('cargo_id_seq', 917, true);


--
-- Data for Name: cargo_opsu; Type: TABLE DATA; Schema: public; Owner: root
--



--
-- Data for Name: condiciones; Type: TABLE DATA; Schema: public; Owner: root
--

INSERT INTO condiciones VALUES ('1', 'Reposo Medico');
INSERT INTO condiciones VALUES ('2', 'Permiso Pre y Post');
INSERT INTO condiciones VALUES ('3', 'Averiguaciones Administrativas');
INSERT INTO condiciones VALUES ('4', 'Proceso Disciplinario');
INSERT INTO condiciones VALUES ('5', 'Jubilado');
INSERT INTO condiciones VALUES ('6', 'Pensionado');
INSERT INTO condiciones VALUES ('7', 'Permiso No Remunerado');
INSERT INTO condiciones VALUES ('8', 'Permiso Remunerado');
INSERT INTO condiciones VALUES ('0', 'Ninguno');


--
-- Data for Name: correo; Type: TABLE DATA; Schema: public; Owner: root
--



--
-- Data for Name: encuesta; Type: TABLE DATA; Schema: public; Owner: root
--

INSERT INTO encuesta VALUES (47, 442346, 2, 3000, true, true);
INSERT INTO encuesta VALUES (48, 442346, 2, 1, false, false);


--
-- Name: encuesta_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('encuesta_id_seq', 48, true);


--
-- Data for Name: encuesta_ls; Type: TABLE DATA; Schema: public; Owner: root
--

INSERT INTO encuesta_ls VALUES (442346, 2, true);


--
-- Data for Name: error; Type: TABLE DATA; Schema: public; Owner: root
--



--
-- Name: error_id_error_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('error_id_error_seq', 1, false);


--
-- Data for Name: evaluacion; Type: TABLE DATA; Schema: public; Owner: root
--

INSERT INTO evaluacion VALUES (100, 'Marzo 2015', '27-03-2015', '10-04-2015', true);


--
-- Name: evaluacion_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('evaluacion_id_seq', 100, true);


--
-- Data for Name: familia_cargo; Type: TABLE DATA; Schema: public; Owner: root
--

INSERT INTO familia_cargo VALUES (0, 'Sin asignar', '');
INSERT INTO familia_cargo VALUES (1, 'GERENCIAL', '');
INSERT INTO familia_cargo VALUES (2, 'SUPERVISORIO', '');
INSERT INTO familia_cargo VALUES (3, 'ADMINISTRATIVO PROFESIONAL', '');
INSERT INTO familia_cargo VALUES (4, 'ADMINISTRATIVO NO PROFESIONAL', '');
INSERT INTO familia_cargo VALUES (5, 'OBREROS', '');


--
-- Name: familia_cargo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('familia_cargo_id_seq', 6, true);


--
-- Data for Name: familia_rol; Type: TABLE DATA; Schema: public; Owner: root
--

INSERT INTO familia_rol VALUES (0, 'Sin asignar', '');
INSERT INTO familia_rol VALUES (1, 'APOYO', 'Personas que van a realizar la encuesta para Funciones de Apoyo');
INSERT INTO familia_rol VALUES (2, 'OPERATIVAS', 'Personas que van a realizar la encuesta para Funciones Operativas');
INSERT INTO familia_rol VALUES (3, 'SUPERVISORIO ADMINISTRATIVO', 'Personas que van a realizar la encuesta para Supervisores Administrativos');
INSERT INTO familia_rol VALUES (4, 'OBRERO', 'Personas que van a realizar la encuesta para Obreros');
INSERT INTO familia_rol VALUES (5, 'SUPERVISORIO OBRERO', 'Personas que van a realizar la encuesta para Supervisores Obreros');


--
-- Name: familia_rol_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('familia_rol_id_seq', 5, true);


--
-- Data for Name: notificacion; Type: TABLE DATA; Schema: public; Owner: root
--



--
-- Name: notificacion_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('notificacion_id_seq', 31, true);


--
-- Data for Name: organizacion; Type: TABLE DATA; Schema: public; Owner: root
--

INSERT INTO organizacion VALUES (0, 0, 'Sin asignar', '0', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (3000, 0, ' COMISION ELECTORAL', '3000', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (4000, 0, ' Rectorado', '4000', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (4001, 4000, ' Programas Especiales', '4001', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (4010, 4000, ' Asesoria Juridica', '4010', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (4020, 4000, ' Direccion Cooperacion y Relac. Interinstituc.', '4020', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (4021, 4000, ' Unidad de Programas Especiales', '4021', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (4022, 4000, ' Oficina de Relaciones Publicas', '4022', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (4023, 4000, ' Oficina de Relaciones Internacionales', '4023', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (4025, 4000, ' Oficina de Prensa', '4025', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (4030, 4000, ' Comision de Planificacion', '4030', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (4031, 4000, ' Oficina de Ingenieria', '4031', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (4040, 4000, ' Programa de Educacion Continua', '4040', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (4041, 4000, ' Programa PAYS', '4041', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (4042, 4000, ' FUNINDES', '4042', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (4043, 4000, ' ARTEVISION', '4043', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (4050, 4000, ' Unidad de Auditoria Interna', '4050', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (4060, 4000, ' Direccion De Desarrollo Estudiantil', '4060', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (4061, 4000, ' Seccion de Deportes', '4061', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (4070, 4000, ' Direccion de Relaciones Internacionales', '4070', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (4072, 4000, ' Dpto. de Soporte Software', '4072', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (4080, 4000, ' Direccion de Cultura', '4080', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (4090, 4000, ' Comision Clasificadora', '4090', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5000, 0, ' Vice-Rectorado Administrativo', '5000', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5010, 5000, ' Direccion de Finanzas', '5010', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5011, 5000, ' Dpto. de Contabilidad', '5011', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5012, 5000, ' Oficina de Presupuesto', '5012', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5013, 5000, ' Dpto. de Tesoreria', '5013', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5014, 5000, ' Dpto. de Registro y Control Financiero', '5014', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5015, 5000, ' Dpto. de Bienes Nacionales', '5015', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5020, 5000, ' Direccion de Gestion de Capital Humano', '5020', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5021, 5000, ' Dpto. de Admon. y Desarrollo de Personal', '5021', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5022, 5000, ' Unidad de Informacion de RRHH', '5022', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5023, 5000, ' Dpto. de Registro y Ordenamiento de Pagos', '5023', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5024, 5000, ' Unidad de Enlace para Asuntos Academicos', '5024', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5025, 5000, ' Departamento de Relaciones Laborales', '5025', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5026, 5000, ' Unidad de Admon. de Recursos Presupuestarios', '5026', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5030, 5000, ' Direccion de Servicios', '5030', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5031, 5000, ' Dpto. de Compras y Suministros', '5031', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5032, 5000, ' Dpto. de Servicios Generales', '5032', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5033, 5000, ' Dpto. de Produccion de Impresos', '5033', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5034, 5000, ' Servicio de Comedores', '5034', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5039, 5000, ' Apoyo Logistico', '5039', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5040, 5000, ' Oficina de Organizacion y Sistemas', '5040', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5050, 5000, ' Nomina de Jubilados', '5050', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5060, 5000, ' Nomina de Pensionados', '5060', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5070, 5000, ' Direccion de Planta Fisica', '5070', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5071, 5000, ' Dpto. de Mantenimiento', '5071', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5072, 5000, ' Dpto. de Proyectos', '5072', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5073, 5000, ' Dpto. de Planeacion', '5073', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (5080, 5000, ' Direccion de Seguridad Integral', '5080', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6000, 0, ' Vice-Rectorado Academico', '6000', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6100, 6000, ' Decanato de Estudios Generales', '6100', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6101, 6100, ' Coord. de Estudios Generales y 1er. AÃO', '6101', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6200, 6000, ' Decanato de Estudios Profesionales', '6200', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6201, 6200, ' Coord. de Arquitectura', '6201', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6202, 6200, ' Coord. de Biologia', '6202', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6204, 6200, ' Coord. de Estudios a Distancia en Lic. Docente', '6204', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6205, 6200, ' Coord. de Fisica', '6205', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6206, 6200, ' Coord. de Ingenieria de la Computacion', '6206', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6207, 6200, ' Coord. de Ingenieria de Materiales', '6207', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6208, 6200, ' Coord. de Ingenieria Electrica', '6208', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6209, 6200, ' Coord. de Ingenieria Electronica', '6209', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6210, 6200, ' Coord. de Ingenieria Mecanica', '6210', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6211, 6200, ' Coord. de Ingenieria Quimica', '6211', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6212, 6200, ' Coord. de Matematicas', '6212', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6213, 6200, ' Coord. de Quimica', '6213', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6214, 6200, ' Coord. de Urbanismo', '6214', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6215, 6200, ' Coord. de Ingenieria Geofisica', '6215', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6216, 6200, ' Coord. de Ingenieria de la Produccion', '6216', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6300, 6000, ' Decanato de Estudios de Postgrado', '6300', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6301, 6300, ' Coord. de Ciencias de Los Alimentos', '6301', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6302, 6300, ' Coord. de Ciencias Politicas', '6302', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6303, 6300, ' Coord. de Estudio de La Informacion', '6303', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6304, 6300, ' Coord. de Filosofia', '6304', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6305, 6300, ' Coord. de Gerencia de La Energia', '6305', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6306, 6300, ' Coord. de Ingenieria Civil', '6306', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6307, 6300, ' Coord. de Ingenieria Emp. y de Sistemas', '6307', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6308, 6300, ' Coord. de Literatura Latin y Contemp.', '6308', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6309, 6300, ' Coord. de Planif. e Ing. de Recursos Hidraulicos', '6309', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6310, 6300, ' Coord. de Psicologia', '6310', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6311, 6300, ' Coord. de Transporte Urbano', '6311', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6312, 6300, ' Coord. de Ingenieria de Sistemas', '6312', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6313, 6300, ' Coord. Desarrollo del Ambiente', '6313', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6314, 6300, ' Coord. Linguistica Aplicada', '6314', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6315, 6300, ' Coord. Ingenieria Mecanica', '6315', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6316, 6300, ' Coord. de Maestria en Musica', '6316', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6317, 6300, ' Coord. de Estudios Interdisciplinarios', '6317', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6400, 6000, ' Decanato de Investigaciones', '6400', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6401, 6400, ' Fondo del Decanato de Investigaciones', '6401', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6475, 6400, ' Secret. Tec. Admtva. de Inst. de Invest.', '6475', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6500, 6000, ' Division de Fisica y Matematicas', '6500', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6501, 6500, ' Dpto. de Matematicas Puras y Aplicadas', '6501', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6502, 6500, ' Dpto. de Fisica', '6502', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6503, 6500, ' Dpto. de Quimica', '6503', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6504, 6500, ' Dpto. de Mecanica', '6504', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6505, 6500, ' Dpto. de Termodinamica y Fenomenos de Transfe.', '6505', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6506, 6500, ' Dpto. de Electronica y Circuitos', '6506', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6507, 6500, ' Dpto. de Conversion y Transporte de Energia', '6507', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6508, 6500, ' Dpto. de Procesos y Sistemas', '6508', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6509, 6500, ' Dpto. de Ciencia de los Materiales', '6509', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6510, 6500, ' Dpto. Computacion y Tecnologia de la Inform.', '6510', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6511, 6500, ' Dpto. de Ciencias de la Tierra', '6511', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6512, 6500, ' Dpto. de Computo Cientifico y Estadistico', '6512', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6551, 6500, ' Instituto de Energia', '6551', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6552, 6500, ' Instituto de Estudios Regionales y Urbanos', '6552', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6553, 6500, ' Instituto de Investigacion y Desarrollo Industrial', '6553', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6554, 6500, ' Instituto de Metalurgia', '6554', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6600, 6000, ' Unidad de Laboratorios', '6600', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6601, 6600, ' Laboratorio de Mecanica    "A",', '6601', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6602, 6600, ' Laboratorio de Quimica     "B",', '6602', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6603, 6600, ' Laboratorio de Electronica "C",', '6603', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6604, 6600, ' Laboratorio de Fisica      "D",', '6604', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6605, 6600, ' Laboratorio de Procesos de Manufactura "E",', '6605', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6606, 6600, ' Laboratorio de Tecnologia de Informacion "F",', '6606', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6700, 6000, ' Division de Ciencias Sociales y Humanidades', '6700', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6701, 6700, ' Dpto. de Ciencias Sociales', '6701', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6702, 6700, ' Dpto. de Lengua y Literatura', '6702', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6703, 6700, ' Dpto. de Ciencias Economicas y Admtvas.', '6703', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6704, 6700, ' Dpto. de Filosofia', '6704', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6705, 6700, ' Dpto. de Idiomas', '6705', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6706, 6700, ' Dpto. de Ciencias y Tec. del Comportamiento', '6706', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6707, 6700, ' Dpto. de DiseÃ±o Arquitectura y Artes Plast.', '6707', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6708, 6700, ' Dpto. de Planificacion Urbana', '6708', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6751, 6700, ' Inst. de Altos Estudios de America Latina', '6751', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6752, 6700, ' Instituto de Estudios Regionales y Urbanos', '6752', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6753, 6700, ' Bolivarium', '6753', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6800, 6000, ' Division de Ciencias Biologicas', '6800', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6801, 6800, ' Dpto. de Biologia Celular', '6801', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6802, 6800, ' Dpto. de Estudios Ambientales', '6802', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6803, 6800, ' Dpto. de Tecnol. de Proc. Biolog. y Bioqui.', '6803', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6804, 6800, ' Dpto. de Biologia de Organismos', '6804', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6851, 6800, ' Instituto de Tecnol. y Ciencias Marinas', '6851', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6852, 6800, ' Instituto de Recursos Naturales Renovables', '6852', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6900, 6000, ' NO--EXISTE--En--El--Archivo', '6900', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6910, 6900, ' Centro de Investigaciones Educativas', '6910', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6920, 6900, ' Decanato de Extension', '6920', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6930, 6900, ' CAMBIO a la 7040 Dir. Servicios Multimedia', '6930', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6940, 6900, ' Biblioteca', '6940', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6950, 6900, ' Direccion de Desarrollo Profesoral', '6950', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6960, 6900, ' Direccion de Deportes', '6960', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (7000, 0, ' Secretaria', '7000', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (7010, 7000, ' Direccion de Admision y Control de Estudios (DACE)', '7010', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (7020, 7000, ' Direccion de Ingenieria de la Informacion', '7020', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (7030, 7000, ' Centro de Documentacion y Archivo (CENDA)', '7030', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (7040, 7000, ' Direccion de Servicios Multimedia', '7040', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (7044, 7000, ' Unidad de Edumatica', '7044', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (7050, 7000, ' Direccion de Servicios Telematicos', '7050', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8000, 0, ' Nucleo Universitario del Litoral (DIR. GENERAL).', '8000', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8010, 8000, ' Ofic. de Informacion y Secretaria.', '8010', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8020, 8000, ' Ofic. de Relaciones Publicas.', '8020', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8090, 8000, ' Pensionados y Jubilados.', '8090', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8100, 8000, ' Direccion de Administracion.', '8100', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8110, 8100, ' Dpto. de Finanzas', '8110', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8120, 8100, ' Dpto. de Recursos Humanos', '8120', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8121, 8100, ' Unidad de Apoyo Administrativo', '8121', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8130, 8100, ' Dpto. de Registro y Control Admtvo.', '8130', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8140, 8100, ' Dpto. de Ingenieria y Mantenimiento', '8140', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8150, 8100, ' Dpto. de Adquisiciones y Reproduccion', '8150', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8160, 8100, ' Dpto. de Seguridad y Servicios', '8160', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8200, 8000, ' Direccion de Apoyo Infor. Academica', '8200', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8210, 8200, ' Dpto. de Admision y Control Estudios', '8210', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8220, 8200, ' Dpto. de Archivo y Estadistica', '8220', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8230, 8200, ' Coord. de Ingenieria de Informacion', '8230', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8240, 8200, ' Dpto. de Biblioteca', '8240', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8250, 8200, ' Departamento de Multimedia Sede Litoral', '8250', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8260, 8200, ' Dpto. de Operaciones de Servicios Telematicos', '8260', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8300, 8000, ' Coord. de Extension Universitaria', '8300', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8400, 8000, ' Dpto. de Desarrollo Estudiantil', '8400', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8410, 8400, ' Coord. de Tecnologia Industrial', '8410', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8420, 8400, ' Coord. de Tecnologia Administrativa', '8420', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8430, 8400, ' Deportes', '8430', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8440, 8400, ' Unidad de Apoyo Docente', '8440', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8500, 8000, ' Direccion de Programacion Docente', '8500', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8510, 8500, ' Coord. de Tecno. Elect. Electronica', '8510', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8520, 8500, ' Coord. de Formacion General', '8520', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8530, 8500, ' Coord. de Tecno. Mecanica y Mant. Aerona.', '8530', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8540, 8500, ' Coord. de Cursos en Coop. con la Empresa', '8540', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8550, 8500, ' Coord. de Admt. de Turismo y Hoteleria', '8550', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8560, 8500, ' Coord. de Educacion Permanente', '8560', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8570, 8500, ' Coord. de Tec. Adm. Gerenciales y Tribut.', '8570', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8600, 8000, ' Direccion de Admt. de Programas Academicos', '8600', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8610, 8600, ' Unidad de Laboratorios', '8610', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8620, 8600, ' Dpto. de Tecnologia Industrial', '8620', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8630, 8600, ' Dpto. de Tecnologia de Servicio', '8630', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8640, 8600, ' Dpto. Form. General y Ccias. Basicas', '8640', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8650, 8600, ' Centro de Inv. en Tec. Apropiadas', '8650', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (8700, 8000, ' Direccion de Investigacion', '8700', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (9000, 0, ' Consejo Superior', '9000', '', '', NULL, NULL);
INSERT INTO organizacion VALUES (6203, 6200, ' Coord. de Cursos en Cooperac. con la Industria', '6203', 'La CoordinaciÃ³n de CooperaciÃ³n TÃ©cnica (CCT) es la unidad encargada de planificar, supervisar, asesorar y controlar el Programa de PasantÃ­as Empresariales que ofrece a sus estudiantes la Universidad SimÃ³n BolÃ­var.', '', NULL, NULL);
INSERT INTO organizacion VALUES (1, 0, 'USB', '1', 'Todas las unidades de la Universidad Simón Bolívar.', 'Unidad creada para realizar encuestas de carácter global.', NULL, NULL);


--
-- Name: organizacion_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('organizacion_id_seq', 1, true);


--
-- Data for Name: persona; Type: TABLE DATA; Schema: public; Owner: root
--

INSERT INTO persona VALUES (0, 0, 'Sin asignar', '', '', ' ', '', '', '', '', NULL, true, '01', '0', NULL);
INSERT INTO persona VALUES (34, 2, 'Pablo', 'Hernandez', '17972062', 'M', '', '3000', '', '', 'pablo.hernandez.borges@gmail.com', true, '01', '0', 2);
INSERT INTO persona VALUES (36, 2, 'Madeleine', 'Ustariz', '12001223', 'F', '', '3000', NULL, NULL, 'mustariz@usb.ve', true, NULL, NULL, 2);
INSERT INTO persona VALUES (35, 2, 'Carmen Alicia', 'Hernandez', '3812692', 'F', '', '3000', NULL, NULL, 'cahernan@usb.ve', true, NULL, '0', 3);


--
-- Data for Name: persona_cargo; Type: TABLE DATA; Schema: public; Owner: root
--

INSERT INTO persona_cargo VALUES (34, 2, false, '11-02-2015', '26-02-2015', '');
INSERT INTO persona_cargo VALUES (34, 2, true, '02-02-2014', NULL, '');
INSERT INTO persona_cargo VALUES (36, 4, false, '24-02-2015', '26-02-2015', '');
INSERT INTO persona_cargo VALUES (36, 4, true, '03-02-2014', NULL, '');
INSERT INTO persona_cargo VALUES (35, 102, true, '01-02-2014', NULL, '');


--
-- Data for Name: persona_encuesta; Type: TABLE DATA; Schema: public; Owner: root
--

INSERT INTO persona_encuesta VALUES (47, 442346, 'dbf9vpmaw6vnh45', 27, 100, 2, 3000, 'autoevaluacion', 34, 34, 'Pendiente', true, '27/03/2015.12:53', '127.0.0.1', 'sin realizar');
INSERT INTO persona_encuesta VALUES (47, 442346, 'fuu896us3zgybmb', 28, 100, 2, 3000, 'evaluador', 35, 34, 'Pendiente', true, '27/03/2015.12:53', '127.0.0.1', 'sin realizar');
INSERT INTO persona_encuesta VALUES (47, 442346, 'rhywu249jhxtjxp', 29, 100, 4, 3000, 'autoevaluacion', 36, 36, 'Pendiente', true, '27/03/2015.12:53', '127.0.0.1', 'sin realizar');
INSERT INTO persona_encuesta VALUES (47, 442346, '6sue49efkikvfet', 30, 100, 4, 3000, 'evaluador', 34, 36, 'Pendiente', true, '27/03/2015.12:53', '127.0.0.1', 'sin realizar');


--
-- Data for Name: persona_evaluador; Type: TABLE DATA; Schema: public; Owner: root
--

INSERT INTO persona_evaluador VALUES (36, 34, true, '24-09-2014', NULL, '');
INSERT INTO persona_evaluador VALUES (34, 35, true, '11-09-2014', '', '');


--
-- Name: persona_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('persona_id_seq', 36, true);


--
-- Data for Name: persona_supervisor; Type: TABLE DATA; Schema: public; Owner: root
--

INSERT INTO persona_supervisor VALUES (34, 35, true, '11-02-2015', NULL, '');
INSERT INTO persona_supervisor VALUES (36, 35, true, '24-02-2015', NULL, '');


--
-- Data for Name: pregunta; Type: TABLE DATA; Schema: public; Owner: root
--

INSERT INTO pregunta VALUES (1021, 3, 442346, 'competencia', '', NULL);
INSERT INTO pregunta VALUES (1022, 0, 442346, 'competencia', 'Atencion al cliente', 3);
INSERT INTO pregunta VALUES (1023, 1, 442346, 'competencia', 'auto control', 3);
INSERT INTO pregunta VALUES (1024, 2, 442346, 'competencia', 'habilidades comunicacionales', 3);
INSERT INTO pregunta VALUES (1025, 3, 442346, 'competencia', 'manejo de la informacion', 3);


--
-- Name: pregunta_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('pregunta_id_seq', 1025, true);


--
-- Data for Name: pregunta_peso; Type: TABLE DATA; Schema: public; Owner: root
--



--
-- Data for Name: respuesta; Type: TABLE DATA; Schema: public; Owner: root
--



--
-- Data for Name: supervisor_encuesta; Type: TABLE DATA; Schema: public; Owner: root
--



--
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: root
--



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
    ADD CONSTRAINT encuesta_id_fam_fkey FOREIGN KEY (id_fam) REFERENCES familia_cargo(id) ON UPDATE CASCADE ON DELETE CASCADE;


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
-- Name: persona_cargo_id_car_fkey; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY persona_cargo
    ADD CONSTRAINT persona_cargo_id_car_fkey FOREIGN KEY (id_car) REFERENCES cargo(id) ON DELETE CASCADE;


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
GRANT ALL ON SCHEMA public TO root;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

