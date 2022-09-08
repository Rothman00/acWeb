    <!-- start: content -->
    <div id="content">
        <div class="tabs-wrapper">
            <div class="panel box-shadow-none text-left content-header">
                <div class="panel-body" style="padding-bottom:0px;">
                    <div class="col-md-12">
                        <h3 class="animated fadeInLeft"><span class="icons icon-list"></span>  PRIVILEGIO</h3>
                        <p class="animated fadeInDown">
                            Home <span class="fa-angle-right fa"></span> Privilegio
                        </p>
                    </div>
                    <ul id="tabs-demo" class="nav nav-tabs content-header-tab" role="tablist" style="padding-top:10px;">
                      <li role="presentation" class="active">
                        <a href="#darrol" id="tabs2" data-toggle="tab">DAR PRIVILEGIOS</a>
                      </li>
                      <li role="presentation" class="">
                        <a href="#quitarrol" id="tabs2" data-toggle="tab">QUITAR PRIVILEGIOS</a>
                      </li>
                    </ul>
                </div>                    
            </div>
            
            <div class="col-md-12 tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="darrol" aria-labelledby="tabs1">
                <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <center><h3>MENÚ ROL</h3></center>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-4">
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <select id="rolMenu" class="select2-A">
                                                <option value="-1">Seleccione Rol</option>
                                                <?php
                                                    foreach ($rol as $rl) {
                                                        if($rl[1]!="SUPER ADMINISTRADOR")
                                                            echo '<option value="'.$rl[0].'">'.$rl[1].'</option>';
                                                        else
                                                            if($mirol=="SUPER ADMINISTRADOR")
                                                                echo '<option value="'.$rl[0].'">'.$rl[1].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 offset-md-4">
                                            <div class="form-group">
                                                <div class="col-sm-10">
                                                    <label>MÓDULO</label>
                                                    <?php 
                                                        foreach ($rutas as $r) {
                                                            echo '<div class="col-sm-12 padding-0">';
                                                            echo '<input id="'.$r[0].'" type="checkbox" name="rolM" onclick="return false;"> '.$r[1];
                                                            echo '</div>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <center><h3>NUEVO ROL</h3></center>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-4">
                                            <br>
                                            <br>
                                            <br>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1">NOMBRE ROL</span>
                                                <input type="text" id="rolI" class="form-control" aria-describedby="basic-addon1">
                                            </div>
                                            <br>
                                            <br>
                                            <button class="btn ripple btn-3d btn-success" onclick="privilegiosGuardar1()">Guardar</button>
                                        </div>
                                        <div class="col-md-4 offset-md-4">
                                            <div class="form-group">
                                                <div class="col-sm-10">
                                                    <label>MÓDULO</label>
                                                    <?php 
                                                        foreach ($rutas as $r) {
                                                            echo '<div class="col-sm-12 padding-0">';
                                                            echo '<input id="'.$r[0].'" type="checkbox" name="nuvrol"> '.$r[1];
                                                            echo '</div>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <center><h3>DAR PRIVILEGIO</h3></center>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select id="asesorPr" class="select2-A">
                                                    <option value="-1">Seleccione Admin MegaProfer</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2"></div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select id="rolPro" class="select2-A">
                                                    <option value="-1">Seleccione Rol</option>
                                                    <?php
                                                        foreach ($rol as $rl) {
                                                            if($rl[1]!="SUPER ADMINISTRADOR")
                                                                echo '<option value="'.$rl[0].'">'.$rl[1].'</option>';
                                                            else
                                                                if($mirol=="SUPER ADMINISTRADOR")
                                                                    echo '<option value="'.$rl[0].'">'.$rl[1].'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-7" id="textoRol"></div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-5">
                                            <button class="btn ripple btn-3d btn-success" onclick="privilegiosGuardar2()">Guardar</button>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                
                <div role="tabpanel" class="tab-pane fade" id="quitarrol" aria-labelledby="tabs2">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <center><h3>QUITAR ROL</h3></center>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                            <div class="col-md-5">
                                                <center><select id="rolProDel" class="select2-A">
                                                    <option value="-1">Seleccione Rol</option>
                                                    <?php
                                                        foreach ($rol as $rl) {
                                                            if($rl[1]!="SUPER ADMINISTRADOR")
                                                                echo '<option value="'.$rl[0].'">'.$rl[1].'</option>';
                                                            else
                                                                if($mirol=="SUPER ADMINISTRADOR")
                                                                    echo '<option value="'.$rl[0].'">'.$rl[1].'</option>';
                                                        }
                                                    ?>
                                                </select></center>
                                                <br>
                                                <br>
                                                <button class="btn ripple btn-3d btn-danger" onclick="privilegiosEliminar1()">ELIMINAR</button>
                                            </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <center><h3>QUITAR PRIVILEGIO</h3></center>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <center><select id="asesorPrDel" class="select2-A">
                                                <option value="-1">Seleccione Admin MegaProfer</option>
                                            </select></center>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <label>ROLES</label>
                                                <?php 
                                                    foreach ($rol as $r) {
                                                        if($r[1]!="SUPER ADMINISTRADOR"){
                                                            echo '<div class="col-sm-12 padding-0">';
                                                            echo '<input id="del'.$r[0].'" type="checkbox" name="quipri" disabled> '.$r[1];
                                                            echo '</div>';
                                                        }else
                                                            if($mirol=="SUPER ADMINISTRADOR"){
                                                                echo '<div class="col-sm-12 padding-0">';
                                                                echo '<input id="del'.$r[0].'" type="checkbox" name="quipri" disabled> '.$r[1];
                                                                echo '</div>';
                                                            }
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-5">
                                        <button class="btn ripple btn-3d btn-danger" onclick="privilegiosEliminar2()">MODIFICAR</button>
                                    </div>
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
</div>