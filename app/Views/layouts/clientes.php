   <!-- start: content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft"><span class="icons icon-people"></span>  CLIENTES</h3>
                    <p class="animated fadeInDown">
                        Home <span class="fa-angle-right fa"></span> Clientes
                    </p>
                </div>
            </div>                    
        </div>
        
        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-5">
                                <h3>Listado de clientes</h3>
                            </div>
                            <div class="col-md-4"  style="text-align:right;">
                                <br>
                                <button class="btn ripple-infinite btn-round btn-primary" onclick="llenadoAsesores()" data-toggle="modal" data-target="#nuevo"><span class="icons icon-user"></span>  Nuevo</button>
                            </div>
                            <div class="col-md-2 offset-md-4" style="text-align:left;">
                                <br>
                                <button class="btn ripple-infinite btn-round btn-success" onclick="exportarClientesExcel();" ><i class="fa fa-file-excel-o"></i>  Exportar</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="responsive-table" id="tableClientes">
                            <center><img src="<?php echo base_url()?>/asset/img/cargando.gif"></center>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        
        <datalist id="listaCodigos"></datalist>
        <datalist id="listaClientes"></datalist>
        
        <div class="modal fade" id="nuevo" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Nuevo cliente</h4>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">ASESOR<span style="color:red">*</span></span>
                            <select id="asesorN" class="select2-A">
                                <option value="-1">Seleccione un asesor</option>
                            </select>
                        </div>
                        <br>
                        EL NOMBRE DEL CLIENTE INGRESADO NO DEBE CONSTAR EN LA LISTA
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">CLIENTE<span style="color:red">*</span></span>
                            <form name='cliNuevo' id='cliNuevo'>
                            <input type="text" name="cliN" list="listaClientes" id="cliN" placeholder="Ingrese el nombre del cliente" class="form-control" aria-describedby="basic-addon1">
                            </form>
                        </div>
                        <br>
                        EL CÓDIGO INGRESADO NO DEBE CONSTAR EN LA LISTA
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">CÓDIGO<span style="color:red">*</span></span>
                            <form name='codNuevo' id='codNuevo'>
                            <input type="text" list="listaCodigos" id="codN" placeholder="Ingrese el código del cliente" class="form-control" aria-describedby="basic-addon1" maxlength="10">
                            </form>
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">DIRECCIÓN</span>
                            <input type="text" id="dirN" placeholder="Ingrese la dirección del cliente" class="form-control" aria-describedby="basic-addon1">
                        </div> 
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">EMAIL</span>
                            <input type="email" name="emaN" id="emaN" placeholder="Ingrese el email del cliente" class="form-control" aria-describedby="basic-addon1">
                        </div> 
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">TELÉFONO</span>
                            <form name='telNuevo' id='telNuevo'>
                                <input type="text" name="telN" id="telN" maxlength="10" placeholder="Ingrese el teléfono del cliente" class="form-control" aria-describedby="basic-addon1">
                            </form>
                        </div> 
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">MÓVIL</span>
                            <form name='mobNuevo' id='mobNuevo'>
                            <input type="text" name="mobN" id="mobN" maxlength="10" placeholder="Ingrese el mobil del cliente" class="form-control" aria-describedby="basic-addon1">
                            </form>
                        </div> 
                        <br>
                        <div class="input-group form-animate-text">
                            <span class="input-group-addon" id="basic-addon1">VISITA DESDE</span>
                            <input type="text" name="desN" id="desN" placeholder="Ingrese la hora visita desde del cliente" class="form-control time" aria-describedby="basic-addon1">
                        </div>
                        <br>
                        <div class="input-group form-animate-text">
                            <span class="input-group-addon" id="basic-addon1">VISITA HASTA</span>
                            <input type="text" name="hasN" id="hasN" placeholder="Ingrese la hora visita hasta del cliente" class="form-control time" aria-describedby="basic-addon1">
                        </div>
                        <br>
                        <span style="color:red">Los campos con * son OBLIGATORIOS</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="guardarCliN" onclick="nuevoCliente();" class="btn btn-default">Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="config" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Actualizar cliente</h4>
                    </div>
                    <div class="modal-body">
                        EL NOMBRE DEL CLIENTE INGRESADO NO DEBE CONSTAR EN LA LISTA
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">CLIENTE<span style="color:red">*</span></span>
                            <form name='cliUpdate' id='cliUpdate'>
                            <input type="text"  name="cliU" list="listaClientes" id="cliU" placeholder="Ingrese el nombre del cliente" class="form-control" aria-describedby="basic-addon1">
                            </form>
                        </div>
                        <br>
                        EL CÓDIGO INGRESADO NO DEBE CONSTAR EN LA LISTA
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">CÓDIGO<span style="color:red">*</span></span>
                            <form name='codUpdate' id='codUpdate'>
                            <input type="text" name="codU" list="listaCodigos" id="codU" placeholder="Ingrese el código del cliente" class="form-control" aria-describedby="basic-addon1" maxlength="10">
                            </form>
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">DIRECCIÓN</span>
                            <input type="text" id="dirU" placeholder="Ingrese la dirección del cliente" class="form-control" aria-describedby="basic-addon1">
                        </div> 
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">EMAIL</span>
                            <input type="email" id="emaU" placeholder="Ingrese el email del cliente" class="form-control" aria-describedby="basic-addon1">
                        </div> 
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">TELÉFONO</span>
                            <form name='telUpdate' id='telUpdate'>
                            <input type="text" name="telU" id="telU" maxlength="9" placeholder="Ingrese el teléfono del cliente" class="form-control" aria-describedby="basic-addon1">
                            </form>
                        </div> 
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">MÓVIL</span>
                            <form name='mobUpdate' id='mobUpdate'>
                            <input type="text" name="mobU" id="mobU" maxlength="10" placeholder="Ingrese el mobil del cliente" class="form-control" aria-describedby="basic-addon1">
                            </form>
                        </div> 
                        <br>
                        <div class="input-group form-animate-text">
                            <span class="input-group-addon" id="basic-addon1">VISITA DESDE</span>
                            <input type="text" id="desU" placeholder="Ingrese la hora visita desde del cliente" class="form-control time" aria-describedby="basic-addon1">
                        </div>
                        <br>
                        <div class="input-group form-animate-text">
                            <span class="input-group-addon" id="basic-addon1">VISITA HASTA</span>
                            <input type="text" id="hasU" placeholder="Ingrese la hora visita hasta del cliente" class="form-control time" aria-describedby="basic-addon1">
                        </div>   
                        <br>
                        <span style="color:red">Los campos con * son OBLIGATORIOS</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="guardarCliU" onclick="actualizarCliente();" class="btn btn-default">Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="foto" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Foto del local</h4>
                    </div>
                    <div class="modal-body">
                        <div style="text-align:center;">
                            <img src="" id="fotoC">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end: content -->