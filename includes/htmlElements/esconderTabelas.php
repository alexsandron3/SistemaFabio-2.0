<?php


function esconderTabela($quantidade){
    $contador = 1;
    while($contador <= $quantidade){
        if($contador != $quantidade){
            echo"<input type='hidden' class='hide_show'>";
        }else{
            
            echo"
                <input type='checkbox' class='hide_show' name='checkForm' id='checkForm'>
                <label class='form-check-label ' for='checkForm'>
                    <span class='ml-1'>Esconder Ações </span>          
                </label>
            ";
        }
        
        $contador++;
    }
}


/* 
<div id='control_sh'>
<input type="checkbox" class="hide_show"><span>Hide a</span>
<input type="checkbox" class="hide_show"><span>Hide b</span>
<input type="checkbox" class="hide_show"><span>Hide c</span>
<input type="checkbox" class="hide_show"><span>Hide d</span>
<input type="checkbox" class="hide_show"><span>Hide e</span>
<input type="checkbox" class="hide_show"><span>Hide f</span>
<input type="checkbox" id="hide_show_all"><span>Hide All</span>
</div> */