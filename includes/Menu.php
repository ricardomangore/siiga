<?php
class Menu extends Tools
{
	function Menu($UsuarioId)
	{		
		$this->Tools($UsuarioId);
	return;
	}

	function displayMenu()
	{
		$R0=$this->getMenuUsuarios();
		echo'
			<div id="Menu">
				<div>
					<a href="sistema.php">
						<img src="img/LogoBig.png" class="logoImg" />
					</a>
				</div>
			';
			$FamiliaId=0;		
			while($Fila=mysql_fetch_row($R0))
			{			
				if($Fila[0]!=$FamiliaId){
				if ($FamiliaId!=0) {
					echo '</div>';		
				}
				echo '<div class="Familias"><img src="img/'.$Fila[2].'" class="imgMenu"/>'.$Fila[1].'</div>';
				echo '<div class="Modulos">';
				$FamiliaId=$Fila[0];

				}
				echo'		
						<div id="Mod" >
						<a href="'.$Fila[4].'"><img src="img/Punto.png" class="vinieta"/>'.$Fila[3].'</a><br>				
						</div>
					';	
			}
	echo '		
		
				</div>
			</div>
		';
	}

}	
?>