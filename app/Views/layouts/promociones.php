    <!-- start: content -->
    <div id="content">
        <div class="tabs-wrapper">
            <div class="panel box-shadow-none text-left content-header">
                <div class="panel-body" style="padding-bottom:0px;">
                    <div class="col-md-12">
                        <h3 class="animated fadeInLeft"><span class="icons icon-bell"></span>  PROMOCIONES</h3>
                        <p class="animated fadeInDown">
                            Home <span class="fa-angle-right fa"></span> Promociones
                        </p>
                    </div>
                    <ul id="tabs-demo" class="nav nav-tabs content-header-tab" role="tablist" style="padding-top:10px;">
                      <li role="presentation" class="active">
                        <a href="#agregarpro" id="tabs2" data-toggle="tab">NUEVA PROMOCI&Oacute;N</a>
                      </li>
                      <li role="presentation" class="">
                        <a href="#editarpro" id="tabs2" data-toggle="tab">ACTIVAS E INACTIVAS</a>
                      </li>
                    </ul>
                </div>                    
            </div>
            <div class="col-md-12 tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="agregarpro" aria-labelledby="tabs1">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="col-md-12 tabs-area text-center" style="justify-content: center;">
                                <h4>AGREGAR PROMOCI&Oacute;N</h4>
                                <br>
                                <div class="row">
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-10">
                                        <form action="<?= base_url('dropzoneI') ?>" method="POST" enctype="multipart/form-data" class="dropzone" id='image-upload'>
                                        </form>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-1"></div>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Fecha Desde</span>
                                            <input type="text" id="fecDesde" placeholder="Ingrese la fecha desde de la promoción" class="form-control dateAnimate" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="col-md-5 offset-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Fecha Hasta</span>
                                            <input type="text" id="fecHasta" placeholder="Ingrese la fecha hasta de la promoción" class="form-control dateAnimate" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6" style="text-align:left;">
                                        <button class="btn ripple-infinite btn-round btn-success btn-block" onclick="guardarDatos();" ><i class="fa fa-save"></i>  GUARDAR</button>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div role="tabpanel" class="tab-pane fade" id="editarpro" aria-labelledby="tabs2">
                       
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <center><h3>PROMOCIONES ACTIVAS</h3></center>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div id="carousel-activo" class="carousel slide" data-ride="carousel">
                                        <!-- Indicators -->
                                        <ol class="carousel-indicators">
                                            <?php
                                                $actI=0;
                                                foreach ($promo["activo"] as $kA => $a) {
                                                    if($actI==0){
                                                        echo '<li data-target="#carousel-activo" data-slide-to="'.$actI.'" class="active"></li>';
                                                    }else{
                                                        echo '<li data-target="#carousel-activo" data-slide-to="'.$actI.'"></li>';
                                                    }
                                                    $actI++;
                                                }
                                            ?>
                                        </ol>

                                        <div class="carousel-inner" role="listbox">
                                            <?php
                                                $actI=0;
                                                foreach ($promo["activo"] as $kA => $a) {
                                                    if($actI==0){
                                                        echo '<div class="item active">';
                                                    }else{
                                                        echo '<div class="item">';
                                                    }
                                                    echo '<img class="img-responsive" data-src="holder.js/900x500/auto/#777:#555/text:First slide" alt="First slide" src="'.$a->PRM_URL.'">';
                                                    echo '<div class="carousel-caption">';
                                                    echo '<button onclick="pasarInfo(\''.$a->PRM_ID.'\', \''.$a->PRM_URL.'\', \''.$a->PRM_FECHAD.'\', \''.$a->PRM_FECHAH.'\');" class="btn btn-primary" data-animation="animated lightSpeedIn" data-toggle="modal" data-target="#config"><i class="fa fa-cog"></i> AJUSTES</button>';
                                                    echo '</div></div>';
                                                    $actI++;
                                                }
                                            ?>
                                        </div><!-- /.carousel-inner -->
                                        <!-- Controls -->
                                        <a class="left carousel-control" href="#carousel-activo"
                                        role="button" data-slide="prev">
                                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="right carousel-control" href="#carousel-activo"
                                            role="button" data-slide="next">
                                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div><!-- /.carousel -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <center><h3>PROMOCIONES INACTIVAS</h3></center>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div id="carousel-inactiva" class="carousel slide" data-ride="carousel">
                                        <!-- Indicators -->
                                        <ol class="carousel-indicators">
                                            <?php
                                                $actI=0;
                                                foreach ($promo["inactivo"] as $kA => $a) {
                                                    if($actI==0){
                                                        echo '<li data-target="#carousel-inactiva" data-slide-to="'.$actI.'" class="active"></li>';
                                                    }else{
                                                        echo '<li data-target="#carousel-inactiva" data-slide-to="'.$actI.'"></li>';
                                                    }
                                                    $actI++;
                                                }
                                            ?>
                                        </ol>

                                        <div class="carousel-inner" role="listbox">
                                            <?php
                                                $actI=0;
                                                foreach ($promo["inactivo"] as $kA => $a) {
                                                    if($actI==0){
                                                        echo '<div class="item active">';
                                                    }else{
                                                        echo '<div class="item">';
                                                    }
                                                    echo '<img class="img-responsive" data-src="holder.js/900x500/auto/#777:#555/text:First slide" alt="First slide" src="'.$a->PRM_URL.'">';
                                                    echo '<div class="carousel-caption">';
                                                    echo '<button onclick="pasarInfo(\''.$a->PRM_ID.'\', \''.$a->PRM_URL.'\', \''.$a->PRM_FECHAD.'\', \''.$a->PRM_FECHAH.'\');" class="btn btn-primary" data-animation="animated lightSpeedIn" data-toggle="modal" data-target="#config"><i class="fa fa-cog"></i> AJUSTES</button>';
                                                    echo '</div></div>';
                                                    $actI++;
                                                }
                                            ?>
                                        </div><!-- /.carousel-inner -->
                                        <!-- Controls -->
                                        <a class="left carousel-control" href="#carousel-inactiva"
                                        role="button" data-slide="prev">
                                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="right carousel-control" href="#carousel-inactiva"
                                            role="button" data-slide="next">
                                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div><!-- /.carousel -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade modal-v1" id="config" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <img id="mostrarImg" class="img-responsive" data-src="holder.js/900x500/auto/#777:#555/text:First slide" alt="First slide" src="asset/img/bg1.jpg">
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1">Desde</span>
                                        <input type="text" id="fecDesdeM" placeholder="Ingrese la fecha desde" class="form-control dateAnimate" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="col-md-6 offset-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1">Hasta</span>
                                        <input type="text" id="fecHastaM" placeholder="Ingrese la fecha hasta" class="form-control dateAnimate" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <button onclick="modificarImgP();" class="btn btn-round btn-warning" data-animation="animated lightSpeedIn"><span class="icons icon-check"></span> ACTIVAR</button>
                                </div>
                                <div class="col-md-6">
                                    <button onclick="eliminarImgP();" class="btn btn-round btn-danger" data-animation="animated lightSpeedIn"><span class="icons icon-ban"></span> INACTIVAR</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>