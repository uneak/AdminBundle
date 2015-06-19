<?php

	namespace Uneak\AdminBundle\Helper;

	use Doctrine\ORM\Query\Expr;

	class GridHelper {
		protected $em;

		public function __construct($em) {
			$this->em = $em;
		}


		public function gridFieldsTotalCount($entityClass) {

			$qb = $this->em->createQueryBuilder();
			$qb
				->select('COUNT(o)')
				->from($entityClass, 'o');

			return $qb->getQuery()->getSingleScalarResult();
		}


		public function gridFieldsCount($qb) {
			$qb->select('COUNT(o)');
			return $qb->getQuery()->getSingleScalarResult();
		}





		public function gridFields($qb, $params) {

			$select = array();

			$select[] = 'o.id as DT_RowId';

			foreach ($params['columns'] as $columns) {
				if ($columns['name'] && substr($columns['name'], 0, 1) != '_') {

					$field = $this->_getFieldName($columns['name']);
					$fieldAlias = str_replace(".", "_", $columns['name']);

					$select[] = $field . ' as ' . $fieldAlias;
				}
			}

			$qb->select(implode(", ", $select));

			foreach ($params['order'] as $order) {

				if (substr($params['columns'][$order['column']]['name'], 0, 1) != '_') {

					$field = $this->_getFieldName($params['columns'][$order['column']]['name']);

					$orderColName = $field;
					$qb->addOrderBy($orderColName, $order['dir']);
				}

			}

			$qb
				->setFirstResult($params['start'])
				->setMaxResults($params['length']);

			return $qb->getQuery()->getArrayResult();
		}






		public function createGridQueryBuilder($entityClass, $params) {

			$qb = $this->em->createQueryBuilder();
			$qb
				->from($entityClass, 'o');

			$this->_addJoinEntity($qb, $params);

			$searches = array();
			if (isset($params['search']['value'])) {
				$searches = explode(" ", trim($params['search']['value']));
				for ($index = 0; $index < count($searches); $index++) {
					$qb->setParameter('main_search_' . $index, '%' . $searches[$index] . '%');
				}
			}

			$fieldsSearch = new Expr\Andx();
			$globalSearch = new Expr\Orx();

			if (isset($params['columns'])) {
				foreach ($params['columns'] as $columns) {
					if ($columns['name'] && substr($columns['name'], 0, 1) != '_') {


						$field = $this->_getFieldName($columns['name']);
						$fieldAlias = str_replace(".", "_", $columns['name']);

						for ($index = 0; $index < count($searches); $index++) {
							$globalSearch->add($qb->expr()->like($field, ':main_search_' . $index));
						}
						if ($columns['search']['value']) {
							$fieldsSearch->add($qb->expr()->like($field, ':' . $fieldAlias . '_search'));
							$qb->setParameter($fieldAlias . '_search', '%' . $columns['search']['value'] . '%');
						}
					}
				}
			}

			$searchWhere = new Expr\Andx();
			if (isset($fieldsSearch)) {
				$searchWhere->add($fieldsSearch);
			}
			if (isset($globalSearch)) {
				$searchWhere->add($globalSearch);
			}

			if ($searchWhere->count()) {
				$qb->andWhere($searchWhere);
			}

			return $qb;
		}


		// TODO: a optimiser
		private function _getFieldName($fieldStr) {
			preg_match_all("/([^\\.]+)/", $fieldStr, $matches);

			if (count($matches[0]) > 1) {
				$lastObject = "o";
				for($i = 0; $i < count($matches[0]) - 1; $i++) {
					$innerJoin['o_'.$matches[0][$i]] = $lastObject.'.'.$matches[0][$i];
					$lastObject = 'o_'.$matches[0][$i];
				}
				$field = $lastObject.'.'.$matches[0][count($matches[0])-1];
			} else {
				$field = 'o.'.$fieldStr;
			}

			return $field;
		}

		private function _addJoinEntity(&$qb, $params) {
			$innerJoin = array();
			foreach ($params['columns'] as $columns) {
				if ($columns['name'] && substr($columns['name'], 0, 1) != '_') {
					$fieldStr = $columns['name'];
					preg_match_all("/([^\\.]+)/", $fieldStr, $matches);

					if (count($matches[0]) > 1) {
						$lastObject = "o";
						for($i = 0; $i < count($matches[0]) - 1; $i++) {
							$innerJoin['o_'.$matches[0][$i]] = $lastObject.'.'.$matches[0][$i];
							$lastObject = 'o_'.$matches[0][$i];
						}
					}
				}
			}

			foreach ($innerJoin as $alias => $relation) {
				$qb->innerJoin($relation, $alias);
			}
		}


	}
