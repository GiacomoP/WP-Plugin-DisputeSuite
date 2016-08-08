<?php

use DisputeSuite\PostTypes\Step;

$image = $data->hasCoclient() ? 'ds-couple.png' : 'ds-individual.png';
$imagePath = "{$template['imagesPath']}/{$image}";
$class = $data->hasCoclient() ? 'ds-service-couple' : 'ds-service-individual';
$stepSlug = Step::SLUG;

?>

<a class="ds-service <?php echo $class; ?>" data-product="<?php echo $data->getId(); ?>" href="<?php echo home_url("$stepSlug/client-info/?service={$data->getId()}", 'relative'); ?>">
    <span class="icon-container">
        <span class="icon"><img src="<?php echo $imagePath; ?>"></span>
    </span>
    <span class="name-container">
        <span class="title"><?php echo $data->getLabel(); ?></span>
        <span class="price"><?php echo "\${$data->getSetupFee()} + \${$data->getMonthlyFee()}/mo"; ?></span>
    </span>
</a>