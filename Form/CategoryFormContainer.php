<?php

namespace CMS\Shop\Form;

use Nette\Forms\Container;

class CategoryFormContainer extends Container {

    public function __construct($category = NULL) {
        $this->addTextArea('description', 'Description');
        if ($category) {
            $this->setDefaults($category);
        }
    }

}
