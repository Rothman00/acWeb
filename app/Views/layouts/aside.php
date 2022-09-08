<div class="container-fluid mimin-wrapper">
    <!-- start:Left Menu -->
    <div id="left-menu">
        <div class="sub-left-menu scroll">
            <ul class="nav nav-list">
                <li><div class="left-bg"></div></li>
                <li class="time">
                    <h1 class="animated fadeInLeft">21:00</h1>
                    <p class="animated fadeInRight">Sat,October 1st 2029</p>
                </li>
                <li class="active ripple">
                    <a href="<?php echo base_Url()?>"><span class="icons icon-home"></span> HOME </a>
                </li>
                <?php
                    $rutasOr=array();
                    //NÚMERO DE RUTAS MÁXIMO
                    $longitud = 9;
                    $indexRuta=1;
                    for ($i = 0; $i < $longitud; $i++) {
                        for ($j = 0; $j < count($rutas); $j++) {
                            $number=$rutas[$j]->RUT_ORDEN;
                            if($number==$indexRuta){
                                array_push($rutasOr, $rutas[$j]);
                                break;
                            }
                        }
                        $indexRuta++;
                    }
                    foreach ($rutasOr as $key => $value) {
                        echo '<li class="ripple">';
                        echo '<a href="'.base_Url().$value->RUT_RUTA.'"><span class="'.$value->RUT_ICONO.'"></span> '.$value->RUT_NOMBRE.' </a>';
                        echo '</li>';   
                    }
                ?>
            </ul>
        </div>
    </div>
    <!-- end: Left Menu -->