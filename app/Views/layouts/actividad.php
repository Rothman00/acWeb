    <!-- start: content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft"><span class="icons icon-calendar"></span>  PROGRAMACIONES DE ASESORES</h3>
                    <p class="animated fadeInDown">
                        Home <span class="fa-angle-right fa"></span> Programaciones
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
                        <div class="responsive-table" id="tablaAsesores">
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
        
        <div class="modal fade" id="privilegio" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Escoger rol</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <form id="radioForm">
                                <div class="col-lg-3">
                                    <label>
                                        <input id="supRadi" type="radio" name="rolAsig" value="supervisor"> SUPERVISOR
                                    </label>
                                </div>
                                <div class="col-lg-3">
                                    <label>
                                        <input id="aseRadi" type="radio" name="rolAsig" value="asesor"> ASESOR
                                    </label>
                                </div>
                            </form>
                            <div class="col-lg-1"></div>
                        </div>
                        <div class="row" id="elementSuper" style="display: none">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-5">
                                <center><select id="asesRegistr" class="select2-A">
                                    <option value="-1">Seleccione Supervisor</option>
                                </select></center>
                            </div>
                            <div class="col-lg-1"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="nuevoPrivilegio();" class="btn btn-default">Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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

        <div class="modal fade" id="planC" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">PLAN COMERCIAL</h4>
                    </div>
                    <div class="modal-body">
                        <div class="center">
                        <?php
                            $fechaA=date('d/M/Y');
                            echo '<h3 style="text-align:center;">PLAN COMERCIAL DISTRIBUCIÓN '.$fechaA.'</h3>';
                        ?>
                        </div>
                        <br>
                        <table id="tbl1" class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th bgcolor="#2822A2" style="color: #FFFFFF; width:80px;">PIN</th>
                                    <th bgcolor="#2822A2" style="color: #FFFFFF; width:150px;">Nombre del Asesor</th>
                                    <th bgcolor="#2822A2" style="color: #FFFFFF; width:110px;">Categoría Asesor</th>
                                    <th colspan="2" bgcolor="#2822A2" style="color: #FFFFFF; width:80px;">Categoría Actual</th>
                                    <th colspan="2" bgcolor="#FCF534" style="color: #000000; width:80px;">Premio alcanzado Mes: <?php echo date('M Y', strtotime('-1 month'));?></th>
                                    <th id="DK" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th id="B" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                    <th id="C" bgcolor="#FFFFFF" style="color: #000000; width:150px;"></th>
                                    <th id="H" bgcolor="#FFFFFF" style="color: #000000; width:110px;"></th>
                                    <th id="G" colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                    <th colspan="2" bgcolor="#575759" style="color: #FFFFFF; width:80px;">Total Premio</th>
                                    <th id="DL" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                </tr>
                            </tbody>
                        </table>
                        <table id="tbl2" class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th bgcolor="#2822A2" style="color: #FFFFFF; width:80px;">Cuota</th>
                                    <th bgcolor="#2822A2" style="color: #FFFFFF; width:150px;">Venta</th>
                                    <th bgcolor="#2822A2" style="color: #FFFFFF; width:110px;">% Cumpl.</th>
                                    <th colspan="2" bgcolor="#FCF534"" style="color: #000000; width:80px;">Premio Alcanzado</th>
                                    <th colspan="2" bgcolor="#575759" style="color: #FFFFFF; width:80px;">Total Premio Por cuota</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th id="D" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                    <th id="E" bgcolor="#FFFFFF" style="color: #000000; width:150px;"></th>
                                    <th id="F" bgcolor="#FFFFFF" style="color: #000000; width:110px;"></th>
                                    <th id="I" colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                    <th id="J" colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                </tr>
                            </tbody>
                        </table>
                        <table id="tbl3" class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th bgcolor="#2822A2" style="color: #FFFFFF; width:80px;">Cuota ZAFIRO</th>
                                    <th bgcolor="#2822A2" style="color: #FFFFFF; width:150px;">Venta ZAFIRO</th>
                                    <th bgcolor="#2822A2" style="color: #FFFFFF; width:110px;">% Cumpl.</th>
                                    <th colspan="2" bgcolor="#FCF534"" style="color: #000000; width:80px;">Premio</th>
                                    <th colspan="2" bgcolor="#575759" style="color: #FFFFFF; width:80px;">Total Premio Por ZAFIRO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th id="K" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                    <th id="L" bgcolor="#FFFFFF" style="color: #000000; width:150px;"></th>
                                    <th id="M" bgcolor="#FFFFFF" style="color: #000000; width:110px;"></th>
                                    <th id="N" colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                    <th id="O" colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                </tr>
                            </tbody>
                        </table>
                        <table id="sub1" class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th bgcolor="#2822A2" style="color: #FFFFFF; width:700px; text-align:center;">PREMIO MIX FAMILIAS</th>
                                    <th id="sumaPremio" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                    <th id="sumaPremioTotal" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                </tr>
                            </thead>
                        </table>
                        <table id="tbl4" class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th bgcolor="#2822A2" style="color: #FFFFFF; width:150px;">MIX FAMILIAS</th>
                                    <th bgcolor="#2822A2" style="color: #FFFFFF; width:80px;">CUOTA</th>
                                    <th bgcolor="#2822A2" style="color: #FFFFFF; width:80px;">VENTA</th>
                                    <th bgcolor="#2822A2" style="color: #FFFFFF; width:80px;">% Cumpl.</th>
                                    <th bgcolor="#FCF534" style="color: #000000; width:80px;">Premio</th>
                                    <th colspan="3" bgcolor="#575759" style="color: #FFFFFF; width:80px;">Total Premio Por Mix Familias</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th bgcolor="#FFFFFF" style="color: #0E1057; width: 150px; border-color:#2604FF;">BAHCO E IRIMO</th>
                                    <th id="P" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="Q" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="R" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="S" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="T" colspan="3" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                </tr>
                                <tr>
                                    <th bgcolor="#FFFFFF" style="color: #0E1057; width: 150px; border-color:#2604FF;">DEXSON</th>
                                    <th id="U" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="V" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="W" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="X" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="Y" colspan="3" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                </tr>
                                <tr>
                                    <th bgcolor="#FFFFFF" style="color: #0E1057; width: 150px; border-color:#2604FF;">FERRETERIA</th>
                                    <th id="Z" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="AA" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="AB" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="AC" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="AD" colspan="3" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                </tr>
                                <tr>
                                    <th bgcolor="#FFFFFF" style="color: #0E1057; width: 150px; border-color:#2604FF;">NORTON VARIOS</th>
                                    <th id="AE" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="AF" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="AG" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="AH" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="AI" colspan="3" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                </tr>
                                <tr>
                                    <th bgcolor="#FFFFFF" style="color: #0E1057; width: 150px; border-color:#2604FF;">IMPORTADOS</th>
                                    <th id="AJ" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="AK" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="AL" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="AM" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="AN" colspan="3" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                </tr>
                                <tr>
                                    <th bgcolor="#FFFFFF" style="color: #0E1057; width: 150px; border-color:#2604FF;">ME CABLES ANDES</th>
                                    <th id="AO" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="AP" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="AQ" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="AR" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="AS" colspan="3" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                </tr>
                                <tr>
                                    <th bgcolor="#FFFFFF" style="color: #0E1057; width: 150px; border-color:#2604FF;">MASTER</th>
                                    <th id="AT" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="AU" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="AV" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="AW" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="AX" colspan="3" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                </tr>
                                <tr>
                                    <th bgcolor="#FFFFFF" style="color: #0E1057; width: 150px; border-color:#2604FF;">SQD</th>
                                    <th id="AY" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="AZ" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="BA" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="BB" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="BC" colspan="3" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                </tr>
                                <tr>
                                    <th bgcolor="#FFFFFF" style="color: #0E1057; width: 150px; border-color:#2604FF;">REFOR</th>
                                    <th id="BD" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="BE" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="BF" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="BG" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="BH" colspan="3" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                </tr>
                                <tr>
                                    <th bgcolor="#FFFFFF" style="color: #0E1057; width: 150px; border-color:#2604FF;">CHOVA</th>
                                    <th id="BI" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="BJ" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="BK" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="BL" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="BM" colspan="3" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                </tr>
                                <tr>
                                    <th bgcolor="#FFFFFF" style="color: #0E1057; width: 150px; border-color:#2604FF;">MEDIAS ROLAND</th>
                                    <th id="BN" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="BO" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="BP" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="BQ" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="BR" colspan="3" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                </tr>
                                <tr>
                                    <th bgcolor="#FFFFFF" style="color: #0E1057; width: 150px; border-color:#2604FF;">TRAVEX</th>
                                    <th id="BS" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="BT" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="BU" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="BV" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="BW" colspan="3" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                </tr>
                                <tr>
                                    <th bgcolor="#FFFFFF" style="color: #0E1057; width: 150px; border-color:#2604FF;">DHINO LED</th>
                                    <th id="BX" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="BY" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="BZ" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="CA" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="CB" colspan="3" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                </tr>
                                <tr>
                                    <th bgcolor="#FFFFFF" style="color: #0E1057; width: 150px; border-color:#2604FF;">VETO</th>
                                    <th id="CC" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="CD" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="CE" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="CF" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="CG" colspan="3" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                </tr>
                                <tr>
                                    <th bgcolor="#FFFFFF" style="color: #0E1057; width: 150px; border-color:#2604FF;">EMTOP</th>
                                    <th id="CH" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="CI" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="CJ" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="CK" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="CL" colspan="3" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                </tr>
                                <tr>
                                    <th bgcolor="#FFFFFF" style="color: #0E1057; width: 150px; border-color:#2604FF;">PROINDUSQUIM S.A.</th>
                                    <th id="CM" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="CN" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="CO" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="CP" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                    <th id="CQ" colspan="3" bgcolor="#FFFFFF" style="color: #0E1057; width: 80px; border-color:#2604FF;"></th>
                                </tr>
                            </tbody>
                        </table>
                        <table id="tbl5" class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th bgcolor="#2822A2" style="color: #FFFFFF; width:80px;">Documentación</th>
                                    <th colspan="2" bgcolor="#2822A2" style="color: #FFFFFF; width:110px;">Valor posible a documentar</th>
                                    <th bgcolor="#2822A2" style="color: #FFFFFF; width:110px;">Valor Documentado</th>
                                    <th colspan="2" bgcolor="#2822A2"" style="color: #FFFFFF; width:80px;">Cumpl.</th>
                                    <th colspan="2" bgcolor="#FCF534" style="color: #000000; width:80px;">Premio Actual</th>
                                    <th colspan="2" bgcolor="#575759" style="color: #FFFFFF; width:80px;">Total Premio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th bgcolor="#2822A2" style=" width:80px;"></th>
                                    <th id="CW" colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                    <th id="CX" bgcolor="#FFFFFF" style="color: #000000; width:110px;"></th>
                                    <th id="CY" colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                    <th id="CZ" colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                    <th id="DA" colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                </tr>
                            </tbody>
                        </table>
                        <table id="tbl6" class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th colspan="2" bgcolor="#2822A2" style="color: #FFFFFF; width:80px;">Cartera de riesgo >16</th>
                                    <th colspan="2" bgcolor="#2822A2" style="color: #FFFFFF; width:110px;">Valor Cartera de Riesgo > 16 días</th>
                                    <th bgcolor="#2822A2" style="color: #FFFFFF; width:110px;">Valor Recaudo</th>
                                    <th colspan="2" bgcolor="#2822A2"" style="color: #FFFFFF; width:80px;">Cumpl.</th>
                                    <th colspan="2" bgcolor="#FCF534" style="color: #000000; width:80px;">Premio Actual</th>
                                    <th colspan="2" bgcolor="#575759" style="color: #FFFFFF; width:80px;">Total Premio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th colspan="2" bgcolor="#2822A2" style=" width:80px;"></th>
                                    <th id="DB" colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                    <th id="DC" bgcolor="#FFFFFF" style="color: #000000; width:110px;"></th>
                                    <th id="DD" colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                    <th id="DE" colspan="2" bgcolor="#FCF534" style="color: #000000; width:80px;"></th>
                                    <th id="DF" colspan="2" bgcolor="#575759" style="color: #FFFFFF; width:80px;"></th>
                                </tr>
                            </tbody>
                        </table>
                        <table id="tbl7" class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th  colspan="2" bgcolor="#2822A2" style="color: #FFFFFF; width:80px;">Cobertura De Clientes</th>
                                    <th colspan="2" bgcolor="#2822A2" style="color: #FFFFFF; width:110px;">Objetivo Clintes</th>
                                    <th bgcolor="#2822A2" style="color: #FFFFFF; width:110px;">Clientes desarrolladosor Recaudo</th>
                                    <th colspan="2" bgcolor="#2FFF40"" style="color: #FFFFFF; width:80px;">Cumpl.> a $1000</th>
                                    <th colspan="2" bgcolor="#FCF534" style="color: #000000; width:80px;">Entre 500 y 999</th>
                                    <th colspan="2" bgcolor="#FF3838" style="color: #FFFFFF; width:80px;">Entre 1 499</th>
                                    <th colspan="2" bgcolor="#FF3838" style="color: #FFFFFF; width:80px;">Sin Venta</th>
                                    <th colspan="2" bgcolor="#FCF534" style="color: #FFFFFF; width:80px;">Premio Actual</th>
                                    <th colspan="2" bgcolor="#575759" style="color: #FFFFFF; width:80px;">Total Premio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th colspan="2" bgcolor="#2822A2" style="color: #FFFFFF; width:80px;"></th>
                                    <th id="CR" colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:110px;"></th>
                                    <th id="CS" bgcolor="#FFFFFF" style="color: #000000; width:110px;"></th>
                                    <th id="conteo" colspan="2" bgcolor="#FFFFFF"" style="color: #000000; width:80px;"></th>
                                    <th id="conteo1" colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                    <th id="conteo2" colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                    <th id="conteo3" colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                    <th id="CU" colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                    <th id="CV" colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <th colspan="2" bgcolor="#FFFFFF" style="color: #FFFFFF; width:80px; border-color:#FFFFFF;"></th>
                                    <th colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:110px; border-color:#FFFFFF;"></th>
                                    <th id="CT" bgcolor="#FFFFFF" style="color: #000000; width:110px;"></th>
                                    <th id="porcent" colspan="2" bgcolor="#FFFFFF"" style="color: #000000; width:80px;"></th>
                                    <th id="porcent1" colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                    <th id="porcent2" colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:80px;"></th>
                                    <th colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:80px; border-color:#FFFFFF;"></th>
                                    <th colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:80px; border-color:#FFFFFF;"></th>
                                    <th colspan="2" bgcolor="#FFFFFF" style="color: #000000; width:80px; border-color:#FFFFFF;"></th>
                                </tr>
                            </tbody>
                        </table>
                        <table id="tbl8" class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th bgcolor="#2822A2" style="color: #FFFFFF; width:80px;">Cod Cliente</th>
                                    <th bgcolor="#2822A2" style="color: #FFFFFF; width:250px;">Cliente</th>
                                    <th bgcolor="#2822A2" style="color: #FFFFFF; width:110px;">VENTA</th>
                                    <th colspan="2" bgcolor="#2822A2"" style="color: #FFFFFF; width:80px;">Estado</th>
                                    <th colspan="2" bgcolor="#2822A2" style="color: #FFFFFF; width:80px;">Oportunidad Historica</th>
                                </tr>
                            </thead>
                            <tbody id="tbl8TB">
                            </tbody>
                        </table>

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