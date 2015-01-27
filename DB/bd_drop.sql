--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

ALTER TABLE ONLY public.supervisor_encuesta DROP CONSTRAINT supervisor_encuesta_token_ls_eva_fkey;
ALTER TABLE ONLY public.supervisor_encuesta DROP CONSTRAINT supervisor_encuesta_id_sup_fkey;
ALTER TABLE ONLY public.respuesta DROP CONSTRAINT respuesta_token_ls_fkey;
ALTER TABLE ONLY public.respuesta DROP CONSTRAINT respuesta_id_pregunta_fkey;
ALTER TABLE ONLY public.pregunta_peso DROP CONSTRAINT pregunta_peso_id_pregunta_fkey;
ALTER TABLE ONLY public.pregunta_peso DROP CONSTRAINT pregunta_peso_id_encuesta_fkey;
ALTER TABLE ONLY public.pregunta DROP CONSTRAINT pregunta_id_encuesta_ls_fkey;
ALTER TABLE ONLY public.persona_supervisor DROP CONSTRAINT persona_supervisor_id_sup_fkey;
ALTER TABLE ONLY public.persona_supervisor DROP CONSTRAINT persona_supervisor_id_per_fkey;
ALTER TABLE ONLY public.persona_evaluador DROP CONSTRAINT persona_evaluador_id_per_fkey;
ALTER TABLE ONLY public.persona_evaluador DROP CONSTRAINT persona_evaluador_id_eva_fkey;
ALTER TABLE ONLY public.persona_encuesta DROP CONSTRAINT persona_encuesta_periodo_fkey;
ALTER TABLE ONLY public.persona_encuesta DROP CONSTRAINT persona_encuesta_id_unidad_fkey;
ALTER TABLE ONLY public.persona_encuesta DROP CONSTRAINT persona_encuesta_id_evaluado_fkey;
ALTER TABLE ONLY public.persona_encuesta DROP CONSTRAINT persona_encuesta_id_encuestado_fkey;
ALTER TABLE ONLY public.persona_encuesta DROP CONSTRAINT persona_encuesta_id_encuesta_ls_fkey;
ALTER TABLE ONLY public.persona_encuesta DROP CONSTRAINT persona_encuesta_id_encuesta_fkey;
ALTER TABLE ONLY public.persona_encuesta DROP CONSTRAINT persona_encuesta_id_car_fkey;
ALTER TABLE ONLY public.persona_cargo DROP CONSTRAINT persona_cargo_id_per_fkey;
ALTER TABLE ONLY public.persona_cargo DROP CONSTRAINT persona_cargo_id_car_fkey;
ALTER TABLE ONLY public.organizacion DROP CONSTRAINT organizacion_idsup_fkey;
ALTER TABLE ONLY public.notificacion DROP CONSTRAINT notificacion_token_ls_per_fkey;
ALTER TABLE ONLY public.notificacion DROP CONSTRAINT notificacion_id_per_fkey;
ALTER TABLE ONLY public.encuesta_ls DROP CONSTRAINT encuesta_ls_id_fam_fkey;
ALTER TABLE ONLY public.encuesta DROP CONSTRAINT encuesta_id_unidad_fkey;
ALTER TABLE ONLY public.encuesta DROP CONSTRAINT encuesta_id_fam_fkey;
ALTER TABLE ONLY public.encuesta DROP CONSTRAINT encuesta_id_encuesta_ls_fkey;
ALTER TABLE ONLY public.correo DROP CONSTRAINT correo_id_per_fkey;
ALTER TABLE ONLY public.cargo DROP CONSTRAINT cargo_id_fam_fkey;
ALTER TABLE ONLY public.usuario DROP CONSTRAINT usuario_pkey;
ALTER TABLE ONLY public.pregunta DROP CONSTRAINT pregunta_pkey;
ALTER TABLE ONLY public.persona DROP CONSTRAINT persona_pkey;
ALTER TABLE ONLY public.persona_encuesta DROP CONSTRAINT persona_encuesta_pkey;
ALTER TABLE ONLY public.organizacion DROP CONSTRAINT organizacion_pkey;
ALTER TABLE ONLY public.notificacion DROP CONSTRAINT notificacion_pkey;
ALTER TABLE ONLY public.familia_rol DROP CONSTRAINT familia_rol_pkey;
ALTER TABLE ONLY public.familia_cargo DROP CONSTRAINT familia_cargo_pkey;
ALTER TABLE ONLY public.evaluacion DROP CONSTRAINT evaluacion_pkey;
ALTER TABLE ONLY public.error DROP CONSTRAINT error_pkey;
ALTER TABLE ONLY public.encuesta DROP CONSTRAINT encuesta_pkey;
ALTER TABLE ONLY public.encuesta_ls DROP CONSTRAINT encuesta_ls_pkey;
ALTER TABLE ONLY public.cargo DROP CONSTRAINT cargo_pkey;
ALTER TABLE public.usuario ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.persona ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.organizacion ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.familia_rol ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.familia_cargo ALTER COLUMN id DROP DEFAULT;
ALTER TABLE public.error ALTER COLUMN id_error DROP DEFAULT;
ALTER TABLE public.cargo ALTER COLUMN id DROP DEFAULT;
DROP SEQUENCE public.usuario_id_seq;
DROP TABLE public.usuario;
DROP TABLE public.supervisor_encuesta;
DROP TABLE public.respuesta;
DROP TABLE public.pregunta_peso;
DROP TABLE public.pregunta;
DROP SEQUENCE public.pregunta_id_seq;
DROP TABLE public.persona_supervisor;
DROP SEQUENCE public.persona_id_seq;
DROP TABLE public.persona_evaluador;
DROP TABLE public.persona_encuesta;
DROP TABLE public.persona_cargo;
DROP TABLE public.persona;
DROP SEQUENCE public.organizacion_id_seq;
DROP TABLE public.organizacion;
DROP TABLE public.notificacion;
DROP SEQUENCE public.notificacion_id_seq;
DROP SEQUENCE public.familia_rol_id_seq;
DROP TABLE public.familia_rol;
DROP SEQUENCE public.familia_cargo_id_seq;
DROP TABLE public.familia_cargo;
DROP TABLE public.evaluacion;
DROP SEQUENCE public.evaluacion_id_seq;
DROP SEQUENCE public.error_id_error_seq;
DROP TABLE public.error;
DROP TABLE public.encuesta_ls;
DROP TABLE public.encuesta;
DROP SEQUENCE public.encuesta_id_seq;
DROP TABLE public.correo;
DROP SEQUENCE public.cargo_id_seq;
DROP TABLE public.cargo;
DROP EXTENSION plpgsql;
DROP SCHEMA public;
--
-- Name: vernier; Type: COMMENT; Schema: -; Owner: root
--

COMMENT ON DATABASE vernier IS 'Base de datos del sistema vernier';


--
-- Name: public; Type: SCHEMA; Schema: -; Owner: root
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO root;

--
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: root
--

COMMENT ON SCHEMA public IS 'standard public schema';


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
    funciones text
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
    observacion text
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
    email character varying(50)
);


ALTER TABLE public.persona OWNER TO root;

--
-- Name: TABLE persona; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON TABLE persona IS 'Tabla del personal registrado en el sistema';


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
    ip text
);


ALTER TABLE public.persona_encuesta OWNER TO root;

--
-- Name: TABLE persona_encuesta; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON TABLE persona_encuesta IS 'Tabla de encuestas del personal evaluado';


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
    ip text
);


ALTER TABLE public.supervisor_encuesta OWNER TO root;

--
-- Name: TABLE supervisor_encuesta; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON TABLE supervisor_encuesta IS 'Tabla de evaluaciones supervisadas';


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
-- Name: public; Type: ACL; Schema: -; Owner: root
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM root;
GRANT ALL ON SCHEMA public TO root;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

