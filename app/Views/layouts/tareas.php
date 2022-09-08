    <!-- start: content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft"><span class="icons icon-list"></span>  TAREAS</h3>
                    <p class="animated fadeInDown">
                        Home <span class="fa-angle-right fa"></span> Tareas
                    </p>
                </div>
            </div>                    
        </div>

        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading"><h3>Nueva tarea</h3></div>
                    <div class="panel-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <h5>Asesores<span style="color:red">*</span></h5>
                                </div>
                                <div class="col-md-4 offset-md-4">
                                    <h5>Clientes<span style="color:red">*</span></h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <select id="asesor" class="select2-A">
                                        <option value="-1">Seleccione Asesor</option>
                                    </select>
                                </div>
                                <div class="col-md-4 offset-md-4">
                                    <select id="cliente" class="select2-A">
                                        <option value="-1">Seleccione Cliente</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div id="informacion" style="display:block;">
                                <h4>Información del asesor</h4>
                                <br>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Nombres</span>
                                            <input type="text" id="aseI" class="form-control" aria-describedby="basic-addon1" disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-md-5 offset-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">DNI</span>
                                            <input type="text" id="dniI" class="form-control" aria-describedby="basic-addon1" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Dirección</span>
                                            <input type="text" id="dirI" class="form-control" aria-describedby="basic-addon1" disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-md-5 offset-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Email</span>
                                            <input type="text" id="emaI" class="form-control" aria-describedby="basic-addon1" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Teléfono</span>
                                            <input type="text" id="telI" class="form-control" aria-describedby="basic-addon1" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                                <br>            
                            </div>
                            <br>
                            <div id="informacion" style="display:block;">
                                <h4>Información del cliente</h4>
                                <br>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Nombres</span>
                                            <input type="text" id="cliI" class="form-control" aria-describedby="basic-addon1" disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-md-5 offset-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Dirección</span>
                                            <input type="text" id="dirCI" class="form-control" aria-describedby="basic-addon1" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Teléfono</span>
                                            <input type="text" id="telCI" class="form-control" aria-describedby="basic-addon1" disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-md-5 offset-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Móvil</span>
                                            <input type="text" id="mobCI" class="form-control" aria-describedby="basic-addon1" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Horario de Visita</span>
                                            <input type="text" id="visCI" class="form-control" aria-describedby="basic-addon1" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                                <br>            
                            </div>
                            <hr>
                            <div id="informacion" style="display:block;">
                                <h4>Datos tarea</h4>
                                <br>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Cobrar $</span>
                                            <form name='cobForm' id='cobForm'>
                                            <input type="number" name="cob" min="0.00" step="0.01" id="cob" placeholder="Cantidad por cobrar" class="form-control" aria-describedby="basic-addon1" value="0" maxlength="8">
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Vender $</span>
                                            <form name='venForm' id='venForm'>
                                            <input type="number" name="ven" min="0.00" step="0.01" id="ven" placeholder="Cantidad por cobrar" class="form-control" aria-describedby="basic-addon1" value="0" maxlength="8">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Otros $</span>
                                            <form name='otrForm' id='otrForm'>
                                            <input type="number" name="otr" min="0.00" step="0.01" id="otr" placeholder="Cantidad por cobrar" class="form-control" aria-describedby="basic-addon1" value="0" maxlength="8">
                                            </fomr>
                                        </div>
                                    </div>
                                    <div class="col-md-5 offset-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Fecha<span style="color:red">*</span></span>
                                            <input type="date" id="fec" placeholder="Ingrese la fecha máxima para la tarea" class="form-control dateAnimate" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Detalle</span>
                                            <textarea type="text" id="det" placeholder="Ingrese algún detalle adicional" rows="4" cols="40" class="form-control" aria-describedby="basic-addon1"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <span style="color:red">Los campos con * son OBLIGATORIOS</span>
                                    </div>
                                    <div class="col-md-4">
                                        <br>
                                        <button id="guardarId" class="btn ripple btn-3d btn-success" onclick="tareaGuardar()">Guardar</button>
                                    </div>
                                    <div class="col-md-4 offset-md-4"></div>
                                </div>
                                <br>            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>
<!-- end: content -->
