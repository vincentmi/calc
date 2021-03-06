<?php
require __DIR__."/../vendor/autoload.php";

require 'SampleExpression.php';

use CCM\Context;

$context = new Context();

$context
    ->set('a1',1)
    ->set('a2',66)
    ->set('rate',0.5)
    ->set('base.b',2)
    ->reg('base.a',function ($context ){
        return $context->get('a1') + $context->get('a2');
    })
    ->reg('base.m','$base.a * $base.b')
    ->reg('cal.c','$base.a + $base.b')
    ->regClass(\CustomExpress\SampleExpression::class)
    ->reg('cal.d',function ($context){
        extract($context->gets('base.m,rate', true));
        if($base_m > 100){
            return $rate * 0.5;
        }else{
            return $rate +10;
        }
    });

echo 'cal.d='.$context->fetch('cal.d')."\n";
$context->printCallstack();
echo 'cal.c='.$context->fetch('cal.c')."\n";
$context->printCallstack();
echo 'cal.c='.$context->fetch('cal.sample')."\n";
$context->printCallstack();

$context->debug(true);
$context->reg('mm','5/0');
echo $context->fetch('mm');



