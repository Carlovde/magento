<?php
namespace Webfant\SkillTest\Block;

use Magento\Framework\View\Element\Template;

class Index extends Template
{
    public function __construct()
    {
        die("DEBUG: Block wordt geladen!");
    }

    public function beforeToHTml(){
        return "Hallo Webfant! Dit is een test vanuit het Block.";
    } 

   protected function _toHtml ()
   {}

}