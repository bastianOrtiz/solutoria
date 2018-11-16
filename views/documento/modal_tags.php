<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Lista de etiquetas de autocompletado</h4>
      </div>
      
        <div class="modal-body">
            <strong>DATOS DE LA EMPRESA</strong>
            <table class="table table-striped table-bordered">
              <tbody>
                  <tr>
                      <td>
                          ETIQUETA
                      </td>
                      <td>
                          DESCRIPCION
                      </td>
                  </tr>
                  <tr>
                      <td><code>{{ empresa.razonSocial }}</code><a href="#" data-dismiss="modal" data-toggle="tooltip" title="Insertar etiqueta al final del texto" class="btnAddTag btn btn-xs" style="font-size: 24px"><i class="fa fa-external-link-square" style="transform: rotate(180deg);"></i></a> 
                      </td>
                      <td>
                          Razon social de la empresa en que pertenece el trabajador.
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <code>{{ empresa.rut }}</code><a href="#" data-dismiss="modal" data-toggle="tooltip" title="Insertar etiqueta al final del texto" class="btnAddTag btn btn-xs" style="font-size: 24px"><i class="fa fa-external-link-square" style="transform: rotate(180deg);"></i></a>
                      </td>
                      <td>
                          Rut de la empresa en que pertenece el trabajador.
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <code>{{ empresa.direccion }}</code><a href="#" data-dismiss="modal" data-toggle="tooltip" title="Insertar etiqueta al final del texto" class="btnAddTag btn btn-xs" style="font-size: 24px"><i class="fa fa-external-link-square" style="transform: rotate(180deg);"></i></a>
                      </td>
                      <td>
                          Direccion de la empresa
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <code>{{ empresa.ciudad }}</code><a href="#" data-dismiss="modal" data-toggle="tooltip" title="Insertar etiqueta al final del texto" class="btnAddTag btn btn-xs" style="font-size: 24px"><i class="fa fa-external-link-square" style="transform: rotate(180deg);"></i></a>
                      </td>
                      <td>
                          Ciudad de la empresa.
                      </td>
                  </tr>
              </tbody>
            </table>
            <p>&nbsp;</p>
            <strong>DATOS DEL TRABAJADOR</strong>
            <table class="table table-striped table-bordered">
              <tbody>
                  <tr>
                      <td>
                          ETIQUETA
                      </td>
                      <td>
                          DESCRIPCION
                      </td>
                  </tr>
                  <tr>
                      <td>
                            <code>{{ trabajador.nombres }}</code><a href="#" data-dismiss="modal" data-toggle="tooltip" title="Insertar etiqueta al final del texto" class="btnAddTag btn btn-xs" style="font-size: 24px"><i class="fa fa-external-link-square" style="transform: rotate(180deg);"></i></a><br>
                            <code>{{ trabajador.apellidoPaterno }}</code><a href="#" data-dismiss="modal" data-toggle="tooltip" title="Insertar etiqueta al final del texto" class="btnAddTag btn btn-xs" style="font-size: 24px"><i class="fa fa-external-link-square" style="transform: rotate(180deg);"></i></a><br>
                            <code>{{ trabajador.apellidoMaterno }}</code><a href="#" data-dismiss="modal" data-toggle="tooltip" title="Insertar etiqueta al final del texto" class="btnAddTag btn btn-xs" style="font-size: 24px"><i class="fa fa-external-link-square" style="transform: rotate(180deg);"></i></a>
                      </td>
                      <td>
                          Variantes del Nombre del trabajador (nombre, apellido Paterno, apellido Materno) 
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <code>{{ trabajador.rut }}</code><a href="#" data-dismiss="modal" data-toggle="tooltip" title="Insertar etiqueta al final del texto" class="btnAddTag btn btn-xs" style="font-size: 24px"><i class="fa fa-external-link-square" style="transform: rotate(180deg);"></i></a>
                      </td>
                      <td>
                          Rut del trabajador.
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <code>{{ trabajador.direccion }}</code><a href="#" data-dismiss="modal" data-toggle="tooltip" title="Insertar etiqueta al final del texto" class="btnAddTag btn btn-xs" style="font-size: 24px"><i class="fa fa-external-link-square" style="transform: rotate(180deg);"></i></a>
                      </td>
                      <td>
                          Dirección del trabajador.
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <code>{{ trabajador.ciudad }}</code><a href="#" data-dismiss="modal" data-toggle="tooltip" title="Insertar etiqueta al final del texto" class="btnAddTag btn btn-xs" style="font-size: 24px"><i class="fa fa-external-link-square" style="transform: rotate(180deg);"></i></a>
                      </td>
                      <td>
                          Ciudad del trabajador.
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <code>{{ trabajador.idNacionalidad }}</code><a href="#" data-dismiss="modal" data-toggle="tooltip" title="Insertar etiqueta al final del texto" class="btnAddTag btn btn-xs" style="font-size: 24px"><i class="fa fa-external-link-square" style="transform: rotate(180deg);"></i></a>
                      </td>
                      <td>
                          Nacionalidad del trabajador
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <code>{{ trabajador.fechaNacimiento }}</code><a href="#" data-dismiss="modal" data-toggle="tooltip" title="Insertar etiqueta al final del texto" class="btnAddTag btn btn-xs" style="font-size: 24px"><i class="fa fa-external-link-square" style="transform: rotate(180deg);"></i></a>
                      </td>
                      <td>
                          Fecha de nacimiento del trabajador en formato ej: 6 de Julio de 1990
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <code>{{ trabajador.finiquito }}</code><a href="#" data-dismiss="modal" data-toggle="tooltip" title="Insertar etiqueta al final del texto" class="btnAddTag btn btn-xs" style="font-size: 24px"><i class="fa fa-external-link-square" style="transform: rotate(180deg);"></i></a>
                      </td>
                      <td>
                          Monto de finiquito del trabajador en formato $ ##.### (miles y pesos)
                          <i class="fa fa-asterisk"></i>
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <code>{{ trabajador.estadoCivil }}</code><a href="#" data-dismiss="modal" data-toggle="tooltip" title="Insertar etiqueta al final del texto" class="btnAddTag btn btn-xs" style="font-size: 24px"><i class="fa fa-external-link-square" style="transform: rotate(180deg);"></i></a>
                      </td>
                      <td>
                          Estado civil del trabajador
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <code>{{ trabajador.horario }}</code><a href="#" data-dismiss="modal" data-toggle="tooltip" title="Insertar etiqueta al final del texto" class="btnAddTag btn btn-xs" style="font-size: 24px"><i class="fa fa-external-link-square" style="transform: rotate(180deg);"></i></a>
                      </td>
                      <td>
                          Texto de titulo del horario del trabajador (para la impresión en contratos)
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <code>{{ trabajador.sueldoBase }}</code><a href="#" data-dismiss="modal" data-toggle="tooltip" title="Insertar etiqueta al final del texto" class="btnAddTag btn btn-xs" style="font-size: 24px"><i class="fa fa-external-link-square" style="transform: rotate(180deg);"></i></a>
                      </td>
                      <td>
                          Monto de sueldo base del trabajador en formato $ ##.### (miles y pesos)
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <code>{{ trabajador.gratificacion }}</code><a href="#" data-dismiss="modal" data-toggle="tooltip" title="Insertar etiqueta al final del texto" class="btnAddTag btn btn-xs" style="font-size: 24px"><i class="fa fa-external-link-square" style="transform: rotate(180deg);"></i></a>
                      </td>
                      <td>
                          Monto de la gratificación del trabajador en formato $ ##.### (miles y pesos)
                      </td>
                  </tr>
              </tbody>
            </table>
            <p>&nbsp;</p>
            <strong>OTROS DATOS&nbsp;</strong>
            <table class="table table-striped table-bordered">
              <tbody>
                  <tr>
                      <td>
                          ETIQUETA
                      </td>
                      <td>
                          DESCRIPCION
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <code>{{ fecha1 }}</code><a href="#" data-dismiss="modal" data-toggle="tooltip" title="Insertar etiqueta al final del texto" class="btnAddTag btn btn-xs" style="font-size: 24px"><i class="fa fa-external-link-square" style="transform: rotate(180deg);"></i></a>
                      </td>
                      <td>
                          Fecha del dia con formato dd-mm-yyyy EJ: 01-01-2018.
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <code>{{ fecha2 }}</code><a href="#" data-dismiss="modal" data-toggle="tooltip" title="Insertar etiqueta al final del texto" class="btnAddTag btn btn-xs" style="font-size: 24px"><i class="fa fa-external-link-square" style="transform: rotate(180deg);"></i></a>
                      </td>
                      <td>
                          Fecha del día con formato “18 de Septiembre de 2018"
                      </td>
                  </tr>
              </tbody>
            </table>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>


<script>

$(".btnAddTag").click(function(e){
    var tag = $(this).prev().text();
    if(navigator.userAgent.match(/MSIE/i)){
        methods.insertTextAtSelection.apply(this,[tag,'html']);
    }
    else{
        document.execCommand('insertHTML',false,tag);
    }
    
})

</script>

