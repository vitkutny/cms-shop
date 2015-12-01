<?php
namespace Ytnuk\Shop\Category\Form;

use Nette;
use Nextras;
use Ytnuk;

final class Container
	extends Ytnuk\Orm\Form\Container
{

	/**
	 * @var \Ytnuk\Shop\Category\Entity
	 */
	private $entity;

	/**
	 * @var \Ytnuk\Shop\Category\Repository
	 */
	private $repository;

	public function __construct(
		Ytnuk\Shop\Category\Entity $entity,
		Ytnuk\Shop\Category\Repository $repository
	) {
		parent::__construct(
			$entity,
			$repository
		);
		$this->entity = $entity;
		$this->repository = $repository;
	}

	protected function attached($form)
	{
		parent::attached($form);
		unset($this['menu-link']);
	}

	public function setValues(
		$values,
		$erase = FALSE
	) : Ytnuk\Orm\Form\Container
	{
		$container = parent::setValues(
			$values,
			$erase
		);
		$link = $this->entity->menu->link;
		$link->module = 'Shop:Category';
		if ( ! $link->parameters->get()->getBy(['key' => $key = current($this->repository->getEntityMetadata()->getPrimaryKey())])) {
			$linkParameter = new Ytnuk\Link\Parameter\Entity;
			$linkParameter->key = $key;
			$linkParameter->value = $this->entity->getPersistedId() ? : $this->repository->persist(
				$this->entity
			)->getPersistedId();
			$link->parameters->add($linkParameter);
		}

		return $container;
	}

	protected function addPropertyDescription(Nextras\Orm\Entity\Reflection\PropertyMetadata $metadata)
	{
		return $this->addPropertyOneHasOne(
			$metadata,
			TRUE
		);
	}
}
