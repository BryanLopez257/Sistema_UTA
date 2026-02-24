<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nosotros - Gestión Académica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        .section-header { border-bottom: 2px solid #901B21; padding-bottom: 10px; margin-bottom: 20px; color: #901B21; }
        .btn-action { width: 35px; height: 35px; padding: 0; line-height: 35px; text-align: center; }
    </style>
</head>
<body>
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <h2 class="text-center mb-4">🏛️ Nosotros - Universidad Técnica de Ambato</h2>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h4 class="text-primary">Historia</h4>
                    <p>
                        La Universidad Técnica de Ambato fue creada el 18 de abril de 1969, como una institución de educación superior
                        comprometida con la formación de profesionales de excelencia y el desarrollo de la región central del Ecuador.
                    </p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title text-primary">
                                <i class="fas fa-bullseye me-2"></i>Misión
                            </h5>
                            <p class="card-text">
                                Formar profesionales líderes competentes, con visión humanística y pensamiento crítico,
                                a través de la docencia, la investigación y la vinculación, que contribuyan al desarrollo
                                del país y la sociedad.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title text-success">
                                <i class="fas fa-eye me-2"></i>Visión
                            </h5>
                            <p class="card-text">
                                Ser una universidad acreditada, socialmente responsable, referente en la educación superior,
                                en la formación de talento humano, en la investigación, innovación y vinculación con la sociedad.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
                <?php if(isset($_SESSION['validarIngreso']) && $_SESSION['validarIngreso'] == 'ok'): ?>
                    <div class="card bg-light border-info shadow-sm mb-4">
                        <div class="card-body py-2 px-3 d-flex align-items-center">
                            <div class="me-3"><i class="fas fa-user-circle fa-3x text-info"></i></div>
                            <div class="flex-grow-1">
                                <h6 class="card-title text-dark fw-bold mb-1">
                                    <?php echo $_SESSION['nombre_real'] ?? $_SESSION['usuario']; ?>
                                </h6>
                                <div class="small text-muted" style="line-height: 1.2;">
                                    <span class="badge bg-primary mb-1"><?php echo ucfirst($_SESSION['privilegio'] ?? 'Invitado'); ?></span><br>
                                    <i class="fas fa-clock me-1"></i>
                                    <?php echo empty($_SESSION['ultima_conexion']) ? "Primer ingreso" : date("d/m/Y H:i", strtotime($_SESSION['ultima_conexion'])); ?>
                                </div>
                            </div>
                            <div class="ms-3 border-start ps-3">
                                <a href="index.php?action=salir" class="btn btn-outline-danger btn-sm"><i class="fas fa-sign-out-alt"></i> Salir</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <hr class="my-5">

        <h3 class="section-header"><i class="fas fa-users"></i> Gestión de Estudiantes</h3>
        
        <div class="mb-3 d-flex flex-wrap align-items-center bg-light p-3 rounded shadow-sm">
            <?php if(isset($_SESSION['privilegio']) && strtolower($_SESSION['privilegio']) == 'secretaria'): ?>
                <button type="button" class="btn btn-success me-3 mb-2" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                    <i class="fas fa-plus-circle me-2"></i> Nuevo Estudiante
                </button>
            <?php endif; ?>
            
            <a href="reporteEstudiante.php" class="btn btn-primary me-2 mb-2" target="_blank">
                <i class="fas fa-file-pdf"></i> Reporte General
            </a>
            
            <button class="btn btn-outline-primary me-2 mb-2" data-bs-toggle="modal" data-bs-target="#reporteFpdfCedulaModal">
                <i class="fas fa-search"></i> Reporte Cédula
            </button>
            
            <button class="btn btn-outline-dark mb-2" data-bs-toggle="modal" data-bs-target="#reporteCursoModal" onclick="cargarComboReporteCurso()">
                <i class="fas fa-list-alt"></i> Reporte Curso
            </button>
        </div>

        <div class="table-responsive mb-5">
            <table class="table table-bordered table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Cédula</th><th>Nombre</th><th>Apellido</th><th>Dirección</th><th>Teléfono</th><th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "models/conexion.php";
                    $_GET['formato'] = 'html';
                    include "models/select.php"; 
                    unset($_GET['formato']);
                    ?>
                </tbody>
            </table>
        </div>

        <h3 class="section-header"><i class="fas fa-book"></i> Gestión de Cursos</h3>
        
        <div class="mb-3 bg-light p-3 rounded shadow-sm">
            <?php if(isset($_SESSION['privilegio']) && strtolower($_SESSION['privilegio']) == 'secretaria'): ?>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCurso" onclick="limpiarModalCurso()">
                    <i class="fas fa-plus-circle"></i> Nuevo Curso
                </button>
            <?php else: ?>
                <span class="text-muted"><i class="fas fa-lock"></i> Solo lectura</span>
            <?php endif; ?>
        </div>

        <div class="table-responsive mb-5">
            <table class="table table-bordered table-striped" id="tablaCursos">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th>ID</th><th>Nombre Curso</th><th>Descripción/Carrera</th><th>Título</th>
                        <?php if(isset($_SESSION['privilegio']) && strtolower($_SESSION['privilegio']) == 'secretaria') echo '<th>Acciones</th>'; ?>
                    </tr>
                </thead>
                <tbody id="tbodyCursos"></tbody>
            </table>
        </div>

        <h3 class="section-header"><i class="fas fa-clipboard-list"></i> Gestión de Inscripciones</h3>
        
        <div class="mb-3 bg-light p-3 rounded shadow-sm">
            <?php if(isset($_SESSION['privilegio']) && strtolower($_SESSION['privilegio']) == 'secretaria'): ?>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalMatricula" onclick="cargarCombos()">
                    <i class="fas fa-plus-circle"></i> Nueva Inscripción
                </button>
            <?php else: ?>
                <span class="text-muted"><i class="fas fa-lock"></i> Solo lectura</span>
            <?php endif; ?>
        </div>

        <div class="table-responsive mb-5">
            <table class="table table-bordered table-striped" id="tablaMatriculas">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th>ID</th><th>Curso</th><th>Estudiante</th>
                        <?php if(isset($_SESSION['privilegio']) && strtolower($_SESSION['privilegio']) == 'secretaria') echo '<th>Acciones</th>'; ?>
                    </tr>
                </thead>
                <tbody id="tbodyMatriculas"></tbody>
            </table>
        </div>

    </div> <div class="modal fade" id="addStudentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Nuevo Estudiante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addStudentForm">
                        <div class="mb-3"><label>Cédula:</label><input type="text" class="form-control" name="cedula" required></div>
                        <div class="mb-3"><label>Nombre:</label><input type="text" class="form-control" name="nombre" required></div>
                        <div class="mb-3"><label>Apellido:</label><input type="text" class="form-control" name="apellido" required></div>
                        <div class="mb-3"><label>Dirección:</label><input type="text" class="form-control" name="direccion"></div>
                        <div class="mb-3"><label>Teléfono:</label><input type="text" class="form-control" name="telefono"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarEstudiante()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editStudentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Editar Estudiante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editStudentForm">
                        <input type="hidden" id="editCedulaOriginal" name="cedula">
                        <div class="mb-3"><label>Cédula:</label><input type="text" class="form-control" id="editCedulaDisplay" disabled></div>
                        <div class="mb-3"><label>Nombre:</label><input type="text" class="form-control" id="editNombre" name="nombre" required></div>
                        <div class="mb-3"><label>Apellido:</label><input type="text" class="form-control" id="editApellido" name="apellido" required></div>
                        <div class="mb-3"><label>Dirección:</label><input type="text" class="form-control" id="editDireccion" name="direccion"></div>
                        <div class="mb-3"><label>Teléfono:</label><input type="text" class="form-control" id="editTelefono" name="telefono"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="actualizarEstudiante()">Actualizar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCurso" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="tituloModalCurso">Gestión de Curso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formCurso">
                        <input type="hidden" name="id_cur" id="id_cur">
                        <input type="hidden" name="accion" id="accionCurso">
                        <div class="mb-3"><label>Nombre Curso:</label><input type="text" class="form-control" name="nom_cur" id="nom_cur" required></div>
                        <div class="mb-3"><label>Descripción/Carrera:</label><input type="text" class="form-control" name="des_cur" id="des_cur" required></div>
                        <div class="mb-3"><label>Título a Otorgar:</label><input type="text" class="form-control" name="tit_oto" id="tit_oto" required></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="guardarCurso()">Guardar Curso</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalMatricula" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Nueva Inscripción</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formMatricula">
                        <input type="hidden" name="accion" value="inscribir">
                        <div class="mb-3">
                            <label>Estudiante:</label>
                            <select class="form-select" name="id_est_per" id="selectEstudiantes" required></select>
                        </div>
                        <div class="mb-3">
                            <label>Curso:</label>
                            <select class="form-select" name="id_cur_per" id="selectCursos" required></select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" onclick="guardarMatricula()">Inscribir</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reporteFpdfCedulaModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reporte por Cédula</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" id="cedulaFpdf" placeholder="Ingrese Cédula">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="generarReporteCedula()">Generar PDF</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reporteCursoModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Reporte de Nómina por Curso</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Seleccione el Curso:</label>
                        <select class="form-select" id="selectCursoReporte">
                            <option value="">Cargando...</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" onclick="generarReporteCursoPDF()">
                        <i class="fas fa-print"></i> Generar Nómina
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            cargarCursos();
            cargarMatriculas();
            
            // Listeners para botones de estudiantes
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function() { abrirEditarEstudiante(this); });
            });
            
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() { eliminarEstudiante(this.dataset.estcedula); });
            });
        });

        // === ESTUDIANTES ===
        function guardarEstudiante() {
            const form = document.getElementById('addStudentForm');
            const formData = new FormData(form);
            fetch('models/guardar.php', {method:'POST', body:formData})
            .then(r => r.text()).then(msg => { alert(msg); location.reload(); });
        }

        function abrirEditarEstudiante(btn) {
            const row = btn.closest('tr');
            document.getElementById('editCedulaOriginal').value = btn.dataset.estcedula;
            document.getElementById('editCedulaDisplay').value = btn.dataset.estcedula;
            document.getElementById('editNombre').value = row.cells[1].innerText;
            document.getElementById('editApellido').value = row.cells[2].innerText;
            document.getElementById('editDireccion').value = row.cells[3].innerText;
            document.getElementById('editTelefono').value = row.cells[4].innerText;
            new bootstrap.Modal(document.getElementById('editStudentModal')).show();
        }

        function actualizarEstudiante() {
            const form = document.getElementById('editStudentForm');
            const formData = new FormData(form);
            formData.append('estcedula', document.getElementById('editCedulaOriginal').value);
            fetch('models/editar.php', {method:'POST', body:formData})
            .then(r => r.text()).then(msg => { alert(msg); location.reload(); });
        }

        function eliminarEstudiante(cedula) {
            if(confirm('¿Eliminar estudiante?')) {
                const fd = new FormData();
                fd.append('estcedula', cedula);
                fetch('models/eliminar.php', {method:'POST', body:fd})
                .then(r => r.text()).then(msg => { alert(msg); location.reload(); });
            }
        }

        // === CURSOS ===
        function cargarCursos() {
            fetch('models/cursos_crud.php?accion=listar')
            .then(r => r.json())
            .then(data => {
                let html = '';
                const esSecretaria = "<?php echo strtolower($_SESSION['privilegio']??''); ?>" == 'secretaria';
                data.forEach(c => {
                    html += `<tr>
                        <td>${c.id_cur}</td>
                        <td>${c.nom_cur}</td>
                        <td>${c.des_cur}</td>
                        <td>${c.tit_oto}</td>
                        ${esSecretaria ? `<td>
                            <button class="btn btn-warning btn-sm" onclick="editarCurso(${c.id_cur}, '${c.nom_cur}', '${c.des_cur}', '${c.tit_oto}')"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="eliminarCurso(${c.id_cur})"><i class="fas fa-trash"></i></button>
                        </td>` : ''}
                    </tr>`;
                });
                document.getElementById('tbodyCursos').innerHTML = html;
            });
        }

        function limpiarModalCurso() {
            document.getElementById('formCurso').reset();
            document.getElementById('tituloModalCurso').innerText = "Nuevo Curso";
            document.getElementById('accionCurso').value = "guardar";
        }

        function editarCurso(id, nom, des, tit) {
            document.getElementById('id_cur').value = id;
            document.getElementById('nom_cur').value = nom;
            document.getElementById('des_cur').value = des;
            document.getElementById('tit_oto').value = tit;
            document.getElementById('accionCurso').value = "editar";
            document.getElementById('tituloModalCurso').innerText = "Editar Curso";
            new bootstrap.Modal(document.getElementById('modalCurso')).show();
        }

        function guardarCurso() {
            const form = document.getElementById('formCurso');
            const fd = new FormData(form);
            fetch('models/cursos_crud.php', {method:'POST', body:fd})
            .then(r => r.text()).then(msg => {
                alert(msg);
                cargarCursos();
                bootstrap.Modal.getInstance(document.getElementById('modalCurso')).hide();
            });
        }

        function eliminarCurso(id) {
            if(confirm('¿Eliminar curso? (Si tiene alumnos no se podrá)')) {
                const fd = new FormData();
                fd.append('accion', 'eliminar');
                fd.append('id_cur', id);
                fetch('models/cursos_crud.php', {method:'POST', body:fd})
                .then(r => r.text()).then(msg => {
                    alert(msg);
                    cargarCursos();
                });
            }
        }

        // === INSCRIPCIONES ===
        function cargarMatriculas() {
            fetch('models/matriculas_crud.php?accion=listar')
            .then(r => r.json())
            .then(data => {
                let html = '';
                const esSecretaria = "<?php echo strtolower($_SESSION['privilegio']??''); ?>" == 'secretaria';
                data.forEach(m => {
                    html += `<tr>
                        <td>${m.id_mat}</td>
                        <td>${m.nombre_curso}</td>
                        <td>${m.nombre_estudiante}</td>
                        ${esSecretaria ? `<td>
                            <button class="btn btn-danger btn-sm" onclick="eliminarMatricula(${m.id_mat})"><i class="fas fa-trash"></i> Anular</button>
                        </td>` : ''}
                    </tr>`;
                });
                document.getElementById('tbodyMatriculas').innerHTML = html;
            });
        }

        function cargarCombos() {
            fetch('models/combo_data.php?tipo=estudiantes')
            .then(r => r.json())
            .then(data => {
                let html = '<option value="">Seleccione...</option>';
                data.forEach(item => html += `<option value="${item.id}">${item.text}</option>`);
                document.getElementById('selectEstudiantes').innerHTML = html;
            });

            fetch('models/combo_data.php?tipo=cursos')
            .then(r => r.json())
            .then(data => {
                let html = '<option value="">Seleccione...</option>';
                data.forEach(item => html += `<option value="${item.id}">${item.text}</option>`);
                document.getElementById('selectCursos').innerHTML = html;
            });
        }

        function guardarMatricula() {
            const est = document.getElementById('selectEstudiantes').value;
            const cur = document.getElementById('selectCursos').value;
            if(!est || !cur) { alert("Seleccione estudiante y curso"); return; }

            const form = document.getElementById('formMatricula');
            const fd = new FormData(form);
            fetch('models/matriculas_crud.php', {method:'POST', body:fd})
            .then(r => r.text()).then(msg => {
                if(msg.includes("Error")) alert("❌ " + msg);
                else { alert("✅ " + msg); cargarMatriculas(); bootstrap.Modal.getInstance(document.getElementById('modalMatricula')).hide(); }
            });
        }

        function eliminarMatricula(id) {
            if(confirm('¿Anular esta inscripción?')) {
                const fd = new FormData();
                fd.append('accion', 'eliminar');
                fd.append('id_mat', id);
                fetch('models/matriculas_crud.php', {method:'POST', body:fd})
                .then(r => r.text()).then(msg => {
                    alert(msg);
                    cargarMatriculas();
                });
            }
        }

        // === REPORTES ===
        function generarReporteCedula() {
            const ced = document.getElementById('cedulaFpdf').value;
            if(ced) window.open(`reporteEstXCedulaFpdf.php?cedula=${ced}`, '_blank');
        }

        // ✅ Función para cargar combo en el Modal de Reporte
        function cargarComboReporteCurso() {
            fetch('models/combo_data.php?tipo=cursos')
            .then(r => r.json())
            .then(data => {
                let html = '<option value="">-- Seleccione un Curso --</option>';
                data.forEach(item => html += `<option value="${item.id}">${item.text}</option>`);
                document.getElementById('selectCursoReporte').innerHTML = html;
            });
        }

        // ✅ Función para abrir el PDF del curso seleccionado
        function generarReporteCursoPDF() {
            const idCurso = document.getElementById('selectCursoReporte').value;
            if (idCurso) {
                window.open('reporteCursoFpdf.php?id_curso=' + idCurso, '_blank');
            } else {
                alert("Por favor, seleccione un curso de la lista.");
            }
        }
    </script>
</body>
</html>