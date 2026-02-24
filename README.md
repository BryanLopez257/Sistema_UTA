# Sistema UTA

Sistema de gestión académica para la Universidad Técnica de Ambato (UTA). Plataforma completa para administración de estudiantes, cursos, matrículas y generación de reportes.

## 📋 Características

- 👥 **Gestión de Estudiantes**: Registro, edición y eliminación de estudiantes
- 📚 **Administración de Cursos**: Crear y gestionar cursos académicos
- 📝 **Control de Matrículas**: Registro de inscripciones de estudiantes en cursos
- 📊 **Reportes**: Generación de reportes en PDF por estudiante y por curso
- 🔐 **Autenticación**: Sistema de login seguro para usuarios
- 🎨 **Interfaz Moderna**: Diseño responsive con jQuery EasyUI

## 🚀 Requisitos

- PHP 7.0 o superior
- MySQL/MariaDB
- XAMPP (incluye Apache y MySQL)
- Navegador web moderno

## 📦 Tecnologías Utilizadas

- **Backend**: PHP
- **Base de Datos**: MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Frameworks/Librerías**:
  - jQuery EasyUI 1.11.3 - UI Components
  - FPDF - Generación de PDFs
  - PHPJasperXML - Reportes dinámicos
  - TCPDF - Generación avanzada de PDFs

## 🔧 Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/BryanLopez257/Sistema_UTA.git
cd Sistema_UTA
```

### 2. Configurar XAMPP
```bash
# Copiar la carpeta del proyecto a htdocs
cp -r Sistema_UTA C:\xampp\htdocs\
```

### 3. Crear la base de datos
- Abre phpMyAdmin: `http://localhost/phpmyadmin`
- Crea una nueva base de datos llamada `utacuarto1`
- Importa el archivo `utacuarto1.sql`

### 4. Configurar la conexión
Verifica el archivo `models/conexion.php` y asegúrate de que los parámetros de conexión sean correctos:

```php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$basedatos = "utacuarto1";
```

### 5. Acceder a la aplicación
Abre tu navegador y ve a: `http://localhost/Sistema_UTA/`

## 📁 Estructura del Proyecto

```
Sistema_UTA/
├── index.php                    # Archivo principal
├── controllers/
│   └── controller.php           # Lógica de controladores
├── models/
│   ├── conexion.php             # Conexión a base de datos
│   ├── model.php                # Modelo base
│   ├── usuarios.php             # Gestión de usuarios
│   ├── cursos_crud.php          # CRUD de cursos
│   ├── matriculas_crud.php      # CRUD de matrículas
│   ├── guardar.php              # Guardar datos
│   ├── editar.php               # Editar registros
│   ├── eliminar.php             # Eliminar registros
│   ├── select.php               # Consultas
│   └── combo_data.php           # Datos para combos
├── views/
│   ├── template.php             # Plantilla base
│   ├── login.php                # Página de login
│   ├── inicio_simple.php         # Página de inicio
│   ├── servicios_simple.php      # Servicios
│   ├── contactanos_simple.php    # Contacto
│   ├── nosotros_simple.php       # Información
│   └── salir.php                # Logout
├── css/
│   ├── style.css                # Estilos personalizados
│   ├── banner-png.css           # Estilos del banner
│   └── uta-theme.css            # Tema UTA
├── fpdf/                        # Librería FPDF
├── jquery-easyui-1.11.3/        # Componentes jQuery EasyUI
├── phpjasperxml-master/         # Generador de reportes
├── reporteEstudiante.php        # Reporte de estudiantes
├── reporteCursoFpdf.php         # Reporte de cursos
├── reporteEstXCedulaFpdf.php    # Reporte por cédula
└── utacuarto1.sql              # Script de base de datos

```

## 🗄️ Base de Datos

El archivo `utacuarto1.sql` contiene todas las tablas necesarias:
- **usuarios**: Información de usuarios del sistema
- **estudiantes**: Datos de estudiantes
- **cursos**: Catálogo de cursos
- **matriculas**: Registros de inscripciones

## 🔐 Credenciales por Defecto

Después de importar la base de datos, puedes usar:
- **Usuario**: admin
- **Contraseña**: admin123

⚠️ **Importante**: Cambia estas credenciales en producción.

## 📊 Generación de Reportes

El sistema genera reportes en PDF de dos formas:

### 1. Reporte por Estudiante
```
http://localhost/Sistema_UTA/reporteEstudiante.php?id=1
```

### 2. Reporte por Curso
```
http://localhost/Sistema_UTA/reporteCursoFpdf.php?id=1
```

### 3. Reporte por Cédula
```
http://localhost/Sistema_UTA/reporteEstXCedulaFpdf.php?cedula=123456789
```

## 🎯 Funcionalidades Principales

### Módulo de Estudiantes
- ✅ Crear nuevo estudiante
- ✅ Ver lista de estudiantes
- ✅ Editar información
- ✅ Eliminar estudiante
- ✅ Buscar por cédula

### Módulo de Cursos
- ✅ Crear nuevo curso
- ✅ Ver catálogo de cursos
- ✅ Editar detalles del curso
- ✅ Eliminar curso
- ✅ Visualizar estudiantes inscritos

### Módulo de Matrículas
- ✅ Inscribir estudiante en curso
- ✅ Ver matrículas activas
- ✅ Editar matrícula
- ✅ Cancelar inscripción
- ✅ Generar reportes de inscripción

## 🐛 Solución de Problemas

### Problema: "No se puede conectar a la base de datos"
**Solución**: Verifica que:
1. MySQL esté iniciado en XAMPP
2. Los parámetros en `models/conexion.php` sean correctos
3. La base de datos `utacuarto1` exista

### Problema: "Error 404 - Página no encontrada"
**Solución**:
1. Asegúrate de que el archivo está en `C:\xampp\htdocs\Sistema_UTA\`
2. Reinicia Apache desde el panel de XAMPP

### Problema: "Error en la carga de estilos o scripts"
**Solución**:
1. Limpia el caché del navegador (Ctrl + F5)
2. Verifica las rutas en los includes CSS y JS

## 📝 Licencia

Este proyecto es de uso interno para la Universidad Técnica de Ambato.

## 👤 Autor

- **Bryan López** - Desarrollo inicial
- GitHub: [@BryanLopez257](https://github.com/BryanLopez257)

## 🤝 Contribuciones

Las contribuciones son bienvenidas. Para cambios mayores, abre un issue primero para discutir qué te gustaría cambiar.

## 📞 Soporte

Para reportar bugs o solicitar nuevas características, abre un issue en el repositorio.

---

**Última actualización**: 24 de febrero de 2026
