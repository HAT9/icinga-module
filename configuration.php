<?php

//sidemenu 
$section = $this->menuSection(N_('Test'), array(
    'icon'      => 'host',
    'priority'  => 30
));



$section->add(N_('Add'), array(
    'icon'        => 'chart-line',
    'description' => $this->translate('Add'),
    'url'         => '/icingaweb2/testmodule/bio/bioinfo',
    'priority'    => 40
));

$section->add(N_('List'), array(
    'icon'        => 'chart-line',
    'description' => $this->translate('List Bio Info'),
    'url'         => '/icingaweb2/testmodule/bio/list',
    'priority'    => 40
));

    