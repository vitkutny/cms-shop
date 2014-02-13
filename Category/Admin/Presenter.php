<?php

namespace WebEdit\Shop\Category\Admin;

use WebEdit\Shop;

final class Presenter extends Shop\Admin\Presenter {

    /**
     * @inject
     * @var \WebEdit\Shop\Category\Model\Facade
     */
    public $categoryFacade;
    private $category;
    private $categories;

    /**
     * @inject
     * @var \WebEdit\Shop\Category\Form\Factory
     */
    public $categoryFormFactory;

    public function renderAdd() {
        $title = $this->translator->translate('shop.category.admin.add');
        $this->menu->breadcrumb->append($title);
    }

    public function actionEdit($id) {
        $this->category = $this->categoryFacade->repository->getCategory($id);
        if (!$this->category) {
            $this->error();
        }
    }

    public function renderEdit() {
        $title = $this->translator->translate('shop.category.admin.edit', NULL, ['category' => $this->category->menu->title]);
        $this->menu->breadcrumb->append($title);
        $this->template->category = $this->category;
    }

    public function actionView() {
        $this->categories = $this->categoryFacade->repository->getAllCategories();
    }

    public function renderView() {
        $this->template->categories = $this->categories;
    }

    protected function createComponentCategoryFormAdd() {
        return $this->categoryFormFactory->create();
    }

    protected function createComponentCategoryFormEdit() {
        return $this->categoryFormFactory->create($this->category);
    }

}
