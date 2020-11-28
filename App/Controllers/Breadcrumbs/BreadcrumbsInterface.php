<?php

namespace Controllers\Breadcrumbs;

interface BreadcrumbsInterface
{
    public function addStep($link, $title);
    public function getHtml();
}