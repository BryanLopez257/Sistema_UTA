<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Estudiantes</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/color.css">
    
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
    
    <style>
        /* Corrección de estilos Bootstrap vs EasyUI */
        .panel-header, .panel-body, .datagrid-header, .window-body, .tabs-header { 
            box-sizing: content-box !important; 
        }
        
        /* Estilo para los formularios dentro de los modales */
        #fm, #fmCurso, #fmMat {
            margin: 0;
            padding: 20px 30px;
        }
        
        .fitem {
            margin-bottom: 15px;
        }
        
        .fitem label {
            display: inline-block;
            width: 80px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        /* Forzar que los inputs de EasyUI ocupen el ancho correcto */
        .easyui-textbox, .easyui-combobox {
            width: 300px; /* Ancho fijo para evitar problemas */
            height: 32px;
        }
    </style>
</head>
<body>

    <div class="card bg-light border-info shadow-sm mb-4" style="min-width: 320px;">
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

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h3><i class="fas fa-university text-primary"></i> Gestión Académica</h3>
    </div>

    <div class="easyui-tabs" style="width:100%;height:600px">
        
        <div title="Gestión Estudiantes" style="padding:10px">
            <table id="dg" class="easyui-datagrid" style="width:100%;height:100%"
                    url="models/select.php" toolbar="#toolbar" pagination="true"
                    rownumbers="true" fitColumns="true" singleSelect="true">
                <thead>
                    <tr>
                        <th field="estcedula" width="100">Cédula</th>
                        <th field="estnombre" width="150">Nombre</th>
                        <th field="estapellido" width="150">Apellido</th>
                        <th field="estdireccion" width="200">Dirección</th>
                        <th field="esttelefono" width="100">Teléfono</th>
                    </tr>
                </thead>
            </table>
            
            <div id="toolbar">
                <input id="searchCedula" class="easyui-textbox" style="width:200px" prompt="Buscar por cédula">
                <a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="searchByCedula()">Buscar</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="clearSearch()">Limpiar</a>
                <span class="datagrid-btn-separator" style="display:inline-block;float:none"></span>
                
                <?php if(isset($_SESSION['privilegio']) && strtolower($_SESSION['privilegio']) == 'secretaria'): ?>
                    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo</a>
                    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>
                    <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Eliminar</a>
                <?php endif; ?>
                
                <a href="#" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="reporteFPDF()">PDF</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="reporteFPDFCedula()">PDF Cédula</a>
            </div>
        </div>

        <div title="Gestión Cursos" style="padding:10px">
            <table id="dgCursos" class="easyui-datagrid" style="width:100%;height:100%"
                    url="models/cursos_crud.php?accion=listar" toolbar="#toolbarCursos" pagination="true"
                    rownumbers="true" fitColumns="true" singleSelect="true">
                <thead>
                    <tr>
                        <th field="id_cur" width="50">ID</th>
                        <th field="nom_cur" width="150">Nombre Curso</th>
                        <th field="des_cur" width="200">Descripción / Carrera</th>
                        <th field="tit_oto" width="150">Título a Otorgar</th>
                    </tr>
                </thead>
            </table>

            <div id="toolbarCursos">
                <?php if(isset($_SESSION['privilegio']) && strtolower($_SESSION['privilegio']) == 'secretaria'): ?>
                    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newCurso()">Nuevo Curso</a>
                    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editCurso()">Editar Curso</a>
                    <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyCurso()">Eliminar Curso</a>
                    <span class="datagrid-btn-separator" style="display:inline-block;float:none"></span>
                <?php endif; ?>
                
                <a href="#" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="reporteCursoPDF()">Imprimir Nómina</a>
            </div>
        </div>

        <div title="Inscripciones" style="padding:10px">
            <table id="dgMat" class="easyui-datagrid" style="width:100%;height:100%"
                    url="models/matriculas_crud.php?accion=listar" toolbar="#toolbarMat" pagination="true"
                    rownumbers="true" fitColumns="true" singleSelect="true">
                <thead>
                    <tr>
                        <th field="id_mat" width="50">ID</th>
                        <th field="nombre_curso" width="200">Curso - Carrera</th>
                        <th field="nombre_estudiante" width="250">Estudiante</th>
                    </tr>
                </thead>
            </table>

            <div id="toolbarMat">
                <?php if(isset($_SESSION['privilegio']) && strtolower($_SESSION['privilegio']) == 'secretaria'): ?>
                    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newMatricula()">Nueva Inscripción</a>
                    <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyMatricula()">Anular Inscripción</a>
                <?php else: ?>
                    <span style="padding:5px">Solo lectura</span>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <div id="dlg" class="easyui-dialog" style="width:500px;height:400px;padding:10px" closed="true" buttons="#dlg-buttons">
        <div class="ftitle">Información del Estudiante</div>
        <form id="fm" method="post" novalidate>
            <div class="fitem" id="div-cedula">
                <label>Cédula:</label>
                <input name="estcedula" id="estcedula" class="easyui-textbox" required="true" style="width:300px;">
            </div>
            <div class="fitem">
                <label>Nombre:</label>
                <input name="estnombre" class="easyui-textbox" required="true" style="width:300px;">
            </div>
            <div class="fitem">
                <label>Apellido:</label>
                <input name="estapellido" class="easyui-textbox" required="true" style="width:300px;">
            </div>
            <div class="fitem">
                <label>Dirección:</label>
                <input name="estdireccion" class="easyui-textbox" style="width:300px;">
            </div>
            <div class="fitem">
                <label>Teléfono:</label>
                <input name="esttelefono" class="easyui-textbox" style="width:300px;">
            </div>
            <input type="hidden" name="editCedulaOriginal" id="editCedulaOriginal">
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="#" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Guardar</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
    </div>

    <div id="dlgCurso" class="easyui-dialog" style="width:500px;height:350px;padding:10px" closed="true" buttons="#dlgCurso-buttons">
        <div class="ftitle">Información del Curso</div>
        <form id="fmCurso" method="post" novalidate>
            <div class="fitem">
                <label>Curso:</label>
                <input name="nom_cur" class="easyui-textbox" required="true" style="width:300px;">
            </div>
            <div class="fitem">
                <label>Descripción:</label>
                <input name="des_cur" class="easyui-textbox" required="true" style="width:300px;">
            </div>
            <div class="fitem">
                <label>Título:</label>
                <input name="tit_oto" class="easyui-textbox" required="true" style="width:300px;">
            </div>
            <input type="hidden" name="id_cur">
        </form>
    </div>
    <div id="dlgCurso-buttons">
        <a href="#" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveCurso()" style="width:90px">Guardar</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgCurso').dialog('close')" style="width:90px">Cancelar</a>
    </div>

    <div id="dlgMat" class="easyui-dialog" style="width:500px;height:300px;padding:10px" closed="true" buttons="#dlgMat-buttons">
        <div class="ftitle">Nueva Matrícula</div>
        <form id="fmMat" method="post" novalidate>
            <div class="fitem">
                <label>Estudiante:</label>
                <input id="cbEstudiante" class="easyui-combobox" name="id_est_per" 
                       style="width:300px;"
                       data-options="valueField:'id',textField:'text',url:'models/combo_data.php?tipo=estudiantes',required:true,panelHeight:'200px'">
            </div>
            <div class="fitem">
                <label>Curso:</label>
                <input id="cbCurso" class="easyui-combobox" name="id_cur_per" 
                       style="width:300px;"
                       data-options="valueField:'id',textField:'text',url:'models/combo_data.php?tipo=cursos',required:true,panelHeight:'auto'">
            </div>
        </form>
    </div>
    <div id="dlgMat-buttons">
        <a href="#" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveMatricula()" style="width:90px">Inscribir</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgMat').dialog('close')" style="width:90px">Cancelar</a>
    </div>

    <script type="text/javascript">
        var url;

        // --- LÓGICA ESTUDIANTES ---
        function newUser(){
            $('#dlg').dialog('open').dialog('setTitle','Nuevo Estudiante');
            $('#fm').form('clear');
            $('#div-cedula').show(); $('#estcedula').textbox('readonly', false);
            url = 'models/guardar.php';
        }
        function editUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','Editar Estudiante');
                $('#fm').form('load',row);
                $('#div-cedula').hide(); $('#editCedulaOriginal').val(row.estcedula);
                url = 'models/editar.php';
            } else $.messager.alert('Aviso','Seleccione un estudiante','warning');
        }
        function saveUser(){
            $('#fm').form('submit',{
                url: url,
                onSubmit: function(param){ 
                    param.editCedulaOriginal = $('#editCedulaOriginal').val() || $('#estcedula').textbox('getValue');
                    return $(this).form('validate'); 
                },
                success: function(result){
                    if (!result.toLowerCase().includes('error')){
                        $('#dlg').dialog('close'); $('#dg').datagrid('reload');
                        $.messager.show({title: 'Éxito', msg: 'Guardado correctamente'});
                    } else $.messager.alert('Error', result, 'error');
                }
            });
        }
        function destroyUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirmar','¿Eliminar estudiante? (Solo si no tiene matrículas)',function(r){
                    if (r){
                        $.post('models/eliminar.php',{estcedula:row.estcedula},function(result){
                            if(result.toLowerCase().includes('elimino')) $('#dg').datagrid('reload');
                            else $.messager.alert('Error', result, 'error');
                        },'text');
                    }
                });
            } else $.messager.alert('Aviso','Seleccione estudiante','warning');
        }

        // --- LÓGICA CURSOS ---
        function newCurso(){
            $('#dlgCurso').dialog('open').dialog('setTitle','Nuevo Curso');
            $('#fmCurso').form('clear');
            url = 'models/cursos_crud.php?accion=guardar';
        }
        function editCurso(){
            var row = $('#dgCursos').datagrid('getSelected');
            if (row){
                $('#dlgCurso').dialog('open').dialog('setTitle','Editar Curso');
                $('#fmCurso').form('load',row);
                url = 'models/cursos_crud.php?accion=editar';
            } else $.messager.alert('Aviso','Seleccione un curso','warning');
        }
        function saveCurso(){
            $('#fmCurso').form('submit',{
                url: url,
                onSubmit: function(){ return $(this).form('validate'); },
                success: function(result){
                    if (!result.toLowerCase().includes('error')){
                        $('#dlgCurso').dialog('close'); $('#dgCursos').datagrid('reload');
                        $('#cbCurso').combobox('reload'); 
                        $.messager.show({title: 'Éxito', msg: result});
                    } else $.messager.alert('Error (Trigger)', result, 'error');
                }
            });
        }
        function destroyCurso(){
            var row = $('#dgCursos').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirmar','¿Eliminar este curso? (Solo si no tiene alumnos)',function(r){
                    if (r){
                        $.post('models/cursos_crud.php?accion=eliminar',{id_cur:row.id_cur},function(result){
                            if(!result.toLowerCase().includes('error')) {
                                $('#dgCursos').datagrid('reload');
                                $('#cbCurso').combobox('reload');
                                $.messager.show({title: 'Éxito', msg: result});
                            } else $.messager.alert('Error', result, 'error');
                        });
                    }
                });
            } else $.messager.alert('Aviso','Seleccione un curso','warning');
        }

        // --- LÓGICA INSCRIPCIONES ---
        function newMatricula(){
            $('#dlgMat').dialog('open').dialog('setTitle','Nueva Inscripción');
            $('#fmMat').form('clear');
            $('#cbEstudiante').combobox('reload');
            $('#cbCurso').combobox('reload');
            url = 'models/matriculas_crud.php?accion=inscribir';
        }
        function saveMatricula(){
            $('#fmMat').form('submit',{
                url: url,
                onSubmit: function(){ return $(this).form('validate'); },
                success: function(result){
                    if (!result.toLowerCase().includes('error')){
                        $('#dlgMat').dialog('close'); $('#dgMat').datagrid('reload');
                        $.messager.show({title: 'Éxito', msg: result});
                    } else $.messager.alert('Error (Trigger)', result, 'error');
                }
            });
        }
        function destroyMatricula(){
            var row = $('#dgMat').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirmar','¿Anular esta inscripción?',function(r){
                    if (r){
                        $.post('models/matriculas_crud.php?accion=eliminar',{id_mat:row.id_mat},function(result){
                            if(!result.toLowerCase().includes('error')) $('#dgMat').datagrid('reload');
                            else $.messager.alert('Error', result, 'error');
                        });
                    }
                });
            } else $.messager.alert('Aviso','Seleccione una inscripción','warning');
        }

        // --- REPORTES Y BUSQUEDA ---
        function searchByCedula(){ $('#dg').datagrid('load',{cedula:$('#searchCedula').textbox('getValue')}); }
        function clearSearch(){ $('#searchCedula').textbox('clear'); $('#dg').datagrid('load',{}); }
        function reporteFPDF() { window.open('reporteEstudiante.php', '_blank'); }
        function reporteFPDFCedula() { 
            var row = $('#dg').datagrid('getSelected');
            if(row) window.open('reporteEstXCedulaFpdf.php?cedula='+row.estcedula, '_blank');
            else $.messager.alert('Aviso','Seleccione un estudiante','warning');
        }

        function reporteCursoPDF() {
            var row = $('#dgCursos').datagrid('getSelected');
            if (row) {
                window.open('reporteCursoFpdf.php?id_curso=' + row.id_cur, '_blank');
            } else {
                $.messager.alert('Atención', 'Por favor, selecciona un curso de la lista para imprimir su nómina.', 'info');
            }
        }
    </script>
</body>
</html>