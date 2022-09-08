    <!-- start: content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft"><span class="fa fa-users"></span>  HISTORIAL DE ASESORES</h3>
                    <p class="animated fadeInDown">
                        Home <span class="fa-angle-right fa"></span> Historial
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
                                <h3>Listado de asesores</h3>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="responsive-table" id="historialTable">
                            <script>
                                let rol = '<?php echo $rol;?>';
                                let ref = '<?php echo $ref;?>';
                            </script>
                            <center><img src="<?php echo base_url()?>/asset/img/cargando.gif"></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="clientes" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">DATOS DE CLIENTES</h4>
                    </div>
                    <div class="modal-body">
                        <div class="responsive-table">
                            <table id="datatable-datos3" class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Cliente</th>
                                        <th>Código</th>
                                        <th>Dirección</th>
                                        <th>Teléfono</th>
                                        <th>Móvil</th>
                                        <th>Atención</th>
                                    </tr>
                                </thead>
                                <tbody id="clientesTB">
                                </tbody>
                            </table>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="ventas" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">DATOS DE VENTAS</h4>
                    </div>
                    <div class="modal-body">
                        <div class="responsive-table">
                            <table id="datatable-datos" class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Cliente</th>
                                        <th>Código</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Venta</th>
                                        <th>Cobro</th>
                                        <th>Otros</th>
                                        <th>Información</th>
                                        <th>Fuera de Ruta</th>
                                    </tr>
                                </thead>
                                <tbody id="ventasTB">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tareas" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">DATOS DE TAREAS</h4>
                    </div>
                    <div class="modal-body">
                        <div class="responsive-table">
                            <table id="datatable-datos1" class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Cliente</th>
                                        <th>Código</th>
                                        <th>Fecha Max</th>
                                        <th>Venta</th>
                                        <th>Cobro</th>
                                        <th>Otros</th>
                                        <th>Detalle</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody id="tareaTB">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="semana" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">PROGRAMACIÓN SEMANAL</h4>
                    </div>
                    <div class="modal-body">
                        <div class="responsive-table">
                            <table id="datatable-datos2" class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Cliente</th>
                                        <th>Código</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Observ.</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody id="semanaTB">
                                </tbody>
                            </table>
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