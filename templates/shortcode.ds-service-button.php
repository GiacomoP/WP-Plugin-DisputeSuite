<?php

$image = $data->hasCoclient() ? 'ds-couple.png' : 'ds-individual.png';
$imagePath = "{$template['imagesPath']}/{$image}";
$class = $data->hasCoclient() ? 'ds-service-couple' : 'ds-service-individual';

?>

<div class="ds-service <?php echo $class; ?>" data-product="<?php echo $data->getId(); ?>">
    <div class="icon-container">
        <div class="icon"><img src="<?php echo $imagePath; ?>"></div>
    </div>
    <div class="name-container">
        <span class="title"><?php echo $data->getLabel(); ?></span>
        <span class="price"><?php echo "\${$data->getSetupFee()} + \${$data->getMonthlyFee()}/mo"; ?></span>
    </div>
</div>