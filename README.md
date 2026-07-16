# EmNOVA - Sistema de Gestión de Innovación y Retos (EMCALI)

Este repositorio contiene el código fuente de **EmNOVA** (v0.5), una aplicación web de intranet desarrollada para **EMCALI EICE ESP** (Empresa de Servicios Públicos de Cali, Colombia). Su propósito principal es gestionar y evaluar propuestas de innovación, retos (desafíos) institucionales e ideas presentadas por los colaboradores.

---

## 🛠️ Arquitectura y Patrón de Diseño

El proyecto está diseñado bajo una arquitectura personalizada inspirada en el patrón **MVC (Modelo-Vista-Controlador)** con un esquema de **Front Controller (Controlador Frontal)** para el enrutamiento:

### 1. Sistema de Enrutamiento (`libs/router.php`)
El archivo de configuración de Apache `.htaccess` redirige todas las peticiones a `index.php`, que actúa como el Front Controller e inicializa la clase `router`.
El enrutador tiene dos flujos principales basados en la URL:
- **Flujo de API (`/api`)**:
  - Se procesa cuando la URL es exactamente `api` y el método es `POST`.
  - Recibe tres parámetros en la petición: `objeto` (el controlador), `metodo` (la función a ejecutar) y `datos` (los parámetros necesarios).
  - Carga dinámicamente el controlador correspondiente desde la carpeta `controllers/`, ejecuta el método solicitado y responde con una representación JSON formateada (`json_encode` con la bandera `JSON_NUMERIC_CHECK`).
- **Flujo de Vistas (Páginas HTML/PHP)**:
  - Resuelve rutas bajo la estructura `views/[carpeta]/[vista].php` basándose en los segmentos de la URL.
  - La URL se descompone en: `/[carpeta]/[vista]/[parametros...]` (por ejemplo, `ideas/misIdeas/`). Si no se definen, por defecto utiliza `main/login`.

### 2. Capa de Base de Datos y CRUD (`libs/database.php` y `libs/baseCrud.php`)
- **`database.php`**: Extiende la clase nativa `mysqli` de PHP. Implementa métodos de abstracción SQL (`select`, `insert`, `update`, `delete`, `cantidad` y `ejecutarConsulta`) que autogeneran consultas SQL a partir de arreglos asociativos y escapan datos para mitigar inyecciones SQL.
- **`baseCrud.php`**: Sirve como clase base para los controladores que gestionan tablas de base de datos directas. Define los métodos heredados para interactuar con la base de datos sin necesidad de duplicar código SQL de inserción o actualización.

---

## 📁 Estructura del Proyecto

A continuación se detalla la estructura física de directorios y su propósito:

```text
emnova/
├── controllers/          # Controladores con la lógica de negocio del servidor
│   ├── archivos.php      # Carga y descarga de archivos PDF en base64
│   ├── correo.php        # Notificaciones por correo electrónico usando PHPMailer
│   ├── criterios.php     # Gestión de criterios de evaluación
│   ├── helpers.php       # Gestión de variables de sesión
│   ├── ideas.php         # Lógica principal de ideas (creación, estados, asignaciones)
│   ├── usuarios.php      # Inicio de sesión e integración con IDM (Intranet)
│   └── ...               # Otros controladores específicos
├── dist/                 # Archivos estáticos del tema principal (AdminLTE)
│   ├── css/              # Estilos personalizados (principal.css) y de AdminLTE
│   └── js/               # Lógica JS principal (funciones.js para llamadas AJAX)
├── libs/                 # Librerías core de la aplicación (Router, Database, BaseCrud)
├── plugins/              # Plugins y dependencias del lado del cliente (jQuery, Bootstrap, etc.)
├── retos/                # Almacenamiento de archivos PDF correspondientes a los Retos
├── vendor/               # Dependencias del servidor administradas por Composer
├── views/                # Vistas organizadas por módulos
│   ├── configuracion/    # Formularios de parametrización (Usuarios, Retos, Tipos, Criterios)
│   ├── ideas/            # Formularios para Nueva Idea, Listar Mis Ideas y Buscar
│   ├── main/             # Login y Perfil de usuario
│   ├── proceso/          # Etapas del flujo de ideas (Reparto, Refinar, Pitch, Calificar)
│   ├── reportes/         # Reportes gráficos (Dashboard) e históricos en Excel
│   ├── header.php        # Encabezado HTML común y barra de navegación
│   └── footer.php        # Pie de página y generación del menú dinámico según rol
├── .htaccess             # Reglas de reescritura para el enrutador
├── index.php             # Punto de entrada de la aplicación
├── composer.json         # Dependencias PHP (PHPOffice, PHPMailer)
└── package.json          # Dependencias JS (Highcharts, Signature Pad)
```

---

## 🔑 Integración y Autenticación de Usuarios

La autenticación de la aplicación está conectada con el **IDM (Identity Manager)** de la Intranet de EMCALI mediante una petición cURL en el controlador `usuarios.php`:
- Endpoint de autenticación: `https://serviciosapppdn.emcali.com.co:5006/users/auth`
- Si las credenciales son válidas, se crea una sesión de PHP y se asocia el rol del usuario (`Administrador`, `Gestor`, `Evaluador` o `Trabajador`).
- El menú lateral en `views/footer.php` se construye dinámicamente según el rol almacenado en la sesión:
  - **Administrador**: Acceso completo, configuración global, retos, ideas, distribución (reparto), refinación, pitch, calificación y reportes.
  - **Gestor**: Acceso a ideas, refinación, pitch, calificación.
  - **Evaluador**: Acceso a retos, ideas, calificación.
  - **Trabajador (Rol general)**: Acceso únicamente a retos e ideas propias.

---

## 📈 Lógica del Proceso de Innovación

Las ideas siguen una máquina de estados definida en el sistema:
1. **Registro**: Un colaborador registra una idea asociada a un reto o de forma libre.
2. **Reparto (Estado 1)**: La administración asigna un Gestor a la idea.
3. **Refinar/Viabilizar (Estado 2)**: El gestor valida la viabilidad técnica y conceptual de la idea.
4. **Preparar Pitch (Estado 3)**: Se programa la fecha y lugar de sustentación (Pitch).
5. **Calificar (Estado 4)**: Evaluadores califican la propuesta basándose en un conjunto de criterios parametrizados que deben sumar exactamente el 100%.
6. **Prototipo (Estado 5)** / **Etapa Proyecto (Estado 6)** / **Banco de ideas (Estado 7)**.

---

## 📦 Dependencias y Librerías Utilizadas

El sistema integra componentes modernos y robustos para proporcionar una experiencia de usuario fluida:

### Backend (PHP / Composer)
- **`phpmailer/phpmailer`**: Encargado de enviar correos electrónicos de confirmación mediante el relay interno de EMCALI (`relay.emcali.com.co:25`).
- **`phpoffice/phpspreadsheet`**: Utilizado para la generación de reportes y exportación de datos en formato Excel (.xlsx).

### Frontend (CSS, JS y NPM)
- **AdminLTE v3 (Bootstrap 4)**: Plantilla base autoadaptable para la interfaz administrativa.
- **jQuery**: Manipulación del DOM y realización de peticiones AJAX asíncronas centralizadas en `funciones.js` (`enviarPeticion`).
- **Highcharts**: Renderizado de gráficos dinámicos interactivos en la sección de Dashboard (`views/reportes/dashboard.php`).
- **Signature Pad**: Utilizado para capturar firmas digitales en los procesos de la aplicación.
- **DataTables**: Plugin de jQuery para visualización de tablas dinámicas con paginación, búsqueda en tiempo real y exportación de datos.
- **SweetAlert2 & Toastr**: Feedback visual elegante para notificaciones y alertas de error/éxito.