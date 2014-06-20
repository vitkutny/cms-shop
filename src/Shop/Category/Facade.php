<?php

namespace WebEdit\Shop\Category;

use WebEdit\Shop\Category;
use WebEdit\Menu;
use WebEdit\Shop\Product;

final class Facade {

    private $repository;
    private $menuFacade;
    private $productRepository;

    public function __construct(Category\Repository $repository, Menu\Facade $menuFacade, Product\Repository $productRepository) {
        $this->repository = $repository;
        $this->menuFacade = $menuFacade;
        $this->productRepository = $productRepository;
    }

    public function add(array $data) {
        $menu = $this->menuFacade->add($data);
        $data['shop_category']['menu_id'] = $menu->id;
        $category = $this->repository->insert($data['shop_category']);
        $data['menu']['link'] = ':Shop:Category:Presenter:view';
        $data['menu']['link_id'] = $category->id;
        $this->menuFacade->edit($menu, $data);
        return $category;
    }

    public function edit($category, array $data) {
        $this->menuFacade->edit($category->menu, $data);
        $this->repository->update($category, $data['shop_category']);
    }

    public function delete($category) {
        if ($this->productRepository->countProductsInMenu($category->menu)) {
            throw new Category\Exception('shop.category.not_empty');
        }
        $this->menuFacade->delete($category->menu);
        $this->repository->remove($category);
    }

}
