<?php
include 'asesor_navbar.php';

$idAlumno = (int)$_GET['idAlumno'];
$idAsesor = (int)$_GET['idAsesor'];
include 'config/Conn.php';
$queryId = "SELECT correo FROM Asesor WHERE idAsesor = '$idAsesor'";
$resultadoId = $conn->query($queryId);
$resultadoId->data_seek(0);
$filaId = $resultadoId->fetch_assoc();
$mail = $filaId['correo'];
$conn->close();

$where = "WHERE Alumno.idAlumno = $idAlumno";
if (isset($_POST['filtrar'])) {
    if ($_POST['mes']) {
        $where .= " AND MONTH(Asesoria.fecha) = " . $_POST['mes'];
    }    
}

?>

<div class="container">
    <?php
    include 'config/Conn.php';
    $queryId = "SELECT CONCAT(a.nombre,' ', a.apellido) AS nombre FROM Alumno a WHERE idAlumno = '$idAlumno'";
    $resultadoId = $conn->query($queryId);
    $resultadoId->data_seek(0);
    $filaId = $resultadoId->fetch_assoc();
    $nombre = $filaId['nombre'];
    ?>
    <h4 class="display-4 text-center">Historial de asesorías</h4>
    <br>
    <h4 class="text-center">Historial de alumno:<br /><?php echo $nombre;?></h4>
    <br>
    <?php
    $conn->close();
    ?>
    <div class="row">
        <form method="POST">
            
            <div class="row">
                <div class="col-sm-12">
                    <h5>FILTROS</h5>
                </div>
                
                <div class="col-sm-4">
                    
                    <select id="motivoAsesoria" class="form-control" name="mes">
                        <option value="0" selected>Mes</option>
                        <option value="1">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3">Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <button name="filtrar" type="submit" class="btn btn-success">FILTRAR</button>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <h5>ASESORÍAS</h5>
        <div class="table-responsive">
        <table class="table table-striped table-dark table-sm table-bordered" style="table-layout: fixed;">
                <thead>
                    <th scope="col">Fecha</th>
                    <th scope="col">Motivo</th>
                    <th scope="col">Dinámica</th>
                    <th scope="col">Observaciones</th>
                </thead>
                <tbody>
                    <?php
                    include 'config/Conn.php';
                    $query = "SELECT 
                      Asesoria.idAsesoria AS idAsesoria 
                      , Alumno.idAlumno AS id 
                      , CONCAT(Alumno.nombre,' ',Alumno.apellido) AS Alumno
                      , DATE_FORMAT(Asesoria.fecha, '%d-%m-%Y') AS Fecha 
                      , Motivo.motivo AS Motivo
                      , Integrantes.descripcion AS Dinamica 
                      , Asesoria.observaciones AS Observaciones
                  FROM Asesoria 
                  JOIN Alumno on Alumno.idAlumno = Asesoria.idAlumno 
                  JOIN Asesor on Asesor.idAsesor = Asesoria.idAsesor 
                  JOIN Motivo on Motivo.idMotivo = Asesoria.idMotivo 
                  JOIN Integrantes on Integrantes.idIntegrantes = Asesoria.idIntegrantes
                  $where
                  ORDER BY Asesoria.idAsesoria DESC";

                    $resultado = $conn->query($query);
                    if (!$resultado) {
                        echo "ERROR: " . $conn->error;
                    }
                    if (!$resultado->fetch_array()) {
                        echo "<tr><td colspan='5'>AUN NO HAY ASESORIAS REGISTRADAS</td></tr>";
                    } else {

                        $resultado->data_seek(0);

                        while ($fila = $resultado->fetch_assoc()) {
                    ?>
                            <tr>
                                <td class="align-middle text-truncate"><?php echo $fila['Fecha']; ?></td>
                                <td class="align-middle text-truncate"><?php echo $fila['Motivo']; ?></td>
                                <td class="align-middle text-truncate"><?php echo $fila['Dinamica']; ?></td>
                                <td class="align-middle text-truncate"><?php echo $fila['Observaciones']; ?></td>
                            </tr>
                    <?php
                        }
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <div class="col-md-12 text-center">
        <ul class="pagination pagination-lg pager" id="pagination_page"></ul>
        </div>

        <div class="row">
            <button class="btn-b purple-gradient btn-block p-3" onclick="window.location.href='asesor_historial.php?id=<?php echo $idAsesor; ?>'">Regresar</button><br>
        </div>
    </div>
</div>

<script src="paginacion/bootstrap-table-pagination.js"></script>
<script src="paginacion/pagination.js"></script>

</body>
</html>