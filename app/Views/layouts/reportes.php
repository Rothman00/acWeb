    <!-- start: content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft"><span class="icons icon-people"></span>  REPORTES</h3>
                    <p class="animated fadeInDown">
                        Home <span class="fa-angle-right fa"></span> Reportes
                    </p>
                </div>
            </div>                    
        </div>
        
        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-4">
                                <h3>REPORTES DE VENTAS</h3>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-2 offset-md-2">
                                <br>
                                <button class="btn ripple-infinite btn-round btn-success" onclick="exportarReportesTotalExcel();" ><i class="fa fa-file-excel-o"></i>  Exportar</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1">Desde</span>
                                    <input type="text" id="fDesdeR" placeholder="Ingrese la fecha desde" class="form-control dateAnimateDH" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1">Hasta</span>
                                    <input type="text" id="fHastaR" placeholder="Ingrese la fecha hasta" class="form-control dateAnimateDH" aria-describedby="basic-addon1" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                            <button class="btn ripple-infinite btn-round btn-primary" onclick="busquedaFechas();" ><i class="fa fa-calendar"></i>  Buscar</button>
                            </div>
                        </div>
                        <br>
                        <div style="text-align: center;">
                            <nav>
                                <ul>
                                    <li style="display:inline-block;"><div style="width: 15px; height: 15px; background: #CBE6CB; float:left;"></div>PROGRAMADOS</li>
                                    <li style="display:inline-block;"><div style="width: 15px; height: 15px; background: #C6FCFC; float:left;"></div>NO PROGRAMADOS</li>
                                    <li style="display:inline-block;"><div style="width: 15px; height: 15px; background: #ADA7AF; float:left;"></div>TAREAS</li>
                                    <li style="display:inline-block;"><div style="width: 15px; height: 15px; background: #F0B7BC; float:left;"></div>REPROGRAMADOS</li>
                                </ul>
                            </nav>
                        </div>
                        <div class="responsive-table" id="reportesTable">
                            <center><img src="<?php echo base_url()?>/asset/img/cargando.gif"></center> 
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        
        <div class="modal fade" id="inform" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Información completa</h4>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">ASESOR</span>
                            <input type="text" disabled="disabled" id="aseV" placeholder="Ingrese el nombre del cliente" class="form-control" aria-describedby="basic-addon1">
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">PIN</span>
                            <input type="text" disabled="disabled" id="pinV" placeholder="Ingrese el nombre del cliente" class="form-control" aria-describedby="basic-addon1">
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">DNI</span>
                            <input type="text" disabled="disabled" id="dniV" placeholder="Ingrese el código del cliente" class="form-control" aria-describedby="basic-addon1">
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">DIRECCIÓN</span>
                            <input type="text" disabled="disabled" id="dirAV" placeholder="Ingrese la dirección del cliente" class="form-control" aria-describedby="basic-addon1">
                        </div> 
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">CLIENTE</span>
                            <input type="email" disabled="disabled" id="cliV" placeholder="Ingrese el email del cliente" class="form-control" aria-describedby="basic-addon1">
                        </div> 
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">CÓDIGO</span>
                            <input type="text" disabled="disabled" id="codV" placeholder="Ingrese el teléfono del cliente" class="form-control" aria-describedby="basic-addon1">
                        </div> 
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">DIRECCIÓN</span>
                            <input type="text" disabled="disabled" id="dirCV" placeholder="Ingrese el mobil del cliente" class="form-control" aria-describedby="basic-addon1">
                        </div> 
                        <br>
                        <div class="input-group form-animate-text">
                            <span class="input-group-addon" id="basic-addon1">EMAIL</span>
                            <input type="text" disabled="disabled" id="emaV" placeholder="Ingrese la hora visita desde del cliente" class="form-control time" aria-describedby="basic-addon1">
                        </div>
                        <br>
                        <div class="input-group form-animate-text">
                            <span class="input-group-addon" id="basic-addon1">FECHA</span>
                            <input type="text" disabled="disabled" id="fecV" placeholder="Ingrese la hora visita hasta del cliente" class="form-control time" aria-describedby="basic-addon1">
                        </div>
                        <br>
                        <div class="input-group form-animate-text">
                            <span class="input-group-addon" id="basic-addon1">HORA</span>
                            <input type="text" disabled="disabled" id="horV" placeholder="Ingrese la hora visita hasta del cliente" class="form-control time" aria-describedby="basic-addon1">
                        </div>
                        <br>
                        <div class="input-group form-animate-text">
                            <span class="input-group-addon" id="basic-addon1">OBSEV.</span>
                            <input type="text" disabled="disabled" id="obsPV" placeholder="Ingrese la hora visita hasta del cliente" class="form-control time" aria-describedby="basic-addon1">
                        </div>
                        <br>
                        <div class="input-group form-animate-text">
                            <span class="input-group-addon" id="basic-addon1">VENTA</span>
                            <input type="text" disabled="disabled" id="ventV" placeholder="Ingrese la hora visita hasta del cliente" class="form-control time" aria-describedby="basic-addon1">
                        </div>
                        <br>
                        <div class="input-group form-animate-text">
                            <span class="input-group-addon" id="basic-addon1">COBRO</span>
                            <input type="text" disabled="disabled" id="cobV" placeholder="Ingrese la hora visita hasta del cliente" class="form-control time" aria-describedby="basic-addon1">
                        </div>
                        <br>
                        <div class="input-group form-animate-text">
                            <span class="input-group-addon" id="basic-addon1">OTROS</span>
                            <input type="text" disabled="disabled" id="otrV" placeholder="Ingrese la hora visita hasta del cliente" class="form-control time" aria-describedby="basic-addon1">
                        </div>
                        <br>
                        <div class="input-group form-animate-text">
                            <span class="input-group-addon" id="basic-addon1">OBSEV.</span>
                            <textarea type="text" disabled="disabled" id="obsVV" placeholder="Ingrese la hora visita hasta del cliente" class="form-control time" aria-describedby="basic-addon1"></textarea>
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