<?php
//testing how to get user input
//TODO: figure out how to get user input to be used in php
//TODO:
//get input from user
$poke_input = $_GET["input"];
//create url to follow
$poke_url= "https://pokeapi.co/api/v2/pokemon/$poke_input";
//get the contents of the json file from api
$poke_json = file_get_contents($poke_url);
//process data to array so that we can navigate it. eg. $array['string'][index][string][index]
$poke_array = json_decode("$poke_json", true);

//similar process to navigate to the species and to the evolution chain for the sprites of the others.
//species
$species_url = $poke_array['species']['url'];
$species_json = file_get_contents($species_url);
$species_array = json_decode("$species_json", true);
//evolution chain
$evolution_chain_url = $species_array["evolution_chain"]['url'];
$evolution_chain_json = file_get_contents($evolution_chain_url);
$evolution_chain_array = json_decode("$evolution_chain_json", true);
//evolution 1
$evolution_1_url = $species_array["evolution_chain"]['url'];
$evolution_1_json = file_get_contents($evolution_1_url);
$evolution_1_array = json_decode($evolution_1_json, true);
//evolution 2
$evolution_2_url = $species_array["evolution_chain"]['url'];
$evolution_2_json = file_get_contents($evolution_2_url);
$evolution_2_array = json_decode($evolution_2_json, true);

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Becode training exercise PokéDex builder">
    <meta name="keywords" content="BeCode, PokéDex, JSON API exercise, JavaScript, CSS, HTML">
    <meta name="author" content="Reinout De Bleser">
    <title>Pokédex</title>
    <!-- Bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
<?php
    if ($poke_input !== null) {
        $sprite = $poke_array['sprites']['front_default'];
        echo '<img src="'.$sprite.'"alt="no image available">';
    }
    else {
        echo "<img src='https://img1.pnghut.com/7/13/17/q07VEEvcKJ/business-deviantart-stock-ball-education.jpg' alt='no image available'>";
    }
?>


<section class="container">
    <form action="" method="get">
        <div class="field">
            <label for="input"></label>
            <input type="text" name="input" id="input" placeholder="Name or Id" />
            <input type="submit"/>
        </div>
    </form>
</section>
<section class="container">
    <h4 class="title">

        <strong name="pokeName" id="pokeName">
            <?php
            $name = $poke_array['name'];
            echo $name;
            ?>
        </strong>
        <em name="pokeName" id="pokeId">
            <?php
            $id = $poke_array['id'];
            echo $id;
            ?>
        </em>
    </h4>
</section>
<section class="moves">
    <ul>
        <?php
        $i=0;
        for ($i =0; $i<4; $i++){
            $moves = $poke_array['moves'][$i]['move']['name'];
            echo "<li> $moves </li>";
        }
        ?>
    </ul>
</section>
<div id="targetEvo">
    <?php
    if ($species_array["evolves_from_species"]['url'] !== null){
    global $poke_from;
    $poke_from = $species_array["evolves_from_species"]['url'];
    echo '<img src="'.$poke_from.'" alt=""/>';
        if ($evolution_1_array["evolves_from_species"]['url'] !== null){
        global $poke_up_2;
        $poke_up_2 = $evolution_1_array["evolves_from_species"]['url'];
        echo '<img src="'.$poke_up_2.'" alt=""/>';
          }
        else {
        $poke_up_2 = 0;
        echo " <img src='https://img1.pnghut.com/7/13/17/q07VEEvcKJ/business-deviantart-stock-ball-education.jpg' alt='no image available'>";
         }
    }
    else {
        if ($evolution_1_array["evolves_from_species"]['url'] !== null){
            global $poke_up_2;
            $poke_up_2 = $evolution_1_array["evolves_from_species"]['url'];
            echo '<img src="'.$poke_up_2.'" alt=""/>';
        }
        else {
            $poke_up_2 = 0;
            echo " <img src='https://img1.pnghut.com/7/13/17/q07VEEvcKJ/business-deviantart-stock-ball-education.jpg' alt='no image available'>";
        }
        echo " <img src='https://img1.pnghut.com/7/13/17/q07VEEvcKJ/business-deviantart-stock-ball-education.jpg' alt='no image available'>";
    }
    ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

</body>
</html>