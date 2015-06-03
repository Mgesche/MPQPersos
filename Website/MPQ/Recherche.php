<html>
	
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf8" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script>
		MPQ = {
		    getHeros: function(puissance, couleur) {
				
				var resultHeros = [];
				
				var puissance = $('#puissance option:selected').text();
				var nom = $('#nom').val();
				var couleur = $('#couleur option:selected').text();
				var effet = $('#effet option:selected').val();
				
				var heros;
				$.get('api/Heros.json', function(data) {
					console.log(data);
					for (iHeros = 0; iHeros < data.length; iHeros++) 
					{ 
						heros = data[iHeros];
						console.log(heros);
						// Puissance
						if(puissance == "" || puissance == "All" || puissance == heros.puissance) {	
						// Nom
						if(nom == "" || heros.nom.indexOf(nom) >= 0) {
						// Effet et couleur
						var isOKEffet = 0;
						var isOKCouleur = 0;
						var descEffet = "";
						for (iAttaque = 0; iAttaque < heros.attaques.length; iAttaque++) {
						if(couleur == "" || couleur == "All" || heros.attaques[iAttaque].couleur == couleur) {
						isOKCouleur = 1;		
						for (iEffet = 0; iEffet < heros.attaques[iAttaque].type.length; iEffet++) {
						if(effet == "" || effet == "All" || heros.attaques[iAttaque].type[iEffet].Effet == effet) {		
							isOKEffet = 1;
							if (descEffet == "") {
								descEffet = "<UL><LI>"+heros.attaques[iAttaque].nom+" : "+heros.attaques[iAttaque].description;
							} else {
								descEffet = descEffet + "</LI><LI>"+heros.attaques[iAttaque].nom+" : "+heros.attaques[iAttaque].description;
							}
						}
						}
						}
						}
						if(isOKCouleur == 1 && isOKEffet == 1){
							var herosOK = {};
							herosOK.nom = heros.nom;
							herosOK.img = heros.img;
							herosOK.descEffet = descEffet+"</LI></UL>";
							resultHeros.push(herosOK);
						}
						}
						} 
					}
				})
				.done(function() {
					$("#infos").html("");
					$("#infos").append("<UL>");
					for (i = 0; i < resultHeros.length; i++) 
					{
						$("#infos").append("<LI><img src=\""+resultHeros[i].img+"\" width=\"40\" height=\"60\"></img>"+resultHeros[i].nom+resultHeros[i].descEffet+"</LI>");
					}
					$("#infos").append("</UL>");
				});
		        return "";
		    }
		}
	</script>
</head>

<body>
	<?php
		$puissance = "";
	    if(isset($_GET["puissance"])) {
			$puissance = $_GET["puissance"];
		}
		$nom = "";
	    if(isset($_GET["nom"])) {
			$nom = $_GET["nom"];
		}
		$couleur = "";
	    if(isset($_GET["couleur"])) {
			$couleur = $_GET["couleur"];
		}
		$effet = "";
	    if(isset($_GET["effet"])) {
			$effet = $_GET["effet"];
		}
	?>
	<form>
		<P>Nom :<br>
		<input type="text" id="nom" name="nom" value=<?php echo "\"".$nom."\""?> onchange="MPQ.getHeros();">
		<P>Puissance :<br>
		<select id="puissance" onchange="MPQ.getHeros();"> 
			<option value="0" <?php if($puissance==""){echo " selected=\"selected\"";} ?>>All</option> 
			<option value="1" <?php if($puissance=="1"){echo " selected=\"selected\"";} ?>>1</option> 
			<option value="2" <?php if($puissance=="2"){echo " selected=\"selected\"";} ?>>2</option>
			<option value="3" <?php if($puissance=="3"){echo " selected=\"selected\"";} ?>>3</option> 
			<option value="4" <?php if($puissance=="4"){echo " selected=\"selected\"";} ?>>4</option>  
		</select>
		<P>Couleur :<br>
		<select id="couleur" onchange="MPQ.getHeros();"> 
			<option value="0" <?php if($couleur==""){echo " selected=\"selected\"";} ?>>All</option> 
			<option value="red" <?php if($couleur=="red"){echo " selected=\"selected\"";} ?>>red</option> 
			<option value="green" <?php if($couleur=="green"){echo " selected=\"selected\"";} ?>>green</option> 
			<option value="yellow" <?php if($couleur=="yellow"){echo " selected=\"selected\"";} ?>>yellow</option> 
			<option value="blue" <?php if($couleur=="blue"){echo " selected=\"selected\"";} ?>>blue</option> 
			<option value="purple" <?php if($couleur=="purple"){echo " selected=\"selected\"";} ?>>purple</option>
			<option value="black" <?php if($couleur=="black"){echo " selected=\"selected\"";} ?>>black</option>  
		</select>
		<P>Effet :<br>
		<select id="effet" onchange="MPQ.getHeros();"> 
			<option value="All" <?php if($effet==""){echo " selected=\"selected\"";} ?>>All</option> 
			<option value="Degat" <?php if($effet=="degat"){echo " selected=\"selected\"";} ?>>Degat : Inflige des dégats a l'ennemi</option> 
			<option value="Protection" <?php if($effet=="protection"){echo " selected=\"selected\"";} ?>>Protection : Protege des dégats ennemis</option>
			<option value="Vol" <?php if($effet=="vol"){echo " selected=\"selected\"";} ?>>Vol : Vol de ressources a l'ennemi</option>
			<option value="Paralysie" <?php if($effet=="paralysie"){echo " selected=\"selected\"";} ?>>Paralysie : Paralyse l'ennemi</option>
			<option value="Critical" <?php if($effet=="critical"){echo " selected=\"selected\"";} ?>>Critical : Crée un critique</option>
			<option value="Destruction" <?php if($effet=="destruction"){echo " selected=\"selected\"";} ?>>Destruction : Detruit des symboles</option>
			<option value="Sacrifice" <?php if($effet=="sacrifice"){echo " selected=\"selected\"";} ?>>Sacrifice : Perd de la vie</option>
			<option value="Generation_AP" <?php if($effet=="generation_AP"){echo " selected=\"selected\"";} ?>>Generation AP : Genere des ressources</option>
			<option value="Generation_AP_Ennemi" <?php if($effet=="Generation_AP_Ennemi"){echo " selected=\"selected\"";} ?>>Generation AP Ennemi : Genere des ressources pour l'ennemi</option>
			<option value="Destruction_Team" <?php if($effet=="destruction_Team"){echo " selected=\"selected\"";} ?>>Destruction Team : Detruit des symboles Team</option>
			<option value="Generation_Team" <?php if($effet=="generation_Team"){echo " selected=\"selected\"";} ?>>Generation Team : Genere des ressources Team</option>
			<option value="Attaque" <?php if($effet=="attaque"){echo " selected=\"selected\"";} ?>>Attaque : Crée des symboles Attaque</option>
			<option value="Assassinat" <?php if($effet=="Assassinat"){echo " selected=\"selected\"";} ?>>Assassinat : Tue l'ennemi</option>
			<option value="Creation_Toile" <?php if($effet=="creation_Toile"){echo " selected=\"selected\"";} ?>>Creation Toile : Crée un symbole Toile</option>
			<option value="Utilisation_Toile" <?php if($effet=="utilisation_Toile"){echo " selected=\"selected\"";} ?>>Utilisation Toile : Utilise les symboles Toile</option>
			<option value="Destruction_Special" <?php if($effet=="destruction_Special"){echo " selected=\"selected\"";} ?>>Destruction Special : Detruit un symbole special de l'ennemi</option>
			<option value="Vole_Special" <?php if($effet=="vole_Special"){echo " selected=\"selected\"";} ?>>Vole Special : Vole un symbole special de l'ennemi</option>
			<option value="Cree_Special_Ennemi" <?php if($effet=="cree_Special_Ennemi"){echo " selected=\"selected\"";} ?>>Cree Special Ennemi : Crée un symbole special pour l'ennemi</option>
			<option value="Piege" <?php if($effet=="piege"){echo " selected=\"selected\"";} ?>>Piege : Crée un symbole piégé</option>
			<option value="Deplacement" <?php if($effet=="Deplacement"){echo " selected=\"selected\"";} ?>>Deplacement : Deplacement d'un symbole</option>
			<option value="Tank" <?php if($effet=="Tank"){echo " selected=\"selected\"";} ?>>Tank : Protege un membre</option>
			<option value="Protection_Symbole" <?php if($effet=="Protection_Symbole"){echo " selected=\"selected\"";} ?>>Protection Symbole : Protege un symbole</option>
			<option value="Vide_AP" <?php if($effet=="Vide_AP"){echo " selected=\"selected\"";} ?>>Vide AP : Vide l'une de ses couleurs</option>
			<option value="Augmentation" <?php if($effet=="Augmentation"){echo " selected=\"selected\"";} ?>>Augmentation : Augmente les degats</option>
			<option value="Conversion" <?php if($effet=="Conversion"){echo " selected=\"selected\"";} ?>>Conversion : Change la couleur de certains symboles</option>
			<option value="Destruction_Special_Allie" <?php if($effet=="Destruction_Special_Allie"){echo " selected=\"selected\"";} ?>>Destruction Special Allie : Detruit un symbole special allié</option>
			<option value="Passif" <?php if($effet=="Passif"){echo " selected=\"selected\"";} ?>>Passif : Competence passive</option>
			<option value="Invisibilite" <?php if($effet=="Invisibilite"){echo " selected=\"selected\"";} ?>>Invisibilite : N'est plus attaquable</option>
			<option value="Reduction_Cout" <?php if($effet=="Reduction_Cout"){echo " selected=\"selected\"";} ?>>Reduction Cout : Reduit le cout des techniques</option>
			<option value="Augmentation_Cout" <?php if($effet=="Augmentation_Cout"){echo " selected=\"selected\"";} ?>>Augmentation Cout : Augmente le cout des techniques de l'ennemi</option>
			<option value="Cree_Charge" <?php if($effet=="Cree_Charge"){echo " selected=\"selected\"";} ?>>Cree Charge : Cree des symboles chargés</option>
			<option value="Utilisation_Charge" <?php if($effet=="Utilisation_Charge"){echo " selected=\"selected\"";} ?>>Utilisation Charge : Utilise les symboles chargés</option>
			<option value="Degat_Equipe" <?php if($effet=="Degat_Equipe"){echo " selected=\"selected\"";} ?>>Degat Equipe : Inflige des dégats a l'equipe ennemi</option>
			<option value="Soin" <?php if($effet=="Soin"){echo " selected=\"selected\"";} ?>>Soin : Soigne une personne</option>
			<option value="Regeneration" <?php if($effet=="Regeneration"){echo " selected=\"selected\"";} ?>>Regeneration : Soigne le lanceur</option>
			<option value="Augmente_Timer" <?php if($effet=="Augmente_Timer"){echo " selected=\"selected\"";} ?>>Augmente Timer : Augmente la durée des timer</option>
			<option value="Soin_Equipe" <?php if($effet=="Soin_Equipe"){echo " selected=\"selected\"";} ?>>Soin Equipe : Soigne l'equipe</option>
			<option value="Destruction_SansAP" <?php if($effet=="Destruction_SansAP"){echo " selected=\"selected\"";} ?>>Destruction Sans AP : Detruit des symboles mais sans générer d'AP</option>
			<option value="Diminution_AP" <?php if($effet=="Diminution_AP"){echo " selected=\"selected\"";} ?>>Diminution AP : Reduit les AP ennemis</option>
		</select>
	</form>
	<DIV id="infos"></DIV>
	<script>
		MPQ.getHeros();
    </script>
</body>

</html>