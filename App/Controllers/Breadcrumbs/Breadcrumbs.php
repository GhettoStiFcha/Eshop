<?php

namespace Controllers\Breadcrumbs;

require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

class Breadcrumbs implements BreadcrumbsInterface
{
       
    public $steps = array(); // Элементы breadcrumbs
    public $sep = ' / '; // Разделитель ссылок

    // Метод для добавления нового элемента
    public function addStep($link, $title)
    {
        $this->steps[] = array('link' => $link, 'title' => $title);
    }
           
    // Метод для вывода всех элементов на экран
    public function getHtml()
    {
        foreach($this->steps as $step) {
            if($step['link'] == null) {
                printf('%s', $step['title']);
            } else {
                printf('<a href="%s">%s</a>%s', $step['link'], $step['title'], $this->sep);
            }
        }
    }

}