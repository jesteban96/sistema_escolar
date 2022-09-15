<?php if(!empty($d)):?>
    <ul class="list-group">
        <?php foreach ($d as $m):?>
            <?php echo sprintf('
                <li class="list-group-item">%s 
                    <button class="btn btn-danger btn-sm float-right quitarMateriaProfesor" data-id="%s">
                        <i class="fas fa-trash"></i>
                    </button>
                </li>',$m->nombre,$m->id);?>
        <?php endforeach?>
    </ul>
<?php else:?>
    <div class="text-center py-5">
        <img class="img-fluid" src="<?php echo get_image('undraw_taken.png');?>" alt="No hay Registros" style="width: 200px" >
        <p class="text-muted">No hay materias asignadas al profesor</p>
    </div>
<?php endif;?>